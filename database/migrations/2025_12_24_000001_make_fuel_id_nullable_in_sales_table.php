<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('sales', function (Blueprint $table) {
            // Make fuel_id nullable since it's not being used in the current implementation
            $table->foreignId('fuel_id')->nullable()->change();
        });
    }

    public function down(): void {
        Schema::table('sales', function (Blueprint $table) {
            $table->foreignId('fuel_id')->nullable(false)->change();
        });
    }
};
