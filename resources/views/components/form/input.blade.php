@isset( $label )
<label class="form-group">{{ ucfirst( $label ) }}</label>
@endisset
<input type="{{ $type ?? 'text' }}"  name="{{ $name ?? '' }}" value="{{ $value ?? '' }}" class="form-control {{ $class ?? 'form-control' }}" @if(isset($placeholder) ) placeholder="{{ ucfirst( $placeholder ) }}" @elseif(isset( $label )) placeholder="{{ ucfirst( $label ) }}" @endisset @isset($attr) @foreach ($attr as $k => $v ) {{$k}}="{{$v}}" @endforeach @endisset autocomplete="off">
@if( $error ?? true )
<span id="{{ str_replace(['[',']'], ['_', ''], ( $name ?? '' ) ) }}-error" style="display: none;" class="label label-danger ml-1 error"></span>
@endif