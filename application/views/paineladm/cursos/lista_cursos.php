<div class="block-header">
  <h2></h2>
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
          Gestão de <?php echo $page; ?>
        </h2>
      </div>
      <div class="botoes-acoes-formularios">
        <div class="container">
          <div class="col-xs-6">
            <?php
            echo anchor("Painel_graduacao/vincular_curso_campus/$campus->id", "<i class='material-icons'>add_box</i> Cadastro do Curso <small> (Vincular ao Campus)</small> ", array('class' => 'btn btn-primary m-t-15 waves-effect'));
            ?>
          </div>
          <div class="col-xs-6">
            <?php 
          echo anchor('Painel_graduacao/lista_campus_cursos', '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect'));
          ?>
          </div>
        </div>
      </div>


      <div class="body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover dataTable js-exportable">
            <thead>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Nome Curso</th>
                <th>Detalhes</th>
                <th>Ações/Itens do Curso</th>
                <th>Matriz/Grade Curricular</th>
                <th>Situação</th>
                <th>Última modificação em, por:</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Nome Curso</th>
                <th>Detalhes</th>
                <th>Ações/Itens do Curso</th>
                <th>Matriz/Grade Curricular</th>
                <th>Situação</th>
                <th>Última modificação em, por:</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              foreach ($dados['cursos'] as $item):
              ?>
              <tr>
                <td class="center">
                  <?php 

                    echo '<a href=' . base_url("Painel_graduacao/editar_vinculo_curso_campus/$campus->id/$item->campus_coursesid") . '>'
                        . '<i class="material-icons">edit</i>'
                        . '</a> ';
                    echo '<a href="" data-toggle="modal" data-target="#modalDelete" data-nome="' . $item->name . '" data-id="' . $item->campus_coursesid . '" >'
                        . '<i class="material-icons">delete</i>'
                        . '</a>';
                     ?>
                </td>
                <td><?php echo $item->campus_coursesid; ?></td>
                <td>
                  <?php echo $item->name.' <br/><small><strong>('.$item->city.')</strong></small>'; ?>

                </td>
                <td>
                  <?php 
                  echo anchor("Painel_graduacao/cadastrar_informacoes_curso/$item->campus_coursesid",'
                  <i class="material-icons">menu_book</i><br />
                  <span>Dados Curso <br /><small>(Sobre o curso, informações sobre áreas de atuação, arquivos de
                      autorização/reconhecimento, Grade/Matriz (PDF) e link vestibular)</smal>
                  </span>');
                  ?>
                </td>
                <td>
                  <div class="btn-opcoes-curso">
                    <?php
                     echo anchor("Painel_graduacao/lista_fotos_curso/$item->campus_coursesid/$campus->id",'Fotos do Curso',array('class'=>"btn-opcoes-curso btn btn-primary")); 
                     ?>
                  </div>
                  <div class="btn-opcoes-curso">
                    <a class="btn-opcoes-curso btn btn-warning">Infraestrutura do Curso</a>
                  </div>
                  <div class="btn-opcoes-curso">
                    <?php
                      //echo anchor();
                    ?>
                    <a class="btn-opcoes-curso btn btn-success">Grade Curricular (Matriz)</a>
                  </div>
                  <div class="btn-opcoes-curso">
                    <a class="btn-opcoes-curso btn btn-info">Infraestrutura do Curso</a>
                  </div>
                  <?php
                  ///echo anchor(base_url(verifyImg($item->icone)), '<img src="' . base_url(verifyImg($item->icone)) . '" class="thumbnail">', array('target' => '_blank'));
                  ?>
                </td>
                <td>
                  <?php 
                    if(isset($item->filesGrid)){
                      echo anchor($item->filesGrid,'<button type="button" class="btn btn-info"><i class="material-icons">archive</i> Ver Arquivo</button>',array('target' => '_blank'));
                    }else{
                      echo 'Não há Grade/Matriz cadastrada.';
                    }
                  ?>
                </td>
                <td>
                  <?php
                    if($item->statusCourses =='0'){
                        $situacao = 'Inativo';
                    }else{
                        $situacao = 'Ativo';
                    }
                    echo $situacao;
                    ?>
                </td>

                <style>
                .btn-opcoes-curso {
                  margin-bottom: 0.5rem;
                }
                </style>


                <td>
                  <?php 
                    //$dateModification = empty($item->updated_at) ? $item->created_at : $item->updated_at;
                   //echo date("d/m/Y H:m:s",strtotime($dateModification)).' - '.$item->userid; 
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
    '<?php echo base_url("Painel_graduacao/deletar_vinculo_curso/$campus->id/"); ?>' +
    id);
});
</script>