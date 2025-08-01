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

        @guest
          <!-- Registrarse en móvil -->
          <a href="{{ route('register') }}" class="btn btn-primary d-md-none">Registrarse</a>
        @else
          <!-- Usuario en móvil -->
          <div class="dropdown d-md-none">
            <button class="btn btn-primary dropdown-toggle" type="button" id="userMenuButtonMobile" data-bs-toggle="dropdown" aria-expanded="false">
              {{ Auth::user()->name }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButtonMobile">
              <li><a class="dropdown-item" href="{{ route('dashboard') }}">Perfil</a></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">Cerrar sesión</button>
                </form>
              </li>
            </ul>
          </div>
        @endguest
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

    <!-- Usuario o Registrarse en desktop -->
    <div class="d-none d-md-flex align-items-center position-absolute end-0 top-50 translate-middle-y me-3">
      @guest
        <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
      @else
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButton">
            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Perfil</a></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">Cerrar sesión</button>
              </form>
            </li>
          </ul>
        </div>
      @endguest
    </div>
  </div>
</nav>
