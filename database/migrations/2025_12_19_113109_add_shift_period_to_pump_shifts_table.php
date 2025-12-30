<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pump_shifts', function (Blueprint $table) {
            $table->enum('shift_period', ['morning', 'evening', 'night'])
                  ->after('pump_id');
        });
    }

    public function down(): void
    {
        Schema::table('pump_shifts', function (Blueprint $table) {
            $table->dropColumn('shift_period');
        });
    }
};
