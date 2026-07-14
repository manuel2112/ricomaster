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
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->time('bill_hour_start')->nullable();
            $table->time('bill_hour_end')->nullable();
            $table->integer('bill_counter_default')->nullable();
            $table->time('campaign_hour_start')->nullable();
            $table->time('campaign_hour_end')->nullable();
            $table->integer('campaign_price_default')->nullable();
            $table->integer('campaign_counter_default')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
