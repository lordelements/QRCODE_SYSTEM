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
        Schema::table('q_r__codes', function (Blueprint $table) {
            $table->string('color')->default('0,0,0'); // Default to black
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('q_r__codes', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
};
