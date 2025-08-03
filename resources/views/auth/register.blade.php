<x-app-layout title="Регистрация">
    @push('styles')
        @vite(['resources/css/auth.css'])
    @endpush

    <div class="center">
        <form method="POST" action="{{ route('register.store') }}">
            @csrf
            <div class="input-group">
                <label for="name">Имя пользователя</label>
                <input id="name" name="name" type="text" required>
                <x-input-error :messages="$errors->get('name')"></x-input-error>
            </div>
            <div class="input-group">
                <label for="password">Пароль</label>
                <input id="password" name="password" type="password" required>
            </div>
            <div class="input-group">
                <label for="password_confirmation">Подтверждение пароля</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required>
                <x-input-error :messages="$errors->get('password')"></x-input-error>
            </div>
            <button type="submit" class="btn">Регистрация</button>
        </form>
    </div>
</x-app-layout>
