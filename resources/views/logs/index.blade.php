@extends('layouts.app')

@section('title')
  <h2>Registro de eventos</h2>
@endsection

@section('content')
<div class="table-responsive">
	<table id="lista" class="table table-striped"></table>
</div>
@endsection

@section('scripts')
  <script>
    $(function () {
      $('#lista').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('logs.index') !!}',
        columns: [
            {data: 'user_name', name: 'user_name', title: 'Usuario', className: 'text-center text-capitalize'},
            {data: 'event', name: 'event', title: 'Evento', className: 'text-center'},
            {data: 'description', name: 'description', title: 'Descripción', className: 'text-center'},
            {data: 'ip', name: 'ip', title: 'IP', className: 'text-center'},
            {data: 'created_at', name: 'created_at', title: 'Fecha', className: 'text-center'},
          ],
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' }
      });
    });
  </script>
@endsection