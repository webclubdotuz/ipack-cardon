<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->char('phone', 9);
            $table->enum('type', ['customer', 'supplier', 'both']);
            $table->string('address')->nullable();

            $table->unique(['phone', 'type']);

            $table->timestamps();
        });

        $contacts = [
            [
                'fullname' => 'По умолчанию',
                'phone' => '123456789',
                'type' => 'both',
                'address' => 'По умолчанию',
                'created_at' => now(),
            ]
        ];

        DB::table('contacts')->insert($contacts);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
