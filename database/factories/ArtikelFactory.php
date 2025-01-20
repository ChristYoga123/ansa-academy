<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artikel>
 */
class ArtikelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence,
            'konten' => fake()->paragraphs(3, true),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($artikel) {
            // Generate random image ID
            $imageId = rand(1, 1000);
            
            // Use Picsum Photos instead of Unsplash
            $imageUrl = "https://picsum.photos/id/{$imageId}/1200/800";
            
            try {
                $artikel->addMediaFromUrl($imageUrl)
                       ->toMediaCollection('artikel-thumbnail');
            } catch (\Exception $e) {
                // If the current ID fails, try another random image
                $fallbackImageUrl = "https://picsum.photos/1200/800"; // This will always return a random image
                $artikel->addMediaFromUrl($fallbackImageUrl)
                       ->toMediaCollection('artikel-thumbnail');
            }
        });
    }

}
