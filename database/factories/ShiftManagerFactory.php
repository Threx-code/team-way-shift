<?php

namespace Database\Factories;

use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShiftManager>
 */
class ShiftManagerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 50),
            'manager_id' => $this->faker->numberBetween(1, 50),
            'shift_id' => Shift::all()->random()->id,
            'shift_date' => $this->faker->dateTimeBetween(
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear()
            ),
        ];
    }
}
