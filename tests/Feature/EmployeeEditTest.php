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

class EmployeeEditTest extends TestCase
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

        Employee::factory()->create([
            'code'          =>  'ABC1001',
            'first_name'    =>  'Jonah',
            'last_name'     =>  'Jameson',
            'deleted_at'    =>  null,
        ]);
    }

    public function test_can_view_edit_page()
    {
        $employee_id = Employee::first()->id;

        $this->actingAs($this->user)
            ->get(route('employees.edit', $employee_id))
            ->assertInertia(fn (Assert $assert) => $assert->component('Employees/Edit'));
    }

    public function test_can_edit_employee()
    {
        $employee = Employee::first();

        $new_employee = $employee->toArray();
        unset($new_employee['full_name']);
        $new_employee['first_name'] =   'Jupiter';

        $response = $this->actingAs($this->user)
                            ->put(route('employees.update', $employee->id), $new_employee);

        $response->assertStatus(302);
        $response->assertRedirect(route('employees.show', $employee->id));

        $response->assertSessionHas(
            [
                'success' => 'Employee record updated.'
            ]
        );

        $this->assertDatabaseHas(
            'employees', $new_employee
        );
    }
}
