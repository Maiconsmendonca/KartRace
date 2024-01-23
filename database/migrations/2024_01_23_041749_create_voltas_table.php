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
        Schema::create('voltas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('horavolta');
            $table->time('tempoVolta');
            $table->float('velocidadeMedia');
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
        Schema::dropIfExists('voltas');
    }
};
