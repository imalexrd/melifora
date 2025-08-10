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
        Schema::table('apiaries', function (Blueprint $table) {
            $table->string('location_gps')->nullable()->after('location');
            $table->string('status')->default('Activo')->after('location_gps');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apiaries', function (Blueprint $table) {
            $table->dropColumn('location_gps');
            $table->dropColumn('status');
        });
    }
};
