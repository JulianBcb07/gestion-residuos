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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('url_image');
            $table->text('descripcion');
            $table->morphs('imageable'); // Es una tabla polimorfica por si requiere una relacion con otra tabla
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};

// Se puso imageable por convenciones de laravel y se almacenaran datos de diferentes tablas si se requiere
// Puede ser que requieran imagenes de las ventas con relacion a esa tabla o imagenes de usuarios etc.