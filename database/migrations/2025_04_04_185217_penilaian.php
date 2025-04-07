<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id('idpenilaian');
            $table->unsignedBigInteger('iduser');
            $table->unsignedBigInteger('idalternatif');
            $table->unsignedBigInteger('idsubkriteria');
            $table->float('nilai');
            $table->timestamps();

            $table->foreign('iduser')->references('iduser')->on('user');
            $table->foreign('idalternatif')->references('idalternatif')->on('alternatif');
            $table->foreign('idsubkriteria')->references('idsubkriteria')->on('subkriteria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
