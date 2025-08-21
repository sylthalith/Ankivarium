<x-app-layout title="Карточки">
    @push('styles')
        @vite(['resources/css/cards.css'])
    @endpush

    @push('scripts')
        @vite(['resources/js/cards.js'])
    @endpush

    <header>
        <div class="title">
            <h1>Мои карточки</h1>
        </div>
        <div class="search-menu">
            <input type="search" placeholder="Поиск карточек...">
            <button class="red-btn">
                <img class="search" src="{{ Vite::asset('resources/images/SearchOutlined.svg') }}">
            </button>
        </div>
    </header>

    <div class="actions">
        <div>
            <button id="new-card" class="red-btn">Новая карточка</button>
        </div>
        <div class="filters">
            <div class="deck-options">
                <select name="deck">
                    <option value="English">English</option>
                    <option value="Russian">Russian</option>
                    <option value="Japanese">Japanese</option>
                </select>
            </div>
            <div class="status-options">
                <select name="status">
                    <option value="new">New</option>
                    <option value="learning">Learning</option>
                    <option value="review">Review</option>
                </select>
            </div>
        </div>
    </div>

    <div class="cards">
        @foreach($cards as $card)
            <x-card :card="$card"></x-card>
        @endforeach
    </div>

</x-app-layout>
