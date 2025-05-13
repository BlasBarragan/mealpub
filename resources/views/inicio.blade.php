@extends('layouts.guest')

@section('content')
    <div class="container text-center mt-5">
        <img src="{{ asset('images/logo.png') }}" alt="mealMate Logo" class="img-fluid mb-4" style="max-width: 300px;">

        <h1 class="mb-4">Bienvenido a MealMate</h1>
        <p class="lead">Planifica tus recetas semanales de forma fácil y personalizada.</p>


        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary me-3">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="btn btn-secondary ms-2">Registrarse</a>
        </div>

    </div>
@endsection
