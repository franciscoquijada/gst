<ul>
@forelse( $identifications as $i => $el )
	<li>{{ $el->name }}: {{ $el->pivot->value }}</li>
@empty
	<li>Usuario sin id externa registrada</li>
@endforelse
</ul>