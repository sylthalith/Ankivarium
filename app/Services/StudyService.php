<?php

namespace App\Services;

use App\Models\Deck;
use App\Models\Card;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class StudyService
{
    protected DeckDailyStatsService $deckDailyStatsService;
    private $coefficients = [
        'again' => 0.0,
        'hard' => 2.0,
        'good' => 3.0,
        'easy' => 5.0,
    ];

    public function __construct(DeckDailyStatsService $deckDailyStatsService)
    {
        $this->deckDailyStatsService = $deckDailyStatsService;
    }

    public function getCardsToStudy(Deck $deck)
    {
        $today = Carbon::now()->toDateString();

        return $deck->cards()->where('next_review_date', '<=', $today);
    }

    public function getNextReviewCard(Deck $deck)
    {
        $query = $this->getCardsToStudy($deck)->inRandomOrder();

        $lastReviewCardId = session()->get('last_review_card_id');

        if ($lastReviewCardId) {
            $query->where('id', '!=', $lastReviewCardId);
        }

        $card = $query->first();

        if (!$card) {
            return null;
        }

        session()->put('last_review_card_id', $card->id);

        return $card;
    }

    public function rateCard(Card $card, string $rating)
    {
        $currentInterval = $card->interval;

        $nextInterval = $this->calculateNextIntervals($currentInterval)[$rating];
        $nextReviewDate = $this->calculateNextReviewDate($nextInterval);
        $cardType = $nextInterval >= 1 ? 'review' : 'learning';

        $today = Carbon::now()->toDateString();

        $updateData = [
            'interval' => $nextInterval,
            'next_review_date' => $nextReviewDate,
            'type' => $cardType,
        ];

        if ($nextReviewDate > $today) {
            $this->deckDailyStatsService->incrementCardsCompleted($card->deck);
            $updateData['reviewed_at'] = $today;
        }

        $card->update($updateData);
    }

    public function calculateNextIntervals(float $interval, bool $rounded = false)
    {
         $intervals = [
            'again' => max($interval * $this->coefficients['again'], 0.1),
            'hard' => $interval * $this->coefficients['hard'],
            'good' => $interval * $this->coefficients['good'],
            'easy' => max($interval * $this->coefficients['easy'], 2),
        ];

         return $rounded ? array_map(fn($v) => round($v, 0), $intervals) : $intervals;
    }

    public function calculateNextReviewDate(float $interval)
    {
        $roundedInterval = round($interval);

        return Carbon::now()->addDays($roundedInterval)->toDateString();
    }
}
