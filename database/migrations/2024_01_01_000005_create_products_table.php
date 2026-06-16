<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Products', function (Blueprint $table) {
            $table->integer('product_id')->autoIncrement();
            $table->string('product_name', 30)->nullable();
            $table->integer('category_id');
            $table->string('size')->nullable()->check("size IN ('S', 'M', 'L', 'XL')");
            $table->integer('quantity')->nullable();
            $table->integer('uom_id');
            $table->decimal('weight', 10, 2)->nullable();
            $table->integer('supplier_id');
            $table->integer('brand_id');
            $table->decimal('mark_up', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('category_id')->on('Categories');
            $table->foreign('uom_id')->references('uom_id')->on('Unit_of_Measure');
            $table->foreign('supplier_id')->references('supplier_id')->on('Suppliers');
            $table->foreign('brand_id')->references('brand_id')->on('Brands');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Products');
    }
};
