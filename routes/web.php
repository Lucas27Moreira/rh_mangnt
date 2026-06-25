<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
   Route::redirect('/', '/home');
   Route::view('/home', 'home')->name('home');

   //user profile page
   Route::get('/user/profile',[ProfileController::class, "index"])->name('user.profile');
});