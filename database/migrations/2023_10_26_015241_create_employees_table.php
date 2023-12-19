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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->string('name');
            $table->string('nik');
            $table->string('kk');
            $table->string('address');
            $table->string('date_of_birth');
            $table->string('place_of_birth');
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('religion')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->date('entry_date');
            $table->date('exit_date')->nullable();
            $table->string('image')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
