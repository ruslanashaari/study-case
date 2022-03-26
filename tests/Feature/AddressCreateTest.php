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

class AddressCreateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name'      =>  'Ruslan Ashaari',
            'email'     =>  'ruslan.ashaari@gmail.com',
        ]);
    }

    public function test_can_view_create_page()
    {
        $this->actingAs($this->user)
            ->get(route('addresses.create'))
            ->assertInertia(fn (Assert $assert) => $assert->component('Addresses/Create'));
    }

    public function test_can_create_address()
    {
        $address = [
            'address_1'     =>  '221B Becker Street',
            'address_2'     =>  null,
            'district'      =>  'Becker',
            'postcode'      =>  null,
            'city'          =>  'London',
            'country_id'    =>  43,
        ];

        $response = $this->actingAs($this->user)
                            ->post(route('addresses.store'), $address);

        $this->assertDatabaseHas(
            'addresses', $address
        );

        $address_id = Address::whereAddress1($address['address_1'])
                        ->whereAddress2($address['address_2'])
                        ->whereDistrict($address['district'])
                        ->wherePostcode($address['postcode'])
                        ->whereCity($address['city'])
                        ->whereCountryId($address['country_id'])
                        ->first()
                        ->id;

        $response->assertStatus(302);
        $response->assertRedirect(route('addresses.show', $address_id));

        $response->assertSessionHas(
            [
                'success' => 'Address created.'
            ]
        );
    }
}
