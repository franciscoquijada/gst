@extends('layouts.base')

@section('page')
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 my-5">
                    <div id="login" class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">{{ __('Confirmar Contraseña') }}</h1>
                                    </div>
                                    <form method="POST" action="{{ route('password.confirm') }}">
                                        @csrf

                                        <div class="form-group row">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                                <span id="password-error" style="display: none;" class="label label-danger ml-1 error"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <a class="btn btn-success send-form">
                                                  {{ __('Continuar') }} <i class="far fa-save"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <hr class="mt-2" />
                                        <div class="text-center mt-3">
                                            @if (Route::has('password.request'))
                                                <a class="small m-2" href="#" data-target="#reset_password" data-toggle="modal">{{ __('Olvide mi contraseña?') }}</a>
                                            @endif
                                        </div>
                                        @include('auth.passwords.email')
                                    </form>
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
@endsection

@section('styles')
<style type="text/css">
    #app{
        background-color: {{ _setting('color_primary', '#36B9CC') }};
    }
</style>
@endsection