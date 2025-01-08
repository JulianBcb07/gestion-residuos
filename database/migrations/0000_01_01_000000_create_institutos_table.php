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
        Schema::create('institutos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80);
            $table->text('descripcion')->nullable();
            $table->string('direccion', 250);
            $table->string('logo', 150)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 80)->unique()->nullable();
            $table->string('sitio_web', 80)->nullable();
            $table->double('meta_anual', 8, 2)->nullable();
            $table->integer('total_personas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('institutos');
    }
};
