<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'idaub' => 1,
                'kodeaub' => 'SBB',
                'aub' => 'Solusi Bangun Beton'
            ],
            [
                'idaub' => 2,
                'kodeaub' => 'VUB',
                'aub' => 'Varia Usaha Beton'
            ]
            ];

            DB::table('aub')->insert($data);
    }
}
