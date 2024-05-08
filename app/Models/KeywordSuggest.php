<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeywordSuggest extends Model
{
    use HasFactory;

    protected $fillable = [

        'book_barcode',
        'department',
        'suggest_book_keyword',
        'user_id',
        'action',
        'status'
      ];

      protected $table = 'keywordsuggest';

      protected $attributes = [
        'status' => '0'
    ];
}
