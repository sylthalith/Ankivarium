<x-app-layout title="Главная">
    @push('styles')
        @vite(['resources/css/header.css', 'resources/css/dashboard.css',])
    @endpush

    @push('scripts')
        @vite(['resources/js/dashboard.js'])
    @endpush

    <x-header title="Мои колоды" search-placeholder="Поиск колод..."></x-header>

    <button class="red-btn new-deck">
        <svg class="plus" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path fill="none" stroke="#ffffff" stroke-linecap="round" stroke-width="2" d="M12 20v-8m0 0V4m0 8h8m-8 0H4"/>
        </svg>
        Новая колода
    </button>
    <div class="decks">
    @foreach ($decks as $deck)
        <x-deck :deck="$deck"></x-deck>
    @endforeach
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Выйти</button>
    </form>
</x-app-layout>
