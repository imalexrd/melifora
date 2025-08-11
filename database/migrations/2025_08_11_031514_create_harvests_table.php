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
        Schema::create('harvests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hive_id')->constrained()->onDelete('cascade');
            $table->date('harvest_date');
            $table->decimal('quantity_kg', 8, 2);
            $table->decimal('quantity_liters', 8, 2);
            $table->decimal('density', 5, 2)->default(1.42);
            $table->string('color_tone');
            $table->string('origin');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvests');
    }
};
