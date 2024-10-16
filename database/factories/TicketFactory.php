<?php
namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),  // Crée un utilisateur si aucun ID n'est fourni
            'draw_id' => 1, // ID d’un tirage, à personnaliser dans chaque test
            'numbers' => json_encode([1, 2, 3, 4, 5]),
            'stars' => json_encode([1, 2]),
        ];
    }
}

