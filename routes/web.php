<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\StudyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::middleware('guest')->group(function () {
    Route::view('/', 'welcome')->name('welcome');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');

    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [LoginController::class, 'create'])->name('login');

    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    // OAuth

    Route::get('auth/yandex/redirect', [SocialController::class, 'handleYandexRedirect']);

    Route::get('auth/yandex/callback', [SocialController::class, 'handleYandexCallback']);


    Route::get('auth/google/redirect', [SocialController::class, 'handleGoogleRedirect']);

    Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback']);


    Route::get('auth/vk/callback', [SocialController::class, 'handleVKCallback']);
});

Route::middleware('auth')->group(function () {

    // Колоды

    Route::get('/decks', [DeckController::class, 'index'])->name('dashboard');

    Route::post('/decks', [DeckController::class, 'store'])->name('decks.store');

    Route::patch('/decks/{deck}', [DeckController::class, 'update'])->name('decks.update');

    Route::delete('/decks/{deck}', [DeckController::class, 'destroy'])->name('decks.destroy');

    // Карточки

    Route::get('/cards', [CardController::class, 'index'])->name('cards.index');

    Route::post('/cards/create', [CardController::class, 'create'])->name('cards.create');

    Route::post('/cards/store', [CardController::class, 'store'])->name('cards.store');

    Route::get('/cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit');

    Route::patch('/cards/{card}', [CardController::class, 'update'])->name('cards.update');

    Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');

    // Обучение

    Route::post('/study', [StudyController::class, 'create'])->name('study.create');

    Route::get('/study/{deck}', [StudyController::class, 'next'])->name('study.next');

    Route::post('/study/{card}', [StudyController::class, 'answer'])->name('study.answer');


    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
