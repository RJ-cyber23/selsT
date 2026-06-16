<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Brands', function (Blueprint $table) {
            $table->integer('brand_id')->autoIncrement();
            $table->string('brand_name', 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Brands');
    }
};
