<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends \Illuminate\Foundation\Auth\User
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'contact_number',
        'password',
        'type'
    ];

    /**
    * Always encrypt the password when it is updated.
    *
    * @param $value
    * @return string
    */
    public function setPasswordAttribute($value)
    {
    $this->attributes['password'] = bcrypt($value);
    }

    /**

     * Interact with the user's first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */

     protected function type(): Attribute
     {
         return new Attribute(
             get: fn ($value) =>  ["technician librarian", "staff librarian", "department representative", "teacher"][$value],
         );
 
     }
}
