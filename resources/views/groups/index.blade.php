@extends('layouts.app')

@section('title')
  <h2>Grupos</h2>
  	@link([
  		'class' => 'btn-success float-right',
  		'href' 	=> route('groups.export'),
  		'label' => 'Exportar',
  		'icon' 	=> 'far fa-file-excel'
  	])
	@can('grupos:crear')
		@linkModal([
			'target' => 'new_group'
		])
	@endcan
@endsection

@section('content')

	@datatable()

	@include('groups.partials.create')
	@include('groups.partials.edit')

@endsection

@push('scripts')
<script>
	$(function () {
	  $('#lista').DataTable({
	    processing: true,
	    serverSide: true,
	    responsive: true,
	    ajax: '{!! route('groups.index') !!}',
	    columns: [
			{data: 'name', name: 'name', title: 'Grupo', className: 'text-center text-capitalize'},
			{data: 'users_count', name: 'users_count', title: 'Usuarios', className: 'text-center'},
			{name: 'created_at', title: 'Fecha', className: 'text-center', data: { '_': 'created_at.display', 'sort': 'created_at.timestamp' } },
			{data: 'action', name: 'acciones', orderable: false, searchable: false, className: 'text-center actions'}
		],
	    language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' }
	  });
	});
</script>
@endpush
