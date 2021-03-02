<x-modal id="new_role" size="lg" route="api.roles.store" >
  <x-slot name="title">
    Registro de roles
  </x-slot>
  
  <div class="row">
    <div class="col-md-12 form-group">
      <x-form.input label="Nombre" name="name" class="alpha" data-field="name" />
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-12 form-group">
      <div class="row">
        <label class="col-md-12 m-0">Permisos del Sistema</label>

        @foreach($system as $title => $section)
          <div class="col-md-6 mt-3">
            <label class="col-md-6"><b>{{ ucfirst( strtolower( $title ) ) }}</b></label>
            
            @foreach($section as $name => $id)
              <div class="pl-4 w-100">
                {!! Form::checkbox('permission[]', $id, false, ['class' => 'form-check-input']) !!}
                {{ ucfirst( strtolower( $name ) ) }}
              </div>
            @endforeach

          </div>

        @endforeach

        @if( is_array( $mod ) && count( $mod ) > 0 )

          @foreach($mod as $title => $sub_mod)

            <hr class="w-100"/>
            <label class="col-md-12">Modulo: {{ ucfirst( strtolower( $title ) ) }}</label>

            @foreach($sub_mod as $title_sub => $section)
              <div class="col-md-6">
                <label class="col-md-6"><b>{{ ucfirst( strtolower( $title_sub ) ) }}</b></label>

                @foreach($section as $name => $id)
                  <div class="pl-4 w-100">
                    {!! Form::checkbox('permission[]', $id, false, ['class' => 'form-check-input']) !!}
                    {{ ucfirst( strtolower( $name ) ) }}
                  </div>
                @endforeach

              </div>
            @endforeach

          @endforeach

        @endif
      </div>
      <span id="permission-error" style="display: none;" class="label label-danger ml-1 error"></span>
    </div>
  </div>
</x-modal>