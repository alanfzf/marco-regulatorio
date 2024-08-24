<?php

use App\Http\Controllers\LawController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('laws.index'));
});


// **** RUTA PARA ARTICULOS ****



// **** RUTA PARA LEYES ****
Route::group(['prefix' => 'laws'], function () {
    Route::post('/{law}/upload_articles', [LawController::class, 'comment'])
        ->name('laws.upload_articles');
});

Route::resource('/laws', LawController::class)->names('laws');
