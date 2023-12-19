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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('item_categories');
            $table->string('unit');
            $table->integer('convertion_1');
            $table->integer('convertion_2');
            $table->decimal('buy_price', 10);
            $table->decimal('sale_price', 10);
            $table->double('stock')->default(0);
            $table->double('initial_stock')->nullable();
            $table->double('minimum_stock')->nullable();
            $table->double('average_stock')->nullable();
            $table->enum('type', ['Production', 'Warehouse']);
            $table->boolean('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
