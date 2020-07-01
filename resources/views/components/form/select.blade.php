@isset( $label )
<b>{{ ucfirst( $label ) }}</b>
@endisset
<select name="{{ $name ?? '' }}" autocomplete="off" class="{{ $class ?? 'form-control select' }}" @isset($attribute) @foreach ($attribute as $k => $v ) {{$k}}="{{$v}}" @endforeach @endisset >
	@include('components.options')
</select>
@if( $error ?? true )
<span id="{{ str_replace(['[',']'], ['_', ''], ( $name ?? '' ) ) }}-error" style="display: none;" class="label label-danger ml-1 error"></span>
@endif