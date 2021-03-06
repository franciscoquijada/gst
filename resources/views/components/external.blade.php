@props(['model'])

@inject('types', 'App\IdentificationType')

	<label class="form-group">Identificadores externos</label>

@forelse( $types->where('model', $model ?? 'App\User')->pluck('name','id') AS $i => $name )
	<div class="w-100">
		<x-form.input type="hidden" name="external[type][]" value="{{ $i }}" />
	    <x-form.input type="text" name="external[value][{{ $i }}]" class="form-control" data-field="externals['value'][{{ $loop->index }}]" placeholder="{{ $name }}" />
	</div>

@empty
	<div class="mt-1 w-100">
	    No hay identificadores externos registrados
	</div>

@endforelse