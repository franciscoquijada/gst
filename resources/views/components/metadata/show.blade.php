@props(['model'])

@inject('metadata', 'App\Meta')

	<label class="form-group d-block mt-0 mb-2">Información Adicional<hr class="m-0" /></label>

@forelse( $metadata->where('model', $model ?? 'App\User')->get() AS $key => $meta )
	<p>
		<b class="text-capitalize">
			{{ $meta->name }}:
		</b> 
		<span 
			@isset( $meta->attr['show_params'] )

				@foreach( $meta->attr['show_params'] as $k => $v )

					{{ $k }}="{{ $v }}"
				@endforeach
			@endisset

			data-field="metadata.{{ $meta->key }}">
		</span>
	</p>

@empty
	<div class="mt-1 w-100">
	    No hay metadatos registrados para este tipo de registros
	</div>

@endforelse