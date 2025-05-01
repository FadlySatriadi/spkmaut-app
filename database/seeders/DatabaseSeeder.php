<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key check sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Jalankan seeder dengan urutan yang benar
        $this->call([
            // 1. Seeder untuk data master/dasar
            RoleSeeder::class,
            UserSeeder::class,
            AubSeeder::class,
            PlantSeeder::class,
            OfficerSeeder::class,
            AdminSeeder::class,
            
            // 2. Seeder untuk data referensi
            KriteriaSeeder::class,
        ]);

        // Aktifkan kembali foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tambahkan output informasi
        $this->command->info('Semua seeder telah berhasil dijalankan!');
    }
}