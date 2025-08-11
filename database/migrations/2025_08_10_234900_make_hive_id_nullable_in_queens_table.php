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
        Schema::table('queens', function (Blueprint $table) {
            // To modify a column with a foreign key, it's often necessary to drop the key,
            // change the column, and then re-add the key.
            // However, for many drivers, ->change() handles this if doctrine/dbal is installed.
            // We are making hive_id nullable.
            $table->foreignId('hive_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('queens', function (Blueprint $table) {
            // Reverting this requires ensuring no records have a null hive_id.
            // For this context, we will simply reverse the nullable change.
            $table->foreignId('hive_id')->nullable(false)->change();
        });
    }
};
