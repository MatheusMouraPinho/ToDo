<!-- Modal 1-->
<div class="modal fade" id="modal_adm2" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Teste</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('/alterar') }}" method="POST">
        @csrf
        <div class="modal-body">
            <input type='hidden' name="alterar" value="<?php echo $id_usuario ?>"/>

            <label for="tipo" class="bold subdados">Tipo</label>
            <select name="tipo" class="select" class="btn btn-primary">
                <option>Usuario</option><option>Avaliador</option><option>Admin</option>
            </select>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Salvar mudanças</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal 2-->