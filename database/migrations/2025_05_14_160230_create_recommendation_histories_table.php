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
        Schema::create('recommendation_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iduser')->constrained('users'); // officer yang melakukan perhitungan
            $table->json('calculation_data'); // menyimpan semua data perhitungan
            $table->string('top_plant_name');
            $table->decimal('top_plant_score', 8, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendation_histories');
    }
};
