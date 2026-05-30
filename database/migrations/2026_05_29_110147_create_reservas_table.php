<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('socio_id');
            $table->unsignedBigInteger('clase_id');
            $table->string('estado')->default('activa');
            $table->timestamps();

            $table->foreign('socio_id')->references('id')->on('usuarios');
            $table->foreign('clase_id')->references('id')->on('clases');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
