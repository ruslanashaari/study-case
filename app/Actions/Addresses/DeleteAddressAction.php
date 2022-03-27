<?php

namespace App\Actions\Addresses;

use DB;
use App\Http\Requests\StoreEmployeeRequest;

class DeleteAddressAction {

	public function handle($address)
	{
        return $address->delete();
	}

}