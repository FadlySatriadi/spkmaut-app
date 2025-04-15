<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfficerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'idofficer' => 1,
                'iduser' => 2,
            ],
        ];

        DB::table('officer')->insert($data);
    }
}
