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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->integer('station');
            $table->integer('region');
            $table->enum('role', ['user', 'superadmin'])->default('user');
            $table->timestamps();
        });
        DB::table('users')->insert([
            'username' => 'superadmin',
            'password' => 'superadmin', 
            'station' => 0, 
            'region' => 0, 
            'role' => 'superadmin',
            'created_at' => now(),
            'updated_at' => now(),
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
