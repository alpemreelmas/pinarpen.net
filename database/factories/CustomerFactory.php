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
            "name"=>$this->faker->firstName(),
            "surname"=>$this->faker->lastName(),
            "phone_number"=>$this->faker->phoneNumber(),
            "address"=>$this->faker->address()
        ];
    }
}
