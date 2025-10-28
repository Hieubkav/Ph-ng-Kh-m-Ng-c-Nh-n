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
        $this->syncOgImage($servicePost);
    }

    /**
     * Refresh derived attributes before updates are saved.
     */
    public function updating(ServicePost $servicePost): void
    {
        $this->ensureSlug($servicePost);
        $this->syncOgImage($servicePost);
    }

    /**
     * Handle the ServicePost "created" event.
     */
    public function created(ServicePost $servicePost): void
    {
        $this->convertToWebP($servicePost);
        $this->clearCache();
    }

    /**
     * Handle the ServicePost "updated" event.
     */
    public function updated(ServicePost $servicePost): void
    {
        $this->convertToWebP($servicePost);
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
    private function syncOgImage(ServicePost $servicePost): void
    {
        $servicePost->og_image = $servicePost->image ?: null;
    }

    /**
     * Convert uploaded images to WebP format when needed.
     */
    private function convertToWebP(ServicePost $servicePost): void
    {
        if (!$servicePost->image) {
            $servicePost->og_image = null;
            return;
        }

        $extension = pathinfo($servicePost->image, PATHINFO_EXTENSION);

        if (strtolower($extension) === 'webp') {
            $servicePost->og_image = $servicePost->image;
            return;
        }

        $imagePath = public_path('storage/' . $servicePost->image);

        if (!file_exists($imagePath)) {
            return;
        }

        $webpFilename = pathinfo($servicePost->image, PATHINFO_FILENAME) . '.webp';
        $webpPath = trim(dirname($servicePost->image), '/\\');
        $webpPath = ($webpPath ? $webpPath . '/' : '') . $webpFilename;
        $fullWebpPath = public_path('storage/' . $webpPath);

        $manager = new ImageManager(new Driver());
        $image = $manager->read($imagePath);
        $image->toWebp(100)->save($fullWebpPath);

        Storage::disk('public')->delete($servicePost->image);

        $servicePost->image = $webpPath;
        $servicePost->og_image = $webpPath;
        $servicePost->saveQuietly();
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
