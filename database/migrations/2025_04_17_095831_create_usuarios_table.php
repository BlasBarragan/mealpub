<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    // Creamos la tabla 'usuarios' con los campos 'id', 'nombre', 'email' y 'password'
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->string('email', 45)->unique();
            $table->string('password', 255);
            $table->timestamps();
        });
    }
    // Si la tabla ya existe, la eliminamos
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
