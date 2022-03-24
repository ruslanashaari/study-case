<?php

namespace App\Actions;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;

class StoreEmployeeAction {

	public function handle(array $payload)
	{
		try {
	        $employee = Employee::create($payload);

	        return [
	        	'status_code'	=>	config('http_status.success'),
	        	'message'	=>	'Employee created.',
	        	'data'		=>	$employee
	        ];			
		} catch (Exception $e) {
			return [
				'status_code' 	=> config('http_status.error'),
				'message' 	=> $e->getMessage(),
			];
		}
	}

}