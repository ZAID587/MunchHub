<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MunchHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/docs/5.3/examples/pricing/pricing.css" rel="stylesheet">
</head>
<body>
  <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
    <button class="btn btn-primary py-2 dropdown-toggle d-flex align-items-center" id="bd-theme" type="button" data-bs-toggle="dropdown">
      <i class="bi bi-moon-stars-fill my-1"></i>
    </button>
    <ul class="dropdown-menu dropdown-menu-end shadow">
      <li><button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light"><i class="bi bi-sun-fill me-2 opacity-50"></i>Claro</button></li>
      <li><button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="dark"><i class="bi bi-moon-stars-fill me-2 opacity-50"></i>Oscuro</button></li>
      <li><button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto"><i class="bi bi-circle-half me-2 opacity-50"></i>Auto</button></li>
    </ul>
  </div>

  <div class="container py-3">
    <header>
      <div class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center link-body-emphasis text-decoration-none">
          <i class="bi bi-bootstrap-fill fs-2 me-2"></i><span class="fs-4">Mi Proyecto Laravel</span>
        </a>

        <!-- Navegación con Menú Desplegable de Usuario -->
        <nav class="d-inline-flex mt-2 mt-md-0 ms-md-auto align-items-center">
          @if (Route::has('login'))
            @auth
              <div class="dropdown">
                <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-person-circle fs-5 me-2"></i>
                  <span>{{ Auth::user()->name ?? 'Zaid Medina Santillan' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                  @if (Route::has('profile.edit'))
                    <li>
                      <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bi bi-person me-2"></i>Perfil
                      </a>
                    </li>
                  @endif
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form method="POST" action="{{ route('logout') }}">
                      @csrf
                      <button type="submit" class="dropdown-item text-danger">
                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                      </button>
                    </form>
                  </li>
                </ul>
              </div>
            @else
              <a class="me-3 py-2 link-body-emphasis text-decoration-none" href="{{ route('login') }}">Log in</a>
              @if (Route::has('register'))
                <a class="py-2 link-body-emphasis text-decoration-none" href="{{ route('register') }}">Register</a>
              @endif
            @endauth
          @endif
        </nav>
      </div>

      <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">Planes de acceso</h1>
        <p class="fs-5 text-body-secondary">Este es mi proyecto personal desarrollado en Laravel. Selecciona el plan que prefieras para comenzar a usar la plataforma o pásate a Pro para obtener más funciones.</p>
      </div>
    </header>

    <main>
      <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
        <div class="col">
          <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3"><h4 class="my-0 fw-normal">Básico</h4></div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$100<small class="text-body-secondary fw-light">/MXN</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>Funciones básicas</li>
                <li>Acceso público</li>
                <li>Soporte comunitario</li>
                <li>Centro de ayuda</li>
              </ul>
              <button type="button" class="w-100 btn btn-lg btn-outline-primary">Comenzar gratis</button>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3"><h4 class="my-0 fw-normal">Pro</h4></div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$225<small class="text-body-secondary fw-light">/MXN</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>Acceso completo</li>
                <li>Panel de control</li>
                <li>Soporte prioritario</li>
                <li>Actualizaciones</li>
              </ul>
              <button type="button" class="w-100 btn btn-lg btn-primary">Únete a Pro</button>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card mb-4 rounded-3 shadow-sm border-primary">
            <div class="card-header py-3 text-bg-primary border-primary"><h4 class="my-0 fw-normal">Personalizado</h4></div>
            <div class="card-body">
              <h1 class="card-title pricing-card-title">$550<small class="text-body-secondary fw-light">/MXN</small></h1>
              <ul class="list-unstyled mt-3 mb-4">
                <li>Módulos a medida</li>
                <li>Acceso ilimitado</li>
                <li>Soporte por llamada</li>
                <li>Integración directa</li>
              </ul>
              <button type="button" class="w-100 btn btn-lg btn-primary">Contáctanos</button>
            </div>
          </div>
        </div>
      </div>

      <h2 class="display-6 text-center mb-4">Comparar planes</h2>
      <div class="table-responsive">
        <table class="table text-center">
          <thead>
            <tr>
              <th style="width: 34%;"></th>
              <th style="width: 22%;">Básico</th>
              <th style="width: 22%;">Pro</th>
              <th style="width: 22%;">Personalizado</th>
            </tr>
          </thead>
          <tbody>
            <tr><th scope="row" class="text-start">Acceso público</th><td><i class="bi bi-check fs-4"></i></td><td><i class="bi bi-check fs-4"></i></td><td><i class="bi bi-check fs-4"></i></td></tr>
            <tr><th scope="row" class="text-start">Panel de administración</th><td></td><td><i class="bi bi-check fs-4"></i></td><td><i class="bi bi-check fs-4"></i></td></tr>
            <tr><th scope="row" class="text-start">Soporte directo</th><td><i class="bi bi-check fs-4"></i></td><td><i class="bi bi-check fs-4"></i></td><td><i class="bi bi-check fs-4"></i></td></tr>
            <tr><th scope="row" class="text-start">Funciones avanzadas</th><td></td><td><i class="bi bi-check fs-4"></i></td><td><i class="bi bi-check fs-4"></i></td></tr>
            <tr><th scope="row" class="text-start">Consultas ilimitadas</th><td></td><td><i class="bi bi-check fs-4"></i></td><td><i class="bi bi-check fs-4"></i></td></tr>
            <tr><th scope="row" class="text-start">Seguridad extra</th><td></td><td></td><td><i class="bi bi-check fs-4"></i></td></tr>
          </tbody>
        </table>
      </div>
    </main>

    <footer class="pt-4 my-md-5 pt-md-5 border-top">
      <div class="row">
        <div class="col-12 col-md">
          <i class="bi bi-bootstrap fs-3 mb-2 d-block"></i>
          <small class="d-block mb-3 text-body-secondary">&copy; 2017–2026</small>
        </div>
        <div class="col-6 col-md">
          <h5>Contacto</h5>
          <ul class="list-unstyled text-small">
            <li class="text-body-secondary">Zaid Medina Santillan</li>
            <li><a class="link-secondary text-decoration-none" href="mailto:zaidmed587@gmail.com">zaidmed587@gmail.com</a></li>
            <li><a class="link-secondary text-decoration-none" href="tel:+527227705013">+52 722-770-5013</a></li>
          </ul>
        </div>
        <div class="col-6 col-md">
          <h5>Recursos</h5>
          <ul class="list-unstyled text-small">
            <li><a class="link-secondary text-decoration-none" href="#">Documentación</a></li>
            <li><a class="link-secondary text-decoration-none" href="#">Guía de uso</a></li>
            <li><a class="link-secondary text-decoration-none" href="#">Repositorio</a></li>
          </ul>
        </div>
        <div class="col-6 col-md">
          <h5>Acerca de</h5>
          <ul class="list-unstyled text-small">
            <li><a class="link-secondary text-decoration-none" href="#">Privacidad</a></li>
            <li><a class="link-secondary text-decoration-none" href="#">Términos</a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>