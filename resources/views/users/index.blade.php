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
		<table id="lista" class="table table-striped"></table>
	</div>

	@include('users.partials.show')
	@include('users.partials.create')
	@include('users.partials.edit')
@endsection

@section('scripts')
<script>
	var table = 
	$(function () {
	  $('#lista').DataTable({
	    processing: true,
	    serverSide: true,
	    responsive: true,
	    ajax: '{!! route('users.index') !!}',
	    columns: [
			{data: 'name', name: 'name', title: 'Nombre', className: 'text-center text-capitalize'},
			{data: 'role_name', name: 'role_name', title: 'Rol', className: 'text-center'},
			{data: 'email', name: 'email', title: 'Email', className: 'text-center'},
			{data: 'department.name', name: 'department', title: 'Departamento', className: 'text-center'},
			{data: 'action', name: 'acciones', orderable: false, searchable: false, className: 'text-center actions'}
		],
	    language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' }
	  });
	});
</script>
@endsection