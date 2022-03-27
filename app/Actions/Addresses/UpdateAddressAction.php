<?php

namespace App\Actions\Addresses;

use App\Models\Address;

class UpdateAddressAction {

	public function handle(array $payload, $address)
	{
        return $address->update($payload);
	}

}