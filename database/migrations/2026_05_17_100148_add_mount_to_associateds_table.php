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
        Schema::table('associateds', function (Blueprint $table) {
            $table->integer('mount')->default(0)->after('menu_special_final');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('associateds', function (Blueprint $table) {
            $table->dropColumn('mount');
        });
    }
};
