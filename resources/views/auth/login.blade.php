@extends('layouts.base')

@section('page')
  	<div class="container">

	    <!-- Outer Row -->
	    <div class="row justify-content-center">

	      	<div class="col-xl-10 col-lg-12 col-md-9">

		        <div class="card o-hidden border-0 shadow-lg my-5">
		          	<div id="login" class="card-body p-0">
		            	<!-- Nested Row within Card Body -->
		            	<div class="row">
		              		<div id="bg-login" class="col-lg-6 d-none d-lg-block bg-login-image" ></div>
		              		<div class="col-lg-6">
			                	<div class="p-5">
			                  		<div class="text-center">
			                    		<h1 class="h4 text-gray-900 mb-4">{{ __('Hola de nuevo!') }}</h1>
			                  		</div>
				                  	
									<form method="POST" action="{{ route('login') }}">
									  	@csrf
									  	<div class="p-3 login_content">
									        <div>
									          <img class="login-logo" src="{{ _setting('company_logo') }}" style="width: 130px;margin: 20px auto; display: block;">
									        </div>
									        @if ($errors->has('email') || $errors->has('password') )
									        	<div class="alert alert-danger" role="alert">
												  <strong>Oh oh!</strong> {{ __('Correo electrónio o contraseña invalida') }}.
												</div>
											@endif
									        <div>
									          <input id="email" type="email" class="form-control input_user{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('Email') }}">
									        </div>
									        <div>
									          <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ __('Contraseña') }}">
									        </div>
									        <div class="text-center">
									          <button type="submit" class="btn btn-info custom submit">
									            {{ __('Iniciar Sesión') }}<i class="fas fa-sign-in-alt"></i>
									          </button>
									          <span class="d-block m-2">{{ __('O') }}</span>

									          <a href="{{ route('social_auth',['driver' => 'google']) }}" class=" d-inline-block btn-default btn text-dark" style="text-decoration: none; border: 1px solid #CCC !important; color: #444 !important">{{ __('Acceder con Google') }} <i class="fab fa-google"></i>
									          </a>
									        </div>
									    </div>
									  	<div class="clearfix"></div>
									</form>
                                	<hr class="mt-2" />
							        <div class="text-center mt-3">
								        @if (Route::has('password.request'))
								        	<a class="small m-2" href="#" data-target="#reset_password" data-toggle="modal">{{ __('Olvide mi contraseña?') }}</a>
	                                	@endif
	                                	@if (Route::has('register'))
											<a class="small m-2" href="#" data-target="#new_user" data-toggle="modal">{{ __('Crear una cuenta') }}</a>
                            			@endif
                        			</div>
                        			@include('auth.register')
                        			@include('auth.passwords.email')
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
	<script type="text/javascript">
		$('.send-reset').on('click', sendReset );
		function sendReset( e ){
		  e.preventDefault();
		  let $form = $(this).parents('form');

		  $.ajax({
		    type: $form.attr('method'), //metodo
		    url: $form.attr('action'), //url
		    data: $form.serialize(),
		    success: function (data) {
		    	$form.parents('.modal').modal('hide');
		    	Swal.fire(
	              'Enviado!',
	              'Hemos enviado las instrucciones al mail ' + $form.find('#email').val()+'.',
	              'success'
	            );
	            $form.find('#email').val('');
		    },
		    error: function (xhr, ajaxOptions, thrownError) {

		      if( xhr.status == 422 ){

		       $.each(xhr.responseJSON.errors, function( index, elem ){

		        let $index = index.split('.')[0];
		        $form.find('#' + $index ).addClass('invalid');
		        $form.find('#' + $index + '-error')
		          .removeAttr('style')
		          .html( elem );
		        });
		        setTimeout(function () {
		          $form.find(".error").fadeOut(1500);
		          $form.find('.invalid').removeClass('invalid')
		        }, 6000);
		      }
		    }
		  });
		}
	</script>
@endsection

@section('styles')
<style type="text/css">
	#app{
		background-color: {{ _setting('color_primary', '#36B9CC') }};
	}
</style>
@endsection