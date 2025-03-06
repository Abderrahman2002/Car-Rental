<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Voiture;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition()
    {
        return [
            'voiture_id' => Voiture::factory(), // Creates a related voiture
            'datedebut' => $this->faker->date(),
            'nombrejours' => $this->faker->numberBetween(1, 30),
        ];
    }
}

