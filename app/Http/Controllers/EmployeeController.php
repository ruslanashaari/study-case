<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeRoleResource;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\AddressNameResource;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Facades\Redirect;
use App\Actions\StoreEmployeeAction;
use App\Actions\UpdateEmployeeAction;
use Illuminate\Http\Request;
use App\Models\EmployeeRole;
use App\Models\Employee;
use App\Models\Address;
use Inertia\Inertia;
use DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = EmployeeResource::collection(Employee::with('address')->select('id', 'code', 'first_name', 'last_name', 'address_id', 'created_at', 'deleted_at')->orderBy('id', 'desc')->get());
        $addresses = AddressNameResource::collection(Address::all());

        return inertia('Employees/Index', compact('employees', 'addresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $addresses = AddressNameResource::collection(Address::select('id', 'address_1', 'address_2', 'district', 'postcode', 'city')->get());
        $roles = EmployeeRoleResource::collection(EmployeeRole::select('id', 'name')->get());

        return inertia('Employees/Create', compact('addresses', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request, StoreEmployeeAction $action)
    {
        try {
            DB::beginTransaction();

            $employee = $action->handle($request->validated());   

            DB::commit();

        } catch (Exception $e) {
            return redirect()
                        ->route('employees.show', $employee->id)
                        ->withErrors($e->getMessage());            
        }

        return redirect()->route('employees.show', $employee->id)->with('success', 'Employee created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $employee->load('address', 'role');
        return inertia('Employees/Show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $addresses = AddressNameResource::collection(Address::select('id', 'address_1', 'address_2', 'district', 'postcode', 'city')->get());
        $roles = EmployeeRoleResource::collection(EmployeeRole::select('id', 'name')->get());

        return inertia('Employees/Edit', compact('employee', 'addresses', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee, UpdateEmployeeAction $action)
    {
        try {
            DB::beginTransaction();

            $action->handle($request->validated(), $employee);

            DB::commit();
        } catch (Exception $e) {
            return redirect()
                        ->route('employees.show', $employee->id)
                        ->withErrors($e->getMessage());
        }

        return redirect()->route('employees.show', $employee->id)->with('success', 'Employee record updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee_name = $employee->full_name;
        $response = $employee->delete();

        if (!$response) 
        {
            return redirect()->route('employees.index')->with('danger', 'Delete process failed');
        }

        return redirect()->route('employees.index')->with('success', $employee_name . ' record deleted.');   
    }
}
