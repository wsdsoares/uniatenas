<div class="block-header">
  <h2>Painel Administrativo</h2>
</div>
<!-- Exportable Table -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo $page; ?>

        </h2>
        <div>
          <span>
            <i>
              <?php echo "Caso não exista a página cadastrada, não será exibido o menu financeiro no site principal"; ?>
            </i>
          </span>
        </div>
      </div>
      <div class="body">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <?php
              if (isset($paginaFinanceiro) and $paginaFinanceiro != '') {
                $tituloBotao = "EDITAR";
              } else {
                $tituloBotao = "CADASTRAR";
              }
              echo anchor("Painel_financeiro/cadastrar_pagina_financeiro/$campus->id/", '<i class="material-icons">desktop_mac</i> ' . $tituloBotao . ' página ()', array('class' => 'btn alerts_info'));
              ?>
            </div>
            <div class="col-xs-6">
              <?php
              if (isset($paginaFinanceiro) and $paginaFinanceiro != '') {
                echo anchor("Painel_financeiro/cadastrar_contato_pagina_financeiro/$campus->id/$paginaFinanceiro->id", '<i class="material-icons">contact_phone</i> ' . $tituloBotao . ' contatos (financeiro)', array('class' => 'btn btn-blue1'));
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <?php
      if ($msg = getMsg()) {
        echo $msg;
      }
      ?>
      <div class="header">
        <h2>
          <?php echo $page; ?>
        </h2>

      </div>
      <div class="botoes-acoes-formularios">
        <div class="container">
          <?php
          if (isset($paginaFinanceiro) and $paginaFinanceiro != '') {
          ?>
            <div class="col-xs-6">
              <?php echo anchor("Painel_financeiro/cadastrar_informacoes_financeiro/$campus->id", '<i class="material-icons">add_box</i> CADASTRAR item da página Financeiro', array('class' => 'btn btn-primary m-t-15 waves-effect')); ?>
            </div>
          <?php
          }
          ?>
          <div class="col-xs-6">
            <?php echo anchor('Painel_financeiro/lista_campus_financeiro', '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect')); ?>
          </div>
        </div>
      </div>
      <br />
      <?php

      if (isset($conteudosPaginaServicos) and $conteudosPaginaServicos != '') {
      ?>
        <div class="body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
              <thead>
                <tr>
                  <th>Ações</th>
                  <th>#</th>
                  <th>Título página</th>
                  <th>Imagem</th>
                  <th>Situação</th>
                  <th>Filial</th>
                  <th>Modificado em, por:</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Ações</th>
                  <th>#</th>
                  <th>Título página</th>
                  <th>Imagem</th>
                  <th>Situação</th>
                  <th>Filial</th>
                  <th>Modificado em, por:</th>
                </tr>
              </tfoot>
              <tbody>
                <?php
                foreach ($dados['conteudosPaginaServicos'] as $item) :
                ?>
                  <tr>
                    <td class="center">
                      <?php

                      echo '<a href=' . base_url("Painel_financeiro/editar_informacoes_financeiro/$campus->id/$item->id") . '>'
                        . '<i class="material-icons">edit</i>'
                        . '</a> ';
                      echo '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $item->title . '" data-id="' . $item->id . '" >'
                        . '<i class="material-icons">delete</i>'
                        . '</a>';
                      ?>
                    </td>
                    <td>
                      <?php echo $item->id; ?>
                    </td>
                    <td>
                      <?php echo $item->title; ?>
                    </td>
                    <td>

                      <?php
                      // if($item->order==0){
                      //   echo 'Texto de introdução da página <br/><small><i>Primeiro texto exibido na página</i></small>';
                      // }else{
                      //   echo anchor(base_url(verifyImg($item->img_destaque)), '<img src="' . base_url(verifyImg($item->img_destaque)) . '" class="thumbnail">', array('target' => '_blank'));
                      // }
                      ?>
                    </td>
                    </td>
                    <td>
                      <?php
                      if ($item->status == '0') {
                        $situacao = 'Inativo';
                      } else {
                        $situacao = 'Ativo';
                      }

                      echo $situacao;
                      ?>
                    </td>

                    <td>
                      <?php echo $item->city; ?>
                    </td>

                    <td>
                      <?php
                      $dateModification = empty($item->updated_at) ? $item->created_at : $item->updated_at;
                      echo $dateModification . ' - ' . $item->user_id;
                      ?>
                    </td>


                  </tr>
                <?php
                endforeach;
                ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php
      }
      ?>
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
      '<?php echo base_url("Painel_financeiro/deletar_item_financeiro/$campus->id/"); ?>' +
      id);
  });
</script>