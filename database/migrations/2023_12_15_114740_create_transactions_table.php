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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained();
            $table->foreignId('user_id')->constrained();

            $table->enum('type', ['purchase', 'sale', 'roll']);
            $table->enum('status', ['pending', 'transport', 'completed', 'draft']); // 'draft

            $table->enum('payment_status', ['pending', 'debt', 'paid']);

            $table->decimal('total', 10, 2)->default(0);

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
