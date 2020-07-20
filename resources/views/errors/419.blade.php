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

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div id="login" class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-12">
                                <div class="p-5 text-center">
                                    <div class="code">
                                        419     
                                    </div>

                                    <div class="message" style="padding: 10px;">
                                        Esta página ha caducado.                         
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