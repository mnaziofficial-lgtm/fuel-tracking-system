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
        Schema::create('meter_readings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pump_id')->constrained();
    $table->foreignId('user_id')->constrained();
    $table->decimal('opening_reading', 10, 2);
    $table->decimal('closing_reading', 10, 2);
    $table->date('date');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meter_readings');
    }
};
