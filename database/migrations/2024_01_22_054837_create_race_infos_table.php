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
        Schema::create('race_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pilot_id')
                ->unique()
                ->constrained('pilot_infos')
                ->onDelete('cascade');

            $table->integer('finishing_position');
            $table->integer('laps_completed');
            $table->integer('total_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_info');
    }
};
