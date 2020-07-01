<div class="modal fade edit" tabindex="-1" role="dialog" aria-hidden="true" id="edit_user">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      {!! Form::open(['id' => 'form_edit', 'route' => 'id_types.index','method'=>'PUT']) !!}
        @csrf
        <div class="modal-header text-center bg-primary">
          <h4 class="modal-title" id="myModalLabel">
            Actualizar tipo de identificacion:  <span data-field="name"></span>
          </h4>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>          
          </button>
        </div>
        <div class="modal-body">

          <div class="row">
            <div class="col-md-6 col-12 form-group">
              <label class="form-group">Nombre</label>
              <input type="text" name="name" value="" data-field="name" autocomplete="off" class="form-control alpha" id="name" placeholder="Nombre">
              <span id="name-error" style="display: none;" class="label label-danger ml-2 mb-2"></span>
            </div>
            <div class="col-md-6 col-12 form-group">
              <label class="form-group">Modelo</label>
              {{ Form::select('model', $models->sort(), old('model'), ['class' => 'form-control select', 'data-field' => 'model'] ) }}
              <span id="model-error" style="display: none;" class="label label-danger ml-1 error"></span>
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