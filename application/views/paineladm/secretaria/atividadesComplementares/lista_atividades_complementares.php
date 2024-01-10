<!-- Exportable Table -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo $page; ?>
        </h2>
      </div>
      <div class="botoes-acoes-formularios">
        <div class="container">
          <div class="col-xs-6">
            <?php
            echo anchor("Painel_secretaria/cadastrar_arquivo_atividades_complementares/$campus->id/$pagina->id", '<i class = "material-icons">
            add
            </i> <span>Cadastrar arquivo</span>', array('class' => 'btn btn-primary m-t-15 waves-effect'));
            ?>
          </div>
          <div class="col-xs-6">
            <?php
            echo anchor("Painel_secretaria/lista_informacoes_secretaria/$campus->id/$pagina->id", '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect'));
            ?>
          </div>
        </div>
      </div>
      <div class="body">
        <?php
        if ($msg = getMsg()) {
          echo $msg;
        }
        ?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Nome</th>
                <th>Arquivo / Link</th>
                <th>Situação</th>
                <th>Data Modificação/usuario</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Nome</th>
                <th>Arquivo / Link</th>
                <th>Situação</th>
                <th>Data Modificação/usuario</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              foreach ($listagem as $row) {
              ?>
                <tr>
                  <td class="center">
                    <?php
                    echo anchor($row->files, '<i class="material-icons">input</i>', array('title' => "arquivo"));
                    //if (in_array("regProvasGab", $permissionCampusArray['campus-1'])) {
                    echo '<a href=' . base_url("Painel_secretaria/editar_arquivo_atividades_complementares/$campus->id/$row->id/$pagina->id") . '>'
                      . '<i class="material-icons">edit</i>'
                      . '</a> ';
                    echo '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $row->name . '" data-id="' . $row->id . '" >'
                      . '<i class="material-icons">delete</i>'
                      . '</a>';

                    ?>
                  </td>
                  <td><?php echo $row->id; ?></td>

                  <td><?php echo $row->name; ?></td>
                  <td><?php echo $row->files; ?></td>
                  <td>
                    <?php echo $situacao = $row->status == 1 ? 'Ativo' : 'Inativo'; ?>
                  </td>
                  <td>
                    <?php
                    $dateModification = empty($row->updated_at) ? $row->created_at : $row->updated_at;
                    echo $dateModification . ' - ' . $row->user_id;
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
        <p>Essa ação é <span class="text-danger" style="font-weight: bold">IRREVERSÍVEL</span> e todos os dados ligados
          a esse item serão removidos <span class="text-danger" style="font-weight: bold">PERMANENTEMENTE</span>.</p>
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
    $(this).find('.nomeItem').text(nomeItem);
    $(this).find('#btnCerteza').attr('href',
      '<?php echo base_url("Painel_secretaria/deletar_atividades_complementares/$campus->id/$pagina->id/"); ?>' + id);
  });
</script>