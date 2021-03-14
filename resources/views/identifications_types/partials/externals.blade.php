<ul>
	@forelse( $identifications as $i => $el )
		<li>{{ strtoupper( $el->type->name ) }}: {{ $el->value }}</li>
	@empty
		<li>Usuario sin id externa registrada</li>
	@endforelse
</ul>