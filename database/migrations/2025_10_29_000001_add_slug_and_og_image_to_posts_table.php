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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->default('')->after('name');
            $table->string('og_image')->nullable()->after('image');
        });

        $posts = DB::table('posts')
            ->select('id', 'name', 'image')
            ->orderBy('id')
            ->get();

        $usedSlugs = [];

        foreach ($posts as $post) {
            $baseSlug = Str::slug($post->name) ?: 'bai-viet';
            if (is_numeric($baseSlug)) {
                $baseSlug = 'bai-viet-' . $baseSlug;
            }
            $slug = $baseSlug;
            $originalSlug = $baseSlug;
            $suffix = 2;

            while (
                in_array($slug, $usedSlugs, true)
                || DB::table('posts')->where('slug', $slug)->exists()
            ) {
                $slug = $originalSlug . '-' . $suffix;
                $suffix++;
            }

            $usedSlugs[] = $slug;

            DB::table('posts')
                ->where('id', $post->id)
                ->update([
                    'slug' => $slug,
                    'og_image' => $post->image,
                ]);
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropUnique('posts_slug_unique');
            $table->dropColumn(['slug', 'og_image']);
        });
    }
};
