<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::factory()->count(10)->create();

        Employee::factory()->count(100)->create();
    }
}
