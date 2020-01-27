<table id="lista" class="table table-striped">
  <thead>
    <tr>
      <th>Departamento</th>
      <th>Usuarios</th>
      <th class="text-center">Acciones</th>
    </tr>
  </thead>
  <tbody id="list-centers">
    @foreach( $departments as $d )
    <tr>
      <td>{{ $d->name }}</td>
      <td>{{ $d->users()->count() }}</td>
      <td class="text-center">
        @can('departamentos:actualizar')
          <button class="btn btn-warning btn_edit" title="Editar" data-item="{{ $d->id }}"><i class="fa fa-edit"></i></button>
        @endcan
        @if( $d->id != 1 ) 
          @can('departamentos:eliminar')
            <button class="btn btn-danger btn_del" title="Eliminar" data-route="{{ route( 'departments.destroy', $d->id )}}"><i class="fa fa-trash"></i></button>
          @endcan
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>