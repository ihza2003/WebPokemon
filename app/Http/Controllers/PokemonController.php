<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function index(Request $request)
    {
        $data = Pokemon::with('abilities')->orderBy('weight', 'desc');

        // 2. Tambahkan filter ke query jika ada
        if ($request->has('filter') && $request->filter != 'all') {
            if ($request->filter == 'light') {
                $data->whereBetween('weight', [100, 150]);
            } elseif ($request->filter == 'medium') {
                $data->whereBetween('weight', [151, 199]);
            } elseif ($request->filter == 'heavy') {
                $data->where('weight', '>=', 200);
            }
        }
        $pokemons = $data->paginate(10);
        $pokemons->appends(['filter' => $request->filter]);

        return view('pokemon.index', compact('pokemons'));
    }
}
