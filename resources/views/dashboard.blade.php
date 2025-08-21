<x-app-layout title="Главная">
    @push('styles')
        @vite(['resources/css/dashboard.css'])
    @endpush

    @push('scripts')
        @vite(['resources/js/dashboard.js'])
    @endpush

    <header>
        <div class="title">
            <h1>Мои колоды</h1>
        </div>
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
        <x-deck
            :deck="$deck">
        </x-deck>
    @endforeach
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Выйти</button>
    </form>
</x-app-layout>
