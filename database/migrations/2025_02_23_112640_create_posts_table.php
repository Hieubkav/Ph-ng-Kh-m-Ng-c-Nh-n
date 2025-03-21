<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->string('pdf')->nullable();
            $table->enum('is_hot',['hot', 'not_hot'])->default('not_hot');
            $table->enum('show_image',['show', 'hide'])->default('show');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cat_post_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cat_post_id')->references('id')->on('cat_posts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
