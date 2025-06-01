<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Mahasiswa Satu',
                'email' => 'mahasiswa@example.com',
                'password' => bcrypt('password'), // ganti sesuai kebutuhan
                'role' => 'mahasiswa',
            ],
            [
                'name' => 'Staff Perpustakaan',
                'email' => 'staff@example.com',
                'password' => bcrypt('password'), // ganti sesuai kebutuhan
                'role' => 'staff',
            ],
            [
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'), // ganti sesuai kebutuhan
                'role' => 'admin',
            ],
        ]);
    }
}
