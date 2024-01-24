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
        Schema::create('laps', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->string('lapHour');
            $table->time('lapTime');
            $table->string('lapSpeed');
            $table->unsignedBigInteger('race_results_id')->nullable();
            $table->foreign('race_results_id')->references('id')->on('race_results');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laps');
    }
};
