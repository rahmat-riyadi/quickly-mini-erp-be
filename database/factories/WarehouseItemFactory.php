<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WarehouseItem>
 */
class WarehouseItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(rand(2,3), true),
            'buy_price' => rand(20000, 50000),
            'sale_price' => rand(20000, 50000),
            'warehouse_item_group_id' => rand(1,15),
            'stock' => rand(10,20),
            'unit' => fake()->randomElement(['Pcs', '300 - Ml', 'Bal'])
        ];
    }
}
