<?php

use App\Http\Controllers\LawController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('laws.index'));
});

// ruta para leyes

Route::resource('/laws', LawController::class)->names('laws');
