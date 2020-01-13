<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ setting('company_name') }} - Login</title>

  <!-- Custom styles for this template-->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

</head>

<body id="app" class="bg-info">

  	<div class="container">

	    <!-- Outer Row -->
	    <div class="row justify-content-center">

	      	<div class="col-xl-10 col-lg-12 col-md-9">

		        <div class="card o-hidden border-0 shadow-lg my-5">
		          	<div id="login" class="card-body p-0">
		            	<!-- Nested Row within Card Body -->
		            	<div class="row">
		              		<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
		              		<div class="col-lg-6">
			                	<div class="p-5">
			                  		<div class="text-center">
			                    		<h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
			                  		</div>
				                  	@if ($errors->has('email') || $errors->has('password') )
										<p class="invalid-feedback" role="alert">Correo electrónio o contraseña invalida</p>
									@endif
									<form method="POST" action="{{ route('login') }}">
									  	@csrf
									  	<div class="p-3 login_content">
									        <div>
									          <img class="login-logo" src="{{ setting('company_logo') }}" style="width: 130px;margin: 20px auto; display: block;">
									        </div>
									        <div>
									          <input id="email" type="email" class="form-control input_user{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
									        </div>
									        <div>
									          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Contraseña">
									        </div>
									        <div>
									          <button type="submit" class="btn btn-info submit">
									            {{ __('Login') }}
									          </button>
									          @if (Route::has('password.request'))
									              <!--a class="reset_pass" href="{{ route('password.request') }}">
									                  {{ __('Recuperar Contraseña?') }}
									              </a-->
									          @endif
									        </div>
									        <hr/>
									        <div class="change_link">
									          <a href="{{ route('social_auth',['driver' => 'google']) }}" class="btn-default btn-xs btn mt-5 mb-5" style="text-decoration: none;">
									              Acceder con Google <i class="fab fa-google"></i>
									          </a>
									        </div>
									    </div>
									  	<div class="clearfix"></div>
									</form>
			                  		<hr>
									<div class="text-center">
										<a class="small" href="forgot-password.html">Forgot Password?</a>
									</div>
									<div class="text-center">
										<a class="small" href="register.html">Create an Account!</a>
									</div>
			                	</div>
							</div>
						</div>
					</div>
				</div>
      		</div>
    	</div>
  	</div>

	<!-- Core JavaScript-->
	<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>