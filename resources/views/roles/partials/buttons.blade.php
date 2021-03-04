@can('roles:ver')
	<x-button.action class="btn-info btn_view_permission" :route="route('api.roles.show', $id)" title="Detalles" icon="fa fa-eye" />
@endcan

@if( $id != 1 ) 
	@can('roles:actualizar')
		<x-button.action class="btn-warning btn_edit_permission" :route="route('api.roles.edit', $id)" title="Editar" icon="fa fa-edit" />
	@endcan
@endif

@if( $id != 1 ) 
	@can('roles:eliminar')
		<x-button.action class="btn-danger btn_del" :route="route('api.roles.destroy', $id)"  title="Eliminar" icon="fa fa-trash" />
	@endcan
@endif