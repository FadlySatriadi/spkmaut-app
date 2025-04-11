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
        Schema::create('rangking', function (Blueprint $table) {
            $table->id('idrangking');
            $table->unsignedBigInteger('idpenilaian');
            $table->string('peringkat');
            $table->timestamps();

            $table->foreign('idpenilaian')->references('idpenilaian')->on('penilaian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rangking');
    }
};