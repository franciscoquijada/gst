@card([ 
  'id'    => 'edit_group', 
  'route' => 'groups.index', 
  'edit'  => true 
])
  @slot('title')
    Actualizar grupo:  <span data-field="name"></span>
  @endslot

  <div class="row">
    <div class="col-md-12 form-group">
      @input([ 
        'label' => 'Nombre', 
        'name'  => 'name', 
        'class' => 'alpha', 
        'attr'  => [ 
          'data-field' => 'name' 
        ] 
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