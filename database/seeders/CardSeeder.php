<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CardSeeder extends Seeder
{
    public function run(): void
    {
        // Demo user (owner)
        $trev = User::firstOrCreate(
            ['email' => 'trev@gmail.com'],
            [
                'name' => 'Trev',
                'password' => Hash::make('123123123'),
            ]
        );

        // Optional: extra users for "owner" column variety
        $qwe = User::firstOrCreate(
            ['email' => 'admin@demo.nl'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin12345'),
            ]
        );

        // Clear cards so reseeding doesn't duplicate
        Card::query()->delete();

        // Fixed demo cards (so your screenshot-like content is consistent)
        Card::create([
            'user_id' => $qwe->id,
            'name' => 'Trev pokemon',
            'rarity' => 'Common',
            'description' => 'asdaswdasdaawdd',
            'image_path' => null,
        ]);

        Card::create([
            'user_id' => $trev->id,
            'name' => 'Trev',
            'rarity' => 'Legendary',
            'description' => 'awdawd',
            'image_path' => null,
        ]);

        Card::create([
            'user_id' => $trev->id,
            'name' => 'asdasdasd',
            'rarity' => 'Rare',
            'description' => 'asdasd',
            'image_path' => null,
        ]);

        // Extra random cards to test pagination/search
        Card::factory()->count(7)->create([
            'user_id' => $trev->id,
        ]);
    }
}
