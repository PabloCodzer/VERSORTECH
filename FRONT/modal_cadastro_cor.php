<div class="modal fade" id="cadastra_cor" tabindex="-1" aria-labelledby="cadastra_edita_cor" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cadastra_edita_cor">Cadastrar Nova Cor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <label id="LabelCorErro" for="nomeCor">Cor:</label>
            <input class="col-sm-12 " type="text" id="nomeCor" name="nomeCor" required>
            <label type="hidden" for="idCor" id="aviso_erro"></label>
            <input class="col-sm-12" type="hidden" id="idCor" name="idCor" required><br><br>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">CANCELAR</button>
        <button type="button" class="btn btn-outline-success"  id="BcorEditaC" onclick="CadastraOuEdit()">CADASTRAR</button>
      </div>
    </div>
  </div>
</div>