<?php

namespace Database\Factories;

use App\Models\Position;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'position_id' => Position::inRandomOrder()->first('id')->id,
            'nik' => '-',
            'kk' => '-',
            'address' => fake()->address,
            'date_of_birth' => Carbon::now(),
            'place_of_birth' => '-',
            'entry_date' => Carbon::now(),
            'username' => fake()->userName,
            'password' => bcrypt('qazwsx'),
            'phone' => fake()->phoneNumber,
            'status' => fake()->randomElement([true, false])
        ];
    }
}
