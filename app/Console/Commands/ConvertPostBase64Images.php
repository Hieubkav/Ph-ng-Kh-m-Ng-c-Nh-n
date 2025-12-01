<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConvertPostBase64Images extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:convert-base64-images
                            {--id= : ID của bài viết cụ thể cần convert}
                            {--dry-run : Chạy thử không lưu vào database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert tất cả base64 images trong content của posts sang storage files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Bắt đầu quét bài viết có base64 images...');
        
        $isDryRun = $this->option('dry-run');
        $specificId = $this->option('id');
        
        if ($isDryRun) {
            $this->warn('⚠️  CHẾ ĐỘ DRY-RUN: Không lưu thay đổi vào database');
        }
        
        // Query posts có base64 images
        $query = Post::where('content', 'LIKE', '%data:image%');
        
        if ($specificId) {
            $query->where('id', $specificId);
        }
        
        $posts = $query->get();
        
        if ($posts->isEmpty()) {
            $this->info('✅ Không tìm thấy bài viết nào có base64 images');
            return Command::SUCCESS;
        }
        
        $this->info("📊 Tìm thấy {$posts->count()} bài viết có base64 images");
        
        $progressBar = $this->output->createProgressBar($posts->count());
        $progressBar->start();
        
        $successCount = 0;
        $errorCount = 0;
        $skippedCount = 0;
        
        foreach ($posts as $post) {
            try {
                $originalContent = $post->content;
                
                // Đếm số lượng base64 images
                preg_match_all('/data:image\/(png|jpg|jpeg|gif|webp|svg\+xml);base64,/i', $originalContent, $matches);
                $imageCount = count($matches[0]);
                
                if ($imageCount === 0) {
                    $skippedCount++;
                    $progressBar->advance();
                    continue;
                }
                
                if (!$isDryRun) {
                    // Trigger observer để convert base64
                    // Cách 1: Sử dụng save() để trigger observer
                    $post->content = $originalContent; // Đảm bảo content được dirty
                    $post->save();
                    
                    $this->newLine();
                    $this->info("✅ Post #{$post->id}: Converted {$imageCount} images");
                } else {
                    $this->newLine();
                    $this->comment("🔍 Post #{$post->id}: Sẽ convert {$imageCount} images (dry-run)");
                }
                
                $successCount++;
                
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("❌ Post #{$post->id}: " . $e->getMessage());
                Log::error("Failed to convert base64 images for Post #{$post->id}: " . $e->getMessage());
                $errorCount++;
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine(2);
        
        // Tổng kết
        $this->info('📈 KẾT QUẢ:');
        $this->table(
            ['Trạng thái', 'Số lượng'],
            [
                ['Thành công', $successCount],
                ['Lỗi', $errorCount],
                ['Bỏ qua', $skippedCount],
            ]
        );
        
        if ($isDryRun) {
            $this->warn('⚠️  Đây là dry-run, không có thay đổi nào được lưu');
            $this->info('💡 Chạy lại không có --dry-run để thực sự convert');
        } else {
            $this->info('✅ Hoàn tất! Kiểm tra thư mục storage/app/public/uploads/content/');
        }
        
        return Command::SUCCESS;
    }
}
