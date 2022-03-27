<?php

namespace App\Actions\Addresses;

use App\Models\Address;

class StoreAddressAction {

	public function handle(array $payload)
	{
        return Address::create($payload);
	}

}