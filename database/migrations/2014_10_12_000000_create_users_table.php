<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('username')->unique();
            $table->integer('phone')->unique();
            $table->string('password');
            $table->timestamps();
        });

        DB::table('users')->insert([
            'fullname' => 'Admin',
            'username' => 'admin',
            'phone' => '934879598',
            'password' => bcrypt('admin')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Улугбек',
            'username' => 'ulugbek',
            'phone' => '934879590',
            'password' => bcrypt('123456')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Гулзар',
            'username' => 'gulzar',
            'phone' => '934879511',
            'password' => bcrypt('123456')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Марат',
            'username' => 'marat',
            'phone' => '934879591',
            'password' => bcrypt('123456')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Анвар',
            'username' => 'anvar',
            'phone' => '934879592',
            'password' => bcrypt('123456')
        ]);

        DB::table('users')->insert([
            'fullname' => 'Гулмира',
            'username' => 'gulmira',
            'phone' => '934879593',
            'password' => bcrypt('123456')
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
