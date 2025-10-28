<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $this->convertToWebP($post);
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $this->convertToWebP($post);
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        // Xóa file ảnh khi xóa bài viết
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        // Xóa file PDF nếu có
        if ($post->pdf && Storage::disk('public')->exists($post->pdf)) {
            Storage::disk('public')->delete($post->pdf);
        }
    }

    /**
     * Convert uploaded image to WebP format
     */
    private function convertToWebP(Post $post): void
    {
        // Kiểm tra xem có ảnh không
        if (!$post->image) {
            return;
        }

        // Kiểm tra nếu ảnh đã là WebP thì không cần xử lý
        $extension = pathinfo($post->image, PATHINFO_EXTENSION);
        if (strtolower($extension) === 'webp') {
            return;
        }

        // Đường dẫn đầy đủ đến file ảnh
        $imagePath = public_path('storage/' . $post->image);
        
        // Kiểm tra file có tồn tại không
        if (!file_exists($imagePath)) {
            return;
        }

        // Tạo tên file webp mới
        $webpFilename = pathinfo($post->image, PATHINFO_FILENAME) . '.webp';
        $webpPath = dirname($post->image) . '/' . $webpFilename;
        $fullWebpPath = public_path('storage/' . $webpPath);

        // Sử dụng Intervention Image để chuyển đổi ảnh sang WebP
        $manager = new ImageManager(new Driver());
        $image = $manager->read($imagePath);
        
        // Giữ nguyên kích thước, chỉ chuyển đổi định dạng, chất lượng 100%
        $image->toWebp(100)->save($fullWebpPath);

        // Xóa file gốc
        Storage::disk('public')->delete($post->image);

        // Cập nhật đường dẫn mới vào cơ sở dữ liệu
        $post->image = $webpPath;
        $post->saveQuietly(); // Không kích hoạt observer lần nữa
    }
}