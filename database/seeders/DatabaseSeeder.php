<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Lomba;
use App\Models\Artikel;
use App\Models\LokerMentor;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ProdukDigital;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        LokerMentor::factory(10)->create();
        Artikel::factory(10)->create();
        Event::factory(10)->create();
        Lomba::factory(10)->create();
        ProdukDigital::factory(10)->create();
    }
}
