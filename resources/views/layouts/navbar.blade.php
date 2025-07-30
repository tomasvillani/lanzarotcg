<nav class="navbar navbar-expand-md bg-white shadow-sm px-4 w-100">
  <div class="container-fluid d-flex justify-content-between align-items-center">

    <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ url('/') }}">
      <img src="{{ asset('img/logo-extendido.png') }}" alt="LanzaroTCG" height="40" class="me-2" />
    </a>

    <ul class="navbar-nav position-absolute start-50 translate-middle-x d-none d-md-flex flex-row">
      <li class="nav-item mx-3">
        <a class="nav-link text-dark" href="{{ url('/') }}">Inicio</a>
      </li>
      <li class="nav-item mx-3">
        <a class="nav-link text-dark" href="{{ url('/cards') }}">Cartas</a>
      </li>
      <li class="nav-item mx-3">
        <a class="nav-link text-dark" href="{{ url('/about') }}">Acerca de</a>
      </li>
    </ul>

    <div class="d-flex align-items-center">
      <a href="/register" class="btn btn-primary">Registrarse</a>
    </div>
  </div>
</nav>
