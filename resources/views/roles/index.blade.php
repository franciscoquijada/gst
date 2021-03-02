@extends('layouts.app')
@section('title')
<h2>Roles</h2>
    @can('roles:crear')
    	<x-button.modal target="new_role" />
    @endcan
@endsection

@section('content')
	<x-datatable :route="route('api.roles.list')" :columns="$columns" />

	@include('roles.partials.show')
	@include('roles.partials.create')
	@include('roles.partials.edit')

@endsection

@push('scripts')
<script type="text/javascript">
	$(function () {
		$('#lista')
			.on( 'click', '.btn_view_permission', window.viewPermission )
			.on( 'click', '.btn_edit_permission', window.editPermission )
	});

	function viewPermission(e){
	  e.preventDefault();
	  let route = $(this).data('route');

	  $.ajax({
	      type: 'GET', //metoodo
	      url: route,
	      headers: {
	      	'Accept': 'application/json',
	      	'X-Requested-With': 'XMLHttpRequest',
	      	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
	          console.log( html )

	          $('#permission').html( html );
	      }
	  });
	}

	function editPermission(e) {
	  e.preventDefault();
	  let route = $(this).data('route');

	  resetForm( $('.modal.edit form') );

	  $.ajax({
	    type: 'GET', //metoodo
	    url: route,
	    headers: { 
	      'Accept': 'application/json',
	      'X-Requested-With': 'XMLHttpRequest',
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
</script>
@endpush

