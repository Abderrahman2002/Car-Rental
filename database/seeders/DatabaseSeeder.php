<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voiture;
use App\Models\Location;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Generate 20 Voitures
        Voiture::factory(20)->create();

        // Generate 20 Locations
        Location::factory(20)->create();
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
