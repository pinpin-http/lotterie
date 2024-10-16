<?php
namespace Database\Factories;

use App\Models\Draw;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrawFactory extends Factory
{
    protected $model = Draw::class;

    public function definition()
    {
        return [
            'date' => now(), // Assure une date non nulle
            'numbers' => json_encode([1, 2, 3, 4, 5]),  // Exemple de nombres
            'stars' => json_encode([1, 2]),             // Exemple d’étoiles
            'jackpot' => 3000000,
            'status' => 'open',        ];
    }
}
