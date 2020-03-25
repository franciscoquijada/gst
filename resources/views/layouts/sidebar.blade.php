
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: {{ _setting('color_primary', '#36B9CC') }}; background-image: linear-gradient(180deg, {{ _setting('color_primary', '#36B9CC') }} 10%, #064985 100%); background-size: cover;">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
      {{ substr( _setting('company_name', 'Tk'), 0, 2 ) }}
    </div>
    <div class="sidebar-brand-text mx-3">{{ _setting( 'company_name', 'Toolkit' ) }}</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="{{ route('home') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Inicio</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Modulos
  </div>

  <!-- Modules -->
  @forelse( $modules as $module )
    @include( strtolower( $module->getName() ) . '::index')
  @empty
    <p style="text-align: center; color: #FFF;font-size: 12px;">No hay modulos cargados</p>
  @endforelse
  <!-- / Modules -->

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    General
  </div>

  <!-- Nav Item - Charts -->
  <!--li class="nav-item">
    <a class="nav-link" href="charts.html">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Charts</span></a>
  </li-->

  @can('usuarios:listado','roles:listado','registros:listado')
  <!-- Nav Item - Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
      <i class="fas fa-fw fa-user"></i>
      <span>Usuarios</span>
    </a>
    <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        @can('usuarios:listado')
            <a class="collapse-item" href="{{ route('users.index') }}">Usuarios</a>
        @endcan
        @can('roles:listado')
            <a class="collapse-item" href="{{ route('roles.index') }}">Roles</a>
        @endcan
        @can('registros:listado')
            <a class="collapse-item" href="{{ route('logs.index') }}">Registros</a>
        @endcan
      </div>
    </div>
  </li>
  <!-- / Nav Item - Collapse Menu -->
  @endcan

  @can('departamentos:listado','configuraciones:listado')
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings">
      <i class="fas fa-fw fa-cogs"></i>
      <span>Configuracion</span>
    </a>
    <div id="collapseSettings" class="collapse" aria-labelledby="headingSettings" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        @can('configuraciones:listado')
            <a class="collapse-item" href="{{ route('settings.index') }}">Opciones</a>
        @endcan
        @can('departamentos:listado')
            <a class="collapse-item" href="{{ route('departments.index') }}">Departamentos</a>
        @endcan
      </div>
    </div>
  </li>
  @endcan

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>   
