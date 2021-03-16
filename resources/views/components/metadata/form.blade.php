@props(['model'])
@inject('metadata', 'App\Meta')

<div class="row">
    <div class="col-12 form-group">
    	<label class="form-group d-block mb-1 mt-2">Información Adicional<hr class="m-0"></label>
    	<div class="row">
    		@forelse( $metadata->where('model', $model ?? '')->get() AS $meta )
				<div class="col-md-{{ $loop->count > 1 && $loop->count < 5 ? ( 12 / $loop->count ) : 6 }}">
				    <x-form.input 
				    	type="text" 
				    	name="metadata[{{ $meta->key }}]" 
				    	class="form-control mb-2 {{ $meta->input_classes }}" 
				    	attr="{!! $meta->input_params !!}" 
				    	data-field="metadata.{{ $meta->key }}" 
				    	label="{{ $meta->name }}"
				    />
				</div>

			@empty
				<div class="mt-1 w-100">
				    No hay campos adicionales registrados
				</div>

			@endforelse
    		
    	</div>
    </div>
</div>