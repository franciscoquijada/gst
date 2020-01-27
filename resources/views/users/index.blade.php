@extends('layouts.app')

@section('title')
  <h2>Usuarios</h2>
    <a class="btn btn-success float-right" href="{{ route('users.export')}}">Exportar <i class="far fa-file-excel"></i></a>
	@can('usuarios:crear')
	<a class="btn btn-info float-right" href="#" data-target="#new_user" data-toggle="modal">Añadir <i class="fa fa-plus"></i></a>
	@endcan
@endsection

@section('content')
	<div class="table-responsive">	
		@include('users.partials.table')
	</div>

	@include('users.partials.show')
	@include('users.partials.create')
	@include('users.partials.edit')
@endsection