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
            $table->unsignedBigInteger('idkriteria');
            $table->string('minmax');
            $table->string('matrixnormalisasi');
            $table->float('hasil');
            $table->timestamps();

            $table->foreign('iduser')->references('iduser')->on('user');
            $table->foreign('idalternatif')->references('idalternatif')->on('alternatif');
            $table->foreign('idkriteria')->references('idkriteria')->on('kriteria');
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