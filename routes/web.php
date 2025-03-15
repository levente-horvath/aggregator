<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\SteamReviewController;
use App\Http\Controllers\RedditController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::get('/terraria-reviews', [SteamReviewController::class, 'index'])->name('steam.reviews');
Route::get('/reddit-comments', [RedditController::class, 'getTerrariaPosts'])->name('reddit.comments');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
