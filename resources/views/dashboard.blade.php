<x-app-layout title="Главная">
    @push('styles')
        @vite(['resources/css/dashboard.css'])
    @endpush

    @push('scripts')
        @vite(['resources/js/dashboard.js'])
    @endpush

    <header>
        <h1>Мои колоды</h1>
        <div class="search-menu">
            <input type="search" placeholder="Поиск колод...">
            <button class="red-btn">
                <img class="search" src="{{ Vite::asset('resources/images/SearchOutlined.svg') }}">
            </button>
        </div>
    </header>

    <button class="red-btn new-deck">
        <img class="plus" src="{{ Vite::asset('resources/images/Plus.svg') }}">
        Новая колода
    </button>
    <div class="decks">
    @foreach ($decks as $deck)
        @php
            $cardsDue =  $stats[$deck->id]->cards_due;
            $cardsCompleted = $stats[$deck->id]->cards_completed;
        @endphp
        <div class="deck" data-deck-id="{{ $deck->id }}">
            <div class="deck-title">
                <h3>{{ $deck->name }}</h3>
            </div>
            <div class="to-study">
                {{ $cardsDue }} карточек
            </div>
            <div class="progress-bar">
                <progress max="{{ $cardsDue }}" value="{{ $cardsCompleted }}"></progress>
            </div>
            <div class="progress">
                Изучено: {{ $cardsCompleted }}/{{ $cardsDue }} ({{ $cardsDue == 0 ? 0 : round($cardsCompleted / $cardsDue)}}%)
            </div>
            <div class="actions">
                <button class="btn action-btn study-btn">
                    <img src="{{ Vite::asset('resources/images/Play.svg') }}">
                    Учить
                </button>
                <form method="GET" action="{{ route('cards.create', ['deck' => $deck]) }}">
                    <input type="hidden" name="deck_id" value="{{ $deck->id }}">
                    <button type="submit" class="btn action-btn add-btn">
                        <img src="{{ Vite::asset('resources/images/Plus.svg') }}">
                        Добавить
                    </button>
                </form>
                <button class="btn action-btn edit-btn">
                    <img src="{{ Vite::asset('resources/images/EditOutlined.svg') }}">
                    Изменить
                </button>
                <button class="btn action-btn delete-btn">
                    <img src="{{ Vite::asset('resources/images/DeleteOutlined.svg') }}">
                    Удалить
                </button>
            </div>
        </div>
    @endforeach
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Выйти</button>
    </form>
</x-app-layout>
