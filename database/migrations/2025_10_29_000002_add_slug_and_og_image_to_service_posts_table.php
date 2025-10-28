<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_posts', function (Blueprint $table) {
            $table->string('slug')->default('')->after('name');
            $table->string('og_image')->nullable()->after('image');
        });

        $servicePosts = DB::table('service_posts')
            ->select('id', 'service_id', 'name', 'image')
            ->orderBy('service_id')
            ->orderBy('id')
            ->get();

        $usedSlugs = [];

        foreach ($servicePosts as $post) {
            $baseSlug = Str::slug($post->name) ?: 'bai-viet-dich-vu';
            if (is_numeric($baseSlug)) {
                $baseSlug = 'bai-viet-dich-vu-' . $baseSlug;
            }
            $slug = $baseSlug;
            $originalSlug = $baseSlug;
            $suffix = 2;
            $serviceId = (int) $post->service_id;

            $usedSlugs[$serviceId] = $usedSlugs[$serviceId] ?? [];

            while (
                in_array($slug, $usedSlugs[$serviceId], true)
                || DB::table('service_posts')
                    ->where('service_id', $serviceId)
                    ->where('slug', $slug)
                    ->exists()
            ) {
                $slug = $originalSlug . '-' . $suffix;
                $suffix++;
            }

            $usedSlugs[$serviceId][] = $slug;

            DB::table('service_posts')
                ->where('id', $post->id)
                ->update([
                    'slug' => $slug,
                    'og_image' => $post->image,
                ]);
        }

        Schema::table('service_posts', function (Blueprint $table) {
            $table->unique(['service_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_posts', function (Blueprint $table) {
            $table->dropUnique('service_posts_service_id_slug_unique');
            $table->dropColumn(['slug', 'og_image']);
        });
    }
};
