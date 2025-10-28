<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PostObserver
{
    /**
     * Set default values before the model is persisted.
     */
    public function creating(Post $post): void
    {
        $this->ensureSlug($post);
        $this->syncOgImage($post);
    }

    /**
     * Refresh derived attributes ahead of updates.
     */
    public function updating(Post $post): void
    {
        $this->ensureSlug($post);
        $this->syncOgImage($post);
    }

    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $this->convertToWebP($post);
        $this->clearCache();
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        $this->convertToWebP($post);
        $this->clearCache();
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        if ($post->pdf && Storage::disk('public')->exists($post->pdf)) {
            Storage::disk('public')->delete($post->pdf);
        }
    }

    /**
     * Make sure a unique slug is present on the model.
     */
    private function ensureSlug(Post $post): void
    {
        if (!$post->name) {
            return;
        }

        if (!$post->slug || $post->isDirty('name')) {
            $post->slug = $this->generateUniqueSlug($post);
        }
    }

    /**
     * Generate a unique slug based on the post title.
     */
    private function generateUniqueSlug(Post $post): string
    {
        $baseSlug = Str::slug($post->name) ?: 'bai-viet';
        if (is_numeric($baseSlug)) {
            $baseSlug = 'bai-viet-' . $baseSlug;
        }
        $slug = $baseSlug;
        $suffix = 2;

        while (
            Post::query()
                ->where('slug', $slug)
                ->when($post->exists, fn ($query) => $query->where('id', '!=', $post->id))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }

    /**
     * Keep the stored og_image in sync with the main image.
     */
    private function syncOgImage(Post $post): void
    {
        $post->og_image = $post->image ?: null;
    }

    /**
     * Convert uploaded images to WebP and update the stored paths.
     */
    private function convertToWebP(Post $post): void
    {
        if (!$post->image) {
            $post->og_image = null;
            return;
        }

        $extension = pathinfo($post->image, PATHINFO_EXTENSION);

        if (strtolower($extension) === 'webp') {
            $post->og_image = $post->image;
            return;
        }

        $imagePath = public_path('storage/' . $post->image);

        if (!file_exists($imagePath)) {
            return;
        }

        $webpFilename = pathinfo($post->image, PATHINFO_FILENAME) . '.webp';
        $webpPath = trim(dirname($post->image), '/\\');
        $webpPath = ($webpPath ? $webpPath . '/' : '') . $webpFilename;
        $fullWebpPath = public_path('storage/' . $webpPath);

        $manager = new ImageManager(new Driver());
        $image = $manager->read($imagePath);
        $image->toWebp(100)->save($fullWebpPath);

        Storage::disk('public')->delete($post->image);

        $post->image = $webpPath;
        $post->og_image = $webpPath;
        $post->saveQuietly();
    }

    /**
     * Flush application caches that may hold stale data.
     */
    private function clearCache(): void
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
    }
}
