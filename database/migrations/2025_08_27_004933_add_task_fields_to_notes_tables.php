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
        Schema::table('apiary_notes', function (Blueprint $table) {
            $table->string('type')->default('note')->after('content');
            $table->dateTime('due_date')->nullable()->after('type');
            $table->timestamp('completed_at')->nullable()->after('due_date');
        });

        Schema::table('hive_notes', function (Blueprint $table) {
            $table->string('type')->default('note')->after('content');
            $table->dateTime('due_date')->nullable()->after('type');
            $table->timestamp('completed_at')->nullable()->after('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apiary_notes', function (Blueprint $table) {
            $table->dropColumn(['type', 'due_date', 'completed_at']);
        });

        Schema::table('hive_notes', function (Blueprint $table) {
            $table->dropColumn(['type', 'due_date', 'completed_at']);
        });
    }
};
