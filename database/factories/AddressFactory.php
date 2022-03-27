<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address_1'     => $this->faker->buildingNumber(),
            'address_2'     => $this->faker->streetAddress(),
            'district'      => $this->faker->city(),
            'postcode'      => $this->faker->postcode(),
            'city'          => $this->faker->state(),
            'country_code'  => 'MY',
        ];
    }
}
