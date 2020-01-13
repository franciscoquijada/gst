<div class="modal fade edit" tabindex="-1" role="dialog" aria-hidden="true" id="edit_user">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      {!! Form::open(['id' => 'form_edit', 'route' => 'departments.index','method'=>'PUT']) !!}
        @csrf
        <div class="modal-header text-center bg-primary">
          <h4 class="modal-title" id="myModalLabel">
            Actualizar departamento:  <span data-field="name"></span>
          </h4>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>          
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-12 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
              <label class="form-group">Nombre</label>
              <input type="text" name="name" value="" data-field="name" onkeypress="return soloLetras(event)" autocomplete="off" class="form-control" id="name" placeholder="Nombre">
              <span id="name-error" style="display: none;" class="label label-danger ml-2 mb-2"></span>
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