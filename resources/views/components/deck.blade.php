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
                <svg xmlns="http://www.w3.org/2000/svg" width="256" height="256" viewBox="0 0 256 256">
                    <path d="M184 74H40a14 14 0 0 0-14 14v112a14 14 0 0 0 14 14h144a14 14 0 0 0 14-14V88a14 14 0 0 0-14-14m2 126a2 2 0 0 1-2 2H40a2 2 0 0 1-2-2V88a2 2 0 0 1 2-2h144a2 2 0 0 1 2 2Zm44-144v120a6 6 0 0 1-12 0V56a2 2 0 0 0-2-2H64a6 6 0 0 1 0-12h152a14 14 0 0 1 14 14"/>
                </svg>
                Учить
            </button>
        </form>
        <form method="POST" action="{{ route('cards.create') }}">
            @csrf
            <input type="hidden" name="deck_id" value="{{ $deck->id }}">
            <button type="submit" class="btn action-btn add-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="2" d="M12 20v-8m0 0V4m0 8h8m-8 0H4"/>
                </svg>
                Добавить
            </button>
        </form>
        <button class="btn action-btn edit-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="m16.475 5.408l2.117 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621"/>
                    <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3"/>
                </g>
            </svg>
            Изменить
        </button>
        <button class="btn action-btn delete-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="1024" height="1024" viewBox="0 0 1024 1024">
                <path d="M360 184h-8c4.4 0 8-3.6 8-8zh304v-8c0 4.4 3.6 8 8 8h-8v72h72v-80c0-35.3-28.7-64-64-64H352c-35.3 0-64 28.7-64 64v80h72zm504 72H160c-17.7 0-32 14.3-32 32v32c0 4.4 3.6 8 8 8h60.4l24.7 523c1.6 34.1 29.8 61 63.9 61h454c34.2 0 62.3-26.8 63.9-61l24.7-523H888c4.4 0 8-3.6 8-8v-32c0-17.7-14.3-32-32-32M731.3 840H292.7l-24.2-512h487z"/>
            </svg>
            Удалить
        </button>
    </div>
</div>
