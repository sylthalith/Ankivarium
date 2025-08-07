<x-app-layout title="Создать карточку">
    @push('styles')
        @vite(['resources/css/auth.css'])
    @endpush

    <div class="center">
        <form method="POST" action="{{ route('cards.store') }}">
            @csrf
            <div class="input-group">
                <label for="deck_id">Deck</label>
                <select name="deck_id" id="deck_id">
                    @foreach($decks as $deck)
                        @if($selected_deck->id == $deck->id)
                            <option value="{{ $deck->id }}" selected>{{ $deck->name }}</option>
                        @else
                            <option value="{{ $deck->id }}">{{ $deck->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="input-group">
                <label for="front">Front</label>
                <input type="text" name="front" id="front">
            </div>
            <div class="input-group">
                <label for="back">Back</label>
                <input type="text" name="back" id="back">
            </div>
            <button type="submit">Создать</button>
        </form>
    </div>
</x-app-layout>
