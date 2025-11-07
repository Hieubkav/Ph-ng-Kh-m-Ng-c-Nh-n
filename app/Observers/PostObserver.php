<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PostObserver
{
    /**
     * Handle the Post "creating" event.
     */
    public function creating(Post $post): void
    {
        // Tự động tạo slug nếu chưa có
        if (empty($post->slug)) {
            $post->slug = \Str::slug($post->name);
        }
    }

    /**
     * Handle the Post "updating" event.
     * Xóa ảnh cũ khi có ảnh mới được upload
     */
    public function updating(Post $post): void
    {
        // Lấy dữ liệu cũ từ database
        $oldPost = Post::find($post->id);
        
        if (!$oldPost) {
            return;
        }

        // Xử lý ảnh chính (image)
        if ($post->image !== $oldPost->image) {
            $this->deleteOldImage($oldPost->image);
            Log::info("Deleted old image for Post ID {$post->id}: {$oldPost->image}");
        }

        // Xử lý file PDF
        if ($post->pdf !== $oldPost->pdf) {
            $this->deleteOldImage($oldPost->pdf);
            Log::info("Deleted old PDF for Post ID {$post->id}: {$oldPost->pdf}");
        }

        // Xử lý ảnh trong content editor
        $this->handleContentImages($oldPost->content, $post->content);
    }

    /**
     * Handle the Post "deleted" event.
     * Xóa tất cả ảnh khi xóa bài viết
     */
    public function deleted(Post $post): void
    {
        // Xóa ảnh chính
        if ($post->image) {
            $this->deleteOldImage($post->image);
            Log::info("Deleted image for deleted Post ID {$post->id}: {$post->image}");
        }

        // Xóa file PDF
        if ($post->pdf) {
            $this->deleteOldImage($post->pdf);
            Log::info("Deleted PDF for deleted Post ID {$post->id}: {$post->pdf}");
        }

        // Xóa tất cả ảnh trong content
        $this->deleteContentImages($post->content);
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        Log::info("Post ID {$post->id} has been restored");
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        // Giống như deleted nhưng cho force delete
        $this->deleted($post);
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
            // Chỉ xóa ảnh từ uploads/content (ảnh của editor)
            if (str_contains($image, 'uploads/content/')) {
                $this->deleteOldImage($image);
                Log::info("Deleted unused content image: {$image}");
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
            // Chỉ xóa ảnh từ uploads/content (ảnh của editor)
            if (str_contains($image, 'uploads/content/')) {
                $this->deleteOldImage($image);
                Log::info("Deleted content image: {$image}");
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
}
