@extends('layouts.app')

@section('title')
  <h2>Registro de eventos</h2>
@endsection

@section('content')
<div class="table-responsive">
	@include('logs.partials.table')
</div>
@endsection
@section('scripts')
  <script>
    $(function () {
      $('#lista').DataTable({
        // "order": [[ 1, "asc" ]],
        processing: true,
        serverSide: true,
        ajax: '{!! route('users.indexData') !!}',
        columns: [
            {data: 'id', name: 'id', title: '#', className: 'text-center'},
            {data: 'name', name: 'name', title: 'Nombre', className: 'text-center'},
            {data: 'email', name: 'email', title: 'Email', className: 'text-center'},
            {data: 'roles[].name', name: 'roles[].name', title: 'Rol', className: 'text-center'},
            {data: 'action', name: 'acciones', orderable: false, searchable: false, className: 'text-center'}

          ],
        "language": {
          "url": "{{ asset('idioma.json') }}"
        }
      });
    });
  </script>
  <script src="{{ asset('js/appjs/users.js') }}"></script>
@endsection