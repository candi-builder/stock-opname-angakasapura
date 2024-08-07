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
        Schema::create('batasan_stock_stations', function (Blueprint $table) {
            $table->id();
            $table->integer('station_id');
            $table->integer('item_id');
            $table->integer('batasan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batasan_stock_stations');
    }
};
