<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\MainController;
    use App\Http\Controllers\StorageCleanupController;
    use Illuminate\Support\Facades\Artisan;

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
    Route::get('/services/{serviceId}/posts/{postId}', [MainController::class, 'servicePost'])
        ->name('servicePost');

    Route::get('/run-storage-link', function () {
        try {
            Artisan::call('storage:link');
            return response()->json(['message' => 'Storage linked successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    });

    // Route để dọn dẹp các file không còn sử dụng (bỏ middleware tạm thời để test)
    Route::match(['get', 'post'], '/cleanup-storage', [StorageCleanupController::class, 'cleanupUnusedFiles'])
        // ->middleware(['auth'])  // Đã comment middleware để test
        ->name('cleanup.storage');
