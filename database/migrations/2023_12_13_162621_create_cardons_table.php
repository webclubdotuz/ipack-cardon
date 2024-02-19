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
        Schema::create('cardons', function (Blueprint $table) {
            $table->id();
            $table->char('name', 100);
            $table->decimal('width', 10, 2);
            $table->decimal('length', 10, 2);
            $table->decimal('layer', 10, 2);
            $table->decimal('salary_percent', 10, 2);
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cardons');
    }
};
