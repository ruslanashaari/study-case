<?php

namespace App\Actions\Employees;

use DB;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;

class StoreEmployeeAction {

	public function handle(array $payload)
	{
        $employee = Employee::create($payload);

        return $employee;
	}

}