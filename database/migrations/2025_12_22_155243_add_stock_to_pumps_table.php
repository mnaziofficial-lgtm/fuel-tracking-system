<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pumps', function (Blueprint $table) {
           $table->decimal('stock', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::table('pumps', function (Blueprint $table) {
        
        });
    }
};
