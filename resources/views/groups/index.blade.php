@extends('layouts.app')

@section('title')
  <h2>Grupos</h2>
  <x-button.link :href="route('groups.export')" class="btn-success float-right" label="Exportar" icon="far fa-file-excel"/>
	@can('grupos:crear')
		<x-button.modal target="new_group" />
	@endcan
@endsection

@section('content')

	<x-datatable :route="route('api.groups.list')" :columns="$columns" />

	@include('groups.partials.create')
	@include('groups.partials.edit')

@endsection