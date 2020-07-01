@extends('layouts.app')

@section('title')
	<h2>Usuarios</h2>
	@link([ 'src' => route('users.export'), 'class' => 'btn-success float-right', 'label' => 'Exportar', 'icon' => 'far fa-file-excel' ])

	@can('usuarios:crear')
		@linkModal([ 'target' => 'new_user' ])
	@endcan
@endsection

@section('content')

	@datatable

	@include('users.partials.show')
	@include('users.partials.create')
	@include('users.partials.edit')

@endsection

@push('scripts')
<script>
	$(function () {
		$('#lista').DataTable({
		    processing: true,
		    serverSide: true,
		    responsive: true,
		    ajax: '{!! route('users.index') !!}',
		    columns: [
				{data: 'name', name: 'name', title: 'Nombre', className: 'text-center text-capitalize'},
				{data: 'role_name', name: 'role_name', title: 'Permisos', className: 'text-center'},
				{data: 'email', name: 'email', title: 'Email', className: 'text-center'},
				{name: 'last_login_at.timestamp', title: 'Ult. Ingreso', className: 'text-center', data: { '_': 'last_login_at.display', 'sort': 'last_login_at.timestamp' } },
				{data: 'action', name: 'acciones', orderable: false, searchable: false, className: 'text-center actions'}
			],
		    language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' }
		});

		$('.get-token').on('click', function(e){
			e.preventDefault();
			let $this = $(this);
			$this.find('i').addClass('fa-spin');

			$.ajax({
				type: 'POST',
				url: '{{ route('ajax.generate_token') }}',
				data: {
					'_token':  $('input[name=_token]').val(),
					'user_id': $('span.user_id').text(),
				},
				success: function (data) {
					$('span[data-field=api_token]').text( data.token || 'error');
					$this.find('i').removeClass('fa-spin');
				},
				error: function (xhr, ajaxOptions, thrownError) {
					if( xhr.status == 422 ){
						console.log( xhr );
					}
					$this.find('i').removeClass('fa-spin');
				}
			});
	  	});
	});
</script>
@endpush