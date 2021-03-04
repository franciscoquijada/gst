<x-modal id="new_user" size="lg" route="api.users.store" >
  <x-slot name="title">
    Registro de usuarios
  </x-slot>
  <div class="row">
    <div class="col-md-6 col-12 form-group">
      <x-form.select label="Grupo" name="group_id" :options="$groups->sort()" />
    </div>
    <div class="col-md-6 col-12 form-group">
      <x-form.select label="Rol" name="rol_id" :options="$roles->sort()" />
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-12 form-group">
      <x-form.input label="Nombre Completo" name="name" class="alpha" />
    </div>
    <div class="col-md-6 col-12 form-group">
      <x-form.input type="email" label="Correo Electrónico" name="email" />
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