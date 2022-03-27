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
            $query =  Employee::with('address')
                        ->select('id', 'code', 'first_name', 'last_name', 'address_id', 'created_at', 'deleted_at')
                        ->orderBy('id', 'desc');

            if ($request->has('search') && !is_null($request->search)) {
                $query->whereAddressId($request->search);
            }

            if ($request->trashed === 'both') {
                $query->withTrashed();
            }

            if ($request->trashed === 'deleted') {
                $query->onlyTrashed();
            }

            $data = $query->get();

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
