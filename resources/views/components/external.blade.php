<b>Identificadores externos</b>
<ul id="external_id">
  @forelse( $user->external as $i => $programa )
  <li class="row mt-3">
    <div class="mr-3">
      @select([ 'name' => 'external[id][]', 'label' => 'Programa', 'class' => 'form-control', 'options' => $external, 'default' => $programa->id, 'error' => false  ])
      <div class="d-block w-100">
        <span id="external_id_{{ $i }}-error" data-title="external_id" style="display: none;" class="label label-danger w-100 ml-1 error"></span>
      </div>
    </div>
    <div>
      @select([ 'name' => 'external[niveles][]', 'label' => 'Nivel', 'class' => 'form-control', 'options' => ['expert' => 'Experto','high' => 'Avanzado', 'medium' => 'Medio', 'low' => 'Bajo'], 'default' => $programa->pivot->nivel, 'error' => false ])
      <div class="d-block w-100">
        <span id="external_niveles_{{ $i }}-error" data-title="external_niveles" style="display: none;" class="label label-danger w-100 ml-1 error"></span>
      </div>
    </div>
    <div>
      <button type="button" style="border-radius: 0" class="btn btn-info mt-3 ml-2 small new_item" href="#" ><i class="fa fa-plus"></i></button>
      <button type="button" style="border-radius: 0" class="btn @if ($loop->first) d-none @endif btn-danger mt-3 ml-2 small del_item" href="#" ><i class="far fa-trash-alt"></i></button>
    </div>
  </li>
  @empty
  <li class="row mt-3">
    <div class="mr-3 mb-3">
      @select([ 'name' => 'external[id][]', 'error' => false, 'label' => 'Programa', 'class' => 'form-control ', 'options' => $external, 'error' => false ])
      <div class="d-block w-100">
        <span id="external_id_0-error" data-title="external_id" style="display: none;" class="label label-danger w-100 ml-1 error"></span>
      </div>
    </div>
    <div>
      @select([ 'name' => 'external[niveles][]', 'error' => false, 'label' => 'Nivel', 'class' => 'form-control ', 'options' => ['expert' => 'Experto','high' => 'Avanzado', 'medium' => 'Medio', 'low' => 'Bajo'], 'error' => false ])
      <div class="d-block w-100">
        <span id="external_niveles_0-error" data-title="external_niveles" style="display: none;" class="label label-danger w-100 ml-1 error"></span>
      </div>
    </div>}
  </li>
  @endforelse
</ul>