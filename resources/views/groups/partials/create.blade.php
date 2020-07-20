@card([ 
  'id'    => 'new_group', 
  'route' => 'groups.store', 
  'title' => 'Registro de grupo' 
])
  <div class="row">
    <div class="col-md-12 form-group">
      @input([ 
        'label' => 'Nombre', 
        'name'  => 'name', 
        'class' => 'alpha' 
      ])
    </div>
  </div>

  @slot('footer')
    @link([ 
      'class' => 'btn-success send-form', 
      'label' => 'Guardar', 
      'icon'  => 'far fa-save' 
    ])
  @endslot
@endcard