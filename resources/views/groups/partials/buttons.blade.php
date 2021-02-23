@can('grupos:actualizar')
	@button([
		'class' => 'btn-warning btn_edit',
		'title' => 'Editar',
        'route'	=> route( 'groups.edit', $id ),
		'icon'	=> 'fa fa-edit'
	])
@endcan
@if( $id != 1 )
  @can('grupos:eliminar')
  	@button([
		'class' => 'btn-danger btn_del',
		'title' => 'Eliminar',
		'route'	=> route( 'groups.destroy', $id ),
		'icon'	=> 'fa fa-trash'
	])
  @endcan
@endif
