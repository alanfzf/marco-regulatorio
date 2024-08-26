<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LawController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('laws.index'));
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
Route::resource('laws', LawController::class)->names('laws');
