<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('login')->insert([
            'name' => 'Neraj Lal',
            'firstname' => 'Neraj',
            'lastname' => 'Lal',
            'phone' => '+918547470675',
            'password' => Hash::make('+918547470675'),
        ]);
    }
}