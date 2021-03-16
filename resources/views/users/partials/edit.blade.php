<x-modal id="edit_user" type="edit" size="lg" method="PUT">
  <x-slot name="title">
    Actualizar usuario:  <span data-field="name"></span>
  </x-slot>

  @include('users.partials.form')
</x-modal>
