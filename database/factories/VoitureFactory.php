<?php


namespace Database\Factories;

use App\Models\Voiture;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoitureFactory extends Factory
{
    protected $model = Voiture::class;

    public function definition()
    {
        return [
            'matricule' => $this->faker->unique()->bothify('??-###'),
            'modele' => $this->faker->word(),
            'carburant' => $this->faker->randomElement(['essence', 'diesel', 'électrique', 'hybride']),
            'prix' => $this->faker->randomFloat(2, 10000, 50000),
            'photo' => $this->faker->imageUrl(640, 480, 'cars'),
        ];
    }
}
