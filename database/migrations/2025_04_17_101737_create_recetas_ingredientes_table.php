<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Creamos la tabla 'recetas_ingredientes' con los campos 'id', 'recetas_id', 'ingredientes_id', 'cantidad' y 'unidad'
    public function up(): void
    {
        Schema::create('recetas_ingredientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recetas_id');
            $table->unsignedBigInteger('ingredientes_id');
            $table->float('cantidad');
            $table->string('unidad', 45);
            $table->timestamps();
            // Definimos la foreign key 'recetas_id' que apunta a la tabla 'recetas'
            $table->foreign('recetas_id')->references('id')->on('recetas')->onUpdate('no action')->onDelete('no action');
            $table->foreign('ingredientes_id')->references('id')->on('ingredientes')->onUpdate('no action')->onDelete('no action');
        });
    }
    // Si la tabla ya existe, la eliminamos
    public function down(): void
    {
        Schema::dropIfExists('recetas_ingredientes');
    }
};
