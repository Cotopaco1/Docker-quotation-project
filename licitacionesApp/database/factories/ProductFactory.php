<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name'          =>  $this->faker->word(),
            'supplier_id'   =>  1,
            'unit_of_measure' => $this->faker->randomElement(['kg', 'lt', 'm', 'cm', 'mm', 'un']),
            'description'   =>  $this->faker->sentence(),
            'unit_price_withouth_tax' => $this->faker->randomFloat(2, 4000, 10000),
            'brand'         =>  $this->faker->word(),
            'notes'         =>  $this->faker->sentence(),
        ];
    }
}
