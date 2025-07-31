<nav class="navbar navbar-expand-md bg-white shadow-sm px-4 w-100">
  <div class="container-fluid position-relative">

    <div class="d-flex w-100 align-items-center justify-content-between">
      <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ url('/') }}">
        <img src="{{ asset('img/logo-extendido.png') }}" alt="LanzaroTCG" height="40" class="me-2" />
      </a>

      <div class="d-flex align-items-center">
        <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse"
          data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a href="/register" class="btn btn-primary d-md-none">Registrarse</a>
      </div>
    </div>

    <div class="collapse navbar-collapse justify-content-center mt-3 mt-md-0" id="mainNavbar">
      <ul class="navbar-nav flex-column flex-md-row w-100 justify-content-md-center align-items-md-center text-center">
        <li class="nav-item mx-md-3">
          <a class="nav-link text-dark" href="{{ url('/') }}">Inicio</a>
        </li>
        <li class="nav-item mx-md-3">
          <a class="nav-link text-dark" href="{{ url('/cards') }}">Cartas</a>
        </li>
        <li class="nav-item mx-md-3">
          <a class="nav-link text-dark" href="{{ url('/about') }}">Acerca de</a>
        </li>
      </ul>
    </div>

    <div class="d-none d-md-flex align-items-center position-absolute end-0 top-50 translate-middle-y me-3">
      <a href="/register" class="btn btn-primary">Registrarse</a>
    </div>
  </div>
</nav>
