<?php

namespace App\Actions;

use DB;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;

class DeleteEmployeeAction {

	public function handle($employee)
	{
        return $employee->delete();
	}

}