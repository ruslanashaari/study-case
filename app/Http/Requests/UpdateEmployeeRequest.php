<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'code'              => 'required',
                                    Rule::unique('employees')->ignore($request->code, 'code'),
            'first_name'        => 'required',
            'last_name'         => 'required',
            'address_id'        => 'required|integer',
            'employee_role_id'  => 'required|integer',
        ];
    }
}
