<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemons';
    protected $fillable = [
        'name',
        'base_experience',
        'weight',
        'image_path',
    ];


    public function abilities()
    {
        return $this->belongsToMany(Abilities::class, 'pokemon_abilities', 'pokemon_id', 'abilities_id');
    }
}
