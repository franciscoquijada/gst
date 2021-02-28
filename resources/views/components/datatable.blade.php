@props(['route', 'columns'])

<div class="table-responsive">	
	<table id="lista" class="table table-striped"></table>
</div>
@push('scripts')
	<script>
		$(function () {
			$('#lista').DataTable({
			    processing: true,
			    serverSide: true,
			    responsive: true,
			    ajax: {
			        url: "{!! $route !!}",
			        type: "GET",
			        headers: { 
				      'Accept': 'application/json',
				      'X-Requested-With': 'XMLHttpRequest',
				      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				    },
			    },
			    columns: @json( $columns ),
			    language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' }
			});
		});
	</script>
@endpush