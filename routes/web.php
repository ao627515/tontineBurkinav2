<?php

use App\Livewire\Home;
use App\Livewire\Login;
use App\Livewire\Register;
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

    // password.reset
});

Route::middleware('auth')->group(function () {
    Route::get('/home', Home::class)->name('home');
    Route::get('/tontine/{tontine}', ShowTontine::class)->name('tontine.show');
    
    // password.confirm
});
