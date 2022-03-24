<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\EmployeeRole;
use App\Models\Address;
use App\Models\User;
use Tests\TestCase;

class EmployeeCreateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name'      =>  'Ruslan Ashaari',
            'email'     =>  'ruslan.ashaari@gmail.com',
        ]);

        Address::factory()->count(10)->create();

        EmployeeRole::factory()->count(5)->create();
    }

    public function test_can_view_create_page()
    {
        $this->actingAs($this->user)
            ->get(route('employees.create'))
            ->assertInertia(fn (Assert $assert) => $assert->component('Employees/Create'));
    }

    public function test_can_create_employees()
    {
        $address_id = Address::first()->id;
        $employee_role_id = EmployeeRole::first()->id;

        $employee = [
            'code'                  =>  'ABC1001',
            'first_name'            =>  'Jonah',
            'last_name'             =>  'Jameson',
            'address_id'            =>  $address_id,
            'employee_role_id'      =>  $employee_role_id,
            'deleted_at'            =>  null,
        ];

        $response = $this->actingAs($this->user)
                            ->post(route('employees.store'), $employee);

        $response->assertStatus(302);
        $response->assertRedirect(route('employees.show', 1));

        $response->assertSessionHas(
            [
                'success' => 'Employee created.'
            ]
        );

        $this->assertDatabaseHas(
            'employees', $employee
        );
    }
}
