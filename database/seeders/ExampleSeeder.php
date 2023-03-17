<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Game;
use App\Models\Standing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $persija = Club::create([
            'name' => 'Persija',
            'city' => 'Jakarta',
        ]);

        $persib = Club::create([
            'name' => 'Persib',
            'city' => 'Bandung',
        ]);

        $arema = Club::create([
            'name' => 'Arema',
            'city' => 'Malang',
        ]);


        Game::create([
            'home_club_id' => $persija->id,
            'away_club_id' => $persib->id,
            'home_score' => 2,
            'away_score' => 1,
        ]);

        Game::create([
            'home_club_id' => $persib->id,
            'away_club_id' => $arema->id,
            'home_score' => 2,
            'away_score' => 4,
        ]);

        Game::create([
            'home_club_id' => $persija->id,
            'away_club_id' => $arema->id,
            'home_score' => 2,
            'away_score' => 3,
        ]);

        Game::create([
            'home_club_id' => $persib->id,
            'away_club_id' => $arema->id,
            'home_score' => 2,
            'away_score' => 3,
        ]);

        Standing::create([
            'club_id' => $persija->id,
            'points' => 0,
            'wins' => 0,
            'draws' => 0,
            'losses' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
        ]);

        Standing::create([
            'club_id' => $persib->id,
            'points' => 0,
            'wins' => 0,
            'draws' => 0,
            'losses' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
        ]);

        Standing::create([
            'club_id' => $arema->id,
            'points' => 0,
            'wins' => 0,
            'draws' => 0,
            'losses' => 0,
            'goals_for' => 0,
            'goals_against' => 0,
        ]);
    }
}
