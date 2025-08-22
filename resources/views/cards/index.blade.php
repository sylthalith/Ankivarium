<x-app-layout title="Карточки">
    @push('styles')
        @vite(['resources/css/header.css', 'resources/css/cards.css'])
    @endpush

    @push('scripts')
        @vite(['resources/js/cards.js'])
    @endpush

    <x-header title="Мои карточки" search-placeholder="Поиск карточек..."></x-header>

    <div class="actions">
        <div>
            <form method="POST" action="{{ route('cards.create') }}">
                @csrf
                <button type="submit" id="new-card" class="red-btn">
                    <svg class="plus" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="none" stroke="#ffffff" stroke-linecap="round" stroke-width="2" d="M12 20v-8m0 0V4m0 8h8m-8 0H4"/>
                    </svg>
                    Новая карточка
                </button>
            </form>
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
