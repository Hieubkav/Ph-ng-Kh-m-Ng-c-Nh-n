<?php

namespace App\Observers;

use App\Models\ServicePost;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ServicePostObserver
{
    /**
     * Handle the ServicePost "creating" event.
     */
    public function creating(ServicePost $servicePost): void
    {
        // Tự động tạo slug nếu chưa có
        if (empty($servicePost->slug)) {
            $servicePost->slug = \Str::slug($servicePost->name);
        }
    }

    /**
     * Handle the ServicePost "saving" event.
     * Convert base64 images trong content sang storage files
     */
    public function saving(ServicePost $servicePost): void
    {
        if ($servicePost->content) {
            $servicePost->content = $this->convertBase64ToStorage($servicePost->content);
        }
    }

    /**
     * Handle the ServicePost "updating" event.
     * Xóa ảnh cũ khi có ảnh mới được upload
     */
    public function updating(ServicePost $servicePost): void
    {
        // Lấy dữ liệu cũ từ database
        $oldServicePost = ServicePost::find($servicePost->id);
        
        if (!$oldServicePost) {
            return;
        }

        // Xử lý ảnh chính (image)
        if ($servicePost->image !== $oldServicePost->image) {
            $this->deleteOldImage($oldServicePost->image);
            Log::info("Deleted old image for ServicePost ID {$servicePost->id}: {$oldServicePost->image}");
        }

        // Xử lý file PDF
        if ($servicePost->pdf !== $oldServicePost->pdf) {
            $this->deleteOldImage($oldServicePost->pdf);
            Log::info("Deleted old PDF for ServicePost ID {$servicePost->id}: {$oldServicePost->pdf}");
        }

        // Xử lý ảnh trong content editor
        $this->handleContentImages($oldServicePost->content, $servicePost->content);
    }

    /**
     * Handle the ServicePost "deleted" event.
     * Xóa tất cả ảnh khi xóa bài viết dịch vụ
     */
    public function deleted(ServicePost $servicePost): void
    {
        // Xóa ảnh chính
        if ($servicePost->image) {
            $this->deleteOldImage($servicePost->image);
            Log::info("Deleted image for deleted ServicePost ID {$servicePost->id}: {$servicePost->image}");
        }

        // Xóa file PDF
        if ($servicePost->pdf) {
            $this->deleteOldImage($servicePost->pdf);
            Log::info("Deleted PDF for deleted ServicePost ID {$servicePost->id}: {$servicePost->pdf}");
        }

        // Xóa tất cả ảnh trong content
        $this->deleteContentImages($servicePost->content);
    }

    /**
     * Handle the ServicePost "restored" event.
     */
    public function restored(ServicePost $servicePost): void
    {
        Log::info("ServicePost ID {$servicePost->id} has been restored");
    }

    /**
     * Handle the ServicePost "force deleted" event.
     */
    public function forceDeleted(ServicePost $servicePost): void
    {
        // Giống như deleted nhưng cho force delete
        $this->deleted($servicePost);
    }

    /**
     * Xóa file ảnh cũ từ storage
     */
    private function deleteOldImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        try {
            // Kiểm tra xem file có tồn tại không
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                Log::info("Successfully deleted file: {$path}");
            } else {
                Log::warning("File not found for deletion: {$path}");
            }
        } catch (\Exception $e) {
            Log::error("Error deleting file {$path}: " . $e->getMessage());
        }
    }

    /**
     * Xử lý ảnh trong content editor khi update
     * So sánh content cũ và mới để xóa ảnh không còn sử dụng
     */
    private function handleContentImages(?string $oldContent, ?string $newContent): void
    {
        if (!$oldContent) {
            return;
        }

        // Lấy danh sách ảnh từ content cũ
        $oldImages = $this->extractImagesFromContent($oldContent);
        
        // Lấy danh sách ảnh từ content mới
        $newImages = $this->extractImagesFromContent($newContent ?? '');
        
        // Tìm ảnh không còn được sử dụng
        $imagesToDelete = array_diff($oldImages, $newImages);
        
        foreach ($imagesToDelete as $image) {
            // Chỉ xóa ảnh từ uploads/service-content (ảnh của editor)
            if (str_contains($image, 'uploads/service-content/')) {
                $this->deleteOldImage($image);
                Log::info("Deleted unused service content image: {$image}");
            }
        }
    }

    /**
     * Xóa tất cả ảnh trong content khi xóa bài viết
     */
    private function deleteContentImages(?string $content): void
    {
        if (!$content) {
            return;
        }

        $images = $this->extractImagesFromContent($content);
        
        foreach ($images as $image) {
            // Chỉ xóa ảnh từ uploads/service-content (ảnh của editor)
            if (str_contains($image, 'uploads/service-content/')) {
                $this->deleteOldImage($image);
                Log::info("Deleted service content image: {$image}");
            }
        }
    }

    /**
     * Trích xuất danh sách ảnh từ HTML content
     */
    private function extractImagesFromContent(string $content): array
    {
        $images = [];
        
        // Tìm tất cả src của img tags
        preg_match_all('/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $content, $matches);
        
        if (!empty($matches[1])) {
            foreach ($matches[1] as $src) {
                // Lấy path tương đối từ URL
                $path = $this->getRelativePathFromUrl($src);
                if ($path) {
                    $images[] = $path;
                }
            }
        }

        // Tìm ảnh trong data-url attributes (TipTap có thể dùng)
        preg_match_all('/data-url=[\'"]([^\'"]+)[\'"]/', $content, $dataMatches);
        
        if (!empty($dataMatches[1])) {
            foreach ($dataMatches[1] as $src) {
                $path = $this->getRelativePathFromUrl($src);
                if ($path) {
                    $images[] = $path;
                }
            }
        }

        return array_unique($images);
    }

    /**
     * Chuyển URL thành path tương đối cho storage
     */
    private function getRelativePathFromUrl(string $url): ?string
    {
        // Xóa domain nếu có
        $url = str_replace(config('app.url'), '', $url);
        $url = str_replace(url('/'), '', $url);
        
        // Xóa /storage/ prefix
        $url = preg_replace('/^\/storage\//', '', $url);
        $url = preg_replace('/^storage\//', '', $url);
        
        // Chỉ xử lý ảnh trong uploads/
        if (str_contains($url, 'uploads/')) {
            // Lấy phần sau uploads/
            if (preg_match('/uploads\/.*/', $url, $matches)) {
                return $matches[0];
            }
        }
        
        return null;
    }

    /**
     * Convert tất cả base64 images trong content sang storage files
     */
    private function convertBase64ToStorage(string $content): string
    {
        // Tìm tất cả base64 images trong content
        // Pattern: data:image/{type};base64,{data}
        preg_match_all('/data:image\/(png|jpg|jpeg|gif|webp|svg\+xml);base64,([A-Za-z0-9+\/=]+)/i', $content, $matches, PREG_SET_ORDER);
        
        if (empty($matches)) {
            return $content;
        }

        $convertedCount = 0;
        
        foreach ($matches as $match) {
            $fullBase64 = $match[0]; // Full base64 string
            $extension = $match[1]; // Image type
            $base64Data = $match[2]; // Base64 encoded data
            
            // Xử lý extension đặc biệt
            if ($extension === 'svg+xml') {
                $extension = 'svg';
            }
            
            try {
                // Convert base64 thành file và lưu vào storage
                $filePath = $this->saveBase64AsFile($base64Data, $extension);
                
                // Tạo URL cho file
                $fileUrl = Storage::disk('public')->url($filePath);
                
                // Thay thế base64 bằng URL trong content
                $content = str_replace($fullBase64, $fileUrl, $content);
                
                $convertedCount++;
                Log::info("Converted base64 image to storage (ServicePost): {$filePath}");
                
            } catch (\Exception $e) {
                Log::error("Failed to convert base64 image (ServicePost): " . $e->getMessage());
                // Tiếp tục với ảnh tiếp theo nếu có lỗi
                continue;
            }
        }
        
        if ($convertedCount > 0) {
            Log::info("Successfully converted {$convertedCount} base64 images to storage (ServicePost)");
        }
        
        return $content;
    }

    /**
     * Lưu base64 data thành file trong storage
     */
    private function saveBase64AsFile(string $base64Data, string $extension): string
    {
        // Decode base64 data
        $imageData = base64_decode($base64Data);
        
        if ($imageData === false) {
            throw new \Exception("Failed to decode base64 data");
        }
        
        // Tạo tên file unique với prefix service-lexical
        $filename = 'service-lexical-' . time() . '-' . uniqid() . '.' . $extension;
        $path = 'uploads/service-content/' . $filename;
        
        // Tạo thư mục nếu chưa tồn tại
        $directory = dirname($path);
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
        
        // Lưu file vào storage
        $saved = Storage::disk('public')->put($path, $imageData);
        
        if (!$saved) {
            throw new \Exception("Failed to save file to storage");
        }
        
        return $path;
    }
}
