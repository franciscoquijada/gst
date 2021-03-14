<x-modal id="edit_group" type="edit" size="lg" method="PUT">
  <x-slot name="title">
    Actualizar grupo:  <span data-field="name"></span>
  </x-slot>
  <div class="row">
    <div class="col-12 form-group">
      <x-form.input label="Nombre" name="name" class="alpha" data-field="name" />
    </div>
  </div>
</x-modal>