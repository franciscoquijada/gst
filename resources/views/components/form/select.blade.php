@props(['label', 'attribute', 'label', 'name', 'options' => [] ])

@isset( $label )
	<label class="form-group">{{ ucfirst( $label ) }}</label>
@endisset
<select name="{{ $name ?? '' }}" autocomplete="off" class="form-control {{ $class ?? 'select' }}" {{ $attributes->whereStartsWith('data') }} >
	<x-form.options :options="$options" />
</select>
@if( $error ?? true )
<span id="{{ str_replace(['[',']'], ['_', ''], ( $name ?? '' ) ) }}-error" style="display: none;" class="label label-danger ml-1 error"></span>
@endif