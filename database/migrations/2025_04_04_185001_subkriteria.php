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
        Schema::create('subkriteria', function (Blueprint $table) {
            $table->id('idsubkriteria');
            $table->unsignedBigInteger('idkriteria')->index();
            $table->string('namasubkriteria');
            $table->float('bobotsubkriteria');
            $table->timestamps();

            $table->foreign('idkriteria')->references('idkriteria')->on('kriteria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subkriteria');
    }
};
