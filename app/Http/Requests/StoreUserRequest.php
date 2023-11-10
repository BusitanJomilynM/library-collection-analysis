<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name'=>'required',
            'last_name'=>'required',
            'school_id'=>'required|integer|unique:users',
            'email'=>'email|unique:users',
            'contact_number'=>'required|unique:users',
            'password'=>'required',
            'type'=>'required'
        ];
    }

    /**
     * Summary of message
     * @return array<string>
     */
    public function messages()
    {
        return[
            'first_name.required' => 'Fill out first name',
            'last_name.required' => 'Fill out last name',
            'password.required' => 'Fill out password',
            'type.required' => 'Select a role',
            'school_id.unique' => 'School ID already registered',
            'school_id.required' => 'Fill out School ID',
            'school_id.integer' => 'School ID must be an integer',
            'email.unique' => 'Email Address is already registered'
        ];
    }
}
