<?php

use App\Models\SecretSanta;
use App\Livewire\ParticipantsList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecretSantaController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard e creazione secret santas
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [SecretSantaController::class, 'index'])->name('dashboard');
    Route::get('/secret-santas/create', [SecretSantaController::class, 'create'])->name('secret-santas.create');
    Route::post('/secret-santas', [SecretSantaController::class, 'store'])->name('secret-santas.store');
});


//Lista partecipanti
Route::get('/participants', function () {
    return view('participants');
})->name('participants');
