<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'purchase_reference' => (int) $this->faker->postcode(),
            'quantity' => $this->faker->numberBetween(1, 500),
            'description' => $this->faker->sentence( 6, true),

        ];
    }
}
