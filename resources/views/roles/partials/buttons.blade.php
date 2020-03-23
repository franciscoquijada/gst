@can('roles:ver')
    <button class="btn btn-info btn_view" title="Detalles" data-item="{{ $id }}" ><i class="fa fa-eye"></i></button>
@endcan
@if( $id != 1 ) 
    @can('roles:actualizar')
        <button class="btn btn-warning btn_edit" title="Editar" data-item="{{ $id }}"><i class="fa fa-edit"></i></button>
    @endcan
@endif
@if( $id != 1 ) 
    @can('roles:eliminar')
      <button class="btn btn-danger btn_del" title="Eliminar" data-route="{{ route( 'roles.destroy', $id )}}"><i class="fa fa-trash"></i></button>
    @endcan
@endif