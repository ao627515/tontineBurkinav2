<?php

use App\Livewire\ForgotPassword;
use App\Livewire\Home;
use App\Livewire\ListeParticipants;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\ResetPassword;
use App\Livewire\ShowTontine;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    // register
    Route::get('/register', Register::class)->name('register');

    // login
    Route::get('/', Login::class)->name('login');

    // password.request
    Route::get('forgot-password', ForgotPassword::class)
    ->name('password.request');

    // password.reset
    Route::get('reset-password/{token}', ResetPassword::class)
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    // Home
    Route::get('/home', Home::class)->name('home');

    // Show Tontine
    Route::get('/tontine/{tontine}', ShowTontine::class)->name('tontine.show');

    //Index participant
    Route::get('/participants', ListeParticipants::class)->name('participant.index');

});
