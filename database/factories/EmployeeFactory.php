<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\EmployeeRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code'              => $this->faker->word,
            'address_id'        => Address::first()->id,
            'employee_role_id'  => EmployeeRole::first()->id,
            'first_name'        => $this->faker->name(),
            'last_name'         => $this->faker->name(),
        ];
    }
}
