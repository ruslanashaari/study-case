<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressNameResource;
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

            $addresses = AddressNameResource::collection(Address::all());
            
        } catch (Exception $e) {
            return inertia('Addresses/Index', 
                [
                    $addresses => []
                ])->withErrors($e->getMessage());
        }

        return inertia('Addresses/Index', compact('addresses'));
    }
}
