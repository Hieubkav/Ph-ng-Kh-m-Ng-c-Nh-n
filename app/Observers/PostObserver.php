<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
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
        $this->prepareImage($post);
    }

    /**
     * Refresh derived attributes ahead of updates.
     */
    public function updating(Post $post): void
    {
        $this->ensureSlug($post);
        $this->prepareImage($post);
    }

    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        $this->clearCache();
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
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
    private function prepareImage(Post $post): void
    {
        $originalImage = $post->getOriginal('image');
        $currentImage = $post->image;

        if (!$currentImage) {
            $this->deleteImageIfExists($originalImage);
            $post->og_image = null;
            return;
        }

        if (!$post->isDirty('image')) {
            $post->og_image = $currentImage;
            return;
        }

        $convertedPath = $this->convertToWebpPath($currentImage);

        if ($convertedPath) {
            $post->image = $convertedPath;
            $post->og_image = $convertedPath;

            if ($originalImage && $originalImage !== $currentImage) {
                $this->deleteImageIfExists($originalImage);
            }
        } else {
            $post->og_image = $currentImage;
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
    * Flush storefront caches that may hold stale data.
    */
    private function clearCache(): void
    {
    Cache::forget('storefront_hot_posts');
    Cache::forget('storefront_cat_posts');
    }
}
