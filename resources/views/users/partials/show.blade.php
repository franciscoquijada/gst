<x-modal id="show_user" type="viewer" size="md">
  <x-slot name="title">
    Usuario: <span data-field="name"></span>
  </x-slot>
  <span class="d-none user_id" data-field="id"></span>
  <p><b>Compañia:</b> <span class="text-capitalize" data-field="company.name"></span></p>
  <p><b>Nombre:</b> <span class="text-capitalize" data-field="name"></span></p>
  <p><b>Identificadores externos:</b> <span data-type="raw" data-field="external_html"></span></p>
  <p><b>Email:</b> <span data-field="email"></span></p>
  <p><b>Teléfono:</b> <span data-field="phone"></span></p>
  <p><b>Creado:</b> <span data-field="created_at"></span></p>
  <p><b>Ultima Actualización:</b> <span data-field="updated_at"></span></p>
  <p><b>Ultimo Ingreso:</b> <span data-field="last_login_at"></span></p>

  <x-slot name="footer">
    <x-button.link class="btn-info" label="Cerrar" icon="fa fa-times" data-dismiss="modal" />
  </x-slot>
</x-modal>