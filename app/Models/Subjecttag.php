<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjecttag extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'department',
        'suggest_book_subject',
        'user_id',
        'action',
        'status'
    ];

    protected $attributes = [
        'status' => '0'
    ];

    protected $table = 'subjecttag';
}
