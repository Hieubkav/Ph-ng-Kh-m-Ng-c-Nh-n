<?php

    use App\Http\Controllers\MainController;
    use App\Http\Controllers\StorageCleanupController;
    use App\Models\Post;
    use App\Models\ServicePost;
    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\Route;

    Route::get('/', [MainController::class, 'storeFront'])
        ->name('storeFront');

    Route::get('/page/{id}', [MainController::class, 'page'])
        ->name('page');
    Route::get('/post/{post}', function (Post $post) {
        return redirect()->route('post', $post->slug);
    })
        ->whereNumber('post')
        ->name('post.legacy');

    Route::get('/post/{slug}', [MainController::class, 'post'])
        ->where('slug', '[-a-zA-Z0-9]+')
        ->name('post');
    Route::get('/catpost/{id}', [MainController::class, 'catPost'])
        ->name('catPost');
    Route::get('/hiring', [MainController::class, 'hiring'])
        ->name('hiring');
    Route::get('/services/{id}', [MainController::class, 'services'])
        ->name('services');
    Route::get('/services/{serviceId}/posts/{post}', function ($serviceId, ServicePost $post) {
        if ((int) $serviceId !== (int) $post->service_id) {
            abort(404);
        }

        return redirect()->route('servicePost', [
            'serviceId' => $serviceId,
            'slug' => $post->slug,
        ]);
    })
        ->whereNumber('serviceId')
        ->whereNumber('post')
        ->name('servicePost.legacy');

    Route::get('/services/{serviceId}/posts/{slug}', [MainController::class, 'servicePost'])
        ->whereNumber('serviceId')
        ->where('slug', '[-a-zA-Z0-9]+')
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
