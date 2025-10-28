<?php

namespace App\Observers;

use App\Models\Doctor;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class DoctorObserver
{
    /**
     * Handle the Doctor "created" event.
     */
    public function created(Doctor $doctor): void
    {
        $this->convertToWebP($doctor);
    }

    /**
     * Handle the Doctor "updated" event.
     */
    public function updated(Doctor $doctor): void
    {
        $this->convertToWebP($doctor);
    }

    /**
     * Handle the Doctor "deleted" event.
     */
    public function deleted(Doctor $doctor): void
    {
        // Xóa file ảnh khi xóa bác sĩ
        if ($doctor->image && Storage::disk('public')->exists($doctor->image)) {
            Storage::disk('public')->delete($doctor->image);
        }
    }

    /**
     * Handle the Doctor "restored" event.
     */
    public function restored(Doctor $doctor): void
    {
        //
    }

    /**
     * Handle the Doctor "force deleted" event.
     */
    public function forceDeleted(Doctor $doctor): void
    {
        //
    }

    /**
     * Convert uploaded image to WebP format
     */
    private function convertToWebP(Doctor $doctor): void
    {
        // Kiểm tra xem có ảnh không
        if (!$doctor->image) {
            return;
        }

        // Kiểm tra nếu ảnh đã là WebP thì không cần xử lý
        $extension = pathinfo($doctor->image, PATHINFO_EXTENSION);
        if (strtolower($extension) === 'webp') {
            return;
        }

        // Đường dẫn đầy đủ đến file ảnh
        $imagePath = public_path('storage/' . $doctor->image);
        
        // Kiểm tra file có tồn tại không
        if (!file_exists($imagePath)) {
            return;
        }

        // Tạo tên file webp mới
        $webpFilename = pathinfo($doctor->image, PATHINFO_FILENAME) . '.webp';
        $webpPath = dirname($doctor->image) . '/' . $webpFilename;
        $fullWebpPath = public_path('storage/' . $webpPath);

        // Sử dụng Intervention Image để chuyển đổi ảnh sang WebP
        $manager = new ImageManager(new Driver());
        $image = $manager->read($imagePath);
        
        // Giữ nguyên kích thước, chỉ chuyển đổi định dạng, chất lượng 100%
        $image->toWebp(100)->save($fullWebpPath);

        // Xóa file gốc
        Storage::disk('public')->delete($doctor->image);

        // Cập nhật đường dẫn mới vào cơ sở dữ liệu
        $doctor->image = $webpPath;
        $doctor->saveQuietly(); // Không kích hoạt observer lần nữa
    }
}
