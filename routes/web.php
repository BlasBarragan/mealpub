<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // clase para la autenticación
use App\Http\Controllers\RecetaController; // controlador de recetas
use App\Http\Controllers\Auth\LoginController; // controlador de login
use App\Http\Controllers\Auth\RegisterController; // controlador de registro de usuarios
use App\Http\Controllers\PerfilController; // controlador de perfil de usuario
use App\Http\Controllers\SemanaController; // controlador de semanas
use App\Http\Controllers\FavoritoController; // controlador de recetas favoritas
use App\Http\Controllers\RecetaSemanaController; // controlador de recetas de la semana


//INICIO
// Botones de login y registro (el acceso a la web esta restringido a usuarios logueados)
Route::get('/', function () {
    return Auth::check()
        // Si el usuario esta logeado ->panel de control. Si no lo esta -> pagina de inicio
        ? redirect()->route('panel')
        : view('inicio');
})->name('inicio');

//PANEL DE CONTROL
// Cuando el usuario esta logeado, mostramos botonera de las distintas secciones de la web (semanas, recetas, favoritas)
Route::get('/panel', function () {
    return view('panel');
})->middleware('auth')->name('panel');

//LOGIN
// Formulario para login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Formulario para registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Procesar el login
Route::post('/login', [LoginController::class, 'login']);
// Procesar el registro
Route::post('/register', [RegisterController::class, 'register']);
// Procesar el logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//PERFIL DE USUARIO
// Mostrar el perfil del usuario
Route::get('/perfil', function () {
    return view('perfil');
})->middleware('auth')->name('perfil');
// Actualizar el perfil del usuario (requiere contraseña actual, implementar mail recuperacion?)
Route::put('/perfil', [PerfilController::class, 'update'])
    ->middleware('auth')
    ->name('perfil.update');

// RECETAS
// Listado de todas las recetas
Route::resource('recetas', RecetaController::class)->middleware('auth');
// Voto de una receta
Route::post('recetas/{receta}/votar', [RecetaController::class, 'votar'])->middleware('auth')->name('recetas.votar');
// Ver recetas favoritas
Route::get('/favoritas', [FavoritoController::class, 'index'])
    ->middleware('auth')
    ->name('favoritas.index');
// Marcar o desmarcar una receta como favorita
Route::post('/favoritas/{receta}/toggle', [FavoritoController::class, 'toggle'])
    ->middleware('auth')
    ->name('favoritas.toggle');
// Ver recetas de un usuario
Route::get('/mis-recetas', [RecetaController::class, 'misRecetas'])->middleware('auth')->name('recetas.mis');


// SEMANAS
// Mostrar el formulario para crear una nueva semana (vacia sin recetas al seleccionar las fecahs)
Route::post('/semanas/planificar', [SemanaController::class, 'validarFechas'])->name('semanas.validar');
// Muestrar formulario para planificar semana
Route::get('/semanas/planificar', [SemanaController::class, 'planificar'])->middleware('auth')->name('semanas.planificar');
// Guardar una semana
Route::post('/semanas', [SemanaController::class, 'store'])->middleware('auth')->name('semanas.store');
// Ver todas las semanas
Route::get('/semanas', [SemanaController::class, 'index'])->middleware('auth')->name('semanas.index');
// Ver detalle de semana
Route::get('/semanas/{semana}', [SemanaController::class, 'show'])->middleware('auth')->name('semanas.show');
// Editar semana
Route::get('/semanas/{semana}/edit', [SemanaController::class, 'edit'])->middleware('auth')->name('semanas.edit');
// Actualizar semana
Route::put('/semanas/{semana}', [SemanaController::class, 'update'])->middleware('auth')->name('semanas.update');
// Eliminar semana
Route::delete('/semanas/{semana}', [SemanaController::class, 'destroy'])->middleware('auth')->name('semanas.destroy');
// Duplicar una semana
Route::post('/semanas/{semana}/duplicar', [SemanaController::class, 'duplicarConFecha'])->middleware('auth')->name('semanas.duplicarConFecha');
// Añadir receta a semana
Route::post('/recetas/a-semana', [RecetaSemanaController::class, 'store'])
    ->name('recetas.añadirASemana')
    ->middleware('auth');
