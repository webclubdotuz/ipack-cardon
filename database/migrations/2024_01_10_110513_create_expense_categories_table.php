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
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('user')->default(0);
            $table->timestamps();
        });

        $expense_categories = [
            [
                'name' => 'Зарплата',
                'user' => 1,
            ],
            [
                'name' => 'Транспорт',
                'user' => 0,
            ],
            [
                'name' => 'Коммунальные платежи',
                'user' => 0,
            ],
            [
                'name' => 'Прочее',
                'user' => 0,
            ],
        ];

        foreach ($expense_categories as $expense_category) {
            \App\Models\ExpenseCategory::create($expense_category);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_categories');
    }
};
