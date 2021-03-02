@extends('layouts.app')

@section('title')
  	<h2>Usuario: {{ $user->name }}</h2>
@endsection

@section('content')
	<div class="col-md-8 mx-auto">
    {!! Form::open([ 'id' => 'form_create', 'route' => 'profile.update', 'method'=>'POST' ]) !!}
      <div class="card border-0 mb-4">
        <div class="card-body px-5 pt-5">
          <div class="row">
            <div class="col-md-6 col-12 form-group">
              <x-form.input label="Nombre Completo" :value="old('name') ?? $user->name" name="name" class="alpha" data-field="name" />
            </div>
            <div class="col-md-6 col-12 form-group">
              <x-form.input type="email" label="Correo Electrónico" :value="old('email') ?? $user->email" name="email" data-field="email" />
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-12 form-group"> 
              <x-form.input type="password" label="Contraseña" name="password" />
            </div>
            <div class="col-md-6 col-12 form-group"> 
              <x-form.input type="password" label="Confirmar Contraseña" name="password_confirmation" />
            </div>
          </div>
        </div>
        <div class="card-footer bg-white text-right">
          <x-button.link class="btn-success send-form" label="Guardar" icon="far fa-save" />
        </div>
      </div>
  {!! Form::close() !!}
</div>
@endsection