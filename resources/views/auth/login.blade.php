@extends('layouts.base')

@section('page')
<nav class="navbar" style="background-color: {{ _setting( 'color_primary', '#36B9CC' ) }}">
	 <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
    <div class="sidebar-brand-icon rotate-n-15">  
      {{ substr( _setting('company_name', 'Tk'), 0, 2 ) }}
    </div>
    <div class="sidebar-brand-text mx-3">{{ _setting( 'company_name', 'Toolkit' ) }}</div>
  </a>
</nav>

<div class="container">
	<!-- Outer Row -->
	<div class="row justify-content-center">

	  	<div class="col-xl-6 col-lg-9 col-md-10">

	        <div class="card o-hidden border-0 my-5">
	          	<div id="login" class="card-body p-0">
	            	<!-- Nested Row within Card Body -->
	            	<div class="row">
	            		<div id="login-form" class="col-12 p-5">
	                  		<div class="text-center">
	                    		<h2 class="h4 text-gray-900">{{ __('Iniciar Sesion') }}</h2>
	                  		</div>
	                  		{!! Form::open(['id' => 'login_form', 'route' => 'login', 'method'=>'POST']) !!}
							  	<div class="p-3 login_content text-center">
                					<p>Por favor completa los siguientes datos</p>
							        <div class="mt-3">
							          	<input id="email" type="email" class="form-control input_user{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('Email') }}">
							          	<span id="email-error" style="display: none;" class="label label-danger ml-1 error error"></span>
							        </div>
							        <div class="mt-3">
							          	<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="{{ __('Contraseña') }}">
							          	<span id="password-error" style="display: none;" class="label label-danger ml-1 error"></span>
							        </div>
							        <div class="text-center mt-3">
							          <a class="btn btn-success send-form">
							            {{ __('Iniciar Sesión') }} <i class="fas fa-sign-in-alt"></i>
							          </a>
							          @if(  env('GOOGLE_CLIENT_ID', false) || env('FB_CLIENT_ID', false) || env('LINKEDIN_CLIENT_ID', false) )
								          <span class="d-block m-2">{{ __('o acceder con') }}</span>
								          @if( env('GOOGLE_CLIENT_ID', false) )
									          <a href="{{ route('social_auth',['driver' => 'google']) }}" class=" d-inline-block btn-default btn text-dark" style="text-decoration: none; border: 1px solid #CCC !important; color: #444 !important">{{ __('Google') }} <i class="fab fa-google"></i>
									          </a>
								          @endif
								          @if( env('FB_CLIENT_ID', false) )
									          <a href="{{ route('social_auth',['driver' => 'facebook']) }}" class=" d-inline-block btn-default btn text-dark" style="text-decoration: none; border: 1px solid #CCC !important; color: #444 !important">{{ __('Facebook') }} <i class="fab fa-facebook-f"></i>
									          </a>
								          @endif
								          @if( env('LINKEDIN_CLIENT_ID', false) )
									          <a href="{{ route('social_auth',['driver' => 'linkedin']) }}" class=" d-inline-block btn-default btn text-dark" style="text-decoration: none; border: 1px solid #CCC !important; color: #444 !important">{{ __('LinkedIn') }} <i class="fab fa-linkedin-in"></i>
									          </a>
								          @endif
							          @endif
							        </div>
							    </div>
							  	<div class="clearfix"></div>
							</form>
	                    	<hr class="mt-2" />
					        <div class="text-center mt-3">
						        @if (Route::has('password.request'))
						        	<a class="small m-2" href="{{ route('password.request') }}">{{ __('¿Olvide mi contraseña?') }}</a>
						        @endif
	                        	@if (Route::has('register'))
									<a class="small m-2" href="{{ route('register')}}"><b>{{ __('Quiero registrarme') }}</b></a>
	                			@endif
	            			</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
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
@endpush