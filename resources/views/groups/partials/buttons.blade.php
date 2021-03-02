@can('grupos:actualizar')
	<x-button.action class="btn-warning btn_edit" :route="route('api.groups.edit', $id)" title="Editar" icon="fa fa-edit" />
@endcan

@if( $id != 1 ) 
	@can('grupos:eliminar')
		<x-button.action class="btn-danger btn_del" :route="route('api.groups.destroy', $id)"  title="Eliminar" icon="fa fa-trash" />
	@endcan
@endif