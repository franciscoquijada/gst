@props([ 'label', 'name', 'value', 'class', 'attributes' ])

@isset( $label )
	<label>
@endisset

<input 
	type="checkbox" 
	name="{{ $name ?? '' }}" 
	value="{{ $value ?? '' }}" 
	class="{{ $class ?? 'form-check-input' }}"
	
	{{ $attributes->whereStartsWith('data') }} 
/>

@isset( $label )
	{{ ucfirst( $label ) }}</label>
@endisset

@if( $error ?? true )
	<span id="{{ str_replace(['[',']'], ['_', ''], ( $name ?? '' ) ) }}-error" style="display: none;" class="label label-danger ml-1 error"></span>
@endif