<li class="nav-item dropdown">
    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Admin</a>
    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
      @can('akses_user')
      <li><a href="{{ route('users.index') }}" class="dropdown-item">User List</a></li>
      @endcan
      @can('akses_role')
      <li><a href="{{ route('roles.index') }}" class="dropdown-item">Roles</a></li>
      @endcan
      @can('akses_permission')
      <li><a href="{{ route('permissions.index') }}" class="dropdown-item">Permissions</a></li>
      @endcan
    </ul>
  </li>