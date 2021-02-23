@isset( $label )
<label class="form-group">{{ ucfirst( $label ) }}</label>
@endisset
<div class="upload">
  <input type="button" class="btn btn-success upload-btn" value="Cargar" />
  <input type="file" id="{{ $name ?? '' }}" name="{{ $name ?? '' }}" accept="{{ $accept ?? 'application/pdf,application/vnd.ms-excel' }}" />
  <span class="file-name"> Seleccione un archivo.. </span>
</div>
<div class="float-right">{!! $value ?? '' !!}</div>
@if( $error ?? true )
<span id="{{ str_replace(['[',']'], ['_', ''], ( $name ?? '' ) ) }}-error" style="display: none;" class="label label-danger ml-1 error"></span>
@endif