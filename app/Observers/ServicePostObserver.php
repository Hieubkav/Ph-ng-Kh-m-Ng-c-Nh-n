<?php

namespace App\Observers;

use App\Models\ServicePost;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ServicePostObserver
{
    /**
     * Prepare derived attributes ahead of persistence.
     */
    public function creating(ServicePost $servicePost): void
    {
        $this->ensureSlug($servicePost);
        $this->prepareImage($servicePost);
    }

    /**
     * Refresh derived attributes before updates are saved.
     */
    public function updating(ServicePost $servicePost): void
    {
        $this->ensureSlug($servicePost);
        $this->prepareImage($servicePost);
    }

    /**
     * Handle the ServicePost "created" event.
     */
    public function created(ServicePost $servicePost): void
    {
        $this->clearCache();
    }

    /**
     * Handle the ServicePost "updated" event.
     */
    public function updated(ServicePost $servicePost): void
    {
        $this->clearCache();
    }

    /**
     * Handle the ServicePost "deleted" event.
     */
    public function deleted(ServicePost $servicePost): void
    {
        if ($servicePost->image && Storage::disk('public')->exists($servicePost->image)) {
            Storage::disk('public')->delete($servicePost->image);
        }

        if ($servicePost->pdf && Storage::disk('public')->exists($servicePost->pdf)) {
            Storage::disk('public')->delete($servicePost->pdf);
        }
    }

    /**
     * Ensure a unique slug exists for the given record.
     */
    private function ensureSlug(ServicePost $servicePost): void
    {
        if (!$servicePost->name) {
            return;
        }

        if (
            !$servicePost->slug
            || $servicePost->isDirty('name')
            || $servicePost->isDirty('service_id')
        ) {
            $servicePost->slug = $this->generateUniqueSlug($servicePost);
        }
    }

    /**
     * Generate a slug that is unique within the service scope.
     */
    private function generateUniqueSlug(ServicePost $servicePost): string
    {
        $baseSlug = Str::slug($servicePost->name) ?: 'bai-viet-dich-vu';
        if (is_numeric($baseSlug)) {
            $baseSlug = 'bai-viet-dich-vu-' . $baseSlug;
        }
        $slug = $baseSlug;
        $suffix = 2;

        while (
            ServicePost::query()
                ->where('service_id', $servicePost->service_id)
                ->where('slug', $slug)
                ->when($servicePost->exists, fn ($query) => $query->where('id', '!=', $servicePost->id))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }

    /**
     * Keep the stored Open Graph image in sync.
     */
    private function prepareImage(ServicePost $servicePost): void
    {
        $originalImage = $servicePost->getOriginal('image');
        $currentImage = $servicePost->image;

        if (!$currentImage) {
            $this->deleteImageIfExists($originalImage);
            $servicePost->og_image = null;
            return;
        }

        if (!$servicePost->isDirty('image')) {
            $servicePost->og_image = $currentImage;
            return;
        }

        $convertedPath = $this->convertToWebpPath($currentImage);

        if ($convertedPath) {
            $servicePost->image = $convertedPath;
            $servicePost->og_image = $convertedPath;

            if ($originalImage && $originalImage !== $currentImage) {
                $this->deleteImageIfExists($originalImage);
            }
        } else {
            $servicePost->og_image = $currentImage;
        }
    }

    private function convertToWebpPath(string $relativePath): ?string
    {
        $extension = strtolower(pathinfo($relativePath, PATHINFO_EXTENSION));

        if ($extension === 'webp') {
            return $relativePath;
        }

        $absolutePath = Storage::disk('public')->path($relativePath);

        if (!file_exists($absolutePath)) {
            return null;
        }

        $webpFilename = pathinfo($relativePath, PATHINFO_FILENAME) . '.webp';
        $directory = trim(dirname($relativePath), '/\\');
        $webpRelativePath = ($directory ? $directory . '/' : '') . $webpFilename;
        $webpAbsolutePath = Storage::disk('public')->path($webpRelativePath);

        $manager = new ImageManager(new Driver());
        $image = $manager->read($absolutePath);
        $image->toWebp(100)->save($webpAbsolutePath);

        Storage::disk('public')->delete($relativePath);

        return $webpRelativePath;
    }

    private function deleteImageIfExists(?string $relativePath): void
    {
        if ($relativePath && Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }

    /**
     * Clear caches so the frontend reflects the latest changes.
     */
    private function clearCache(): void
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
    }
}
