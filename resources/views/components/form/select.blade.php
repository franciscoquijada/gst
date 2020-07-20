@isset( $label )
<label class="form-group">{{ ucfirst( $label ) }}</label>
@endisset
<select name="{{ $name ?? '' }}" autocomplete="off" class="form-control {{ $class ?? 'form-control select' }}" @isset($attribute) @foreach ($attribute as $k => $v ) {{$k}}="{{$v}}" @endforeach @endisset >
	@include('components.form.options')
</select>
@if( $error ?? true )
<span id="{{ str_replace(['[',']'], ['_', ''], ( $name ?? '' ) ) }}-error" style="display: none;" class="label label-danger ml-1 error"></span>
@endif