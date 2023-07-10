<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'martinsola11@gmail.com',
            'rol_id' => 1,
            'password' => bcrypt('12345678'),
        ]);
        
        User::create([
            'email' => 'franco.pinciroli@hotmail.com',
            'rol_id' => 1,
            'password' => bcrypt('12345678'),
        ]);

        User::create([
            'email' => 'dia.fernandezcariaga.ezequiel@gmail.com',
            'rol_id' => 2,
            'password' => bcrypt('12345678'),
        ]);
    }
}
