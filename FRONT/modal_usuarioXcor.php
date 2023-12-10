<div class="modal fade" id="usuarioXcor" tabindex="-1" aria-labelledby="usuarioXcor_edita" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="usuarioXcor_edita">Usuario X Cor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
  
                <input class="col-sm-12" type="hidden" id="id_uxc" name="id_uxc" required>
                <input class="col-sm-12" type="hidden" id="id_Use" name="id_Use" required>
                <input class="col-sm-12" type="hidden" id="id_Cor" name="id_Cor" required>

                <label id="usuas">Usuarios Disponiveis:</label>
                <select class="col-sm-12" name="usu_disponiveis" id="usu_disponiveis">
                    <option value="0">selecione um infeliz</option>
                </select>
                <label type="hidden" for="email" id="aviso_erro_usuas"></label>
                <br><br>
                <label id="cores">Escolha a Cor:</label>
                <select class="col-sm-12" name="colors_diponiveis" id="colors_diponiveis">
                    <option value="0">selecione uma cor</option>
                </select>
                <label type="hidden" for="email" id="aviso_erro_usescores"></label>
                <br><br>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">CANCELAR</button>
        <button type="button" class="btn btn-outline-success"  id="BcorEditaUXC" onclick="inseEditUsuxCor()">CADASTRAR</button>
      </div>
    </div>
  </div>
</div>