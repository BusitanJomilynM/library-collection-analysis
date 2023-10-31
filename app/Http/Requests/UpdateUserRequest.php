<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UpdateUserRequest extends FormRequest
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
            'school_id'=>'required|integer|unique:users,school_id,'.$this->id,
            'email'=>'email|unique:users,email,'.$this->id,
            'type'=>'required'
        ];
    }

    public function messages()
    {
        return[
            'first_name.required' => 'Fill out first name',
            'last_name.required' => 'Fill out last name',
            'type.required' => 'Select a role',
            'school_id.unique' => 'School ID already registered',
            'school_id.required' => 'Fill out School ID',
            'email.unique' => 'Email Address is already registered'
        ];
    }
}
