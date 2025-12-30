<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('government_caps', function (Blueprint $table) {
            $table->id();
            $table->string('region'); // Town/Region
            $table->string('fuel_type'); // Petrol, Diesel, Kerosene
            $table->decimal('cap_price', 8, 2);
            $table->date('effective_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('government_caps');
    }
};
