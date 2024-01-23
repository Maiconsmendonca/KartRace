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
            $table->string('codigo');
            $table->string('nomePiloto');
            $table->integer('voltasCompletadas');
            $table->float('tempoTotal');
            $table->integer('posicaoChegada')->nullable();
            $table->unsignedBigInteger('piloto_id');
            $table->foreign('piloto_id')->references('id')->on('pilotos');
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
