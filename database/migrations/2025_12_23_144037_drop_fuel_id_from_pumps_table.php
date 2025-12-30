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
        Schema::table('pumps', function (Blueprint $table) {
            $table->dropForeign('pumps_fuel_id_foreign');
            $table->dropColumn('fuel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pumps', function (Blueprint $table) {
            $table->unsignedBigInteger('fuel_id')->nullable();
            $table->foreign('fuel_id')->references('id')->on('fuels')->onDelete('cascade');
        });
    }
};
