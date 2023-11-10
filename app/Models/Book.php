<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_callnumber',
        'book_barcode',
        'book_title',
        'book_author',
        'book_copyrightyear',
        'book_sublocation',
        'book_subject',
        'book_volume',
        'book_publisher',
        'book_purchasedwhen',
        'book_lccn',
        'book_isbn',
        'book_edition',
        'status'
    ];

    protected $attributes = [
        'status' => '0'
    ];
      
        

       
}
