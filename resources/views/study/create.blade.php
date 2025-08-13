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
                <div class="card-text"></div>
                <div class="actions">
                    <button id="show" class="show-answer hidden">
                        Показать ответ
                    </button>
                    <button id="again" class="difficulty-btn hidden">
                        <img src="{{ Vite::asset('resources/images/FaceSad.svg') }}">
                        <div class="difficulty-btn-text">Снова</div>
                        <div class="time"></div>
                    </button>
                    <button id="hard" class="difficulty-btn hidden">
                        <img src="{{ Vite::asset('resources/images/FaceNeutral.svg') }}">
                        <div class="difficulty-btn-text">Трудно</div>
                        <div class="time"></div>
                    </button>
                    <button id="good" class="difficulty-btn hidden">
                        <img src="{{ Vite::asset('resources/images/FaceHappy.svg') }}">
                        <div class="difficulty-btn-text">Хорошо</div>
                        <div class="time"></div>
                    </button>
                    <button id="easy" class="difficulty-btn hidden">
                        <img src="{{ Vite::asset('resources/images/FaceVeryHappy.svg') }}">
                        <div class="difficulty-btn-text">Легко</div>
                        <div class="time"></div>
                    </button>
                </div>
            </div>
            <div class="progress">
                <progress></progress>
                <div id="progress-text"></div>
            </div>
        </div>
    </div>
</x-app-layout>
