<x-app-layout title="Обучение">
    @push('styles')
        @vite(['resources/css/study.css', 'resources/css/center-div.css'])
    @endpush

    @push('scripts')
        @vite(['resources/js/study.js'])
    @endpush

    @push('meta')
        <meta name="deck-id" content="{{ $deck->id }}">
    @endpush

    <div class="center">
        <div class="card-container">
            <div class="deck-info">
                {{ $deck->name }}
            </div>
            <div class="card">
                <div class="front">
                    <div id="front-text" class="card-text"></div>
                    <div id="front-actions" class="actions">
                        <button id="show" class="show-answer">
                            Показать ответ
                        </button>
                    </div>
                </div>

                <div class="back">
                    <div id="back-text" class="card-text"></div>
                    <div id="back-actions" class="actions">
                        <button id="again" class="difficulty-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke-linecap="round" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 9.05v-.1m8 .1v-.1"/><path stroke-linejoin="round" d="M16 16c-.5-1.5-1.79-3-4-3s-3.5 1.5-4 3"/></g></svg>
                            <div class="difficulty-btn-text">Снова</div>
                            <div class="time"></div>
                        </button>
                        <button id="hard" class="difficulty-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke-linecap="round" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 9.05v-.1m8 .1v-.1M8 14h8"/></g></svg>
                            <div class="difficulty-btn-text">Трудно</div>
                            <div class="time"></div>
                        </button>
                        <button id="good" class="difficulty-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke-linecap="round" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 9.05v-.1m8 .1v-.1"/><path stroke-linejoin="round" d="M16 14c-.5 1.5-1.79 3-4 3s-3.5-1.5-4-3"/></g></svg>
                            <div class="difficulty-btn-text">Хорошо</div>
                            <div class="time"></div>
                        </button>
                        <button id="easy" class="difficulty-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke-linecap="round" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 9.05v-.1m8 .1v-.1"/><path stroke-linejoin="round" d="M12 18a4 4 0 0 0 4-4H8a4 4 0 0 0 4 4"/></g></svg>
                            <div class="difficulty-btn-text">Легко</div>
                            <div class="time"></div>
                        </button>
                    </div>
                </div>
            </div>
            <div class="progress">
                <progress></progress>
                <div id="progress-text">Карточка 0 из ?</div>
            </div>
        </div>
    </div>
</x-app-layout>
