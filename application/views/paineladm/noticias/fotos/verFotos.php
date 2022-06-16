<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          Lista de Fotos da Notícia <?php echo $news->id ?>
        </h2>
      </div>

      <div class="register">
        <?php
        echo anchor("Painel_noticias/cadastrarFotos/$campus->id/$news->id", '
            <i class = "material-icons">
            add
            </i> <span>Cadastrar outra foto</span>', array('class' => 'btn btn-primary m-t-15 waves-effect'));
        ?>
        <?php
        echo anchor("Painel_noticias/noticias/$campus->id", '
            <i class = "material-icons">
            assignment_return
            </i> <span>Voltar</span>', array('class' => 'btn btn-warning m-t-15 waves-effect'));
        ?>
      </div>

      <div class="body">
        <?php
        if ($msg = getMsg()){
            echo $msg;
        }
        ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>Ações</th>
                <th>Código</th>
                <th>Titulo</th>
                <th>Campus - Cidade</th>
                <th>Fotos</th>
                <th>Autor</th>
                <th>Modificado em</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Ações</th>
                <th>Código</th>
                <th>Titulo</th>
                <th>Campus - Cidade</th>
                <th>Fotos</th>
                <th>Autor</th>
                <th>Modificado em</th>
              </tr>
            </tfoot>
            <tbody>
              <?php

            foreach ($fotos as $foto) {
                ?>
              <tr>
                <td class="center">
                  <?php
                    echo anchor('Noticias/editar/' . $foto->id, '<i class="material-icons">edit</i>');

                    echo '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $foto->file . '" data-id="'.$news->id.'-'.$foto->id.'/'.'" >'
                        . '<i class="material-icons">delete</i>'
                        . '</a>';
                                    ?>
                </td>
                <td><?php echo $foto->id; ?></td>
                <td>
                  <div class="col-md-4">
                    <?php
                    echo anchor(base_url(verifyImg($foto->file)), '<img src="' . base_url(verifyImg($foto->file)) . '" class="thumbnail">', array('target' => '_blank'));
                    ?>
                  </div>
                </td>

                <td><?php echo $foto->usersid; ?></td>
                <td>
                  <?php
                    if ($foto->datecreated != NULL) {
                        echo date('d/m/Y H:i:s', strtotime($foto->datecreated));
                    } else {
                        echo '';
                    }
                    ?>
                </td>
              </tr>
              <?php
            }
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Você tem certeza?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Você tem certeza que deseja realizar essa ação de deletar o item abaixo?</p>
        <p>Essa ação é <span class="text-danger" style="font-weight: bold">IRREVERSÍVEL</span> e todos os dados
          ligados a esse item serão removidos <span class="text-danger"
            style="font-weight: bold">PERMANENTEMENTE</span>.
        </p>
        <p>O item selecionado é: <span class="text-info nomeItem" style="font-weight: bold"></span></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <a id="btnCerteza" class="btn btn-danger" href="">Sim, tenho certeza!</a>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view('templates/elementsPainel/footers/footerDelete'); ?>

<script type="text/javascript">
$('#modalDelete').on('show.bs.modal', function(e) {
  var nomeItem = $(e.relatedTarget).attr('data-nome');
  var id = $(e.relatedTarget).attr('data-id');
  console.log(id);
  $(this).find('.nomeItem').text(nomeItem);
  $(this).find('#btnCerteza').attr('href', '<?php echo base_url("Painel_noticias/deletarFoto/$campus->id/"); ?>' +
    id);
});
</script>