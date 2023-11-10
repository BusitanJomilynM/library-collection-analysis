<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Book;
use Illuminate\Validation\Rule;

class UpdateArchiveRequest extends FormRequest
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
            'book_callnumber'=>'nullable|sometimes|unique:books,book_callnumber,'.$this->book->id,
            'book_barcode'=>[
                'nullable',Rule::unique((new Book)->getTable())->ignore($this->route()->book->id ?? null)]
          
        ];
    }
    public function messages()
    {
        return[
          
        ];
    }
}
