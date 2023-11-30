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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->on('employees')->references('id');
            $table->unsignedBigInteger('shift_time_id');
            $table->foreign('shift_time_id')->on('shift_times')->references('id');
            $table->string('status')->nullable();
            $table->time('attendance_time');
            $table->time('attendance_time_out')->nullable();
            $table->boolean('is_late');
            $table->string('description');
            $table->string('location');
            $table->integer('deduction')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
