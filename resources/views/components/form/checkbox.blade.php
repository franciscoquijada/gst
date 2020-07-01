@isset( $label )<label>@endisset
<input type="checkbox" name="{{ $name ?? '' }}" value="{{ $value ?? '' }}" class="{{ $class ?? '' }}" @isset($attribute) @foreach ($attribute as $k => $v ) {{$k}}="{{$v}}" @endforeach @endisset>
@isset( $label ) {{ ucfirst( $label ) }}</label>@endisset
@if( $error ?? true )
<span id="{{ str_replace(['[',']'], ['_', ''], ( $name ?? '' ) ) }}-error" style="display: none;" class="label label-danger ml-1 error"></span>
@endif