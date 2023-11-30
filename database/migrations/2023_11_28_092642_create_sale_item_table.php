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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10);
            $table->decimal('price_2', 10)->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('is_use_cup')->default(false);
            $table->string('label')->nullable();
            $table->string('relation_code')->nullable();
            $table->string('relation_flag')->nullable();
            $table->unsignedBigInteger('sale_item_group_id');
            $table->foreign('sale_item_group_id')->on('sale_item_groups')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_items');
    }
};
