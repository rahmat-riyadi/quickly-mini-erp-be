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
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->string('do_number');
            $table->unsignedBigInteger('counter_id');
            $table->foreign('counter_id')->on('counters')->references('id');
            $table->date('delivery_date')->nullable();
            $table->time('delivery_time')->nullable();
            $table->date('order_date');
            $table->time('order_time');
            $table->string('delivery_type')->nullable();
            $table->string('items_type');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_orders');
    }
};
