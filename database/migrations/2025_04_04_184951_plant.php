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
        Schema::create('plant', function (Blueprint $table) {
            $table->id('idplant');
            $table->unsignedBigInteger('idaub');
            $table->string('namaplant');
            $table->string('kodeplant');
            $table->text('lokasi');
            $table->enum('status', ['aktif', 'nonaktif']);
            $table->timestamps();

            $table->foreign('idaub')->references('idaub')->on('aub');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plant');
    }
};
