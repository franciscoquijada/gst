@extends('layouts.app')

@section('title')
  <h2>Opciones</h2>
@endsection

@section('content')
	<div class="table-responsive">
	  @include('settings.table')
	</div>
	<style type="text/css">
	  #list-settings input:invalid {
	    border: 1px solid red !important;
	  }
	</style>
@endsection

@section('scripts')
<script type="text/javascript">
$(function(){
	$('#list-settings input').on('change', updateSetting);
	function updateSetting( e ){
	    e.preventDefault();
	    if( $(this).length > 0 ){
	    	let $this = $(this),
	    		id = $this.attr('id');

		    $.ajax({
		        type: 'POST', //metodo
		        url: window.location + '/' + id, //url
		        data: { 
		        	'value': $(this).val(),
		        	'_token': $('input[name=_token]').val() 
		        },
		        success: function (data) {

		            if ( data.status === 400 ) {
		            	$this.val('').addClass('invalid');
		            	$('#' + id + '-error')
		                        .removeAttr('style')
		                        .html( data.error.value[0] );

		                setTimeout( function () {
		                    $('#list-settings').find(".error").fadeOut(1500);
		                    $('#list-settings').find('.invalid').removeClass('invalid');
		                }, 4000);

		            } else {
		            	console.log('updated!');
		            }
		        }
		    });
	    }
	}
});
</script>

@endsection