<div class="modal fade create" tabindex="-1" role="dialog" aria-hidden="true" id="new_user">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      {!! Form::open(['id' => 'form_create', 'route' => 'api.users.store', 'method'=>'POST']) !!}
        <div class="modal-header text-center bg-primary">
          <h4 class="modal-title">Registro de usuarios</h4>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>          
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-6 col-12 form-group {{ $errors->has('group_id') ? 'has-error' : '' }}">
              <label class="form-group">Grupo</label>
              {{ Form::select('group_id', $groups->sort(), old('group_id'), ['class' => 'form-control select'] ) }}
              <span id="group_id-error" style="display: none;" class="label label-danger ml-1 error"></span>
            </div>
            <div class="col-md-6 col-12 form-group {{ $errors->has('rol_id') ? 'has-error' : '' }}">
              <label class="form-group">Rol</label>
              {{ Form::select('rol_id', $roles->sort(), old('rol_id'), ['class' => 'form-control select'] ) }}
              <span id="rol_id-error" style="display: none;" class="label label-danger ml-1 error"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-12 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
              <label class="form-group">Nombre</label>
              <input type="text" name="name" value="{{ old('name') }}" autocomplete="off" class="form-control alpha" id="name" placeholder="Nombre Completo">
              <span id="name-error" style="display: none;" class="label label-danger ml-1 error"></span>
            </div>
            <div class="col-md-6 col-12 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
              <label class="form-group">Email</label>
              <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email" autocomplete="off" placeholder="Correo Electrónico">
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
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <div class="col-12 text-center">
            <a class="btn btn-success send-form">
              Guardar <i class="far fa-save"></i>
            </a>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>  
</div>