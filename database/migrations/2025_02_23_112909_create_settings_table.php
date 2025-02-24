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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('hotline')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('logo')->nullable();
            $table->string('slogan')->nullable();
            $table->string('image_schedule')->nullable();
            $table->string('zalo')->nullable();
            $table->string('facebook')->nullable();
            $table->string('messenger')->nullable();
            $table->text('google_map')->nullable();
            $table->string('mst')->nullable();
            $table->enum('hr_status', ['on', 'off'])->default('off');
            $table->text('hr_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
