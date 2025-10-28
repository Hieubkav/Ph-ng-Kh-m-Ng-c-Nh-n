<?php

namespace App\Observers;

use App\Models\ServicePost;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ServicePostObserver
{
    /**
     * Handle the ServicePost "created" event.
     */
    public function created(ServicePost $servicePost): void
    {
        $this->convertToWebP($servicePost);
    }

    /**
     * Handle the ServicePost "updated" event.
     */
    public function updated(ServicePost $servicePost): void
    {
        $this->convertToWebP($servicePost);
    }

    /**
     * Handle the ServicePost "deleted" event.
     */
    public function deleted(ServicePost $servicePost): void
    {
        // Xóa file ảnh khi xóa bài viết dịch vụ
        if ($servicePost->image && Storage::disk('public')->exists($servicePost->image)) {
            Storage::disk('public')->delete($servicePost->image);
        }

        // Xóa file PDF nếu có
        if ($servicePost->pdf && Storage::disk('public')->exists($servicePost->pdf)) {
            Storage::disk('public')->delete($servicePost->pdf);
        }
    }

    /**
     * Convert uploaded image to WebP format
     */
    private function convertToWebP(ServicePost $servicePost): void
    {
        // Kiểm tra xem có ảnh không
        if (!$servicePost->image) {
            return;
        }

        // Kiểm tra nếu ảnh đã là WebP thì không cần xử lý
        $extension = pathinfo($servicePost->image, PATHINFO_EXTENSION);
        if (strtolower($extension) === 'webp') {
            return;
        }

        // Đường dẫn đầy đủ đến file ảnh
        $imagePath = public_path('storage/' . $servicePost->image);
        
        // Kiểm tra file có tồn tại không
        if (!file_exists($imagePath)) {
            return;
        }

        // Tạo tên file webp mới
        $webpFilename = pathinfo($servicePost->image, PATHINFO_FILENAME) . '.webp';
        $webpPath = dirname($servicePost->image) . '/' . $webpFilename;
        $fullWebpPath = public_path('storage/' . $webpPath);

        // Sử dụng Intervention Image để chuyển đổi ảnh sang WebP
        $manager = new ImageManager(new Driver());
        $image = $manager->read($imagePath);
        
        // Giữ nguyên kích thước, chỉ chuyển đổi định dạng, chất lượng 100%
        $image->toWebp(100)->save($fullWebpPath);

        // Xóa file gốc
        Storage::disk('public')->delete($servicePost->image);

        // Cập nhật đường dẫn mới vào cơ sở dữ liệu
        $servicePost->image = $webpPath;
        $servicePost->saveQuietly(); // Không kích hoạt observer lần nữa
    }
}