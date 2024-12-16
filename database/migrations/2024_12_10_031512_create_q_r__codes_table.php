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
        Schema::create('q_r__codes', function (Blueprint $table) {
            $table->id();
            $table->enum('device_type', ['Laptop', 'Phone', 'Tablet', 'Earphone']);
            $table->string('device_name');
            $table->string('owner_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('q_r__codes');
    }
};
