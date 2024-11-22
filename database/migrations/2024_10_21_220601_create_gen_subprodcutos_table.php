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
        Schema::create('gen_subproductos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->double('valor_kg', 8, 3);
            $table->foreignId('instituto_id')->constrained();
            $table->foreignId('subproducto_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.en r
     */
    public function down(): void
    {
        Schema::dropIfExists('gen_subproductos');
    }
};
