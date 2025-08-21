@php
    $cardsDue = $deck->stats->cards_due;
    $cardsCompleted = $deck->stats->cards_completed;
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
        Изучено: {{ $cardsCompleted }}/{{ $cardsDue }} ({{ $cardsDue == 0 ? 0 : round($cardsCompleted / $cardsDue * 100)}}%)
    </div>
    <div class="actions">
        <form method="POST" action="{{ route('study.create') }}">
            @csrf
            <input type="hidden" name="deck_id" value="{{ $deck->id }}">
            <button type="submit" class="btn action-btn study-btn">
                <img src="{{ Vite::asset('resources/images/Play.svg') }}">
                Учить
            </button>
        </form>
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
