@extends('layouts.app')

@section('title')
  <h2>Registro de eventos</h2>
@endsection

@section('content')
<div class="table-responsive">
	<table id="lista" class="table table-striped"></table>
</div>
@endsection

@push('scripts')
  <script>
    $(function () {
      $('#lista').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        sort:[[4,'DESC']],
        ajax: '{!! route('logs.index') !!}',
        columns: [
            {data: 'event', name: 'event', title: 'Evento', className: 'text-center'},
            {name: 'loggable_id', title: 'Usuario', className: 'text-center text-capitalize', data: { '_': 'loggable.name', 'sort': 'loggable.name' }},
            {data: 'description', name: 'description', title: 'Descripción', className: 'text-center'},
            {data: 'ip', name: 'ip', title: 'IP', className: 'text-center'},
            {name: 'created_at', title: 'Fecha', className: 'text-center', data: { '_': 'created_at.display', 'sort': 'created_at.timestamp' } },
          ],
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json' }
      });
    });
  </script>
@endpush