@card([ 'id' => 'edit_group', 'route' => 'groups.index', 'edit' => true ])
  @slot('title')
    Actualizar grupo:  <span data-field="name"></span>
  @endslot

  <div class="row">
    <div class="col-md-12 form-group">
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