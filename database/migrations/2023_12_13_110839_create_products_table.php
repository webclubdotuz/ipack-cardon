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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('quantity', 10, 2);
            $table->char('unit', 10)->default('шт');
            $table->string('image')->nullable();
            $table->boolean('shop')->default(false);
            $table->timestamps();
        });

        $products = [
            [
                'name' => 'Коробка шприц 3x3',
                'description' => 'Коробка шприц 3x3',
                'price' => 3200,
                'quantity' => 0,
                'image' => null,
                'shop' => true,
            ],
            [
                'name' => 'Коробка шприц 3x5',
                'description' => 'Коробка шприц 3x5',
                'price' => 3500,
                'quantity' => 0,
                'image' => null,
                'shop' => true,
            ],
            [
                'name' => 'Клей для коробок',
                'description' => 'Клей для коробок',
                'price' => 1000,
                'quantity' => 0,
                'image' => null,
                'shop' => false,
            ],
            [
                'name' => 'Мыс сым',
                'description' => 'Мыс сым',
                'price' => 1000,
                'quantity' => 0,
                'unit' => 'кг',
                'image' => null,
                'shop' => false,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
