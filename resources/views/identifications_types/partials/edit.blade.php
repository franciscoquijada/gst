<x-modal id="edit_user" type="edit" size="md" route="api.id_types.store" method="PUT" >
  <x-slot name="title">
    Registro de tipo de identificador
  </x-slot>
  <div class="row">
    <div class="col-12 form-group">
      <x-form.input label="Nombre" name="name" class="alpha" data-field="name" />
    </div>
  </div>
  <div class="row">
    <div class="col-12 form-group">
      <x-form.select label="Modelo" name="model" :options="$models->sort()" data-field="model" />
    </div>
  </div>
</x-modal>
