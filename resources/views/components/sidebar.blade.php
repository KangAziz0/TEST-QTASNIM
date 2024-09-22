<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
      <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold">Argon Dashboard 2</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('dashboard') ? 'bg-gradient-danger btn btn-sm text-white' : '' }}" href="/">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-tv-2 {{Request::routeIs('dashboard') ? 'text-white' : 'text-primary'}} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('products') ? 'bg-gradient-danger btn btn-sm text-white' : '' }}" href="/products">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-app {{Request::routeIs('products') ? 'text-white' : 'text-info'}} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Products</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('categories') ? 'bg-gradient-danger btn btn-sm text-white' : '' }}" href="/categories">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-single-copy-04 {{Request::routeIs('categories') ? 'text-white' : 'text-warning'}} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Categories</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('transaction') ? 'bg-gradient-danger btn btn-sm text-white' : '' }}" href="/transactions">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-cart {{Request::routeIs('transaction') ? 'text-white' : 'text-warning'}} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Transaction</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('reports') ? 'bg-gradient-danger btn btn-sm text-white' : '' }}" href="/reports">
          <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
            <i class="ni ni-cart {{Request::routeIs('reports') ? 'text-white' : 'text-warning'}} text-sm opacity-10"></i>
          </div>
          <span class="nav-link-text ms-1">Transaction Reports</span>
        </a>
      </li>
    </ul>
  </div>
</aside>