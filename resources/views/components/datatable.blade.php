@props(['route', 'trash', 'columns'])

<ul class="nav nav-tabs table-tabs" id="table-tabs-{{ \Str::random(5) }}" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">Activos <span id="table_all_count"></span></a>
  </li>

  @isset( $trash )
	  <li class="nav-item" role="presentation">
	    <a class="nav-link" id="trash-tab" data-toggle="tab" href="#trash" role="tab" aria-controls="trash" aria-selected="false">Eliminados <span id="table_trash_count"></span></a>
	  </li>
  @endisset

</ul>
<div class="tab-content" id="myTabContent">
	<div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
  		<div class="table-responsive">	
			<table id="table_all" class="table table-striped"></table>
		</div>
	</div>
	@isset( $trash )
	  	<div class="tab-pane fade" id="trash" role="tabpanel" aria-labelledby="trash-tab">
	  		<div class="table-responsive">	
				<table id="table_trash" class="table table-striped"></table>
			</div>
	  	</div>
  	@endisset
</div>

@push('scripts')
	<script>
		$(function () {
			
			$('#table_all').DataTable({
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
			    language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' },
			    fnDrawCallback: function () {
					$('#table_all_count')
						.text( '(' + this.fnSettings().fnRecordsTotal() + ')' );
				}
			});

			@isset( $trash )
			$('#trash-tab').on('show.bs.tab', function (event) {

				if(! $.fn.dataTable.isDataTable("#table_trash") ){
					$('#table_trash').DataTable({
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
						    data: (d) => {
				                d.trashed = true;
				            }
					    },
					    columns: @json( $columns ),
					    language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' },
					    fnDrawCallback: function () {
							$('#table_trash_count')
								.text( '(' + this.fnSettings().fnRecordsTotal() + ')' );
						}
					});
				}

			});
			  	
		  	@endisset
		});
	</script>
@endpush