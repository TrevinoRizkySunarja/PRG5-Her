<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition(): array
    {
        $rarities = ['Common', 'Rare', 'Legendary'];

        return [
            'user_id' => User::factory(),
            'name' => fake()->words(2, true),
            'rarity' => fake()->randomElement($rarities),
            'description' => fake()->sentence(8),
            'image_path' => null, // keep null for seed (no files)
        ];
    }
}
