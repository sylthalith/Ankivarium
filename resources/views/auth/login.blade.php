<x-app-layout title="Вход в аккаунт">
    @push('styles')
        @vite(['resources/css/center-div.css'])
    @endpush

    <div class="center">
        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="input-group">
                <label for="name">Имя пользователя</label>
                <input id="name" name="name" type="text" required>
                <x-input-error :messages="$errors->get('name')"></x-input-error>
            </div>
            <div class="input-group">
                <label for="password">Пароль</label>
                <input id="password" name="password" type="password" required>
                <x-input-error :messages="$errors->get('password')"></x-input-error>
            </div>
            <label for="remember">Запомнить</label>
            <input id="remember" name="remember" type="checkbox">
            <button type="submit">Вход</button>
        </form>
    </div>
</x-app-layout>
