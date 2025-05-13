<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Creamos la tabla 'recetas_semanas' con los campos 'id', 'semana_id', 'dia_semana', 'desayuno_receta_id', 'comida_receta_id', 'merienda_receta_id' y 'cena_receta_id'
    public function up(): void
    {
        Schema::create('recetas_semanas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('semana_id');
            $table->enum('dia_semana', ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo']);
            $table->unsignedBigInteger('desayuno_receta_id')->nullable();
            $table->unsignedBigInteger('comida_receta_id')->nullable();
            $table->unsignedBigInteger('merienda_receta_id')->nullable();
            $table->unsignedBigInteger('cena_receta_id')->nullable();
            $table->timestamps();
            // Definimos la foreign key 'semana_id' que apunta a la tabla 'semanas'
            $table->foreign('semana_id')->references('id')->on('semanas')->onUpdate('no action')->onDelete('no action');
            // Definimos la foreign key 'desayuno_receta_id' que apunta a la tabla 'recetas'
            $table->foreign('desayuno_receta_id')->references('id')->on('recetas')->onUpdate('no action')->onDelete('no action');
            // Definimos la foreign key 'comida_receta_id' que apunta a la tabla 'recetas'
            $table->foreign('comida_receta_id')->references('id')->on('recetas')->onUpdate('no action')->onDelete('no action');
            // Definimos la foreign key 'merienda_receta_id' que apunta a la tabla 'recetas'
            $table->foreign('merienda_receta_id')->references('id')->on('recetas')->onUpdate('no action')->onDelete('no action');
            // Definimos la foreign key 'cena_receta_id' que apunta a la tabla 'recetas'
            $table->foreign('cena_receta_id')->references('id')->on('recetas')->onUpdate('no action')->onDelete('no action');
        });
    }
    // Si la tabla ya existe, la eliminamos
    public function down(): void
    {
        Schema::dropIfExists('recetas_semanas');
    }
};
