@card([ 'id' => 'new_group', 'route' => 'groups.store', 'title' => 'Registro de grupo' ])
  <div class="row">
    <div class="col-md-12 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
      <label class="form-group">Nombre</label>
      <input type="text" name="name" value="" data-field="name" autocomplete="off" class="form-control alpha" id="name" placeholder="Nombre">
      <span id="name-error" style="display: none;" class="label label-danger ml-2 mb-2"></span>
    </div>
  </div>

  @slot('footer')
    <a class="btn btn-success send-form">
      Guardar <i class="far fa-save"></i>
    </a>
  @endslot
@endcard