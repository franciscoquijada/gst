@if( $default_option ?? true )
	<option value="" @if( !isset( $default ) ) selected="selected" @endif>{{ $placeholder ?? '- Seleccione -' }}</option>
@endif
@if(!empty($options))
	@foreach($options as $key => $value)
    	<option value="{{ $key }}" @if( ($default ?? '') == $key ) selected="selected" @endif>{{ $value }}</option>
  @endforeach
@endif