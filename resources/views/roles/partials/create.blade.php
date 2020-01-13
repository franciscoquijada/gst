<div class="modal fade bs-example-modal-md create" tabindex="-1" role="dialog" aria-hidden="true" id="new_role">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      {!! Form::open(['route' => 'roles.store','method'=>'POST']) !!}
        <div class="modal-header text-center bg-primary">
          <h4 class="modal-title">Registro de roles</h4>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>          
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 form-group {{ $errors->has('departament_id') ? 'has-error' : '' }}">
              <label class="form-group">Nombre</label>
              {!! Form::text('name', '', ['placeholder' => 'Nombre', 'class' => 'form-control'])
            !!}
              <span id="name-error" style="display: none;" class="label label-danger ml-1 error"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-12 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
              <label class="col-md-6">Permisos</label>
              @foreach($permissions as $p)
              <label class="col-md-6">
                  {!! Form::checkbox('permission[]', $p->id, false, ['class' => 'form-check-input']) !!}
                  {{ $p->name }}
              </label>
              @endforeach
              <span id="permission-error" style="display: none;" class="label label-danger ml-1 error"></span>
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