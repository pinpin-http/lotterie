<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Draw;
use Illuminate\Support\Carbon;

class DrawSeeder extends Seeder
{
    public function run()
    {
        // Création d'un tirage avec des numéros aléatoires pour tester
        Draw::create([
            'date' => Carbon::now()->addDays(1),
            'numbers' => json_encode([rand(1, 49), rand(1, 49), rand(1, 49), rand(1, 49), rand(1, 49)]),
            'stars' => json_encode([rand(1, 9), rand(1, 9)]),
            'jackpot' => 3000000,
            'status' => 'open',
        ]);
    }
}
