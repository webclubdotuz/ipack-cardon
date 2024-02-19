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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('cardon_id')->constrained();
            $table->integer('quantity');
            $table->longText('description');

            $table->date('deadline');

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->foreignId('transaction_id')->nullable()->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
