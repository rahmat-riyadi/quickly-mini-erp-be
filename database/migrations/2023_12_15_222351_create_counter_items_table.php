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
        Schema::create('counter_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('counter_id');
            $table->foreign('counter_id')->on('counters')->references('id');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->on('items')->references('id');
            $table->float('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counter_items');
    }
};
