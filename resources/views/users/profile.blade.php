@extends('layouts.app')

@section('title')
  	<h2>Usuario: {{ $user->name }}</h2>
@endsection

@section('content')
	<div class="col-md-6 mx-auto">
  <div class="card border-0 mb-4">
    <div class="card-body px-5 pt-5">
		{!! Form::open([ 'id' => 'form_create', 'route' => 'profile.update', 'method'=>'POST' ]) !!}
      <div class="row">
        <div class="col-12 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
          <label class="form-group">Email</label>
          <input type="email" name="email" value="{{ old('email') ?? $user->email }}" class="form-control" id="email" autocomplete="off" placeholder="Correo Electrónico">
          <span id="email-error" style="display: none;" class="label label-danger ml-1 error"></span>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-12 form-group {{ $errors->has('password') ? 'has-error' : '' }}"> 
          <label class="form-group">Contraseña</label>
          {{ Form::password('password', ['class' => 'form-control']) }}
          <span id="password-error" style="display: none;" class="label label-danger ml-1 error"></span>
        </div>
        <div class="col-md-6 col-12 form-group {{ $errors->has('password') ? 'has-error' : '' }}"> 
          <label class="form-group">Confirmar Contraseña</label>
          {{Form::password('password_confirmation', ['class' => 'form-control']) }}
          <span id="password_confirmation-error" style="display: none;" class="label label-danger ml-1 error"></span>
        </div>
      </div>
    	<div class="text-center my-4">
    		<a href="#" class="btn btn-success send-form"> Guardar <i class="far fa-save"></i>
    	    </a>
    	</div>
		  {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection