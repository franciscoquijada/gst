<div class="modal fade edit" tabindex="-1" role="dialog" aria-hidden="true" id="edit_user">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      {!! Form::open(['id' => 'form_edit', 'route' => 'users.index','method'=>'PUT']) !!}
        <div class="modal-header text-center bg-primary">
          <h4 class="modal-title" id="myModalLabel">
            Actualizar usuario:  <span data-field="name"></span>
          </h4>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>          
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 col-12 form-group">
              <label class="form-group">Grupo</label>
              {{ Form::select('group_id', $groups->sort(), old('group_id'), ['class' => 'form-control select', 'data-field' => 'group_id'] ) }}
              <span id="group_id-error" style="display: none;" class="label label-danger ml-1 error"></span>
            </div>

            <div class="col-md-6 col-12 form-group {{ $errors->has('rol_id') ? 'has-error' : '' }}">
              <label class="form-group">Rol</label>
              {{ Form::select('rol_id', $roles->sort(), old('rol_id'), ['class' => 'form-control select', 'data-field' => 'roles[0]["id"]'] ) }}
              <span id="rol_id-error" style="display: none;" class="label label-danger ml-1 error"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-12 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
              <label class="form-group">Nombre</label>
              <input type="text" name="name" value="" data-field="name" autocomplete="off" class="form-control alpha" id="name" placeholder="Nombre Completo">
              <span id="name-error" style="display: none;" class="label label-danger ml-1 error"></span>
            </div>

            <div class="col-md-6 col-12 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
              <label class="form-group">Email</label>
              <input type="email" name="email" value="" data-field="email" class="form-control" id="email" autocomplete="off" placeholder="Correo Electrónico">
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
          <div class="col-md-12 col-sm-12 col-xs-12 text-center">
            <a class="btn btn-success send-form">
              Guardar <i class="far fa-save"></i>
            </a>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>  
</div>