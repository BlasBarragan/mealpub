<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Creamos la tabla 'semanas' con los campos 'id', 'usuario_id', 'inicio' y 'fin'
    public function up(): void
    {
        Schema::create('semanas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->date('inicio')->unique();
            $table->date('fin')->unique();
            $table->unique(['usuario_id', 'inicio', 'fin']); // unique para que no se repitan semanas
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
        Schema::dropIfExists('semanas');
    }
};
