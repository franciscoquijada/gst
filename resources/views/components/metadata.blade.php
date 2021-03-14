@props(['model'])

@inject('metadata', 'App\Meta')

	<label class="form-group">Metadata<hr class="m-0" /></label>

@forelse( $metadata->where('model', $model ?? 'App\User')->pluck('name','key') AS $key => $name )
	<p><b class="text-capitalize">{{ $name }}:</b> <span data-field="{{ $key }}"></span></p>

@empty
	<div class="mt-1 w-100">
	    No hay metadatos registrados para este tipo de registros
	</div>

@endforelse