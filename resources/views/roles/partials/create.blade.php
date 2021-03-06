<x-modal id="new_role" size="lg" route="api.roles.store" >
  <x-slot name="title">
    Registro de roles
  </x-slot>
  
  <div class="row">
    <div class="col-12 form-group">
      <x-form.input label="Nombre" name="name" class="alpha" data-field="name" />
    </div>
  </div>

  <div class="row">
    <div class="col-12 form-group">
      <div class="row">
        <label class="col-12 m-0">Permisos del Sistema<hr class="m-0" /></label>
      </div>
      <div class="row">
        
        @foreach( $system as $title => $section )
          <div class="col-md-6 mt-3">
            <label class="col-md-6"><b>{{ ucfirst( strtolower( $title)) }}</b></label>

            @foreach( $section as $name => $id )
              <div class="pl-4 w-100">
                <x-form.checkbox name="permission[]" :value="$id" />
                {{ ucfirst( strtolower( $name ) ) }}
              </div>
            @endforeach

          </div>
        @endforeach

        @if( is_array( $mod ) && count( $mod ) > 0 )
    
          @foreach($mod as $title => $sub_mod)
            <hr class="w-100"/>
            <label class="col-12">Modulo: {{ ucfirst( strtolower( $title ) ) }}</label>

            @foreach($sub_mod as $title_sub => $section)
              <div class="col-md-6">
              <label class="col-md-6"><b>{{ ucfirst( strtolower( $title_sub ) ) }}</b></label>

              @foreach($section as $name => $id)
                <div class="pl-4 w-100">
                  <x-form.checkbox name="permission[]" :value="$id" />
                  {{ ucfirst( strtolower( $name ) ) }}
                </div>
              @endforeach

              </div>
            @endforeach

          @endforeach

        @endif

      </div>
    </div>
  </div>

  <span id="permission-error" style="display: none;" class="label label-danger ml-1 error"></span>
</x-modal>