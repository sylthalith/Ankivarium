<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Deck;
use App\Services\DeckDailyStatsService;
use App\Services\StudyService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudyController extends Controller
{
    use AuthorizesRequests;

    private StudyService $studyService;
    private DeckDailyStatsService $deckDailyStatsService;

    public function __construct(StudyService $studyService, DeckDailyStatsService $deckDailyStatsService)
    {
        $this->studyService = $studyService;
        $this->deckDailyStatsService = $deckDailyStatsService;
    }

    public function create(Request $request)
    {
        $credentials = $request->validate(['deck_id' => 'required']);

        $deck = auth()->user()->decks()->findOrFail($credentials['deck_id']);

        $this->authorize('view',  $deck);

        $cardsCompleted = $this->deckDailyStatsService->getStats($deck)->cards_completed;
        $cardsDue = $this->deckDailyStatsService->getStats($deck)->cards_due;

        if ($cardsCompleted >= $cardsDue) {
            return redirect()->route('dashboard');
        }

        return view('study.create', ['deck' => $deck]);
    }

    public function next(Deck $deck)
    {
        $this->authorize('view', $deck);

        $card = $this->studyService->getNextReviewCard($deck);

        if (!$card) {
            return response()->noContent();
        }

        $intervals = $this->studyService->calculateNextIntervals($card->interval, true);
        $cardsCompleted = $this->deckDailyStatsService->getStats($deck)->cards_completed;
        $cardsDue = $this->deckDailyStatsService->getStats($deck)->cards_due;

        return response()->json([
            'card_id' => $card->id,
            'front' => $card->front,
            'back' => $card->back,
            'intervals' => $intervals,
            'cards_completed' => $cardsCompleted,
            'cards_due' => $cardsDue,
        ]);
    }

    public function answer(Request $request, Card $card)
    {
        $this->authorize('update', $card);

        $credentials = $request->validate(['rating' => ['required', 'in:again,hard,good,easy']]);

        $rating = $credentials['rating'];

        $this->studyService->rateCard($card, $rating);

        $intervals = $this->studyService->calculateNextIntervals($card->interval, true);
        $cardsCompleted = $this->deckDailyStatsService->getStats($card->deck)->cards_completed;
        $cardsDue = $this->deckDailyStatsService->getStats($card->deck)->cards_due;

        return response()->json([
            'intervals' => $intervals,
            'cards_completed' => $cardsCompleted,
            'cards_due' => $cardsDue,
        ]);
    }
}
