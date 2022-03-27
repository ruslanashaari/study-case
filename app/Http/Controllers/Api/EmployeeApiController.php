<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EmployeeResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeApiController extends Controller
{
    public function list(Request $request)
    {
        try {
            $data =  Employee::with('address')
                        ->select('id', 'code', 'first_name', 'last_name', 'address_id', 'created_at', 'deleted_at')
                        ->orderBy('id', 'desc')
                        ->get();

        } catch (Exception $e) {
            return [
                'status'    =>  500,
                'message'   =>  $e->getMessage(),
            ];   
        }

        return [
            'status'    =>  config('http_status.success'),
            'message'   =>  'Employee list retrieved',
            'data'      =>  EmployeeResource::collection($data)
        ];
    }
}
