@isset( $label )
<b>{{ ucfirst( $label ) }}</b>
@endisset
<input type="{{ $type ?? 'text' }}"  name="{{ $name ?? '' }}" value="{{ $value ?? '' }}" class="{{ $class ?? 'form-control' }}" @if(isset($placeholder) ) placeholder="{{ ucfirst( $placeholder ) }}" @elseif(isset( $label )) placeholder="{{ ucfirst( $label ) }}" @endisset @isset($attribute) @foreach ($attribute as $k => $v ) {{$k}}="{{$v}}" @endforeach @endisset>
@if( $error ?? true )
<span id="{{ str_replace(['[',']'], ['_', ''], ( $name ?? '' ) ) }}-error" style="display: none;" class="label label-danger ml-1 error"></span>
@endif