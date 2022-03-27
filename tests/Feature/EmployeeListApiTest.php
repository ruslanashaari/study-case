<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Resources\EmployeeResource;
use App\Models\EmployeeRole;
use App\Models\Employee;
use App\Models\Address;
use App\Models\User;
use Tests\TestCase;
use Carbon\Carbon;

class EmployeeListApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name'      =>  'Ruslan Ashaari',
            'email'     =>  'ruslan.ashaari@gmail.com',
        ]);

        $address        = Address::factory()->create();
        $employee_role  = EmployeeRole::factory()->create();


        $this->payload = [
            [
                'code'              =>  'ABC0999',
                'first_name'        =>  'Natasha',
                'last_name'         =>  'Romanoff',
                'address_id'        =>  $address->id,
                'employee_role_id'  =>  $employee_role->id,
                'deleted_at'        =>  null,
            ],
            [
                'code'              =>  'ABC1002',
                'first_name'        =>  'Maria',
                'last_name'         =>  'Hill',
                'address_id'        =>  $address->id,
                'employee_role_id'  =>  $employee_role->id,
                'deleted_at'        =>  null,
            ],
            [
                'code'              =>  'ABC1003',
                'first_name'        =>  'Bucky',
                'last_name'         =>  'Barnes',
                'address_id'        =>  $address->id,
                'employee_role_id'  =>  $employee_role->id,
                'deleted_at'        =>  null,
            ],
        ];

        Employee::insert($this->payload);
    }

    public function test_can_retrieve_employees()
    {
        $body = [
            'trashed'   =>  '',
            'search'    =>  '',
        ];

        $expected_response = [
            'status'    =>  config('http_status.success'),
            'message'   =>  'Employee list retrieved',
        ];

        $response = $this->actingAs($this->user)
            ->post(route('api.employees.list'), $body);

        $response->assertJsonFragment($expected_response);
    }
}
