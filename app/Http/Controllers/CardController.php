<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Deck;
use App\Services\DeckDailyStatsService;
use App\Policies\CardPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CardController extends Controller
{
    use AuthorizesRequests;

    private DeckDailyStatsService $deckDailyStatsService;

    public function __construct(DeckDailyStatsService $deckDailyStatsService)
    {
        $this->deckDailyStatsService = $deckDailyStatsService;
    }

    public function index()
    {
        $this->authorize('viewAny', Card::class);

        $cards = auth()->user()->cards;

        return view('cards.index', ['cards' => $cards]);
    }

    public function create(Deck $deck)
    {
        $this->authorize('create', $deck);

        $decks = auth()->user()->decks()->get();

        return view('cards.create', ['decks' => $decks, 'selected_deck' => $deck]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Deck::class);

        $credentials = $request->validate([
            'deck_id' => ['required', 'exists:decks,id'],
            'front' => ['required'],
            'back' => ['required'],
        ]);

        $deck = auth()->user()->decks()->findOrFail($credentials['deck_id']);

        $deck->cards()->create([
            'front' => $credentials['front'],
            'back' => $credentials['back'],
        ]);

        $this->deckDailyStatsService->incrementCardsDue($deck);

        return redirect()->route('dashboard');
    }

    public function edit(Card $card)
    {
        $this->authorize('update', $card);

        $decks = auth()->user()->decks()->get();

        return view('cards.edit', compact('card', 'decks'));
    }

    public function update(Request $request, Card $card)
    {
        $this->authorize('update', $card);

        $credentials = $request->validate([
            'deck_id' => ['required'],
            'front' => ['required'],
            'back' => ['required'],
        ]);

        $oldDeck = $card->deck;
        $newDeck = auth()->user()->decks()->findOrFail($credentials['deck_id']);

        $card->update([
            'deck_id' => $newDeck->id,
            'front' => $credentials['front'],
            'back' => $credentials['back'],
        ]);

        if ($newDeck->isNot($oldDeck)) {
            $this->deckDailyStatsService->removeCardFromDeck($card, $oldDeck);
            $this->deckDailyStatsService->addCardToDeck($card, $newDeck);
        }

        return redirect()->route('cards.index');
    }

    public function destroy(Card $card)
    {
        $this->authorize('delete', $card);

        $this->deckDailyStatsService->removeCardFromDeck($card, $card->deck);

        $card->delete();

        return response()->noContent();
    }
}
