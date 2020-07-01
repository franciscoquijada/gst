@extends('layouts.app')
@section('title')
<h2>Roles</h2>
    @can('roles:crear')
        <a class="btn btn-info float-right" href="#" data-target="#new_role" data-toggle="modal">Añadir <i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('content')
	<div class="table-responsive">
		<table id="lista" class="table table-striped"></table>
	</div>

	@include('roles.partials.show')
	@include('roles.partials.create')
	@include('roles.partials.edit')

@endsection

@push('scripts')
<script type="text/javascript">

	function viewPermission(e){
	  e.preventDefault();
	  let id = $(this).data('item');

	  $.ajax({
	      type: 'GET', //metoodo
	      url: window.location + '/' + id, //id del delete
	      data: {
	          '_token': $('input[name=_token]').val(),
	      },
	      success: function ( data ) {
	          $('.viewer.modal').modal('show')
	          .find('[data-field]').each( function( i, e ){
	            let elem = $(e);
	            elem.text( eval('data.' + elem.data('field') ) || ' N/D ' );
	          });

	          let permissions = {};

	          $( data.permissions ).each( function( i, e ){
	          	let nm = e.name.split(':');

	          	if( typeof nm[2] == 'undefined' ){
	          		if( typeof permissions[ nm[0] ] == 'undefined' ){
		          		permissions[ nm[0] ] = '<li>' +  nm[1] + '</li>';
		          	} else {
		          		permissions[ nm[0] ] += '<li>' +  nm[1] + '</li>';
		          	}
	          	} else {
	          		if( typeof permissions[ nm[0] ] == 'undefined' ){
		          		permissions[ nm[0] ] = '<li>' +  nm[1] + ' - ' + nm[2] + '</li>';
		          	} else {
		          		permissions[ nm[0] ] += '<li>' +  nm[1] + ' - ' + nm[2] + '</li>';
		          	}
	          	}

	          	
	          });

	          let html = '';

	          $.each(permissions, function( i, e ){
	          	html += '<div class="col-md-6"><span><b>' + i;
	          	html += '</b></span><ul>' + e + '</ul></div>';
	          });

	          $('#permission').html( html );
	      }
	  });
	}

	function editPermission(e) {
	  e.preventDefault();
	  let id = $(this).data('item');

	  resetForm( $('.modal.edit form') );

	  $.ajax({
	    type: 'GET', //metoodo
	    url: window.location + '/' + id + '/edit',
	    data: {
	        '_token': $('input[name=_token]').val(),
	    },
	    success: function (data) {
	      $('.modal.edit')
	        .modal('show')
	        .find('[data-field]').each( function( i, e ){
	          let elem = $(e);
	          if(  elem.hasClass('form-control') ){
	            elem.val( eval('data.fields.' + elem.data('field') ) || '' );
	          }else{
	            elem.text( eval('data.fields.' + elem.data('field') ) || ' N/D ' );
	          }
	        }).parents('form').attr('action', data.route );

	        $(data.fields.permissions).each( function( i, e ){
	        	$('.modal.edit .form-check-input[value="' + e.id  + '"]').prop('checked', true);
	        });
	      }
	    });
	}

	$(function () {
		$('#lista')
			.off('click', '.btn_view',  window.viewInfo )
			.on( 'click',  '.btn_view', window.viewPermission )
			.off('click', '.btn_edit',  window.editItem )
			.on( 'click',  '.btn_edit', window.editPermission )
			.DataTable({
				processing: true,
				serverSide: true,
				responsive: true,
				ajax: '{!! route('roles.index') !!}',
				columns: [
					{data: 'name', name: 'name', title: 'Nombre', className: 'text-center text-capitalize'},
					{data: 'users_count', name: 'users', title: 'Usuarios', className: 'text-center'},
					{data: 'action', name: 'acciones', orderable: false, searchable: false, className: 'text-center actions'}
				],
				language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' }
			});
	});
</script>
@endpush

