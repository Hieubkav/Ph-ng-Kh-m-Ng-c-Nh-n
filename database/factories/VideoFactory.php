<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $youtubeIds = [
            'dQw4w9WgXcQ',
            'oHg5SJYRHA0',
            'tgbNymZ7vqY',
            'E7wJTI-1dvQ',
        ];

        $videoId = fake()->randomElement($youtubeIds);

        return [
            'title' => fake()->sentence(6),
            'youtube_url' => "https://www.youtube.com/watch?v={$videoId}",
            'display_order' => fake()->numberBetween(1, 10),
            'is_hot' => fake()->boolean(20),
            'is_active' => true,
        ];
    }
}
