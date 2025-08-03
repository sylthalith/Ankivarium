<x-app-layout title="Главная">
    @push('styles')
        @vite(['resources/css/dashboard.css'])
    @endpush

    <header>
        <h1>Мои колоды</h1>
        <div class="search-menu">
            <input type="search" placeholder="Поиск колод...">
            <button class="btn">
                <img class="search" src="{{ Vite::asset('resources/images/search.png') }}">
            </button>
        </div>
    </header>

    <button class="btn new-deck">
        <img class="plus" src="{{ Vite::asset('resources/images/plus.png') }}">
        Новая колода
    </button>
    <div class="decks">
    @for ($i = 0; $i < 4; $i++)
        <div class="deck">
            <div class="deck-title">
                <h3>Длинное название для колоды</h3>
            </div>
            <div class="to-study">
                100 карточек
            </div>
            <div class="progress-bar">
                <progress max="100" value="30"></progress>
            </div>
            <div class="progress">
                Изучено: 30/100 (30%)
            </div>
            <div class="actions">
                <button class="action-btn">
                    <img src="{{ Vite::asset('resources/images/start.png') }}">
                    Учить
                </button>
                <button class="action-btn">
                    <img src="{{ Vite::asset('resources/images/plus.png') }}">
                    Добавить
                </button>
                <button class="action-btn">
                    <img src="{{ Vite::asset('resources/images/edit.png') }}">
                    Изменить
                </button>
                <button class="action-btn">
                    <img src="{{ Vite::asset('resources/images/delete.png') }}">
                    Удалить
                </button>
            </div>
        </div>
    @endfor
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Выйти</button>
    </form>
</x-app-layout>
