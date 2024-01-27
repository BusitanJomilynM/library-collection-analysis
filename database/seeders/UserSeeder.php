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
            'email' => 'technical@mail.com',
            'school_id' => '20160092',
            'contact_number' => '639612942718',
            'type' => '0',
            'password' => '12341234',
        ]);
        User::create([
            'first_name' => 'Jomilyn',
            'middle_name' => 'Mismisen',
            'last_name' => 'Busitan',
            'email' => 'deptrep@mail.com',
            'school_id' => '20192618',
            'contact_number' => '639715432987',
            'type' => '2',
            'password' => '12341234'
        ]);
        User::create([
            'first_name' => 'John',
            'middle_name' => 'Mane',
            'last_name' => 'Doe',
            'email' => 'staff@mail.com',
            'school_id' => '20161111',
            'contact_number' => '639294782234',
            'type' => '1',
            'password' => '33332222',
        ]);
        User::create([
            'first_name' => 'Brianne',
            'middle_name' => 'Ni',
            'last_name' => 'Eideinne',
            'email' => 'deptrep2@mail.com',
            'school_id' => '20160001',
            'contact_number' => '639715434765',
            'type' => '2',
            'password' => '12341234'
        ]);
        User::create([
            'first_name' => 'Angel',
            'middle_name' => 'Saranilla',
            'last_name' => 'Tuma-ag',
            'email' => 'technical2@mail.com',
            'school_id' => '20160002',
            'contact_number' => '639715434764',
            'type' => '2',
            'password' => '12341234'
        ]);
        User::create([
            'first_name' => 'Rhoy',
            'middle_name' => ' ',
            'last_name' => 'Macedonio',
            'email' => 'teacher@mail.com',
            'school_id' => '20190001',
            'contact_number' => '639715434763',
            'type' => '3',
            'password' => '12341234'
        ]);
    }
}
