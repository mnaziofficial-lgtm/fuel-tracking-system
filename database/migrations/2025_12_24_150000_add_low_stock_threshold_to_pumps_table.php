<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pumps', function (Blueprint $table) {
            $table->decimal('low_stock_threshold', 8, 2)->nullable()->after('stock');
        });
    }

    public function down()
    {
        Schema::table('pumps', function (Blueprint $table) {
            $table->dropColumn('low_stock_threshold');
        });
    }
};
