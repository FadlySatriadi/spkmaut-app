<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'iduser' => 1,
                'username' => 'admin',
                'nama' => 'Fadly',
                'password' => Hash::make('12345'),
                'role' => 'admin',
            ],
            [
                'iduser' => 2,
                'username' => 'officer',
                'nama' => 'Satriadi',
                'password' => Hash::make('12345'),
                'role' => 'officer',
            ]
        ];

        DB::table('user')->insert($data);
    }
}