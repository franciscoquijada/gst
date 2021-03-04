@inject('types', 'App\IdentificationType')
	<label class="form-group">Identificadores externos</label>
@forelse( $types->where('model', $model ?? 'App\User')->pluck('name','id') as $i => $name )
	<div class="mt-1 w-100">
	  <input type="hidden" name="external[type][]" value="{{ $i }}" >
	    <input type="text" name="external[value][{{ $i }}]" class="form-control" data-field="externals['value'][{{ $loop->index }}]" placeholder="{{ $name }}" >
	    
	    <span id="external_value_{{ $i }}-error" style="display: none;" class="label label-danger ml-1 error"></span>
	</div>
@empty
	<div class="mt-1 w-100">
	    No hay identificadores externos registrados
	</div>
@endforelse