<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProdukDigital>
 */
class ProdukDigitalFactory extends Factory
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
            'platform' => $platform = fake()->randomElement(['file', 'url']),
            'url' => $platform === 'url' ? fake()->url() : null,
            'harga' => fake()->numberBetween(1000, 100000),
            'is_unlimited' => $isUnlimited = fake()->boolean(),
            'qty' => $isUnlimited ? null : fake()->numberBetween(1, 100),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function($produk)
        {
            // Generate random image ID
            $imageId = rand(1, 1000);
            
            // Use Picsum Photos instead of Unsplash
            $imageUrl = "https://picsum.photos/id/{$imageId}/1200/800";
            
            try {
                $produk->addMediaFromUrl($imageUrl)
                       ->toMediaCollection('produk-digital-thumbnail');
                
            } catch (\Exception $e) {
                // If the current ID fails, try another random image
                $fallbackImageUrl = "https://picsum.photos/1200/800"; // This will always return a random image
                $produk->addMediaFromUrl($fallbackImageUrl)
                       ->toMediaCollection('produk-digital-thumbnail');
            }
        });
    }

}
