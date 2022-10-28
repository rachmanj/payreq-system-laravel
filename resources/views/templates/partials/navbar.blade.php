<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-dark layout-fixed">
    <div class="container">
      <a href="#"class="navbar-brand">
        <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text text-white font-weight-light">Topbar Template</span>
      </a>
  
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="#" class="nav-link">Dashboard</a>
          </li>

          @hasanyrole('superadmin|admin|acc_cashier')
          @include('templates.partials.menu.payreq')
          @include('templates.partials.menu.accounting')
          @endhasanyrole

          @hasanyrole('superadmin|admin|acc_cashier|dnc_staff')
          <li class="nav-item">
            <a href="{{ route('rabs.index') }}" class="nav-link">RABs</a>
          </li>
          @endhasanyrole

          @hasanyrole('superadmin|admin|user')
            @include('templates.partials.menu.admin')
          @endhasanyrole
          
        </ul>
      </div>
  
      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
          <a href="#" class="nav-link">{{ auth()->user()->name }}</a>
        </li>
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link text-dark">
              <i class="fas fa-sign-out-alt"></i> Logout
            </button>
          </form>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->