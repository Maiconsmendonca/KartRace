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
        Schema::create('laps_infos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('race_id')
                ->unique()
                ->constrained('race_infos')
                ->onDelete('cascade');

            $table->integer('lap_number');
            $table->time('hour');
            $table->time('lap_time');
            $table->float('average_speed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laps_infos');
    }
};
