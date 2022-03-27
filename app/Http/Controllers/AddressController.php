<?php

namespace App\Http\Controllers;

use App\Actions\Addresses\UpdateAddressAction;
use App\Actions\Addresses\DeleteAddressAction;
use App\Actions\Addresses\StoreAddressAction;
use App\Http\Resources\AddressNameResource;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Requests\StoreAddressRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Address;
use Inertia\Inertia;
use DB;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $addresses = AddressNameResource::collection(Address::orderBy('id', 'desc')->get());
            
        } catch (Exception $e) {
            return inertia('Addresses/Index', 
                [
                    $addresses => []
                ])->withErrors($e->getMessage());
        }

        return inertia('Addresses/Index', compact('addresses'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        return inertia('Addresses/Show', compact('address'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            return inertia('Addresses/Create');

        } catch (Exception $e) {
            return redirect()
                        ->route('addresses.index')
                        ->withErrors($e->getMessage());            
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request, StoreAddressAction $action)
    {
        try {
            DB::beginTransaction();

            $address = $action->handle($request->validated());   

            DB::commit();

        } catch (Exception $e) {
            return redirect()
                        ->route('addresses.create')
                        ->withInput()
                        ->withErrors($e->getMessage());      
        }

        return redirect()->route('addresses.show', $address->id)->with('success', 'Address created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        try {
            return inertia('Addresses/Edit', compact('address'));

        } catch (Exception $e) {
            return redirect()
                        ->route('addresses.index')
                        ->withErrors($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressRequest $request, Address $address, UpdateAddressAction $action)
    {
        try {
            DB::beginTransaction();

            $action->handle($request->validated(), $address);

            DB::commit();
        } catch (Exception $e) {
            return redirect()
                        ->route('addresses.edit', $address->id)
                        ->withInput()
                        ->withErrors($e->getMessage());
        }

        return redirect()->route('addresses.show', $address->id)->with('success', 'Address record updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address, DeleteAddressAction $action)
    {
        try {
            DB::beginTransaction();

            $address_name = $address->full_address;

            $action->handle($address);
            DB::commit();
        } catch (Exception $e) {
            return redirect()
                        ->route('addresses.index')
                        ->withErrors($e->getMessage());
        }

        return redirect()->route('addresses.index')->with('success', $address_name . ' record deleted.');   
    }
}
