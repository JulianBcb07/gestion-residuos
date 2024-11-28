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
        Schema::create('gen_semanals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zonas_areas_id')->constrained()->onDelete('restrict');
            $table->date('fecha');
            $table->string('turno');
            $table->double('valor_kg', 8, 3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gen_semanals');
    }
};
