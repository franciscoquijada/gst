@extends('layouts.base')

@section('page')
<nav class="navbar">
  <img class="logo d-block" src="{{ _setting( 'company_logo', '' ) }}">
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
                <h2 class="h4 text-gray-900">{{ __('Olvide mi contraseña') }}</h2>
              </div>
              {!! Form::open(['id' => 'reset_form', 'route' => 'password.email','method'=>'POST']) !!}
              <div class="p-3 login_content text-center">
                <p>Por favor ingresa tu correo electrónico</p>
                <div class="mt-3">
                  <input id="email" type="email" class="form-control input_user" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ __('Email') }}">
                  <span id="email-error" style="display: none;" class="label label-danger ml-1 error error"></span>
                </div>
              </div>
              <div class="col-12 text-center">
                <a class="btn btn-success send-reset">
                  {{ __('Enviar') }} <i class="fas fa-envelope"></i></i>
                </a>
              </div>
              <div class="clearfix"></div>
            {!! Form::close() !!}
            <hr class="mt-2" />
            <div class="text-center mt-3">
              @if (Route::has('password.request'))
              <a class="small m-2" href="{{ route('login') }}">{{ __('Iniciar sesión') }}</a>
              @endif
              @if (Route::has('register'))
              <a class="small m-2" href="{{ route('register')}}"><b>{{ __('Registrarte') }}</b></a>
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
        Swal.fire(
          'Enviado!',
          'Hemos enviado las instrucciones al mail ' + $form.find('#email').val() +'.',
          'success'
          ).then((result) => {
          location.href = '{{ route('login')}}';
        });
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
       } else if( xhr.status == 500 ){
        Swal.fire(
          'Error =(',
          'Lo sentimos ha ocurrido un error mientras buscabamos tus datos, intenta mas tarde',
          'error'
          ).then((result) => {
          location.href = '{{ route('login')}}';
        });
       }
     }
   });
  }
</script>
@endpush