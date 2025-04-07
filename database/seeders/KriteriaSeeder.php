<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    public function run()
    {
        $kriteriaData = [
            [
                'namakriteria' => 'Available Market',
                'kodekriteria' => 'C1',
                'bobotkriteria' => 5
            ],
            [
                'namakriteria' => 'Utilisasi Plant',
                'kodekriteria' => 'C2',
                'bobotkriteria' => 4
            ],
            [
                'namakriteria' => 'Avail Raw Material',
                'kodekriteria' => 'C3',
                'bobotkriteria' => 4
            ],
            [
                'namakriteria' => 'Break Even Point',
                'kodekriteria' => 'C4',
                'bobotkriteria' => 3
            ],
            [
                'namakriteria' => 'Kedekatan dengan Pasar',
                'kodekriteria' => 'C5',
                'bobotkriteria' => 4
            ],
            [
                'namakriteria' => 'Keamanan Investasi',
                'kodekriteria' => 'C6',
                'bobotkriteria' => 3
            ],
            [
                'namakriteria' => 'Biaya Investasi',
                'kodekriteria' => 'C7',
                'bobotkriteria' => 5
            ],
            [
                'namakriteria' => 'Biaya Operasional',
                'kodekriteria' => 'C8',
                'bobotkriteria' => 4
            ],
            [
                'namakriteria' => 'Analisis Dampak Lingkungan',
                'kodekriteria' => 'C9',
                'bobotkriteria' => 3
            ],
            [
                'namakriteria' => 'Kebisingan dan Polusi',
                'kodekriteria' => 'C10',
                'bobotkriteria' => 3
            ],
            [
                'namakriteria' => 'Kesesuaian dengan Regulasi',
                'kodekriteria' => 'C11',
                'bobotkriteria' => 4
            ],
            [
                'namakriteria' => 'Kompetisi Pasar',
                'kodekriteria' => 'C12',
                'bobotkriteria' => 3
            ],
            [
                'namakriteria' => 'Aksesibilitas',
                'kodekriteria' => 'C13',
                'bobotkriteria' => 3
            ],
        ];

        foreach ($kriteriaData as $data) {
            DB::table('kriteria')->insert([
                'namakriteria' => $data['namakriteria'],
                'kodekriteria' => $data['kodekriteria'],
                'bobotkriteria' => $data['bobotkriteria'],
            ]);
        }
    }
}