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
        Schema::create('rolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->decimal('size', 8, 3);
            $table->decimal('weight', 8, 3);
            $table->decimal('paper_weight', 8, 3);
            $table->boolean('glue');
            $table->decimal('price', 16, 3);
            $table->decimal('total', 16, 3);

            $table->boolean('used')->default(false);
            $table->date('used_date')->nullable();
            $table->text('used_description')->nullable();
            $table->foreignId('used_user_id')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rolls');
    }
};
