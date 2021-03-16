<x-modal id="new_user" size="lg" route="api.users.store" >
  <x-slot name="title">
    Registro de usuarios
  </x-slot>
  
  @include('users.partials.form')
</x-modal>