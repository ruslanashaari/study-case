<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\EmployeeRole;
use App\Models\Employee;
use App\Models\Address;
use App\Models\User;
use Tests\TestCase;

class EmployeeListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name'      =>  'Ruslan Ashaari',
            'email'     =>  'ruslan.ashaari@gmail.com',
        ]);

        $addresses = Address::factory()->count(10)->create();

        EmployeeRole::factory()->count(5)->create();

        Employee::factory()->create([
            'code'          =>  'ABC1001',
            'first_name'    =>  'Jonah',
            'last_name'     =>  'Jameson',
            'deleted_at'    =>  null,
        ]);

        Employee::factory()->create([
            'code'          =>  'ABC1002',
            'first_name'    =>  'Maria',
            'last_name'     =>  'Hill',
            'deleted_at'    =>  null,
        ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_view_employees()
    {
        $this->actingAs($this->user)
            ->get('/employees')
            ->assertInertia(fn (Assert $assert) => $assert
                ->component('Employees/Index')
                ->has('employees', 2)
                ->has('employees.0', fn (Assert $assert) => $assert
                    ->where('code', 'ABC1002')
                    ->where('first_name', 'Maria')
                    ->where('last_name', 'Hill')
                    ->where('deleted_at', null)
                    ->etc()
                )
                ->has('employees.1', fn (Assert $assert) => $assert
                    ->where('code', 'ABC1001')
                    ->where('first_name', 'Jonah')
                    ->where('last_name', 'Jameson')
                    ->where('deleted_at', null)
                    ->etc()
                )
            );
    }

    public function test_cannot_view_deleted_employees()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_filter_to_view_deleted_employees()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
