<?php

namespace App\Console\Commands;

use App\Models\Pokemon;
use App\Models\Abilities;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FetchPokemonCommand extends Command
{
    protected $signature = 'app:fetch-pokemon-command';
    protected $description = 'Fetch data Pokemon dari PokeAPI ke Database Lokal';

    public function handle()
    {
        $this->info('Memulai Scrapping...');

        for ($id = 1; $id <= 400; $id++) {
            //fetch api
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$id}");

            if (!$response->successful()) {
                $this->error("Gagal mengambil ID: {$id}");
                continue;
            }

            $data = $response->json();

            // Menfilter Weight >= 100
            if ($data['weight'] < 100) continue;

            // Menyimpan gambar ke lokal storage
            $imageUrl = $data['sprites']['front_default'];

            // Cek jika gambar ada
            if ($imageUrl) {
                $imageName = "pokemon_{$id}.png";
                $imageContent = file_get_contents($imageUrl);
                Storage::disk('public')->put("images/{$imageName}", $imageContent);
                $imagePath = "storage/images/{$imageName}";
            } else {
                $imagePath = null;
            }

            // Update or Create data pokemon
            $pokemon = Pokemon::updateOrCreate(
                ['id' => $id],
                [
                    'name' => $data['name'],
                    'base_experience' => $data['base_experience'],
                    'weight' => $data['weight'],
                    'image_path' => $imagePath
                ]
            );

            // melakukan proses penyimpanan Abilities & Relasi
            $abilityIds = [];
            foreach ($data['abilities'] as $ab) {
                // FILTER: is_hidden: false
                if (!$ab['is_hidden']) {
                    // Simpan ke tabel abilities
                    $ability = Abilities::firstOrCreate(['name' => $ab['ability']['name']]);
                    $abilityIds[] = $ability->id;
                }
            }

            // Menyinkronkan tabel pivot pokemon_abilities
            $pokemon->abilities()->sync($abilityIds);

            $this->info("Berhasil menyimpan: {$pokemon->name} (Weight: {$pokemon->weight})");
        }

        $this->info('Scrapping Selesai!');
    }
}
