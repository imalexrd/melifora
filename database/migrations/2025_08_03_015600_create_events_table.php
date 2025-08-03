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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hive_id')->constrained()->onDelete('cascade');
            $table->date('event_date');
            $table->enum('type', [
                'Cosecha de miel',
                'Alimentacion artificial',
                'Divison de colmena',
                'Unificacion de colmena',
                'Sustitucion o ingreso de reyna',
                'Tratamiento'
            ]);
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
