<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'code' => $this->faker->postcode(),
            'quantity' => $this->faker->numberBetween(10, 500),
            'price' => $this->faker->year()
        ];
    }
}
