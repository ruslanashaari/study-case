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

class AddressListTest extends TestCase
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
        
        Address::factory()->create([
            'address_1'     =>  '221B Becker Street',
            'address_2'     =>  null,
            'district'      =>  'Becker',
            'postcode'      =>  null,
            'city'          =>  'London',
            'country_id'    =>  43,
        ]);

        Address::factory()->create([
            'address_1'     =>  '4 Privet Drive',
            'address_2'     =>  'Little Whinging',
            'district'      =>  'Surrey',
            'postcode'      =>  null,
            'city'          =>  'Hogwarts',
            'country_id'    =>  43,
        ]);

        EmployeeRole::factory()->count(5)->create();
        Employee::factory()->count(50)->create();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_view_addresses()
    {
        $this->actingAs($this->user)
            ->get(route('addresses.index'))
            ->assertInertia(fn (Assert $assert) => $assert
                ->component('Addresses/Index')
                ->has('addresses', 2)
                ->has('addresses.0', fn (Assert $assert) => $assert
                    ->where('address_1', '4 Privet Drive')
                    ->where('address_2', 'Little Whinging')
                    ->where('district', 'Surrey')
                    ->where('postcode', null)
                    ->where('city', 'Hogwarts')
                    ->where('country_id', 43)
                    ->where('deleted_at', null)
                    ->etc()
                )
                ->has('addresses.1', fn (Assert $assert) => $assert
                    ->where('address_1', '221B Becker Street')
                    ->where('address_2', '')
                    ->where('district', 'Becker')
                    ->where('postcode', null)
                    ->where('city', 'London')
                    ->where('country_id', 43)
                    ->where('deleted_at', null)
                    ->etc()
                )
            );
    }

    public function test_cannot_view_deleted_addresses()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_filter_to_view_deleted_addresses()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
