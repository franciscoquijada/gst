@extends('layouts.app')

@section('title')
  <h2>Registro de eventos</h2>
@endsection

@section('content')
<div class="table-responsive">
	@include('logs.partials.table')

</div>
@endsection
