@extends('layouts.app')

@section('title')
  <h2>Opciones</h2>
@endsection

@section('content')
<div class="table-responsive">
	<table id="lista" class="table table-striped">
		<thead>
			<tr>
				<th>Opcion</th>
				<th>Valor</th>
			</tr>
		</thead>
		<tbody id="list-settings">
			@csrf
			@foreach( $settings as $setting )
			<tr>
				<td>{{ ucfirst( strtolower($setting->name) ) }}</td>
				<td>
					<input type="{{ $setting->field['type'] }}" id="{{ $setting->id }}" name="value" value="{{ $setting->value }}" class="{{ $setting->field['type'] }} form-control" required>
					<span id="{{ $setting->id }}-error" style="display: none;" class="label label-danger ml-1 error"></span>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection

@push('styles')
<style>
	#list-settings input:invalid {
		border: 1px solid red !important;
	}
</style>
@endpush

@push('scripts')
<script type="text/javascript">
$(function(){
	$('#list-settings').on('change', 'input', function(e){
	    e.preventDefault();
	    
	    if( $(this).length > 0 ){
	    	let $this = $(this),
	    		id = $this.attr('id'),
	    		speed = 5000;

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
		            	Swal.mixin({
							toast: true,
							position: 'top-end',
							showConfirmButton: false,
							timer: speed,
							timerProgressBar: true,
							onOpen: (toast) => {
								toast.addEventListener('mouseenter', Swal.stopTimer)
								toast.addEventListener('mouseleave', Swal.resumeTimer)
							}
						}).fire({
							"title":"Configuracion actualizada",
							"icon":"success"
						});

		            	console.log('updated!');
		            }
		        }
		    });
	    }
	});
});
</script>

@endpush