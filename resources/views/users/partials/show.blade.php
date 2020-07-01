<div class="modal fade in viewer" tabindex="-1" role="dialog" aria-hidden="true" id="show_user">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-primary text-center">
        <h4 class="modal-title">Usuario: <span data-field="name"></span></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <span class="d-none user_id" data-field="id"></span>
        <p><b>Compañia:</b> <span data-field="company.name"></span></p>
        <p><b>Rut:</b> <span data-field="rut"></span></p>
        <p><b>Nombre:</b> <span data-field="name"></span></p>
        <p><b>Email:</b> <span data-field="email"></span></p>
        <p><b>Teléfono:</b> <span data-field="phone"></span></p>
        <p><b>Token API:</b> <span id="foo" data-field="api_token" style="max-width: 200px;overflow-x: scroll;display: inline-block;margin: 0 10px -23px 10px;"></span> <button type="button" class="btn btn-success get-token"><i class="fas fa-sync-alt"></i></button></span> <button type="button" class="btn btn-info btn-copy" data-container="body" data-toggle="popover" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-clipboard-target="#foo"><i class="far fa-copy"></i></button></p>
        <p><b>Creado:</b> <span data-field="created_at"></span></p>
        <p><b>Ultima Actualización:</b> <span data-field="updated_at"></span></p>
        <p><b>Ultimo Ingreso:</b> <span data-field="last_login_at"></span></p>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>