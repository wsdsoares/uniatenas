<script src="//cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<?php
// echo '<pre>';
// // print_r($informacoesCurso);
// echo '</pre>';
?>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo $page; ?>
        </h2>
      </div>
      <?php 
      ?>
      <div class="body">
        <?php
          if ($msg = getMsg()){
              echo $msg;
          }
          ?>
        <?php echo form_open_multipart("Painel_graduacao/editar_curso/$curso->id/$modalidade") ?>

        <h2 class="card-inside-title">Informações do Curso</h2>

        <div class="row clearfix">
          <div class="col-md-5">
            <label for="title">Nome</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">web</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => 'Nome do curso'), set_value('name',$curso->name));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <label for="title">Duração</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">web</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'duration', 'class' => 'form-control', 'placeholder' => 'Duração. Ex.: 2,5 anos'), set_value('duration',$curso->duration));
                ?>
              </div>
            </div>
          </div>

        </div>

        <div class="row clearfix">
          <div class="col-sm-3">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Tipo do curso</label>
                <?php
                    $optionTypes = array(
                        'Bacharelado' => 'Bacharelado',
                        'Licenciatura' => 'Licenciatura'
                    );
                    echo form_dropdown('types', $optionTypes, set_value('types',$curso->types), array('class' => 'form-control show-tick'));
                    ?>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Área do curso</label>
                <?php
                // foreach ($campus as $local) {
                        //     $optionLocal[$local->id] = $local->city;
                        // }
                  $opcoesAreas = array();
                  foreach($areasGraduacao as $item){
                    $opcoesAreas[$item->id] = $item->nome;
                  }

                  echo form_dropdown('areas_id', $opcoesAreas, set_value('areas_id',$curso->areas_id), array('class' => 'form-control show-tick'));
                  ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix" style="background:#f1f1f1">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Icone do curso
                  <small> (Ícone do curso exibido na página de alunos, entre outros)</small>
                </label>
                <?php echo form_input(array('name' => 'icone', 'type' => 'file', 'class' => 'form-control'), set_value('icone')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="informacoes-cadastradas">
              <?php
              if($curso->icone!='' and !empty($curso->icone)){
                echo anchor(base_url(verifyImg($curso->icone)), '<img src="' . base_url(verifyImg($curso->icone)) . '" class="thumbnail">', array('target' => '_blank'));
                }else{
                  echo '<span> Sem imagem cadastrada. <span>';
                }
              ?>
            </div>
          </div>
        </div>

        <div class="separacao-forms"></div>

        <div class="row clearfix">
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Status <small>(1 -Visível, 0 - Oculto)</small></label>
                <?php
                    $optionSituation = array(
                        '1' => 'Visível - Ativo',
                        '0' => 'Oculto - Inativo'
                    );
                    echo form_dropdown('status', $optionSituation, set_value('status',$curso->status), array('class' => 'form-control show-tick'));
                    ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
              echo anchor('Painel_graduacao/todos_cursos/presencial', 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
              ?>
          </div>
        </div>

        <?php
        echo form_close();
        ?>
      </div>
    </div>
  </div>
</div>