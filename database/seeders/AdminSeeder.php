<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'idadmin' => 1,
                'iduser' => 1,
            ],
        ];

        DB::table('admin')->insert($data);
    }
}