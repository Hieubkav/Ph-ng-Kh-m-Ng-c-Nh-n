<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Doctor;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\ServicePost;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class StorageCleanupController extends Controller
{
    /**
     * Dọn dẹp các file không sử dụng trong storage
     */
    public function cleanupUnusedFiles(Request $request)
    {
        // Bỏ kiểm tra xác thực để test
        // if (!auth()->check() || !Auth::user()->hasRole('admin')) {
        //     abort(403, 'Bạn không có quyền thực hiện hành động này');
        // }

        $disk = Storage::disk('public');
        $uploadDir = 'uploads';
        $scheduleDir = 'schedules';
        
        // Lấy danh sách các file trong thư mục uploads và schedules
        $allUploadedFiles = collect($disk->allFiles($uploadDir))
            ->merge(collect($disk->allFiles($scheduleDir)))
            ->map(function ($path) {
                return $path; // Chuyển đường dẫn tương đối
            });

        // Lấy danh sách file đang được sử dụng từ database và model chứa nó
        $usedFilesWithModel = collect();
        
        // Thu thập thông tin file từ các model
        $usedFilesWithModel = $usedFilesWithModel->merge($this->getFilesWithModelInfo(Carousel::all(), 'image', 'CarouselResource'));
        $usedFilesWithModel = $usedFilesWithModel->merge($this->getFilesWithModelInfo(Doctor::all(), 'image', 'DoctorResource'));
        $usedFilesWithModel = $usedFilesWithModel->merge($this->getFilesWithModelInfo(Service::all(), 'image', 'ServiceResource'));
        $usedFilesWithModel = $usedFilesWithModel->merge($this->getFilesWithModelInfo(Schedule::all(), 'url_thumbnail', 'ScheduleResource'));
        $usedFilesWithModel = $usedFilesWithModel->merge($this->getFilesWithModelInfo(Post::all(), 'image', 'PostResource'));
        $usedFilesWithModel = $usedFilesWithModel->merge($this->getFilesWithModelInfo(Post::all(), 'pdf', 'PostResource'));
        $usedFilesWithModel = $usedFilesWithModel->merge($this->getFilesWithModelInfo(ServicePost::all(), 'image', 'ServicePostResource'));
        $usedFilesWithModel = $usedFilesWithModel->merge($this->getFilesWithModelInfo(ServicePost::all(), 'pdf', 'ServicePostResource'));
        
        // Thêm kiểm tra file từ SettingUp page
        $setting = Setting::first();
        if ($setting) {
            // Thêm ảnh logo
            if ($setting->logo) {
                $usedFilesWithModel->push([
                    'path' => $setting->logo,
                    'model' => Setting::class,
                    'model_id' => $setting->id,
                    'resource' => 'SettingUp'
                ]);
            }
            
            // Thêm ảnh mặc định
            if ($setting->tmp_pic) {
                $usedFilesWithModel->push([
                    'path' => $setting->tmp_pic,
                    'model' => Setting::class,
                    'model_id' => $setting->id,
                    'resource' => 'SettingUp'
                ]);
            }
        }

        // Tạo một collection chỉ chứa đường dẫn file
        $usedFiles = $usedFilesWithModel->pluck('path');

        // Tìm các file không còn sử dụng
        $unusedFiles = $allUploadedFiles->reject(function ($file) use ($usedFiles) {
            foreach ($usedFiles as $usedFile) {
                if ($usedFile && strpos($file, $usedFile) !== false) {
                    return true; // File đang được sử dụng
                }
            }
            return false; // File không được sử dụng
        });

        // Chuẩn bị thông tin file
        $fileInfos = [];
        foreach ($allUploadedFiles as $file) {
            $path = public_path('storage/' . $file);
            $size = File::exists($path) ? $this->formatBytes(File::size($path)) : 'Unknown';
            $extension = File::extension($path);
            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
            $isPdf = strtolower($extension) === 'pdf';
            $url = asset('storage/' . $file);
            $created = File::exists($path) ? date('d/m/Y H:i:s', File::lastModified($path)) : 'Unknown';
            
            // Kiểm tra xem file có đang được sử dụng không
            $isUsed = false;
            $resourceInfo = null;
            foreach ($usedFilesWithModel as $usedFile) {
                if ($usedFile['path'] && strpos($file, $usedFile['path']) !== false) {
                    $isUsed = true;
                    $resourceInfo = $usedFile['resource'];
                    break;
                }
            }

            $fileInfos[] = [
                'path' => $file,
                'size' => $size,
                'extension' => $extension,
                'isImage' => $isImage,
                'isPdf' => $isPdf,
                'url' => $url,
                'created' => $created,
                'isUsed' => $isUsed,
                'resource' => $resourceInfo
            ];
        }

        // Sắp xếp file theo thời gian tạo (mới nhất trước)
        usort($fileInfos, function($a, $b) {
            $dateA = $a['created'] !== 'Unknown' ? strtotime($a['created']) : 0;
            $dateB = $b['created'] !== 'Unknown' ? strtotime($b['created']) : 0;
            return $dateB - $dateA;
        });

        // Thống kê
        $totalFiles = $allUploadedFiles->count();
        $usedCount = $usedFiles->count();
        $unusedCount = $unusedFiles->count();
        
        // Xử lý xóa các file đã chọn
        if ($request->isMethod('post')) {
            $filesToDelete = $request->input('files', []);
            $deletedCount = 0;
            
            foreach ($filesToDelete as $file) {
                if ($disk->exists($file)) {
                    $disk->delete($file);
                    $deletedCount++;
                }
            }
            
            return redirect()->route('cleanup.storage')
                ->with('success', "Đã xóa thành công $deletedCount file.");
        }
        
        return view('admin.storage-cleanup', [
            'fileInfos' => $fileInfos,
            'totalFiles' => $totalFiles,
            'usedCount' => $usedCount,
            'unusedCount' => $unusedCount,
        ]);
    }
    
    /**
     * Thu thập thông tin về file và model chứa nó
     */
    private function getFilesWithModelInfo($records, $field, $resourceName)
    {
        return $records->map(function($item) use ($field, $resourceName) {
            return [
                'path' => $item->{$field},
                'model' => get_class($item),
                'model_id' => $item->id,
                'resource' => $resourceName
            ];
        })->filter(function ($value) {
            return !empty($value['path']);
        });
    }
    
    /**
     * Lấy danh sách các file từ một model
     */
    private function getFilesFromModel($records, $field)
    {
        return $records->pluck($field)->filter(function ($value) {
            return !empty($value);
        });
    }
    
    /**
     * Format byte size sang định dạng đọc được
     */
    private function formatBytes($bytes, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}