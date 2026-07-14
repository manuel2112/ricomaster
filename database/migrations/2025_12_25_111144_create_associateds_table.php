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
        Schema::create('associateds', function (Blueprint $table) {
            $table->id();
            $table->string('cod')->nullable();
            $table->string('name')->nullable();
            $table->string('rut')->nullable();
            $table->string('social_name')->nullable();
            $table->string('address')->nullable();
            $table->string('commune')->nullable();
            $table->text('map')->nullable();
            $table->string('whatsapp')->nullable();
            $table->integer('menu_normal_associated')->nullable();
            $table->integer('menu_special_associated')->nullable();
            $table->integer('menu_normal_final')->nullable();
            $table->integer('menu_special_final')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associateds');
    }
};
