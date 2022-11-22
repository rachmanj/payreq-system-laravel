<li class="nav-item dropdown">
    <a id="dropdownPayreq" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Accounting</a>
    <ul aria-labelledby="dropdownPayreq" class="dropdown-menu border-0 shadow">
      {{-- <li><a href="{{ route('reports.index') }}" class="dropdown-item">Reports</a></li> --}}
      <li><a href="{{ route('rabs.index') }}" class="dropdown-item">RABs</a></li>
      <li><a href="{{ route('transaksi.index') }}" class="dropdown-item">Transactions</a></li>
      <li><a href="{{ route('rekaps.index') }}" class="dropdown-item">Rekaps Tx</a></li>
      <li><a href="{{ route('acc-dashboard.index') }}" class="dropdown-item">Dashboard</a></li>
    </ul>
  </li>