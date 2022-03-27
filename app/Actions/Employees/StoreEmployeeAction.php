<?php

namespace App\Actions\Employees;

use DB;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;

class StoreEmployeeAction {

	public function handle(array $payload)
	{
        return Employee::create($payload);
	}

}