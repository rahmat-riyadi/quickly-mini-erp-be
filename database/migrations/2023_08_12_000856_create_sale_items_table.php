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
        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price');
            $table->decimal('price_2')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('is_use_cup')->default(false);
            $table->string('label')->nullable();
            $table->string('relation_code')->nullable();
            $table->string('relation_flag')->nullable();
            $table->unsignedBigInteger('sales_item_group_id');
            $table->foreign('sales_item_group_id')->on('sales_item_groups')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_items');
    }
};
