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
        Schema::table('product_useds', function (Blueprint $table) {
            $table->decimal('price', 15, 0)->after('quantity')->default(0);
            $table->decimal('total', 15, 0)->after('price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_useds', function (Blueprint $table) {
            //
        });
    }
};
