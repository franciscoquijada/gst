<x-modal id="new_type" size="md" route="api.id_types.store" >
  <x-slot name="title">
    Registro de tipo de identificador
  </x-slot>
  <div class="row">
    <div class="col-12 form-group">
      <x-form.input label="Nombre" name="name" class="alpha" />
    </div>
  </div>
  <div class="row">
    <div class="col-12 form-group">
      <x-form.select label="Modelo" name="model" :options="$models->sort()" />
    </div>
  </div>
</x-modal>
