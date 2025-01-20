<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
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
            'deskripsi' => fake()->paragraph(),
            'waktu_open_registrasi' => fake()->dateTime(),
            'waktu_close_registrasi' => fake()->dateTime(),
            'waktu_pelaksanaan' => fake()->dateTime(),
            'jenis' => $jenis = fake()->randomElement(['online', 'offline']),
            'pricing' => $pricing = fake()->randomElement(['gratis', 'berbayar']),
            'harga' => function() use ($pricing) {
                return $pricing === 'gratis' 
                    ? 0 
                    : fake()->numberBetween(10000, 1000000);
            },
            'link_meet' => $jenis === 'online' ? fake()->url() : null,
            'venue' => $jenis === 'offline' ? fake()->address() : null,
            'kuota' => fake()->numberBetween(10, 100),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function($event)
        {
            // Generate random image ID
            $imageId = rand(1, 1000);
            
            // Use Picsum Photos instead of Unsplash
            $imageUrl = "https://picsum.photos/id/{$imageId}/1200/800";
            
            try {
                $event->addMediaFromUrl($imageUrl)
                       ->toMediaCollection('event-thumbnail');
            } catch (\Exception $e) {
                // If the current ID fails, try another random image
                $fallbackImageUrl = "https://picsum.photos/1200/800"; // This will always return a random image
                $event->addMediaFromUrl($fallbackImageUrl)
                       ->toMediaCollection('event-thumbnail');
            }
        });
    
    }

}
