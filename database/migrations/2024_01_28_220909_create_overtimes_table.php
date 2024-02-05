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
        Schema::create('overtimes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_id');
            $table->foreign('attendance_id')->on('attendances')->references('id')->onDelete('CASCADE');
            $table->unsignedBigInteger('overtime_master_id')->nullable();
            $table->foreign('overtime_master_id')->on('overtime_masters')->references('id')->onDelete('SET NULL');
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('amount', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};
