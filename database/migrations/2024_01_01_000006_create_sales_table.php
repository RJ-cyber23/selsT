<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Sales', function (Blueprint $table) {
            $table->integer('sale_id')->autoIncrement();
            $table->integer('product_id');
            $table->integer('quantity')->nullable();
            $table->integer('customer_id');

            $table->foreign('product_id')->references('product_id')->on('Products');
            $table->foreign('customer_id')->references('customer_id')->on('Customers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Sales');
    }
};
