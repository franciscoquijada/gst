@extends('layouts.app')

@section('title')
  <h2>Tipos de identificadores externos</h2>
	@can('tipos identificadores:crear')
	<a class="btn btn-info float-right" href="#" data-target="#new_type" data-toggle="modal">Añadir <i class="fa fa-plus"></i></a>
	@endcan
@endsection

@section('content')

	<div class="table-responsive">
	  <table id="lista" class="table table-striped"></table>
	</div>

	@include('identifications_types.partials.create')
	@include('identifications_types.partials.edit')
  
@endsection

@push('scripts')
<script>
	$(function () {
	  $('#lista').DataTable({
	    processing: true,
	    serverSide: true,
	    responsive: true,
	    ajax: '{!! route('id_types.index') !!}',
	    columns: [
			{data: 'name', name: 'name', title: 'Tipo', className: 'text-center text-capitalize'},
			{data: 'model', name: 'model', title: 'Modelo', className: 'text-center'},
			{name: 'created_at', title: 'Fecha', className: 'text-center', data: { '_': 'created_at.display', 'sort': 'created_at.timestamp' } },
			{data: 'action', name: 'acciones', orderable: false, searchable: false, className: 'text-center actions'}
		],
	    language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' }
	  });
	});
</script>
@endpush