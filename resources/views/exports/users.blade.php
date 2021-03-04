<table>
        <tr>
                <th>Identificación</th>
                <th>Compañia</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Fecha de Registro</th>
                <th>Ultimo inicio de sesion</th>
                <th>Ultima actualizacion</th>
        </tr>
        @foreach ($users as $user)
        <tr>
                <td>@forelse( $user->identifications as $i => $el )
                        {{ $el->name }}: {{ $el->pivot->value }}
                @empty 
                        Usuario sin id externa registrada
                @endforelse</td>
                <td>{{ $user->group->name }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->last_login_at }}</td>
                <td>{{ $user->updated_at }}</td>
        </tr> 
        @endforeach
</table>