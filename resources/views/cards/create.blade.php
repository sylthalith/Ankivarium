<x-app-layout title="Создать карточку">
    @push('styles')
        @vite(['resources/css/center-div.css'])
    @endpush

    <div class="center">
        <form method="POST" action="{{ route('cards.store') }}">
            @csrf
            <div class="input-group">
                <label for="deck_id">Deck</label>
                <select name="deck_id" id="deck_id">
                    @foreach($decks as $deck)
                        <option value="{{ $deck->id }}"
                            {{ $selected_deck && $selected_deck->id == $deck->id ? 'selected' : '' }}>
                            {{ $deck->name }}
                        </option>
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
