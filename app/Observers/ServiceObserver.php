<?php

namespace App\Observers;

use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ServiceObserver
{
    /**
     * Handle the Service "created" event.
     */
    public function created(Service $service): void
    {
        $this->convertToWebP($service);
    }

    /**
     * Handle the Service "updated" event.
     */
    public function updated(Service $service): void
    {
        $this->convertToWebP($service);
    }

    /**
     * Handle the Service "deleted" event.
     */
    public function deleted(Service $service): void
    {
        // Xóa file ảnh khi xóa dịch vụ
        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }
    }

    /**
     * Handle the Service "restored" event.
     */
    public function restored(Service $service): void
    {
        //
    }

    /**
     * Handle the Service "force deleted" event.
     */
    public function forceDeleted(Service $service): void
    {
        //
    }

    /**
     * Convert uploaded image to WebP format
     */
    private function convertToWebP(Service $service): void
    {
        // Kiểm tra xem có ảnh không
        if (!$service->image) {
            return;
        }

        // Kiểm tra nếu ảnh đã là WebP thì không cần xử lý
        $extension = pathinfo($service->image, PATHINFO_EXTENSION);
        if (strtolower($extension) === 'webp') {
            return;
        }

        // Đường dẫn đầy đủ đến file ảnh
        $imagePath = public_path('storage/' . $service->image);
        
        // Kiểm tra file có tồn tại không
        if (!file_exists($imagePath)) {
            return;
        }

        // Tạo tên file webp mới
        $webpFilename = pathinfo($service->image, PATHINFO_FILENAME) . '.webp';
        $webpPath = dirname($service->image) . '/' . $webpFilename;
        $fullWebpPath = public_path('storage/' . $webpPath);

        // Sử dụng Intervention Image để chuyển đổi ảnh sang WebP
        $manager = new ImageManager(new Driver());
        $image = $manager->read($imagePath);
        
        // Giữ nguyên kích thước, chỉ chuyển đổi định dạng, chất lượng 100%
        $image->toWebp(100)->save($fullWebpPath);

        // Xóa file gốc
        Storage::disk('public')->delete($service->image);

        // Cập nhật đường dẫn mới vào cơ sở dữ liệu
        $service->image = $webpPath;
        $service->saveQuietly(); // Không kích hoạt observer lần nữa
    }
}
