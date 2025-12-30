<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fuels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Petrol, Diesel
            $table->decimal('price_per_litre', 10, 2);
            $table->decimal('current_stock', 10, 2); // liters
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('fuels');
    }
};
