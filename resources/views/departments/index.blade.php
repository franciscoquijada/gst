@extends('layouts.app')

@section('title')
  <h2>Departamentos</h2>
	<a class="btn btn-success float-right" href="{{ route('department.export')}}">Exportar <i class="far fa-file-excel"></i></a>
	@can('crear departamento')
	<a class="btn btn-info float-right" href="#" data-target="#new_user" data-toggle="modal">Añadir <i class="fa fa-plus"></i></a>
	@endcan
@endsection

@section('content')

	<div class="table-responsive">
	  @include('departments.partials.table')
	</div>

	@include('departments.partials.create')
	@include('departments.partials.edit')
  
@endsection