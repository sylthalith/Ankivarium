<?php

namespace App\Services;

use App\Models\Deck;
use Illuminate\Support\Carbon;

class DeckDailyStatsService
{
    public function getStats(Deck $deck)
    {
        $deckStat = $deck->stats()->whereDate('updated_at', today())->first();

        if (!$deckStat) {
            $deckStat = $this->createStats($deck);
        }

        return $deckStat;
    }

    public function createStats(Deck $deck)
    {
        $this->deleteOldStats($deck);

        $cardsDue = $deck->cards()->where('next_review_date', '<=', Carbon::now()->toDateString())->count();

        return $deck->stats()->create([
            'cards_due' => $cardsDue,
            'cards_completed' => 0,
        ]);
    }

    public function updateStats(Deck $deck, $cardsDue = null, $cardsCompleted = null)
    {
        if (!$cardsDue) {
            $cardsDue = $deck->cards()->where('next_review_date', '<=', Carbon::now()->toDateString())->count();
        }

        if (!$cardsCompleted) {
            $cardsCompleted = 0;
        }

        $deckStat = $deck->stats()->create([
            'cards_due' => $cardsDue,
            'cards_completed' => $cardsCompleted,
        ]);
    }

    public function incrementCardsDue(Deck $deck)
    {
        $this->getStats($deck)->increment('cards_due');
    }

    public function decrementCardsDue(Deck $deck)
    {
        $this->getStats($deck)->decrement('cards_due');
    }

    public function incrementCardsCompleted(Deck $deck)
    {
        $this->getStats($deck)->increment('cards_completed');
    }

    public function decrementCardsCompleted(Deck $deck)
    {
        $this->getStats($deck)->decrement('cards_completed');
    }

    public function deleteOldStats(Deck $deck)
    {
        $deck->stats()->get()->each->delete();
    }
}
