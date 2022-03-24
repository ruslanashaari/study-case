<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Employee;
use App\Models\EmployeeRole;
use Illuminate\Database\Seeder;
use Database\Seeders\EmployeeSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Address::factory()->count(10)->create();

        EmployeeRole::factory()->count(5)->create();

        Employee::factory()->count(100)->create();
    }
}
