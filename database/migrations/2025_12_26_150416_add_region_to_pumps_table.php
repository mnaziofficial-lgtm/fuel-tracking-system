<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('pumps', function (Blueprint $table) {
            $table->string('region')->after('name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pumps', function (Blueprint $table) {
            $table->dropColumn('region');
        });
    }
};
