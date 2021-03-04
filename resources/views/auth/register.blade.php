@extends('layouts.base')

@section('page')
<nav class="navbar"><img class="logo d-block" src="{{ _setting( 'company_logo', 'Toolkit' ) }}">
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
                <h2 class="h4 text-gray-900">{{ __('Registro') }}</h2>
              </div>
              {!! Form::open(['id' => 'register_form', 'route' => 'register','method'=>'POST']) !!}
              <div class="p-3 login_content text-center">
                <p>Por favor completa los siguientes datos</p>
                <div class="mt-3">
                  <input type="text" name="name" value="{{ old('name') }}" autocomplete="off" class="form-control alpha" id="name" placeholder="Nombre Completo">
                  <span id="name-error" style="display: none;" class="label label-danger ml-1 error"></span>
                </div>
                <div class="mt-3">
                  <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email" autocomplete="off" placeholder="Correo Electrónico">
                  <span id="email-error" style="display: none;" class="label label-danger ml-1 error"></span>
                </div>
                <div class="mt-3">
                  <input id="password" type="password" class="form-control" name="password" required placeholder="{{ __('Contraseña') }}">
                  <span id="password-error" style="display: none;" class="label label-danger ml-1 error"></span>
                </div>
                <div class="mt-3">
                  <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="{{ __('Confirmar Contraseña') }}">
                  <span id="password_confirmation-error" style="display: none;" class="label label-danger ml-1 error"></span>
                </div>
              </div>
              <div class="col-12 text-center">
                <a class="btn btn-success send-form">{{ __('Registrarte') }} <i class="far fa-save"></i></a> 
              </div>
              <div class="clearfix"></div>
              {!! Form::close() !!}
              <hr class="mt-2" />
              <div class="text-center mt-3">
                @if (Route::has('password.request'))
                  <a class="small m-2" href="{{ route('password.request') }}">{{ __('¿Olvide mi contraseña?') }}</a>
                @endif
                <a class="small m-2" href="{{ route('login')}}"><b>{{ __('Ya tengo cuenta') }}</b></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection