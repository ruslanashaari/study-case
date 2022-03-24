<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code'              => 'required|unique:App\Models\Employee,code',
            'first_name'        => 'required',
            'last_name'         => 'required',
            'address_id'        => 'required|integer',
            'employee_role_id'  => 'required|integer',
        ];
    }
}
