<table id="lista" class="table table-striped">
    <thead>
      <tr>
        <th>Usuario</th>
        <th>Evento</th>
        <th>Descripcion</th>
        <th>IP</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody id="list-users">
      @foreach($logs as $log)
        <tr>
            <td>{{ $log->user->name ?? 'N/A'}}</td>
            <td>{{ $log->event }}</td>
            <td>{{ $log->description }}</td>
            <td>{{ $log->ip}}</td>
            <td>{{ $log->created_at }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  