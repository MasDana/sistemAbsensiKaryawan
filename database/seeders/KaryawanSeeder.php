<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('karyawan')->insert([
            [
                'id' => 111,
                'nama_karyawan' => 'John Doe',
                'jabatan_id' => 1,
                'email' => 'john.doe@example.com',
                'no_hp' => '081234567890',
                'password' => Hash::make('password123'),
                'tanggal_lahir' => '1990-05-15',
                'gender' => 'male',
                'alamat' => 'Jl. Raya Denpasar No.1, Bali',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 112,
                'nama_karyawan' => 'Jane Smith',
                'jabatan_id' => 2,
                'email' => 'jane.smith@example.com',
                'no_hp' => '081298765432',
                'password' => Hash::make('password123'),
                'tanggal_lahir' => '1992-08-20',
                'gender' => 'female',
                'alamat' => 'Jl. Kuta Selatan No.25, Bali',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 113,
                'nama_karyawan' => 'Michael Brown',
                'jabatan_id' => 3,
                'email' => 'michael.brown@example.com',
                'no_hp' => '081345678901',
                'password' => Hash::make('password123'),
                'tanggal_lahir' => '1988-12-05',
                'gender' => 'male',
                'alamat' => 'Jl. Ubud No.3, Gianyar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 114,
                'nama_karyawan' => 'Emily Davis',
                'jabatan_id' => 4,
                'email' => 'emily.davis@example.com',
                'no_hp' => '081356789012',
                'password' => Hash::make('password123'),
                'tanggal_lahir' => '1995-03-10',
                'gender' => 'female',
                'alamat' => 'Jl. Sanur No.10, Denpasar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 115,
                'nama_karyawan' => 'Ben Dover',
                'jabatan_id' => 5,
                'email' => 'ben.dover@example.com',
                'no_hp' => '081356789012',
                'password' => Hash::make('password123'),
                'tanggal_lahir' => '1995-03-10',
                'gender' => 'female',
                'alamat' => 'Jl. Sanur No.10, Denpasar',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
