<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Persons extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Person::create([
            'name' => 'Martin',
            'lastname' => 'Sola',
            'address' => 'Rivadavia 1097',
            'phone' => '3404437748',
            'file_number' => '48618',
            'user_id' => 1,
        ]);

        Person::create([
            'name' => 'Franco',
            'lastname' => 'Pinciroli',
            'address' => 'Juan José Paso 8324',
            'phone' => '3412787705',
            'file_number' => '47854',
            'user_id' => 2,
        ]);

        Person::create([
            'name' => 'Ezequiel',
            'lastname' => 'Fernández Cariaga',
            'address' => 'Av. Carlos Pellegrini 1730',
            'phone' => '3364623469',
            'file_number' => '47771',
            'user_id' => 3,
        ]);
    }
}
