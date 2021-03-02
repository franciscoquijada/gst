@can('tipos identificadores:actualizar')
	<x-button.action class="btn-warning btn_edit" :route="route('api.id_types.edit', $id)" title="Editar" icon="fa fa-edit" />
@endcan

@if( $id != 1 ) 
	@can('tipos identificadores:eliminar')
		<x-button.action class="btn-danger btn_del" :route="route('api.id_types.destroy', $id)"  title="Eliminar" icon="fa fa-trash" />
	@endcan
@endif