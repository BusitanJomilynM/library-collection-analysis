<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Alex Raphael',
            'middle_name' => 'Lapuz',
            'last_name' => 'Abalos',
            'email' => 'technician@mail.com',
            'school_id' => '20160092',
            'type' => '0',
            'password' => '12341234',
        ]);
        User::create([
            'first_name' => 'Jomilyn',
            'middle_name' => 'Mismisen',
            'last_name' => 'Busitan',
            'email' => 'deptrep@mail.com',
            'school_id' => '20192618',
            'type' => '2',
            'password' => '59865986'
        ]);
        User::create([
            'first_name' => 'John',
            'middle_name' => 'Mane',
            'last_name' => 'doe',
            'email' => 'staff@mail.com',
            'school_id' => '20164152',
            'type' => '1',
            'password' => '33332222',
        ]);
    }
}
