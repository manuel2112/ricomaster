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
        Schema::table('bills', function (Blueprint $table) {
            $table->dropForeign('bills_type_menu_id_foreign');
            $table->unsignedBigInteger('week_id')->nullable()->change();
            $table->unsignedBigInteger('type_menu_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->unsignedBigInteger('week_id')->nullable(false)->change();
            $table->unsignedBigInteger('type_menu_id')->nullable(false)->change();
            $table->foreign('week_id')->references('id')->on('weeks');
            $table->foreign('type_menu_id')->references('id')->on('type_menus');
        });
    }
};
