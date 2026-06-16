<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Unit_of_Measure', function (Blueprint $table) {
            $table->integer('uom_id')->autoIncrement();
            $table->string('uom_name', 30)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Unit_of_Measure');
    }
};
