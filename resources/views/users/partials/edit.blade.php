<x-modal id="edit_user" type="edit" size="lg" method="PUT">
  <x-slot name="title">
    Actualizar usuario:  <span data-field="name"></span>
  </x-slot>

  <div class="row">
    <div class="col-md-6 col-12 form-group">
      <x-form.select label="Grupo" name="group_id" :options="$groups->sort()" data-field="group_id" />
    </div>
    <div class="col-md-6 col-12 form-group">
      <x-form.select label="Rol" name="rol_id" :options="$roles->sort()" data-field="roles[0]['id']" />
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-12 form-group">
      <x-form.input label="Nombre Completo" name="name" class="alpha" data-field="name" />
    </div>
    <div class="col-md-6 col-12 form-group">
      <x-form.input type="email" label="Correo Electrónico" name="email" data-field="email" />
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-12 form-group"> 
      <x-form.input type="password" label="Contraseña" name="password" />
    </div>
    <div class="col-md-6 col-12 form-group"> 
      <x-form.input type="password" label="Confirmar Contraseña" name="password_confirmation" />
    </div>
  </div>
</x-modal>
