<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('panel') }}">
            <img src="{{ asset('images/logo.png') }}" alt="MealMate Logo" style="height: 40px;">
            MealMate
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @auth
                    {{-- Nombre de usuario y acceso a su perfil --}}
                    <li class="nav-item">
                        <a href="{{ route('perfil') }}" class="nav-link">Hola, {{ Auth::user()->nombre }}</a>
                    </li>
                    {{-- Boton de cerrar sesion --}}
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light ms-2">Cerrar sesión</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
