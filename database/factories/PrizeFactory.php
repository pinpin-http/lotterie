<?php

namespace Database\Factories;

use App\Models\Prize;
use App\Models\Draw;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrizeFactory extends Factory
{
    protected $model = Prize::class;

    public function definition()
    {
        return [
            'draw_id' => Draw::factory(),
            'user_id' => User::factory(),
            'rank' => $this->faker->numberBetween(1, 10),
            'amount' => $this->faker->randomFloat(2, 100, 100000),
            'percentage' => $this->faker->numberBetween(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
