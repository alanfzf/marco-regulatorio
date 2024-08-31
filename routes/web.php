<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LawController;
use App\Http\Controllers\TeamController;
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


Route::group(['prefix' => 'teams', 'middleware' => ['auth', 'role:admin']], function () {
    // show all laws here.
    Route::get('show', [TeamController::class, 'show'])
        ->name('teams.show');

    // show the users that can be associated to a specific law.
    Route::get('law/{law}', [TeamController::class, 'users'])
        ->name('teams.users');

    // modify the team for a specific law.
    Route::patch('law/{law}', [TeamController::class, 'update'])
        ->name('teams.update');
});



// **** RUTA PARA ITEMS ****
Route::patch('laws/{law}/articles/{article}/items/{item}/comment', [ItemController::class, 'comment'])
    ->name('items.comment');

Route::resource('laws.articles.items', ItemController::class)
    ->names('items');

// **** RUTA PARA ARTICULOS ****
Route::resource('laws.articles', ArticleController::class)
    ->names('articles');

// **** RUTA PARA LEYES ****
Route::get('laws/{law}/report/', [LawController::class, 'report'])
    ->name('laws.report');

Route::post('laws/{law}/upload', [LawController::class, 'upload'])
    ->name('laws.upload');

Route::resource('laws', LawController::class)
    ->middleware('auth')
    ->names('laws');
