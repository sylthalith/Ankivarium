<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body>
    <nav>
        @auth
            <div class="title">
                Ankivarium
            </div>
            <div class="menu">
                <a href="#">Главная</a>
                <a href="#">Карточки</a>
                <a href="#">Статистика</a>
            </div>
            <div class="profile">
                <a href="#">User</a>
            </div>
        @else
            <div class="title">
                Ankivarium
            </div>
            <div class="menu">
                <a href="{{ route('login') }}">Вход</a>
                <a href="{{ route('register') }}">Регистрация</a>
            </div>
        @endauth
    </nav>
    <div class="content">
        {{ $slot }}
    </div>
    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>
</html>
