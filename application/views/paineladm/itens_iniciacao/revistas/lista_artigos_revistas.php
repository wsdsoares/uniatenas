<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo $page; ?>
        </h2>
      </div>

      <div class="register">
        <?php
                echo anchor("Painel_publicacoes/cadastrar_artigo_revista/$campus->id/$revista->id", '
                    <i class = "material-icons">
                    add
                    </i> <span>Cadastrar</span>', array('class' => 'btn btn-primary m-t-15 waves-effect'));
                ?>
        <?php
                echo anchor("Painel_publicacoes/lista_revistas/$campus->id", '
                    <i class = "material-icons">
                    arrow_back
                    </i> <span>Voltar</span>', array('class' => 'btn btn-danger btn-system m-t-15 btn-viewer'));
                ?>


      </div>


      <div class="body">
        <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>

        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>#</th>
                <th>Titulo</th>
                <th>Tipo</th>
                <th>Data Criação</th>
                <th>Status</th>
                <th>Curso</th>
                <th>Ano</th>

                <th>Campus</th>
              </tr>
            </thead>
            <tfoot>
              <tr>

                <th>#</th>
                <th>Titulo</th>
                <th>Tipo</th>
                <th>Data Criação</th>
                <th>Status</th>
                <th>Curso</th>
                <th>Ano</th>

                <th>Campus</th>

              </tr>
            </tfoot>
            <tbody>

              <?php
                            foreach ($dados['publicacoes'] as $row) {
                                ?>
              <tr <?php
                                if ($row->files == 'assets/files/magazines/')
                                    echo 'style="background:#fff3cd;"';
                                ?>>
                <td class="center">
                  <?php
                    echo anchor($row->files, '
                        <i class="material-icons">picture_as_pdf</i>', array("target" => 'blank')
                    );
                    echo '<a href=' . base_url("Painel_publicacoes/editar_artigo_revista/$campus->id/$row->paginas_id/$row->id") . '>'
                    . '<i class="material-icons">edit</i>'
                    . '</a> '
                    . '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $row->title . '" data-id="' . $row->id . '" >'
                    . '<i class="material-icons">delete</i>'
                    . '</a>';
                    ?>
                </td>

                <td>
                  <?php echo $row->title; 
                  $verificaExistenciaArquivo= explode('.',$row->files );
                  $finalArquivo =  end($verificaExistenciaArquivo);
                  if(!file_exists($row->files)){
                    echo '****** <span class="alert-danger" style="color:#ffff;">ATENÇÃO - Arquivo não cadastrado no Banco de Dados</span>';
                  }elseif($finalArquivo !== 'pdf'){
                    echo '****** <span class="alert-danger" style="color:#ffff;">ATENÇÃO - PDF INEXISTENTE OU ARQUIVO CORROMPIDO</span>';
                  }
                  ?>
                </td>
                <td>
                  <?php echo $row->types . "- VOL.:" . $row->volume . " - N" . $row->number_vol ?>
                </td>
                <td><?php
                  echo date('d/m/Y H:i:s', strtotime($row->created));
                      ?>
                </td>
                <td>
                  <?php
                    if ($row->status == 1) {
                        echo 'Ativo';
                    } else {
                        echo 'Inativo';
                    }
                    ?>
                </td>
                <td><?php echo $row->courses; ?></td>
                <td><?php echo $row->year; ?></td>

                <td><?php echo $row->campus; ?></td>

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
    '<?php echo base_url("Painel_publicacoes/deletarMagazine/$campus->id/"); ?>' +
    id);
});
</script>