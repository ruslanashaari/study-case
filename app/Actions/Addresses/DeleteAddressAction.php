<?php

namespace App\Actions\Addresses;

use DB;
use Exception;
use App\Http\Requests\StoreEmployeeRequest;

class DeleteAddressAction {

	public function handle($address)
	{
        $address->load('employee');
		
        if (!is_null($address->employee)) {
            throw new Exception('This address has employee assigned to it');       
        }

        return $address->delete();
	}

}