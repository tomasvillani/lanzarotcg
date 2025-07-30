<nav class="navbar navbar-expand-md bg-white shadow-sm px-4 w-100">
        <div class="container-fluid">

            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" alt="LanzaroTCG" width="50" height="40" class="d-inline-block align-text-top me-2" />

            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="mainNavbar">
                <ul class="navbar-nav mx-auto mb-2 mb-md-0 d-flex">
                    <li class="nav-item mx-4">
                        <a class="nav-link text-dark" href="{{ url('/') }}">Inicio</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link text-dark" href="{{ url('/cartas') }}">Cartas</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link text-dark" href="{{ url('/acerca-de') }}">Acerca de</a>
                    </li>
                </ul>

                <div>
                    <a href="/register" class="btn btn-primary">Registrarse</a>
                </div>
            </div>
        </div>
    </nav>