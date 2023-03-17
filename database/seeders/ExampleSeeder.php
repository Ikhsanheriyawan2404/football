<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Club::create([
            'name' => 'Persija',
            'city' => 'Jakarta',
        ]);

        Club::create([
            'name' => 'Persib',
            'city' => 'Bandung',
        ]);

        Club::create([
            'name' => 'Arema',
            'city' => 'Malang',
        ]);


        Game::create([
            'home_club_id' => 1,
            'away_club_id' => 2,
            'home_score' => 2,
            'away_score' => 1,
        ]);

        Game::create([
            'home_club_id' => 2,
            'away_club_id' => 3,
            'home_score' => 2,
            'away_score' => 4,
        ]);

        Game::create([
            'home_club_id' => 1,
            'away_club_id' => 3,
            'home_score' => 2,
            'away_score' => 3,
        ]);

    }
}
