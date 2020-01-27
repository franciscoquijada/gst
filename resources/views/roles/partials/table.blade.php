<table id="lista" class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Usuarios</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody id="list-users">
        @foreach($roles as $rol)
        <tr>
            <td>{{ $rol->name }}</td>
            <td>{{ $rol->users()->count() }}</td>
            <td class="text-center">
                @can('roles:ver')
                    <button class="btn btn-info btn_view" title="Detalles" data-item="{{ $rol->id }}" ><i class="fa fa-eye"></i></button>
                @endcan
                @if( $rol->id != 1 ) 
                    @can('roles:actualizar')
                        <button class="btn btn-warning btn_edit" title="Editar" data-item="{{ $rol->id }}"><i class="fa fa-edit"></i></button>
                    @endcan
                @endif
                @if( $rol->id != 1 ) 
                    @can('roles:eliminar')
                      <button class="btn btn-danger btn_del" title="Eliminar" data-route="{{ route( 'roles.destroy', $rol->id )}}"><i class="fa fa-trash"></i></button>
                    @endcan
                @endif
            </td>

        </tr>
        @endforeach
    </tbody>
</table>