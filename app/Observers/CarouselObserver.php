<?php

namespace App\Observers;

use App\Models\Carousel;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CarouselObserver
{
    /**
     * Handle the Carousel "created" event.
     */
    public function created(Carousel $carousel): void
    {
        $this->convertToWebP($carousel);
    }

    /**
     * Handle the Carousel "updated" event.
     */
    public function updated(Carousel $carousel): void
    {
        $this->convertToWebP($carousel);
    }

    /**
     * Convert uploaded image to WebP format
     */
    private function convertToWebP(Carousel $carousel): void
    {
        // Kiểm tra xem có ảnh không
        if (!$carousel->image) {
            return;
        }

        // Kiểm tra nếu ảnh đã là WebP thì không cần xử lý
        $extension = pathinfo($carousel->image, PATHINFO_EXTENSION);
        if (strtolower($extension) === 'webp') {
            return;
        }

        // Đường dẫn đầy đủ đến file ảnh
        $imagePath = public_path('storage/' . $carousel->image);
        
        // Kiểm tra file có tồn tại không
        if (!file_exists($imagePath)) {
            return;
        }

        // Tạo tên file webp mới
        $webpFilename = pathinfo($carousel->image, PATHINFO_FILENAME) . '.webp';
        $webpPath = dirname($carousel->image) . '/' . $webpFilename;
        $fullWebpPath = public_path('storage/' . $webpPath);

        // Sử dụng Intervention Image để chuyển đổi ảnh sang WebP
        $manager = new ImageManager(new Driver());
        $image = $manager->read($imagePath);
        
        // Giữ nguyên kích thước, chỉ chuyển đổi định dạng
        $image->toWebp(100)->save($fullWebpPath);

        // Xóa file gốc
        Storage::disk('public')->delete($carousel->image);

        // Cập nhật đường dẫn mới vào cơ sở dữ liệu
        $carousel->image = $webpPath;
        $carousel->saveQuietly(); // Không kích hoạt observer lần nữa
    }
}