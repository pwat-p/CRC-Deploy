<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'line_id' => $this->faker->regexify('[A-Z]{4}[0-9]{3}'),
            'line_basic_id' => $this->faker->regexify('[A-Z]{4}[0-9]{3}'),
        ];
    }
}
