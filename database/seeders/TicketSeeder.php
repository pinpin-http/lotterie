<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Draw;

class TicketSeeder extends Seeder
{
    public function run()
    {
        $draw = Draw::first(); // Utilise le premier tirage

        User::where('role', 'user')->each(function ($user) use ($draw) {
            Ticket::create([
                'user_id' => $user->id,
                'draw_id' => $draw->id,
                'numbers' => json_encode([rand(1, 49), rand(1, 49), rand(1, 49), rand(1, 49), rand(1, 49)]),
                'stars' => json_encode([rand(1, 9), rand(1, 9)]),
            ]);
        });
    }
}
