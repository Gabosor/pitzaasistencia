<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'), 
            'ci' => '123',
            'nombres' => 'Admin',
            'apellidos' => 'Admin',
            'fechaIng' => now(),
            'rol' => 0,
            'SalarioBase' => 5000, 
            'telefono' => '1234567890',
        ]);
    }
}
