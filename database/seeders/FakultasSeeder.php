<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fakultas')->insert([
            [
                'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis',
                'slug' => 'fakultas-ekonomi-dan-bisnis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_fakultas' => 'Fakultas Sains dan Teknologi',
                'slug' => 'fakultas-sains-dan-teknologi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_fakultas' => 'Fakultas Hukum',
                'slug' => 'fakultas-hukum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_fakultas' => 'Fakultas Bahasa Asing',
                'slug' => 'fakultas-bahasa-asing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_fakultas' => 'Fakultas Ilmu Komunikasi',
                'slug' => 'fakultas-ilmu-komunikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
