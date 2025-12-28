<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Dashboard\Index;
use App\Livewire\Event\EventShow;
use App\Livewire\Cabinet\OrganizerCabinet;

//События главная
Route::get('/', function () {
    return view('events.index');
});

Route::get('/login', function () {
    return redirect('/')
        ->with('open-login-modal', true);
})->name('login');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/dashboard', Index::class)->middleware(['auth'])->name('dashboard');

Route::get('/event/{event}', EventShow::class)->name('event.show');

Route::get('/cabinet/organizer', OrganizerCabinet::class)->middleware(['auth'])->name('cabinet.organizer');
