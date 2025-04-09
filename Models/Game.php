<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'start_time', 'venue', 'status', 'result_1', 'result_2',
        'team_1_id', 'team_2_id', 'referee_id', 'attendance',
    ];

    protected $casts = [
        'start_time' => 'datetime',
    ];

    /**
     * Get the home team for the game.
     */
    public function team1() // Use team1 for home team relationship
    {
        return $this->belongsTo(Team::class, 'team_1_id');
    }

    /**
     * Get the away team for the game.
     */
    public function team2() // Use team2 for away team relationship
    {
        return $this->belongsTo(Team::class, 'team_2_id');
    }

    /**
     * Get the referee for the game.
     */
    public function referee()
    {
        return $this->belongsTo(Referee::class);
    }
}