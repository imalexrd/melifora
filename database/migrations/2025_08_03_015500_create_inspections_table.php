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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hive_id')->constrained()->onDelete('cascade');
            $table->date('inspection_date');
            $table->string('queen_status')->nullable();
            $table->string('population')->nullable();
            $table->string('honey_stores')->nullable();
            $table->string('pollen_stores')->nullable();
            $table->string('brood_pattern')->nullable();
            $table->string('behavior')->nullable();
            $table->string('pests_diseases')->nullable();
            $table->string('treatments')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
