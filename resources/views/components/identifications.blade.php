@props(['model'])
@inject('types', 'App\IdentificationType')

<div class="row">
    <div class="col-12 form-group">
    	<label class="form-group d-block mb-1 mt-2">Identificadores externos<hr class="m-0"></label>
    	<div class="row">
    		@forelse( $types->where('model', $model ?? 'App\User')->get() AS $type )
				<div class="col-md-{{ ( 12 / $loop->count ) > 3 ? ( 12 / $loop->count ) : 4 }}">
				    <x-form.input type="text" name="external[{{ $type->id }}]" class="form-control mb-2 {{ $type->input_classes }}" attr="{!! $type->input_params !!}" data-field="externals[{{ $type->id }}].value" label="{{ $type->name }}"  />
				</div>

			@empty
				<div class="mt-1 w-100">
				    No hay identificadores externos registrados
				</div>

			@endforelse
    		
    	</div>
    </div>
</div>



	

