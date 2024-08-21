<?php

use App\Http\Controllers\LawController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect(route('laws.index'));
});

// ruta para leyes
Route::group(['prefix' => 'laws'], function () {
    Route::resource('/', LawController::class)->names('laws');
});

Route::get('/ftp/{file}', function ($file) {

    $download = Storage::get($file);
    $mime = Storage::mimeType($file);
    $headers = ['Content-Type' => $mime];


    return response()->stream(function () use ($download) {
        echo $download;
    }, Response::HTTP_OK, $headers);
})->name('ftp.show');
