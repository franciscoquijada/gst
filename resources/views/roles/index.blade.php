@extends('layouts.app')
@section('title')
<h2>Roles</h2>
    @can('crear rol')
        <a class="btn btn-info float-right" href="#" data-target="#new_role" data-toggle="modal">Añadir <i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('content')
	<div class="table-responsive">
		@include('roles.partials.table')
	</div>

	@include('roles.partials.show')
	@include('roles.partials.create')
	@include('roles.partials.edit')

@endsection

@section('scripts')
<script type="text/javascript">
	$('.btn_view')
		.off('click', viewInfo )
		.on('click', viewPermission );

	$('.btn_edit')
		.off('click', editItem )
		.on('click', editPermission );

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

	          let permissions = new Array();

	          $( data.permissions ).each( function( i, e ){
	            permissions.push( '<li class="col-md-6">' + e.name + '</li>');
	          });

	          $('#permission').html( permissions.join('') );
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
</script>
@endsection

