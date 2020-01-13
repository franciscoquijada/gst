<table id="lista" class="table table-striped">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Rol</th>
      <th>Email</th>
      <th>Departamento</th>
      <th class="text-center">Acciones</th>
    </tr>
  </thead>
  <tbody id="list-users">
    @foreach($users as $user)
      <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->getRoleNames()[0] }}</td>
        <td>{{ $user->email }}</td>
        </td>
        <td>{{ $user->department->name }}</td>
        <td class="text-center">
          @can('ver usuario')
            <button class="btn btn-info btn_view" title="Detalles" data-item="{{ $user->id }}" ><i class="fa fa-eye"></i></button>
          @endcan
          @can('actualizar usuario')
            <button class="btn btn-warning btn_edit" title="Editar" data-item="{{ $user->id }}"><i class="fa fa-edit"></i></button>
          @endcan
          @if( $user->id != 1 ) 
            @can('eliminar usuario')
              <button class="btn btn-danger btn_del" title="Eliminar" data-route="{{ route( 'users.destroy', $user->id )}}"><i class="fa fa-trash"></i></button>
            @endcan
          @endif
        </td>
      </tr>
  @endforeach
  </tbody>
</table>
