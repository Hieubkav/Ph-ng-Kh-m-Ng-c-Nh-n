<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\ServicePost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanUnusedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:clean-unused {--dry-run : Hiển thị file sẽ xóa nhưng không xóa thật}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dọn dẹp ảnh không còn được sử dụng trong storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Đang quét các file ảnh không sử dụng...');
        
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->warn('⚠️  CHẾ ĐỘ DRY RUN - Không xóa file thực tế');
        }
        
        // Lấy tất cả ảnh từ database
        $usedImages = $this->getUsedImages();
        
        $this->info('📊 Tìm thấy ' . count($usedImages) . ' ảnh đang được sử dụng trong database');
        
        // Lấy tất cả file trong storage/uploads
        $allFiles = $this->getAllStorageFiles();
        
        $this->info('📦 Tìm thấy ' . count($allFiles) . ' file trong storage');
        
        // Tìm file không được sử dụng
        $unusedFiles = array_diff($allFiles, $usedImages);
        
        if (empty($unusedFiles)) {
            $this->info('✅ Không có file nào cần dọn dẹp!');
            return 0;
        }
        
        $this->warn('🗑️  Tìm thấy ' . count($unusedFiles) . ' file không sử dụng');
        
        // Tính tổng dung lượng
        $totalSize = 0;
        foreach ($unusedFiles as $file) {
            if (Storage::disk('public')->exists($file)) {
                $totalSize += Storage::disk('public')->size($file);
            }
        }
        
        $this->info('💾 Tổng dung lượng: ' . $this->formatBytes($totalSize));
        
        // Hiển thị danh sách file
        if ($this->option('verbose') || $isDryRun) {
            $this->line('');
            $this->info('📋 Danh sách file sẽ xóa:');
            foreach ($unusedFiles as $file) {
                $size = Storage::disk('public')->exists($file) ? Storage::disk('public')->size($file) : 0;
                $this->line('  - ' . $file . ' (' . $this->formatBytes($size) . ')');
            }
            $this->line('');
        }
        
        if ($isDryRun) {
            $this->info('✨ Dry run hoàn tất. Sử dụng lệnh không có --dry-run để xóa thật.');
            return 0;
        }
        
        // Xác nhận trước khi xóa
        if (!$this->confirm('Bạn có chắc muốn xóa ' . count($unusedFiles) . ' file này?')) {
            $this->info('❌ Đã hủy thao tác.');
            return 0;
        }
        
        // Xóa file
        $deletedCount = 0;
        $errorCount = 0;
        
        $this->withProgressBar($unusedFiles, function ($file) use (&$deletedCount, &$errorCount) {
            try {
                if (Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                    $deletedCount++;
                }
            } catch (\Exception $e) {
                $errorCount++;
                $this->error('Lỗi xóa file ' . $file . ': ' . $e->getMessage());
            }
        });
        
        $this->line('');
        $this->line('');
        $this->info('✅ Đã xóa ' . $deletedCount . ' file (' . $this->formatBytes($totalSize) . ')');
        
        if ($errorCount > 0) {
            $this->error('⚠️  Có ' . $errorCount . ' lỗi xảy ra');
        }
        
        return 0;
    }
    
    /**
     * Lấy danh sách tất cả ảnh đang được sử dụng
     */
    private function getUsedImages(): array
    {
        $usedImages = [];
        
        // Lấy ảnh từ Post
        $posts = Post::all();
        foreach ($posts as $post) {
            // Ảnh chính
            if ($post->image) {
                $usedImages[] = $post->image;
            }
            
            // PDF
            if ($post->pdf) {
                $usedImages[] = $post->pdf;
            }
            
            // Ảnh trong content
            if ($post->content) {
                $contentImages = $this->extractImagesFromContent($post->content);
                $usedImages = array_merge($usedImages, $contentImages);
            }
        }
        
        // Lấy ảnh từ ServicePost
        $servicePosts = ServicePost::all();
        foreach ($servicePosts as $servicePost) {
            // Ảnh chính
            if ($servicePost->image) {
                $usedImages[] = $servicePost->image;
            }
            
            // PDF
            if ($servicePost->pdf) {
                $usedImages[] = $servicePost->pdf;
            }
            
            // Ảnh trong content
            if ($servicePost->content) {
                $contentImages = $this->extractImagesFromContent($servicePost->content);
                $usedImages = array_merge($usedImages, $contentImages);
            }
        }
        
        return array_unique($usedImages);
    }
    
    /**
     * Lấy tất cả file trong storage/uploads
     */
    private function getAllStorageFiles(): array
    {
        $files = [];
        $directories = ['uploads', 'uploads/content', 'uploads/service-content'];
        
        foreach ($directories as $directory) {
            if (Storage::disk('public')->exists($directory)) {
                $dirFiles = Storage::disk('public')->allFiles($directory);
                $files = array_merge($files, $dirFiles);
            }
        }
        
        return $files;
    }
    
    /**
     * Trích xuất ảnh từ HTML content
     */
    private function extractImagesFromContent(string $content): array
    {
        $images = [];
        
        // Tìm tất cả src của img tags
        preg_match_all('/<img[^>]+src=[\'"]([^\'"]+)[\'"][^>]*>/i', $content, $matches);
        
        if (!empty($matches[1])) {
            foreach ($matches[1] as $src) {
                $path = $this->getRelativePathFromUrl($src);
                if ($path) {
                    $images[] = $path;
                }
            }
        }
        
        return array_unique($images);
    }
    
    /**
     * Chuyển URL thành path tương đối
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
            if (preg_match('/uploads\/.*/', $url, $matches)) {
                return $matches[0];
            }
        }
        
        return null;
    }
    
    /**
     * Format bytes thành dạng readable
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
