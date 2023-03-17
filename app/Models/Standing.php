<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function homeGames()
    {
        return $this->hasMany(Game::class, 'home_club_id');
    }

    public function awayGames()
    {
        return $this->hasMany(Game::class, 'away_club_id');
    }
}
