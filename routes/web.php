<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\MainController;

    Route::get('/', [MainController::class, 'storeFront'])
        ->name('storeFront');

    Route::get('/page/{id}', [MainController::class, 'page'])
        ->name('page');
    Route::get('/post/{id}', [MainController::class, 'post'])
        ->name('post');
    Route::get('/catpost/{id}', [MainController::class, 'catPost'])
        ->name('catPost');
    Route::get('/hiring', [MainController::class, 'hiring'])
        ->name('hiring');
    Route::get('/services/{id}', [MainController::class, 'services'])
        ->name('services');

