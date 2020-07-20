<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">

	<!-- Topbar Navbar -->
	<ul class="navbar-nav ml-auto">

		@auth

		<!-- Nav Item - Alerts -->
	<li class="nav-item dropdown no-arrow mx-1">
	  <a class="nav-link dropdown-toggle mark_as_read heartBeat animated" data-route="{{ route('ajax.mark_as_read')}}" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    <i class="fas fa-bell fa-fw"></i>
	    @if( $alerts = auth::user()->unreadNotifications->count() )
	    <!-- Counter - Alerts -->
	    <span class="badge badge-danger badge-counter">{{ $alerts }}</span>
	    @endif
	  </a>
	  <!-- Dropdown - Alerts -->
	  <div class="dropdown-list dropdown-menu dropdown-menu-right animated--grow-in" aria-labelledby="alertsDropdown">
	    <h6 class="dropdown-header">Notificaciones</h6>
	    @foreach (auth::user()->unreadNotifications as $notification)
	    <a class="dropdown-item d-flex align-items-center" href="#">
	      <div class="mr-3">
	        <div class="icon-circle bg-primary">
	          <i class="fas fa-file-alt text-white"></i>
	        </div>
	      </div>
	      <div>
	        <div class="small text-gray-500">{{ $notification->created_at->format('h:m d/m/Y') }}</div>
	        <span class="font-weight-bold">{{ $notification->data['title'] }}</span><br/>
	        <span class="text-sm">{{ $notification->data['message'] }}</span>
	      </div>
	    </a>
	    @endforeach
	    <a class="dropdown-item text-center small text-gray-500" href="#">Mostrar todas las notificaciones</a>
	  </div>
	</li>

	<!-- Nav Item - Messages --
	<li class="nav-item dropdown no-arrow mx-1">
	  <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    <i class="fas fa-envelope fa-fw"></i>
	    <!-- Counter - Messages --
	    <span class="badge badge-danger badge-counter">7</span>
	  </a>
	  <!-- Dropdown - Messages --
	  <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
	    <h6 class="dropdown-header">
	      Message Center
	    </h6>
	    <a class="dropdown-item d-flex align-items-center" href="#">
	      <div class="dropdown-list-image mr-3">
	        <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
	        <div class="status-indicator bg-success"></div>
	      </div>
	      <div class="font-weight-bold">
	        <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
	        <div class="small text-gray-500">Emily Fowler · 58m</div>
	      </div>
	    </a>
	    <a class="dropdown-item d-flex align-items-center" href="#">
	      <div class="dropdown-list-image mr-3">
	        <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
	        <div class="status-indicator"></div>
	      </div>
	      <div>
	        <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
	        <div class="small text-gray-500">Jae Chun · 1d</div>
	      </div>
	    </a>
	    <a class="dropdown-item d-flex align-items-center" href="#">
	      <div class="dropdown-list-image mr-3">
	        <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
	        <div class="status-indicator bg-warning"></div>
	      </div>
	      <div>
	        <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
	        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
	      </div>
	    </a>
	    <a class="dropdown-item d-flex align-items-center" href="#">
	      <div class="dropdown-list-image mr-3">
	        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
	        <div class="status-indicator bg-success"></div>
	      </div>
	      <div>
	        <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
	        <div class="small text-gray-500">Chicken the Dog · 2w</div>
	      </div>
	    </a>
	    <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
	  </div>
	</li>-->

		<div class="topbar-divider d-none d-sm-block"></div>

		<!-- Nav Item - User Information -->
		<li class="nav-item dropdown no-arrow">
			<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-chevron-down mr-2 text-gray-400"></i>
				<span class="mr-2 d-none d-lg-inline text-gray-600 small text-capitalize"><b>{{ auth()->user()->name ?? '' }}</b></span>
			</a>
			<!-- Dropdown - User Information -->
			<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
				<a class="dropdown-item" href="{{route('profile.show')}}">
					<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
					Configuracion
				</a>
				<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
					<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
					Cerrar Sesión
				</a>
			</div>
		</li>
		<!-- / Nav Item - User Information -->
		@endauth
	</ul>
</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5>Cerrar Sesión</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">¿Estas seguro que deseas cerrar sesión?.</div>
			<div class="modal-footer">
				<a class="btn btn-primary" type="button" data-dismiss="modal"><i class="fas fa-undo"></i>Cancel</a>
				<a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
				document.getElementById('logout-form').submit();">
				<i class="fas fa-sign-out-alt"></i> {{ __('Continuar') }}
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf
				</form>
			</a>
		</div>
	</div>
</div>
</div>
<!-- / Logout Modal-->