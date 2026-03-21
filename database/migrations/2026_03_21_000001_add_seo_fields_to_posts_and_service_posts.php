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
            $table->string('seo_title')->nullable()->after('slug');
            $table->text('seo_description')->nullable()->after('seo_title');
        });

        Schema::table('service_posts', function (Blueprint $table) {
            $table->string('seo_title')->nullable()->after('slug');
            $table->text('seo_description')->nullable()->after('seo_title');
        });

        DB::table('posts')
            ->select('id', 'name', 'content', 'image', 'og_image', 'seo_title', 'seo_description')
            ->orderBy('id')
            ->chunkById(100, function ($posts) {
                foreach ($posts as $post) {
                    $updates = [];

                    if (($post->og_image === null || $post->og_image === '') && !empty($post->image)) {
                        $updates['og_image'] = $post->image;
                    }

                    if ($post->seo_title === null || $post->seo_title === '') {
                        $updates['seo_title'] = Str::limit(trim($post->name ?? ''), 70, '');
                    }

                    if ($post->seo_description === null || $post->seo_description === '') {
                        $plainContent = trim(strip_tags($post->content ?? ''));
                        $baseDescription = $plainContent !== '' ? $plainContent : trim($post->name ?? '');
                        $updates['seo_description'] = Str::limit($baseDescription, 155, '...');
                    }

                    if (!empty($updates)) {
                        DB::table('posts')
                            ->where('id', $post->id)
                            ->update($updates);
                    }
                }
            });

        DB::table('service_posts')
            ->select('id', 'name', 'content', 'image', 'og_image', 'seo_title', 'seo_description')
            ->orderBy('id')
            ->chunkById(100, function ($servicePosts) {
                foreach ($servicePosts as $servicePost) {
                    $updates = [];

                    if (($servicePost->og_image === null || $servicePost->og_image === '') && !empty($servicePost->image)) {
                        $updates['og_image'] = $servicePost->image;
                    }

                    if ($servicePost->seo_title === null || $servicePost->seo_title === '') {
                        $updates['seo_title'] = Str::limit(trim($servicePost->name ?? ''), 70, '');
                    }

                    if ($servicePost->seo_description === null || $servicePost->seo_description === '') {
                        $plainContent = trim(strip_tags($servicePost->content ?? ''));
                        $baseDescription = $plainContent !== '' ? $plainContent : trim($servicePost->name ?? '');
                        $updates['seo_description'] = Str::limit($baseDescription, 155, '...');
                    }

                    if (!empty($updates)) {
                        DB::table('service_posts')
                            ->where('id', $servicePost->id)
                            ->update($updates);
                    }
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description']);
        });

        Schema::table('service_posts', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description']);
        });
    }
};
