<x-app-layout title="Главная">
    Dashboard
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Выйти</button>
    </form>
</x-app-layout>
