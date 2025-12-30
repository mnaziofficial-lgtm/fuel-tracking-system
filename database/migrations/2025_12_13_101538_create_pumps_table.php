<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pumps', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Pump 1, Pump 2
            $table->foreignId('fuel_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pumps');
    }
};
