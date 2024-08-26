<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LawController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('laws.index'));
})->name('home');

// **** RUTA PARA AUTH ****
Route::group(['prefix' => 'auth'], function () {
    Route::get('login', [AuthController::class, 'show'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('loogut', [AuthController::class, 'logout'])->name('auth.logout');
});

// **** RUTA PARA ITEMS ****
Route::resource('laws.articles.items', ItemController::class)
    ->names('items');

// **** RUTA PARA ARTICULOS ****
Route::patch('laws/{law}/articles/{article}/validate_items', [ArticleController::class, 'validate_items'])
    ->name('articles.validate_items');

Route::resource('laws.articles', ArticleController::class)
    ->names('articles');

// **** RUTA PARA LEYES ****
Route::post('laws/{law}/upload', [LawController::class, 'upload'])
    ->name('laws.upload');

Route::resource('laws', LawController::class)
    ->middleware('auth')
    ->names('laws');
