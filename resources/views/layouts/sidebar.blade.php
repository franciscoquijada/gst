
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
      {{ substr( ( setting('company_name') ?? 'Tk' ), 0, 2 ) }}
    </div>
    <div class="sidebar-brand-text mx-3">{{ setting('company_name') ?? 'Toolkit' }}</div>
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

  <!-- Nav Item - Pages Collapse Menu -->
    @forelse($modules as $module)
        @include( strtolower( $module->name ) . '::index')
    @empty
        <p style="text-align: center; color: #FFF;font-size: 12px;">No hay modulos cargados</p>
    @endforelse

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

  <!-- Nav Item - Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
      <i class="fas fa-fw fa-user"></i>
      <span>Usuarios</span>
    </a>
    <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        @can('listado de usuarios')
            <a class="collapse-item" href="{{ route('users.index') }}">Usuarios</a>
        @endcan
        @can('listado de roles')
            <a class="collapse-item" href="{{ route('roles.index') }}">Roles</a>
        @endcan
        @can('auditoria')
            <a class="collapse-item" href="{{ route('logs.index') }}">Registros</a>
        @endcan
      </div>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings">
      <i class="fas fa-fw fa-cogs"></i>
      <span>Configuracion</span>
    </a>
    <div id="collapseSettings" class="collapse" aria-labelledby="headingSettings" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        @can('configuracion empresa')
            <a class="collapse-item" href="{{ route('settings.index') }}">Opciones</a>
        @endcan
        @can('listado de departamentos')
            <a class="collapse-item" href="{{ route('departments.index') }}">Departamentos</a>
        @endcan
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>   
