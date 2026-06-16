<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Users', function (Blueprint $table) {
            $table->integer('user_id')->autoIncrement();
            $table->string('first_name', 60)->nullable();
            $table->string('last_name', 60)->nullable();
            $table->date('bod')->nullable();
            $table->string('phone_number', 11)->nullable();
            $table->string('Gmail', 60)->nullable();
            $table->string('location_address', 60)->nullable();
            $table->string('username', 60)->nullable();
            $table->string('password', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Users');
    }
};
