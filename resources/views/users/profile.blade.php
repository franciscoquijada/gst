@extends('layouts.app')

@section('title')
  	<h2>Perfil: {{ $user->name }}</h2>
@endsection

@section('content')
	<div class="mx-5">	
		{!! Form::open([ 'id' => 'form_create', 'route' => 'profile.update', 'method'=>'POST' ]) !!}
          <div class="row">
            <div class="col-md-6 col-12 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
              <label class="form-group">Nombre</label>
              <input type="text" name="name" value="{{ old('name') ?? $user->name }}" autocomplete="off" class="form-control alpha" id="name" placeholder="Nombre Completo">
              <span id="name-error" style="display: none;" class="label label-danger ml-1 error"></span>
            </div>
            <div class="col-md-6 col-12 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
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
              {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
              <span id="password_confirmation-error" style="display: none;" class="label label-danger ml-1 error"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-12 form-group" {{ $errors->has('phone') ? 'has-error' : '' }}>
              <label class="form-group">Teléfono</label>
              <input type="text" name="phone" value="{{ old('phone') ?? $user->phone }}" class="form-control numeric" id="phone"  placeholder="Teléfono" data-inputmask="'mask':['9 9999 9999','+(99) 9 9999 9999']">
              <span id="phone-error" style="display: none;" class="label label-danger ml-1 error"></span>     
            </div>
            <div class="col-md-6 col-12 form-group {{ $errors->has('rut') ? 'has-error' : '' }}">
              <label class="form-group">Rut</label>
              <input type="text" name="rut" value="{{ old('rut') ?? $user->rut }}" autocomplete="off" data-inputmask="'mask':['9.999.999-9|k','99.999.999-9|k']" class="form-control" id="rut" placeholder="RUT">
              <span id="rut-error" style="display: none;" class="label label-danger ml-1 error"></span>
            </div>
          </div>
		<div class="text-center my-4">
			<a href="#" class="btn btn-success send-form"> Guardar <i class="far fa-save"></i>
		    </a>
		</div>
		{!! Form::close() !!}
	</div>
@endsection