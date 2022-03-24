<?php

namespace App\Actions;

use DB;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;

class UpdateEmployeeAction {

	public function handle(array $payload, $employee)
	{
        return $employee->update($payload);
	}

}