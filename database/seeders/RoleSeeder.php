<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'idrole' => 1,
                'nama_role' => 'admin',
                'deskripsi' => '',
            ],
            [
                'idrole' => 2,
                'nama_role' => 'officer',
                'deskripsi' => '',
            ]
        ];

        DB::table('role')->insert($data);
    }
}