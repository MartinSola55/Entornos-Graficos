<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'admin',
        ]);

        Role::create([
            'name' => 'student',
        ]);

        Role::create([
            'name' => 'teacher',
        ]);

        Role::create([
            'name' => 'responsible',
        ]);
    }
}
