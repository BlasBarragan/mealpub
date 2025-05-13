@extends('layouts.app')

@section('content')
    <div class="container text-center mt-5">
        <h1 class="mb-4">Bienvenido a MealMate</h1>

        <div class="row justify-content-center gy-4">
            <div class="col-md-4">
                <a href="{{ route('semanas.index') }}" class="btn btn-primary btn-lg w-100 py-3">
                    📅 Ver semanas
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('recetas.index') }}" class="btn btn-secondary btn-lg w-100 py-3">
                    🥘 Ver recetas
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('favoritas.index') }}" class="btn btn-warning btn-lg w-100 py-3">
                    ⭐ Mis favoritas
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('recetas.mis') }}" class="btn btn-success btn-lg w-100 py-3">🍳 Mis recetas</a>
            </div>
        </div>
    </div>
@endsection
