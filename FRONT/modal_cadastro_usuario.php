<div class="modal fade" id="ModalCarastroUsuario" tabindex="-1" aria-labelledby="ModalCarastroUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalCarastroUsuarioLabel">Cadastrar Novo Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
          <label id="label_nome_usuario" for="nome">Nome:</label>
          <input class="col-sm-12" type="text" id="nome_usuario" name="nome_usuario" required>
          <label type="hidden" for="email" id="aviso_erro_nome"></label>
          <br><br>

          <label id="label_email_usuario" for="email">Email:</label>
          <input class="col-sm-12" type="email" id="email_suario" name="email_suario" required>
          <label type="hidden" for="email" id="aviso_erro_email"></label>
          <br><br>

          <input class="col-sm-12" type="hidden" id="idUsuario" name="idUsuario" required><br><br>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">CANCELAR</button>
        <button type="button" class="btn btn-outline-success" id="BcorEditaU" onclick="cadastraEditaUsu()">CADASTRAR</button>
      </div>
    </div>
  </div>
</div>