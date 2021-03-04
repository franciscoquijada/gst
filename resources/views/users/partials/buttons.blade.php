@if( $deleted_at == null )
	@can('usuarios:ver')
		<x-button.action class="btn-info btn_view" :route="route('api.users.show', $id)" title="Detalles" icon="fa fa-eye" />
	@endcan

	@can('usuarios:actualizar')
		<x-button.action class="btn-warning btn_edit" :route="route('api.users.edit', $id)" title="Editar" icon="fa fa-edit" />
	@endcan

	@if( $id != 1 ) 
		@can('usuarios:eliminar')
			<x-button.action class="btn-danger btn_del" :route="route('api.users.destroy', $id)"  title="Eliminar" icon="fa fa-trash" />
		@endcan
	@endif
@endif