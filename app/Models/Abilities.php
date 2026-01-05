<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Abilities extends Model
{
    use HasFactory;

    protected $table = 'abilities';
    protected $fillable = [
        'name',
    ];

    public function pokemons()
    {
        return $this->belongsToMany(Pokemon::class, 'pokemon_abilities');
    }
}
