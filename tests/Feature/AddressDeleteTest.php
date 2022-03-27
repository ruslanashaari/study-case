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
use Carbon\Carbon;

class AddressDeleteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name'      =>  'Ruslan Ashaari',
            'email'     =>  'ruslan.ashaari@gmail.com',
        ]);

        Address::factory()->create();
    }

    public function test_can_delete_address()
    {
        $address = Address::first()->toArray();
        $address_name = $address['full_address'];
        unset($address['full_address']);

        $response = $this->actingAs($this->user)
                            ->delete(route('addresses.destroy', $address['id']));

        $response->assertStatus(302);
        $response->assertRedirect(route('addresses.index'));

        $response->assertSessionHas(
            [
                'success' => $address_name . ' record deleted.'
            ]
        );

        $address['deleted_at'] = Carbon::now()->toDateTimeString();

        $this->assertSoftDeleted(
            'addresses', $address
        );
    }
}
