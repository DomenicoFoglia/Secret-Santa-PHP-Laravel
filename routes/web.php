<?php

use App\Models\SecretSanta;
use App\Livewire\ParticipantsList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecretSantaController;

Route::get('/', function () {
    if (auth()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});

// Dashboard e gestione secret santas
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [SecretSantaController::class, 'index'])->name('dashboard');
    Route::get('/secret-santas/create', [SecretSantaController::class, 'create'])->name('secret-santas.create');
    Route::get('/secret-santas/show/{id}', [SecretSantaController::class, 'show'])->name('secret-santas.show');
    Route::get('/secret-santas/edit/{id}', [SecretSantaController::class, 'edit'])->name('secret-santas.edit');
    // Route::post('/secret-santas', [SecretSantaController::class, 'store'])->name('secret-santas.store');
    Route::delete('/secret-santas/{id}', [SecretSantaController::class, 'destroy'])->name('secret-santas.destroy');
});


//Lista partecipanti
Route::get('/participants', function () {
    return view('participants');
})->name('participants');
