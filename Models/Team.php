<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Use SoftDeletes

class Team extends Model
{
    use HasFactory, SoftDeletes; // Add SoftDeletes

    protected $fillable = [
        'name', 'logo_url', 'home_venue',
        'matches_played', 'wins', 'draws', 'losses',
        'goals_for', 'goals_against', 'goal_difference', 'points',
        // 'coach_id' // Add if you create a Coach model
    ];

    /**
     * Get the players for the team.
     */
    public function players()
    {
        return $this->hasMany(Player::class);
    }

     /**
      * Get the home games for the team.
      */
    public function homeGames()
    {
        return $this->hasMany(Game::class, 'team_1_id');
    }

    /**
     * Get the away games for the team.
     */
    public function awayGames()
    {
        return $this->hasMany(Game::class, 'team_2_id');
    }

    // Optional: Coach relationship
    // public function coach() {
    //     return $this->belongsTo(Coach::class);
    // }
}