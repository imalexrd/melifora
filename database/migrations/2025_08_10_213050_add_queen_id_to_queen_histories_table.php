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
        Schema::table('queen_histories', function (Blueprint $table) {
            $table->foreignId('queen_id')->nullable()->constrained()->onDelete('set null')->after('hive_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('queen_histories', function (Blueprint $table) {
            $table->dropForeign(['queen_id']);
            $table->dropColumn('queen_id');
        });
    }
};
