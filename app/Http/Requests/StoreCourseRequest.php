<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'course_code'=>'required|unique:course',
            'course_name'=>'required|unique:course',
            'course_department'=>'required'
        ];
    }

    public function messages()
    {
        return[
            'course_code.required'=>'Fill out book Course Code',
            'course_name.required'=>'Fill out book Course Description',
            'course_code.unique'=>'Course with that code already exist',
            'course_name.unique'=>'Course of that name already exist',
            'course_department'=>'Fill out Department'
        ];
    }
}
