  <div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="card">
        <div class="header">
          <h2>
            Gestão de <?php echo $page; ?>
          </h2>
        </div>
        <div class="botoes-acoes-formularios">
          <div class="container">
            <div class="col-xs-6">
              <?php
              echo anchor("Painel_graduacao/cadastrar_arquivo_autorizacao_reconhecimento/$cursoPorCampus->campus_coursesid/$campus->id", "<i class='material-icons'>add_box</i> Cadastro de arquivo", array('class' => 'btn btn-primary m-t-15 waves-effect'));
              ?>
            </div>
            <div class="col-xs-6">
              <?php
              echo anchor("Painel_graduacao/lista_cursos/$campus->id/presencial", '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect'));
              ?>
            </div>
          </div>
        </div>


        <div class="body">
          <?php
          if ($msg = getMsg()) {
            echo $msg;
          }
          if (!empty($dados['arquivosAutorizacaoReconhecimento'])) {
          ?>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                <thead>
                  <tr>
                    <th>Ações</th>
                    <th>Código</th>
                    <th>Arquivo</th>
                    <th>Tipo do arquivo</th>
                    <th>Situação</th>
                    <th>Modificado em, por</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Ações</th>
                    <th>Código</th>
                    <th>Arquivo</th>
                    <th>Tipo do arquivo</th>
                    <th>Situação</th>
                    <th>Modificado em, por</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php

                  foreach ($dados['arquivosAutorizacaoReconhecimento'] as $arquivo) {
                  ?>
                    <tr>
                      <td class="center">
                        <?php
                        echo '<a href=' . base_url("Painel_graduacao/editar_arquivo_autorizacao_reconhecimento/$cursoPorCampus->campus_coursesid/$campus->id/$arquivo->id") . '>'
                          . '<i class="material-icons">edit</i>'
                          . '</a> ';

                        echo '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $arquivo->files . '" data-id="' . $arquivo->id . '/' . '" >'
                          . '<i class="material-icons">delete</i>'
                          . '</a>';
                        ?>
                      </td>
                      <td><?php echo $arquivo->id; ?></td>
                      <td>
                        <?php
                        echo anchor($arquivo->files, '<button type="button" class="btn btn-info"><i class="material-icons">archive</i> Ver Arquivo</button>', array('target' => '_blank'));
                        ?>
                      </td>
                      <td><?php echo $arquivo->tipo_arquivo; ?></td>
                      <td>
                        <?php
                        if ($arquivo->status == '0') {
                          echo 'Inativo';
                        } else {
                          echo 'Ativo';
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        $dateModification = empty($arquivo->atualizado_em) ? $arquivo->criado_em : $arquivo->atualizado_em;
                        echo date("d/m/Y H:m:s", strtotime($dateModification)) . ' - ' . $arquivo->user_id;
                        ?>
                      </td>

                    </tr>
                  <?php
                  }
                  ?>

                </tbody>
              </table>
            </div>
          <?php
          } //fim da verificação de está vazio o arrey 


          ?>
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
            ligados a esse item serão removidos <span class="text-danger" style="font-weight: bold">PERMANENTEMENTE</span>.
          </p>
          <p>O item selecionado é: <span class="text-info nomeItem" style="font-weight: bold">
            </span>
          </p>
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
        '<?php
          echo base_url("Painel_graduacao/deletar_arquivo_autorizacao_reconhecimento/$cursoPorCampus->campus_coursesid/$arquivo->id/");
          ?>' + id);

      console.log()

    });
  </script>