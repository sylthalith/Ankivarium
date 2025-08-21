<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Services\DeckDailyStatsService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    use AuthorizesRequests;

    private DeckDailyStatsService $deckDailyStatsService;

    public function __construct(DeckDailyStatsService $deckDailyStatsService)
    {
        $this->deckDailyStatsService = $deckDailyStatsService;
    }

    public function index()
    {
        $this->authorize('viewAny', Deck::class);

        $decks = auth()->user()->decks()->get();
        $stats = [];

        $decks->each(function ($deck) use (&$stats) {
            $stats[$deck->id] = $this->deckDailyStatsService->getStats($deck);;
        });

        return view('dashboard', compact('decks', 'stats'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Deck::class);

        $credentials = $request->validate([
            'name' => ['required', 'string']
        ]);

        $deck = auth()->user()->decks()->create($credentials);
        $this->deckDailyStatsService->createStats($deck);

        $deckHTML = view('components.deck', ['deck' => $deck])->render();

        return response()->json(['deck_html' => $deckHTML]);
    }

    public function update(Request $request, Deck $deck)
    {
        $this->authorize('update', $deck);

        $credentials = $request->validate([
            'new_deck_name' => ['required', 'string']
        ]);

        $deck->update(['name' => $credentials['new_deck_name']]);

        return response()->json(['new_deck_name' => $deck->name]);
    }

    public function destroy(Deck $deck)
    {
        $this->authorize('delete', $deck);

        $deck->delete();

        return response()->json();
    }
}
