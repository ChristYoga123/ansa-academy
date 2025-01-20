<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lomba>
 */
class LombaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(),
            'penyelenggara' => fake()->company(),
            'deskripsi' => fake()->paragraph(),
            'waktu_open_registrasi' => fake()->dateTime(),
            'waktu_close_registrasi' => fake()->dateTime(),
            'link_pendaftaran' => fake()->url(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function($lomba)
        {
            // Generate random image ID
            $imageId = rand(1, 1000);
            
            // Use Picsum Photos instead of Unsplash
            $imageUrl = "https://picsum.photos/id/{$imageId}/1200/800";
            
            try {
                $lomba->addMediaFromUrl($imageUrl)
                       ->toMediaCollection('lomba-thumbnail');
            } catch (\Exception $e) {
                // If the current ID fails, try another random image
                $fallbackImageUrl = "https://picsum.photos/1200/800"; // This will always return a random image
                $lomba->addMediaFromUrl($fallbackImageUrl)
                       ->toMediaCollection('lomba-thumbnail');
            }
        });
    }

}
