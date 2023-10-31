<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [

        'book_title',
        'copies',
        'material_type',
        'author',
        'isbn',
        'publisher',
        'edition',
        'source',
        'user_id',
        'type',
        'department',
        'status'
      ];

      protected $attributes = [
        'status' => '0'
    ];

}
