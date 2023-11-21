<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequisitionRequest extends FormRequest
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
            'book_title'=>'required',
            'copies'=>'required',
            'material_type'=>'required',
            'author'=>'required',
            'isbn'=>'required',
            'user_id'=>'required',
            'type'=>'required',
            'department'=>'required',
       
        ];
    }
    public function messages()
    {
        return[
            'book_title.required' => 'Fill out book title',
            'call_number.required' => 'Fill out book call number',
            'barcode.required' => 'Fill out book barcode',
            'copies.required' => 'Fill out how many copies',
            'material_type.required' => 'Fill out material type',
            'isbns.required' => 'Fill out ISBN',
            'author.required' => "Fill out book's author",
            'user_id.required' => 'User Id is needed',
            'type.required' => 'User type is required',
            'department.required' => 'Fill with your respective department',
            
        ];
    }
}
