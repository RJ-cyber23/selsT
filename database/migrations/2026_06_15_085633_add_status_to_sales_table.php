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
        Schema::table('Sales', function (Blueprint $table) {
            $table->string('status', 20)->default('completed')->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('Sales', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
