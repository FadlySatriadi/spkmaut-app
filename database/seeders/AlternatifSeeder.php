<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlternatifSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua idplant yang ada di tabel plant
        $plants = DB::table('plant')->orderBy('idplant')->get();
        
        $counter = 1;
        
        foreach ($plants as $plant) {
            DB::table('alternatif')->insert([
                'idplant' => $plant->idplant,
                'kodealternatif' => 'A' . $counter++
            ]);
        }
    }
}