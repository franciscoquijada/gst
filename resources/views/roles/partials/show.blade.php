<x-modal id="show_role" type="viewer" size="lg">
  <x-slot name="title">
    Rol: <span data-field="name"></span>
  </x-slot>
  <p><b>Permisos asociados:</b></p>
  <div id="permission" class="row"></div>

  <x-slot name="footer">
    <x-button.link class="btn-info" label="Cerrar" icon="fa fa-times" data-dismiss="modal" />
  </x-slot>
</x-modal>