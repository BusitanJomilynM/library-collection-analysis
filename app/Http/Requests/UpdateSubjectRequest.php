<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
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
            'subject_code'=>'required|unique:subject,subject_code,'.$this->subject->id,
            'subject_name'=>'required|unique:subject,subject_name,'.$this->subject->id,
            'subject_course'=>'required'
        ];
    }

    public function messages()
    {
        return[
            'subject_code.required'=>'Fill out Subject Code',
            'subject_name.required'=>'Fill out Subject Description',
            'subject_code.unique'=>'Subject with that code already exist',
            'subject_name.unique'=>'Subject of that name already exist',
            'subject_course.required'=>'Fill out Course'
        ];
    }
}
