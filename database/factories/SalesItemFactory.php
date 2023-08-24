<?php

namespace Database\Factories;

use App\Models\SalesItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesItem>
 */
class SalesItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => fake()->words(3, true),
            'price' => rand(32000, 60000),
            'price_2' => rand(32000, 60000),
            'status' => fake()->randomElement([true, false]),
            'sales_item_group_id' => rand(1,15)
        ];
    }
}
