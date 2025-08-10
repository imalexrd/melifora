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
        Schema::create('hives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apiary_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('qr_code')->nullable();
            $table->unsignedTinyInteger('rating')->default(0);
            $table->enum('type', ['Langstroth', 'Dadant', 'Layens', 'Top-Bar', 'Warre', 'Flow']);
            $table->date('birth_date')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', [
                'Desconocido', 'Activa', 'Invernando', 'Enjambrazon', 'Despoblada', 'Huerfana',
                'Zanganera', 'En formacion', 'Revision', 'Mantenimiento', 'Alimentacion Artificial',
                'Crianza de reinas', 'Pillaje', 'Pillera', 'Union', 'Sin uso'
            ])->default('Desconocido');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hives');
    }
};
