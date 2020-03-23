@extends('layouts.app')

@section('title')
  <h2>Departamentos</h2>
	<a class="btn btn-success float-right" href="{{ route('department.export')}}">Exportar <i class="far fa-file-excel"></i></a>
	@can('departamentos:crear')
	<a class="btn btn-info float-right" href="#" data-target="#new_user" data-toggle="modal">Añadir <i class="fa fa-plus"></i></a>
	@endcan
@endsection

@section('content')

	<div class="table-responsive">
	  <table id="lista" class="table table-striped"></table>
	</div>

	@include('departments.partials.create')
	@include('departments.partials.edit')
  
@endsection

@section('scripts')
<script>
	$(function () {
	  $('#lista').DataTable({
	    processing: true,
	    serverSide: true,
	    responsive: true,
	    ajax: '{!! route('departments.index') !!}',
	    columns: [
			{data: 'name', name: 'name', title: 'Departamento', className: 'text-center text-capitalize'},
			{data: 'users_count', name: 'users_count', title: 'Usuarios', className: 'text-center'},
			{data: 'created_at', name: 'created_at', title: 'Fecha', className: 'text-center'},
			{data: 'action', name: 'acciones', orderable: false, searchable: false, className: 'text-center actions'}
		],
	    language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' }
	  });
	});
</script>
@endsection