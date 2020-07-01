@extends('layouts.base')

@section('page')
    <nav class="navbar">
        <img class="logo d-block" src="{{ _setting( 'company_logo', '' ) }}">
    </nav>

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div id="login" class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-12">
                                <div class="p-5 text-center">
                                    <div class="code">
                                        403     
                                    </div>

                                    <div class="message" style="padding: 10px;">
                                         Su usuario no tiene permisos para acceder a esta url. contacte al administrador.                       
                                    </div>
                                    <a href="{{ route('home') }}" class="btn btn-sm btn-info mt-5" title="Ir al home ">ir al home <i class="fa fa-home"></i></a>
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
<!-- Styles -->
<style>
    .code {
        font-size: 42px;
        padding: 0 15px 0 15px;
        text-align: center;
        font-weight: 100 !important;
    }

    .message {
        font-size: 18px;
        text-align: center;
    }
    a>i{
        height: 100%;
    }
</style>
@endpush