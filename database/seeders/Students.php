<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Students extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'name' => 'Martin',
            'lastname' => 'Sola',
            'adress' => 'Rivadavia 1097',
            'dni' => '42559237',
            'phone' => '3404437748',
            'file_number' => '48618',
            'user_id' => 1,
        ]);

        Student::create([
            'name' => 'Franco',
            'lastname' => 'Pinciroli',
            'adress' => 'Juan José Paso 8324',
            'dni' => '43167893',
            'phone' => '3412787705',
            'file_number' => '47854',
            'user_id' => 2,
        ]);

        Student::create([
            'name' => 'Ezequiel',
            'lastname' => 'Fernández Cariaga',
            'adress' => 'Av. Carlos Pellegrini 1730',
            'dni' => '43313322',
            'phone' => '3364623469',
            'file_number' => '47771',
            'user_id' => 3,
        ]);
    }
}
