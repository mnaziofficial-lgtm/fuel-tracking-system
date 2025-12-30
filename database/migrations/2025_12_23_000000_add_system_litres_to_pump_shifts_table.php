<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pump_shifts', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('pump_shifts', 'meter_litres')) {
                $table->decimal('meter_litres', 10, 2)->nullable()->after('closing_meter');
            }
            if (!Schema::hasColumn('pump_shifts', 'system_litres')) {
                $table->decimal('system_litres', 10, 2)->nullable()->after('meter_litres');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pump_shifts', function (Blueprint $table) {
            if (Schema::hasColumn('pump_shifts', 'meter_litres')) {
                $table->dropColumn('meter_litres');
            }
            if (Schema::hasColumn('pump_shifts', 'system_litres')) {
                $table->dropColumn('system_litres');
            }
        });
    }
};
