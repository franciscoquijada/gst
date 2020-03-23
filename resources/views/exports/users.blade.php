<table>
        <tr>
        <th>Rut</th>
        <th>Nombre</th>
        <th>Telefono</th>
        <th>Email</th>
        <th>Departamento</th>
        <th>Fecha de Registro</th>
        <th>Ultimo inicio de sesion</th>
        </tr>
        @foreach ($users as $user)
        <tr>
        <td>{{ $user->rut }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->phone }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->department->name }}</td>
        <td>{{ $user->created_at }}</td>
        <td>{{ $user->last_login_at }}</td>
        </tr> 
        @endforeach
</table>