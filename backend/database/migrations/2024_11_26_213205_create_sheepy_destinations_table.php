<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('ticker');
            $table->string('title');
            $table->string('network');
            $table->boolean('deposit_enabled');
            $table->boolean('withdrawal_enabled');
            $table->decimal('deposit_fee', 16, 8);
            $table->decimal('withdrawal_fee', 16, 8);
            $table->decimal('withdrawal_min', 16, 8);
            $table->decimal('withdrawal_max', 16, 8);
            $table->string('memo')->nullable();
            $table->unsignedInteger('decimals');
            $table->string('explorer_address_link');
            $table->string('explorer_tx_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destinations');
    }
};
