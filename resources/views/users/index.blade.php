@extends('layouts.app')

@section('title')
	<h2>Usuarios</h2>
	<x-button.link :href="route('users.export')" class="btn-success float-right" label="Exportar" icon="far fa-file-excel"/>

	@can('usuarios:crear')
		<x-button.modal target="new_user" />
	@endcan
@endsection

@section('content')

	<x-datatable :route="route('api.users.list')" trash="true" :columns="$columns" />

	@include('users.partials.show')
	@include('users.partials.create')
	@include('users.partials.edit')

@endsection

@push('scripts')
<script>
	$(function () {

		$('.get-token').on('click', function(e){
			e.preventDefault();
			let $this = $(this);
			$this.find('i').addClass('fa-spin');

			$.ajax({
				type: 'POST',
				url: '{{ route('ajax.generate_token') }}',
				headers: { 
			      'X-Requested-With': 'XMLHttpRequest',
			      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
				data: {
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