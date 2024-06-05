<div class="block-header">
  <h2>Painel Administrativo</h2>
</div>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <?php
      if ($msg = getMsg()){
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
          <div class="col-xs-6">
            <?php echo anchor("Painel_pesquisa_tcc/cadastrar_itens_tcc/$campus->id/$pagina->id", '<i class="material-icons">add_box</i> CADASTRAR Item', array('class' => 'btn btn-primary m-t-15 waves-effect'));?>
          </div>

          <div class="col-xs-6">
            <?php echo anchor("Painel_pesquisa_tcc_monografias/cursos_monografia/$campus->id/$pagina->id", '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect'));?>
          </div>
        </div>
      </div>
      <br />
      <?php
      //$uriCampus = NULL, $pageId = NULL, $idCurso = NULL
      if(isset($listaMonografias) and $listaMonografias != '' ){
      ?>
      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Título</th>
                <th>Link PDF</th>
                <th>Ano</th>
                <th>Situação</th>
                <th>Modificado em, por:</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Título</th>
                <th>Link PDF</th>
                <th>Ano</th>
                <th>Situação</th>
                <th>Modificado em, por:</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              foreach ($dados['listaMonografias'] as $item):
                  ?>
              <tr>
                <td class="center">
                  <?php 

                    echo '<a href=' . base_url("Painel_pesquisa_tcc_monografias/editar_links_uteis_biblioteca/$campus->id/$pagina->id/$item->id") . '>'
                      . '<i class="material-icons">edit</i>'
                      . '</a> '
                      . '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $item->title . '" data-id="' . $item->id . '" >'
                      . '<i class="material-icons">delete</i>'
                      . '</a>';
                  ?>
                </td>
                <td><?php echo $item->id; ?></td>
                <td><?php echo $item->title;?></td>

                <td>
                  <div class="btn-opcoes-curso">
                    <?php
                      
                     
                      if (!file_exists($item->files)){
                        echo '****** <span class="alert-danger" style="color:#ffff;">ATENÇÃO - PDF INEXISTENTE OU ARQUIVO CORROMPIDO</span>';
                      }else{
                        echo file_exists(base_url($item->files));
                        echo anchor($item->files, '
                        ACESSAR LINK <i class="material-icons">picture_as_pdf</i>', array("target" => 'blank')
                        );
                      }
                     ?>
                  </div>
                </td>

                <td>
                  <?php echo $item->year;?>
                </td>
                <td>
                  <?php echo $item->status;?>
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

  $(this).find('.nomeItem').text(nomeItem);
  $(this).find('#btnCerteza').attr('href',
    '<?php echo base_url("Painel_biblioteca/deletar_item_links_uteis_biblioteca/$campus->id/$pagina->id/"); ?>' +
    id);
});
</script>


<?php 
/*
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Monografias - <?php echo $curso->name;?>
</h2>
</div>

<div class="register">
  <?php
                echo anchor('publicacoes/CadastrarMonografias/'.$curso->id, '
                    <i class = "material-icons">
                    add
                    </i> <span>Cadastrar</span>', array('class' => 'btn btn-primary m-t-15 waves-effect'));
                ?>
  <?php
                echo anchor('publicacoes/revistas/', '
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
          <th>Data Criação</th>
          <th>Status</th>
          <th>Ano</th>
        </tr>
      </thead>
      <tfoot>
        <tr>

          <th>#</th>
          <th>Titulo</th>
          <th>Data Criação</th>
          <th>Status</th>
          <th>Ano</th>


        </tr>
      </tfoot>
      <tbody>

        <?php
                            foreach ($dados['monografias'] as $row) {
                                ?>
        <tr <?php
                            if ($row->files == 'assets/files/magazines/<')
                                echo 'style="background:#fff3cd;"';
                                ?>>
          <td class="center">
            <?php
                                            echo anchor($row->files, '
                                                <i class="material-icons">picture_as_pdf</i>', array("target" => 'blank')
                                            );
                                            echo '<a href=' . base_url("publicacoes/editarMagazine/$row->coursesid/$row->id") . '>'
                                            . '<i class="material-icons">edit</i>'
                                            . '</a> '
                                            . '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $row->title . '" data-id="' . $row->id . '" >'
                                            . '<i class="material-icons">delete</i>'
                                            . '</a>';
                                            ?>
          </td>


          <td><?php echo $row->title; ?></td>

          <td><?php
                                        echo date('d/m/Y H:i:s', strtotime($row->datecreated));
                                        ?></td>
          <td>
            <?php
                                        if ($row->status == 1) {
                                            echo 'Ativo';
                                        } else {
                                            echo 'Inativo';
                                        }
                                        ?>
          </td>

          <td><?php echo $row->year; ?></td>



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
  console.log(id);
  $(this).find('.nomeItem').text(nomeItem);
  $(this).find('#btnCerteza').attr('href', '<?php echo base_url("publicacoes/deletarMagazine/"); ?>' + id);
});
</script>