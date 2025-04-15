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
                'koderole' => 'ADM',
                'namarole' => 'admin',
            ],
            [
                'idrole' => 2,
                'koderole' => 'OFC',
                'namarole' => 'officer',
            ]
        ];

        DB::table('role')->insert($data);
    }
}