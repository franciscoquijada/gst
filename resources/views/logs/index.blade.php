@extends('layouts.app')

@section('title')
  <h2>Registro de eventos</h2>
@endsection

@section('content')
  <x-datatable :route="route('api.logs.list')" :columns="$columns" />
@endsection