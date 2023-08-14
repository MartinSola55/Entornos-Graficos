<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Teachers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::create([
            'name' => 'Daniela',
            'lastname' => 'Díaz',
            'phone' => '341123123',
            'file_number' => '35123',
            'user_id' => 4,
        ]);
    }
}
