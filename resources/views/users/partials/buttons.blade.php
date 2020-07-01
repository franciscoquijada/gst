@can('usuarios:ver')
	@buttonAction(['class' => 'btn-info btn_view', 'item' => $id, 'title' => 'Detalles', 'icon' => 'fa fa-eye'])
@endcan

@can('usuarios:actualizar')
	@buttonAction(['class' => 'btn-warning btn_edit', 'item' => $id, 'title' => 'Editar', 'icon' => 'fa fa-edit'])
@endcan

@if( $id != 1 ) 
	@can('usuarios:eliminar')
		@buttonAction(['class' => 'btn-danger btn_del', 'route' => route( 'users.destroy', $id ), 'title' => 'Eliminar', 'icon' => 'fa fa-trash'])
	@endcan
@endif