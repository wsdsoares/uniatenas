<div class="block-header">
  <h2>Painel Administrativo</h2>
</div>
<!-- Exportable Table -->
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
          <?php
         
          ?>
          <div class="col-xs-6">
            <?php echo anchor("Painel_publicacoes/registro_revistas/$campus->id", '<i class="material-icons">add_box</i> CADASTRAR Revista', array('class' => 'btn btn-primary m-t-15 waves-effect'));?>
          </div>
          <?php 
         
          ?>
          <div class="col-xs-6">
            <?php echo anchor('Painel_publicacoes/lista_campus_revistas', '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect'));?>
          </div>
        </div>
      </div>
      <br />
      <?php
      //if(isset($paginaFinanceiro) and $paginaFinanceiro != '' ){
      ?>
      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Título </th>
                <th>CAPA</th>
                <th>Situação</th>
                <th>Lista de Artigos</th>
                <th>Modificado em, por:</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Título </th>
                <th>CAPA</th>
                <th>Situação</th>
                <th>Lista de Artigos</th>
                <th>Modificado em, por:</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              foreach ($dados['revistas'] as $item):
              ?>
              <tr>
                <td class="center">
                  <?php 
                    echo '<a href=' . base_url("Painel_publicacoes/editar_registro_revistas/$campus->id/$item->id") . '>'
                        . '<i class="material-icons">edit</i>'
                        . '</a> ';
                    echo '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $item->titulo . '" data-id="' . $item->id . '" >'
                        . '<i class="material-icons">delete</i>'
                        . '</a>';
                  ?>
                </td>
                <td><?php echo $item->id; ?></td>
                <td><?php echo $item->titulo;?></td>
                <td>

                  <?php
                   $verificaExistenciaArquivo= explode('.',$item->capa );
                   $finalArquivo =  end($verificaExistenciaArquivo);
                   if(!file_exists($item->capa)){
                     echo '****** <span class="alert-danger" style="color:#ffff;">ATENÇÃO - Arquivo não cadastrado no Banco de Dados</span>';
                   }elseif
                     (
                       $finalArquivo == 'jpg' or $finalArquivo == 'JPG' 
                       or $finalArquivo == 'PNG' or $finalArquivo == 'png' 
                       or  $finalArquivo == 'JPEG' or $finalArquivo == 'jpeg'
                     )
                     {
                     echo anchor(base_url(verifyImg($item->capa)), '<img src="' . base_url(verifyImg($item->capa)) . '" class="thumbnail">', array('target' => '_blank'));
                   }else{
                     echo '****** <span class="alert-danger" style="color:#ffff;">ATENÇÃO - PDF INEXISTENTE OU ARQUIVO CORROMPIDO</span>';
                   }

                  // if (file_exists($item->capa)){
                  //   echo anchor(base_url(verifyImg($item->capa)), '<img src="' . base_url(verifyImg($item->capa)) . '" class="thumbnail">', array('target' => '_blank'));
                  // }else{
                  //   echo '****** <span class="alert-danger" style="color:#ffff;">ATENÇÃO - ARQUIVO INEXISTENTE OU CORROMPIDO</span>';
                  // }
                  ?>
                </td>
                </td>
                <td>
                  <?php
                    if($item->status =='0'){
                        $situacao = 'Inativo';
                    }else{
                        $situacao = 'Ativo';
                    }

                    echo $situacao;
                    ?>
                </td>

                <td>
                  <div class="btn-opcoes-curso">
                    <?php
                     echo anchor("Painel_publicacoes/lista_artigos_revistas/$campus->id/$item->id",'Artigos da revista',array('class'=>"btn-opcoes-curso btn btn-primary")); 
                     ?>
                  </div>
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
      //}
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
    '<?php echo base_url("Painel_financeiro/deletar_item_financeiro/$campus->id/"); ?>' +
    id);
});
</script>