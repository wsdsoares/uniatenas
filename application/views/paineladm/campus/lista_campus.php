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
            echo anchor("Painel_campus/cadastrar_campus", '<i class="material-icons">add_box</i> CADASTRAR Campus', array('class' => 'btn btn-primary m-t-15 waves-effect'));
            ?>
          </div>

        </div>
      </div>
      <br />
      <br />
      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Cidade</th>
                <th>Situação / Visivel</th>
                <th>Tipo</th>
                <th>Criado em:</th>
                <th>Modificado em, por:</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Cidade</th>
                <th>Situação / Visível</th>
                <th>Tipo</th>
                <th>Criado em:</th>
                <th>Modificado em, por:</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              foreach ($dados['listagemDosCampus'] as $campus){
                  ?>
              <tr>
                <td class="center">
                  <?php 

                  echo '<a href=' . base_url("Painel_Campus/editar_campus/$campus->id") . '>'
                      . '<i class="material-icons">edit</i>'
                      . '</a> ';
                      echo '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $campus->name . '" data-id="' . $campus->id . '" >'
                          . '<i class="material-icons">delete</i>'
                          . '</a>';

                        /*            $redirect = 'Painel_home-slideshow';
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
                <td><?php echo $campus->id; ?></td>
                <td><?php echo $campus->city; ?></td>
                <td>
                  <?php
                   if($campus->status =='1'){
                    echo 'ativo /';
                  }else{
                    echo 'inativo /';
                  }
                  if($campus->visible =='SIM'){
                    echo 'Visível';
                  }else{
                    echo'Invisível';
                  }
                  ?>
                </td>
                <td>
                  <?php
                  if($campus->type =='centrouniversitario'){
                    echo 'Centro Universitário';
                  }
                  if($campus->type =='faculdade'){
                    echo 'Faculdade';
                  }
                  ?>
                </td>

                <td> <?php echo date("d/m/Y",strtotime($campus->created_at)); ?></td>
                <td>
                  <?php 
                    $dateModification = empty($campus->updated_at) ? $campus->created_at : $campus->updated_at;
                    echo date("d/m/Y",strtotime($dateModification)); 
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

  $(this).find('.nomeItem').text(nomeItem);
  $(this).find('#btnCerteza').attr('href', '<?php echo base_url("Painel_campus/deletar_campus/"); ?>' + id);


});
</script>