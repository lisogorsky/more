<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Dashboard\Index;

//События главная
Route::get('/', function () {
    return view('events.index');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/dashboard', Index::class)->middleware(['auth'])->name('dashboard');
