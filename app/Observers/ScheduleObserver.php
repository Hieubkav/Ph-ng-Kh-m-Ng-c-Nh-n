<?php

namespace App\Observers;

use App\Models\Schedule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ScheduleObserver
{
    /**
    * Handle the Schedule "created" event.
    */
    public function created(Schedule $schedule): void
    {
    $this->convertToWebP($schedule);
        Cache::forget('storefront_active_schedule');
    }

    /**
    * Handle the Schedule "updated" event.
     */
    public function updated(Schedule $schedule): void
    {
        $this->convertToWebP($schedule);
        Cache::forget('storefront_active_schedule');
    }

    /**
     * Handle the Schedule "deleted" event.
     */
    public function deleted(Schedule $schedule): void
    {
    // Xóa file ảnh khi xóa lịch khám
    if ($schedule->url_thumbnail && Storage::disk('public')->exists($schedule->url_thumbnail)) {
            Storage::disk('public')->delete($schedule->url_thumbnail);
        }
        Cache::forget('storefront_active_schedule');
    }

    /**
     * Convert uploaded image to WebP format
     */
    private function convertToWebP(Schedule $schedule): void
    {
        // Kiểm tra xem có ảnh không
        if (!$schedule->url_thumbnail) {
            return;
        }

        // Kiểm tra nếu ảnh đã là WebP thì không cần xử lý
        $extension = pathinfo($schedule->url_thumbnail, PATHINFO_EXTENSION);
        if (strtolower($extension) === 'webp') {
            return;
        }

        // Đường dẫn đầy đủ đến file ảnh
        $imagePath = public_path('storage/' . $schedule->url_thumbnail);
        
        // Kiểm tra file có tồn tại không
        if (!file_exists($imagePath)) {
            return;
        }

        // Tạo tên file webp mới
        $webpFilename = pathinfo($schedule->url_thumbnail, PATHINFO_FILENAME) . '.webp';
        $webpPath = dirname($schedule->url_thumbnail) . '/' . $webpFilename;
        $fullWebpPath = public_path('storage/' . $webpPath);

        // Sử dụng Intervention Image để chuyển đổi ảnh sang WebP
        $manager = new ImageManager(new Driver());
        $image = $manager->read($imagePath);
        
        // Giữ nguyên kích thước, chỉ chuyển đổi định dạng, chất lượng 100%
        $image->toWebp(100)->save($fullWebpPath);

        // Xóa file gốc
        Storage::disk('public')->delete($schedule->url_thumbnail);

        // Cập nhật đường dẫn mới vào cơ sở dữ liệu
        $schedule->url_thumbnail = $webpPath;
        $schedule->saveQuietly(); // Không kích hoạt observer lần nữa
    }
}