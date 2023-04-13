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
          <div class="col-xs-offset-8">
            <?php echo anchor("Painel_pesquisa_tcc/lista_informacoes_tcc/$campus->id", '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect'));?>
          </div>
        </div>
      </div>
      <br />
      <?php
      if(isset($cursos) and $cursos != '' ){
      ?>
      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Cursos</th>
                <th>Lista Monografias</th>

              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Cursos</th>
                <th>Lista Monografias</th>

              </tr>
            </tfoot>
            <tbody>
              <?php
              foreach ($dados['cursos'] as $item){
              ?>
              <tr>
                <td class="center">
                  <?php 

                    echo '<a href=' . base_url("Painel_pesquisa_tcc_monografias/editar_links_uteis_biblioteca/$campus->id/$pagina->id/$item->idCursoCampus") . '>'
                        . '<i class="material-icons">edit</i>'
                        . '</a> ';
                  ?>
                </td>
                <td><?php echo $item->id; ?></td>
                <td><?php echo "$item->name (<small>$item->modalidade</small>)";?></td>

                <td>
                  <div class="btn-opcoes-curso">
                    <?php
                     echo anchor("Painel_pesquisa_tcc_monografias/lista_monografias/$campus->id/$pagina->id/$item->idCursoCampus",'<i class="material-icons">picture_as_pdf</i> Lista - Monografias',array('class'=>"btn-opcoes-curso btn btn-info")); 
                     ?>
                  </div>
                </td>

              </tr>
              <?php
              }
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