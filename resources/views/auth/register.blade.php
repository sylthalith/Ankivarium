<x-app-layout title="Регистрация">
    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <div>
            <label for="name">Имя пользователя</label>
            <input id="name" name="name" type="text" required>
            <x-input-error :messages="$errors->get('name')"></x-input-error>
        </div>
        <div>
            <label for="password">Пароль</label>
            <input id="password" name="password" type="password" required>
        </div>
        <div>
            <label for="password_confirmation">Подтверждение пароля</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required>
            <x-input-error :messages="$errors->get('password')"></x-input-error>
        </div>
        <button type="submit">Регистрация</button>
    </form>
</x-app-layout>
