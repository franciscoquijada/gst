@props(['href' => '#', 'label', 'icon', 'class'])
<a class="btn {{ $class ?? '' }}" href="{{ $href }}">{{ $label ?? '' }} @isset($icon)<i class="{{ $icon }}"></i>@endisset</a>