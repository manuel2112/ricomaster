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
        Schema::table('client_finals', function (Blueprint $table) {
            $table->unsignedBigInteger('associated_id')->after('name');
            $table->integer('mount')->default(0)->after('associated_id');
            $table->boolean('send')->default(true)->after('mount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_finals', function (Blueprint $table) {
            $table->dropColumn('associated_id');
            $table->dropColumn('mount');
            $table->dropColumn('send');
        });
    }
};
