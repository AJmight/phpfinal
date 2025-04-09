<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'date_of_birth', 'nationality', 'position',
        'shirt_number', 'photo_url', 'status', 'team_id',
        // 'rating' // Add if you implement player ratings
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the team that owns the player.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}