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

class AddressEditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name'      =>  'Ruslan Ashaari',
            'email'     =>  'ruslan.ashaari@gmail.com',
        ]);

        Address::factory()->count(1)->create();
    }

    public function test_can_view_edit_page()
    {
        $address_id = Address::first()->id;

        $this->actingAs($this->user)
            ->get(route('addresses.edit', $address_id))
            ->assertInertia(fn (Assert $assert) => $assert->component('Addresses/Edit'));
    }

    public function test_can_edit_address()
    {
        $address = Address::first();

        $new_address = $address->toArray();
        unset($new_address['full_address']);
        $new_address['address_1'] =   '221B Becker Street';

        $response = $this->actingAs($this->user)
                            ->put(route('addresses.update', $address->id), $new_address);

        $response->assertStatus(302);
        $response->assertRedirect(route('addresses.show', $address->id));

        $response->assertSessionHas(
            [
                'success' => 'Address record updated.'
            ]
        );

        $this->assertDatabaseHas(
            'addresses', $new_address
        );
    }
}
