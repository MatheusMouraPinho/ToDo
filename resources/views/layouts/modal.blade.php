<!-- Modal 1 --> 
<?php if (isset($alterar)){?>
    <div class="modal fade" id="modal<?php echo $id_usuario ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/alterar') }}" method="POST">
                @csrf
                <div class="modal-body-white">
                    <p class="text-center"><h5>Alterar o acesso de: <?php echo $nome ?></h5></p>
                    <br>
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
<?php }?>
<!-- Modal 2--> 
<?php if (isset($opçoes)){?>
    <div class="modal fade" id="modal<?php echo $id_post ?>" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('/option') }}" method="POST">
                @csrf
                <div class="modal-body-white">
                    <p><h4>Opções:</h4></p>
                    <br>
                    <h5>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" id="defaultUnchecked1" type="radio" name="option" value="barrar" required>
                        <label class="custom-control-label" for="defaultUnchecked1">Barrar Post</label>
                    </div>
                    <br>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" id="defaultUnchecked2" type="radio" name="option" value="rem_den" required>
                        <label class="custom-control-label" for="defaultUnchecked2">Remover denuncias</label>
                    </div>
                    <br>
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input" id="defaultUnchecked3" type="radio" name="option" value="del_post" required>
                        <label class="custom-control-label" for="defaultUnchecked3">Deletar o Post</label>
                    </div>
                    </h5>
                </div>
                <div class="modal-footer">
                    <input type='hidden' name="id_denuncia" value="<?php echo $id_denuncia ?>"/>
                    <input type='hidden' name="id_postagem" value="<?php echo $id_post ?>"/>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
<?php }?>
<!--modal 3-->