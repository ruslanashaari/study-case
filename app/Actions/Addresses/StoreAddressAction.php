<?php

namespace App\Actions\Addresses;

use App\Models\Address;

class StoreAddressAction {

	public function handle(array $payload)
	{
        $address = Address::create($payload);

        return $address;
	}

}