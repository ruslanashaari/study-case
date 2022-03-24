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

class EmployeeDeleteTest extends TestCase
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

    public function test_can_delete_employee()
    {
        $employee = Employee::first()->toArray();
        $employee_name = $employee['full_name'];
        unset($employee['full_name']);

        $response = $this->actingAs($this->user)
                            ->delete(route('employees.destroy', $employee['id']));

        $response->assertStatus(302);
        $response->assertRedirect(route('employees.index'));

        $response->assertSessionHas(
            [
                'success' => $employee_name . ' record deleted.'
            ]
        );

        $this->assertSoftDeleted(
            'employees', $employee
        );
    }
}
