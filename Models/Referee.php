<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referee extends Model
{
    use HasFactory, SoftDeletes;

     protected $fillable = [
        'name', 'email', 'phone_number', 'certification_level',
        'status', 'notes',
    ];

     /**
      * Get the games officiated by the referee.
      */
    public function games()
    {
        return $this->hasMany(Game::class);
    }
}