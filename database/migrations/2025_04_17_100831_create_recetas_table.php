<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Creamos la tabla 'recetas' con los campos 'id', 'usuario_id', 'nombre', 'raciones', 'n_votos', 'puntuacion', 'tipo_receta' y 'dificultad'
    public function up(): void
    {
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('nombre', 45);
            $table->integer('raciones');
            $table->string('n_votos', 45);
            $table->decimal('puntuacion', 5, 2);
            $table->enum('tipo_receta', ['entrante', 'aperitivo', 'plato_principal', 'reposteria', 'cremas_y_sopas', 'arroces_y_pastas']);
            $table->enum('dificultad', ['facil', 'medio', 'avanzado']);
            $table->timestamps();
            // Definimos la foreign key 'usuario_id' que apunta a la tabla 'usuarios'
            $table->foreign('usuario_id')
                ->references('id')->on('usuarios')
                ->onUpdate('no action')->onDelete('no action');
        });
    }
    // Si la tabla ya existe, la eliminamos
    public function down(): void
    {
        Schema::dropIfExists('recetas');
    }
};
