@extends('layouts.app')

@section('title')
  <h2>Tipos de identificadores externos</h2>
	@can('tipos identificadores:crear')
		<x-button.modal target="new_type" />
	@endcan
@endsection

@section('content')

	<x-datatable :route="route('api.id_types.list')" :columns="$columns" />

	@include('identifications_types.partials.create')
	@include('identifications_types.partials.edit')
  
@endsection