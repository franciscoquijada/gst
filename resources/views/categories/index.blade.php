@extends('layouts.app')

@section('title')
  <h2>Grupos</h2>
  <x-button.link :href="route('categories.export')" class="btn-success float-right" label="Exportar" icon="far fa-file-excel"/>
	@can('grupos:crear')
		<x-button.modal target="new_group" />
	@endcan
@endsection

@section('content')

	<x-datatable :route="route('api.categories.list')" trash="true" :columns="$columns" />

	@include('categories.partials.create')
	@include('categories.partials.edit')

@endsection