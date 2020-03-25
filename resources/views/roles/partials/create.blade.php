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
              <div class="row">
                <label class="col-md-12">Permisos del Sistema</label>
                @foreach($system as $title => $section)
                <div class="col-md-6 mt-3">
                  <label class="col-md-6"><b>{{ $title }}</b></label>
                  @foreach($section as $name => $id)
                  <div class="pl-4 w-100">
                    {!! Form::checkbox('permission[]', $id, false, ['class' => 'form-check-input']) !!}
                    {{ $name }}
                  </div>
                  @endforeach
                </div>
                @endforeach
                @if( is_array( $mod ) && count( $mod ) > 0 )
                  @foreach($mod as $title => $sub_mod)
                    <hr class="w-100"/>
                    <label class="col-md-12">Modulo: {{ $title }}</label>
                    @foreach($sub_mod as $title_sub => $section)
                      <div class="col-md-6">
                      <label class="col-md-6"><b>{{ $title_sub }}</b></label>
                      @foreach($section as $name => $id)
                        <div class="pl-4 w-100">
                          {!! Form::checkbox('permission[]', $id, false, ['class' => 'form-check-input']) !!}
                          {{ $name }}
                        </div>
                      @endforeach
                      </div>
                    @endforeach
                  @endforeach
                @endif
                <span id="permission-error" style="display: none;" class="label label-danger ml-1 error"></span>
              </div>
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