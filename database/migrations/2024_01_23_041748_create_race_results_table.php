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
        Schema::create('race_results', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('pilot_id');
            $table->foreign('pilot_id')->references('id')->on('pilots');

            $table->integer('lapsCompleted');
            $table->integer('totalTime');
            $table->integer('finishingPosition')->nullable();
            $table->string('averageSpeed')->nullable();
            $table->string('lastLapTime');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_results');
    }
};
