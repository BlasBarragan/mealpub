<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Creamos la tabla 'recetas_favoritas' con los campos 'id', 'usuario_id' y 'receta_id'
    public function up(): void
    {
        Schema::create('recetas_favoritas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('receta_id');
            $table->timestamps();
            // Definimos la foreign key 'usuario_id' que apunta a la tabla 'usuarios'
            $table->foreign('usuario_id')
                ->references('id')->on('usuarios')
                ->onUpdate('no action')->onDelete('no action');
            // Definimos la foreign key 'receta_id' que apunta a la tabla 'recetas'
            $table->foreign('receta_id')
                ->references('id')->on('recetas')
                ->onUpdate('no action')->onDelete('no action');
        });
    }
    // Si la tabla ya existe, la eliminamos
    public function down(): void
    {
        Schema::dropIfExists('recetas_favoritas');
    }
};
