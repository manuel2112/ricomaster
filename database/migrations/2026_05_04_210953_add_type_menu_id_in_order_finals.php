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
        Schema::table('order_finals', function (Blueprint $table) {
            $table->unsignedBigInteger('type_menu_id')->after('associated_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_finals', function (Blueprint $table) {
            $table->dropForeign(['type_menu_id']);
            $table->dropColumn('type_menu_id');
        });
    }
};
