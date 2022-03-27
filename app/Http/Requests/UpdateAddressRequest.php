<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    { 
        if (Auth::check()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address_1'     =>  'required',
            'address_2'     =>  '',
            'district'      =>  'required',
            'postcode'      =>  '',
            'city'          =>  'required',
            'country_id'    =>  'integer',
        ];
    }
}
