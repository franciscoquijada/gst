<x-modal id="show_user" type="viewer" size="md">
  <x-slot name="title">
    Usuario: <span data-field="name"></span>
  </x-slot>
  <span class="d-none user_id" data-field="id"></span>
  <p><b>Grupo:</b> <span data-field="group.name"></span></p>
  <p><b>Nombre:</b> <span data-field="name"></span></p>
  <p><b>Email:</b> <span data-field="email"></span></p>
  <p><b>Teléfono:</b> <span data-field="phone"></span></p>
  <!--p><b>Token API:</b> <span id="foo" data-field="api_token" style="max-width: 200px;overflow-x: scroll;display: inline-block;margin: 0 10px -23px 10px;"></span> <button type="button" class="btn btn-success get-token"><i class="fas fa-sync-alt"></i></button></span> <button type="button" class="btn btn-info btn-copy" data-container="body" data-toggle="popover" data-placement="top" data-content="" data-clipboard-target="#foo"><i class="far fa-copy"></i></button></p-->
  <p><b>Creado:</b> <span data-field="created_at"></span></p>
  <p><b>Ultima Actualización:</b> <span data-field="updated_at"></span></p>
  <p><b>Ultimo Ingreso:</b> <span data-field="last_login_at"></span></p>

  <x-slot name="footer">
    <x-button.link class="btn-info" label="Cerrar" icon="fa fa-times" data-dismiss="modal" />
  </x-slot>
</x-modal>