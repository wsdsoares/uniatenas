<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO</h2>
</div>
<style>
.btn-opcoes-curso {
  margin-bottom: 0.5rem;
}
</style>
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
          Gestão de <?php echo ($page); ?>
        </h2>

      </div>
      <div class="botoes-acoes-formularios">
        <div class="container">
          <div class="col-xs-6">
            <?php
            echo anchor("Painel_Campus/cadastrar_infraestrutura/$campus->id", '<i class="material-icons">add_box</i> CADASTRAR - Infraestrutura', array('class' => 'btn btn-primary m-t-15 waves-effect'));
            ?>
          </div>
          <div class="col-xs-6">
            <?php 
            echo anchor('Painel_Campus/lista_campus_infraestrutura', '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect'));
            ?>
          </div>
        </div>
      </div>
      <br />
      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Nome</th>
                <th>Fotos</th>
                <th>Situação</th>
                <th>Campus</th>
                <th>Criado em:</th>
                <th>Modificado em, por:</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Nome</th>
                <th>Fotos</th>
                <th>Situação</th>
                <th>Campus</th>
                <th>Criado em:</th>
                <th>Modificado em, por:</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              foreach ($dados['listaInfraestrutura'] as $item){
              ?>
              <tr>
                <td class="center">
                  <?php 

                      echo '<a href=' . base_url("Painel_Campus/editar_indicador/$item->id") . '>'
                          . '<i class="material-icons">edit</i>'
                          . '</a> ';
                      // echo '<a href="" 
                      //     data-toggle="modal" 
                      //     data-target="#modalDelete" 
                      //     data-nome="' . $item->id . '" data-id="' . $item->id . '" >'
                      //     . '<i class="material-icons">delete</i>'
                      //     . '</a>';
/*
                                    $redirect = 'Painel_home-slideshow';
                                    $table = 'banners';

                                    if ($campus->status == 1) {
                                        echo  '<i class="material-icons">visibility</i>'
                                            . '</a>';
                                    } elseif ($campus->status == 0) {
                                        echo  '<i class="material-icons">visibility_off</i>'
                                            . '</a>';
                                    }
                                   */ ?>
                </td>
                <td><?php echo $item->id; ?></td>
                <td><?php echo $item->title;?></td>
                <td>
                  <div class="btn-opcoes-curso">
                    <?php
                     echo anchor("Painel_Campus/lista_fotos_infraestrutura/$item->id/$item->idCampus",'Fotos da infraestrutura',array('class'=>"btn-opcoes-curso btn btn-primary")); 
                     ?>
                  </div>
                  <div class="btn-opcoes-curso">
                    <?php
                     echo anchor("Painel_Campus/lista_fotos_infraestrutura/$item->id/$item->idCampus",'Descrição e informações da infraestrutura',array('class'=>"btn-opcoes-curso btn btn-warning")); 
                     ?>
                  </div>
                </td>
                <td>
                  <?php
                  if($item->status =='0'){
                    echo 'Inativo';
                  }else{
                    echo'Ativo';
                  }
                  ?>
                </td>
                <td><?php echo $item->city;?></td>
                <td>

                </td>

                <td>
                  <?php 
                    $dateModification = empty($item->updated_at) ? $item->created_at : $item->updated_at;
                    echo date("d/m/Y H:m:s",strtotime($dateModification)).' - '.$item->user_id; 
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
  $(this).find('#btnCerteza').attr('href',
    '<?php echo base_url("Painel_Campus/delete_indicador/$campus->id/"); ?>' + id);
});
</script>