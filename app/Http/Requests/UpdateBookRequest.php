<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Book;

class UpdateBookRequest extends FormRequest
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
            'book_callnumber'=>'required|unique:books',
            'book_barcode'=>'required|unique:books',
            'book_title'=>'required',
            'book_author'=>'required',
            'book_copyrightyear'=>'required',
            'book_sublocation'=>'required',
            'book_subject'=>'required'
          
        ];
    }
    public function messages()
    {
        return[
            'book_callnumber.required' => 'Fill out book call number',
            'book_barcode.required' => 'Fill out book barcode',
            'book_title.required' => 'Fill out book title',
            'book_author.required' => "Fill out book's author",
            'book_copyrightyear.required' => 'Fill out book release date',
            'sublocation.required' => 'Select book location',
            'book_sublocation.required' => 'Fill out tags ',
            'book_barcode.unique' => 'A book with that barcode is already registered',
        ];
    }
}
