<header class="navbar navbar-expand-md navbar-light d-print-none">
  <div class="container-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark d-none-initial-sm pe-0 pe-md-3">
      <a href=".">
        <span class="text-primary fw-bold">BANTECH</span> POS
      </a>
    </h1>
    <div class="navbar-nav flex-row order-md-last">
      <div class="nav-item d-none d-md-flex me-3">
        <div class="btn-list">
          </div>
      </div>
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
          <span class="avatar avatar-sm" style="background-image: url(https://ui-avatars.com/api/?name=Admin+Bantech&background=0D6EFD&color=fff)"></span>
          <div class="d-none d-xl-block ps-2">
            <div>{{ Auth::user()->employe->full_name ?? Auth::user()->name }}</div>
            <div class="mt-1 small text-muted">{{ Auth::user()->role }}</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="#" class="dropdown-item">Profile & Account</a>
          <div class="dropdown-divider"></div>
          <a id="btnLogout" href="#" class="dropdown-item text-danger">Logout</a>
        </div>
      </div>
    </div>
  </div>
</header>