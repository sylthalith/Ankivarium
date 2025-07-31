<x-app-layout title="Вход в аккаунт">
    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <label for="name">Имя пользователя</label>
        <input id="name" name="name" type="text" required>
        <x-input-error :messages="$errors->get('name')"></x-input-error>
        <label for="password">Пароль</label>
        <input id="password" name="password" type="password" required>
        <x-input-error :messages="$errors->get('password')"></x-input-error>
        <label for="remember">Запомнить</label>
        <input id="remember" name="remember" type="checkbox">
        <button type="submit">Вход</button>
    </form>
</x-app-layout>
