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
        Schema::create('pairs', function (Blueprint $table) {
            $table->id();
            $table->string('source_name');
            $table->string('destination_name');
            $table->decimal('source_min', 16, 8);
            $table->decimal('source_max', 16, 8);
            $table->decimal('destination_min', 16, 8);
            $table->decimal('destination_max', 16, 8);
            $table->decimal('rate', 16, 8);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pairs');
    }
};
