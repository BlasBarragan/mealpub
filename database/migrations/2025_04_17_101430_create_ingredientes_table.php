<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Creamos la tabla 'ingredientes' con los campos 'id', 'nombre' y 'tipo'
    public function up(): void
    {
        Schema::create('ingredientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45)->unique();
            $table->enum('tipo', ['fruta', 'verdura', 'carne', 'pescado', 'ave', 'especia', 'lacteo', 'cereal', 'legumbre']);
            $table->timestamps();
        });
    }
    // Si la tabla ya existe, la eliminamos
    public function down(): void
    {
        Schema::dropIfExists('ingredientes');
    }
};
