<?php
?>
<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<!-- Input -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo $page; ?>
        </h2>
      </div>
      <div class="body">
        <?php
        if ($msg = getMsg()):
            echo $msg;
        endif;
        ?>
        <?php echo form_open_multipart("Painel_secretaria/editar_calendario_semestre/$campus->id/$id") ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-5">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título</label>
                <?php
                  echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title',$listagem->name));
                  ?>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <label for="campusid">Semestre</label>
            <?php
              $optionStatus[0] = '-- Selecione --';
              $optionStatus[1] = '1º Semestre';
              $optionStatus[2] = '2º Semestre';

              echo form_dropdown('semestre', $optionStatus, set_value('semestre',$listagem->semester), array('class' => 'form-control show-tick')); ?>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Ano</label>
                <?php
                  echo form_input(array('name' => 'year', 'type' => 'number', 'min' => '2000', 'max' => $ano, 'class' => 'form-control', 'placeholder' => 'Ano'), set_value('year',$listagem->year));
                  ?>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <label for="campusid">Status</label>
            <?php
               $optionSituation = array(
                '1' => 'Visível - Ativo',
                '0' => 'Oculto - Inativo'
              );

              echo form_dropdown('status', $optionSituation, set_value('status',$listagem->status), array('class' => 'form-control show-tick')); 
              ?>
          </div>
          <div class="col-sm-3">
            <label for="campusid">Tipo</label>
            <?php
              $optionStatus[0] = '-- Selecione --';
              $optionStatus[1] = 'Demais cursos';
              $optionStatus[2] = 'Medicina (internato)';
              //$optionStatus[3] = 'Medicina-Omega';

              echo form_dropdown('tipo', $optionStatus, set_value('tipo',$idtipo), array('class' => 'form-control show-tick')); 
              ?>
          </div>
        </div>


        <!-- File Upload | Drag & Drop OR With Click & Choose -->
        <div class="row clearfix">
          <div class="col-sm-3">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Arquivo Atual</label>
                <?php echo anchor($listagem->files, '<i class="material-icons">insert_drive_file</i>', array('title' => "arquivo")); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <div class="form-line">
                <span> Caso, deseje trocar o arquivo atual, selecione o arquivo.</span>
                <?php echo form_input(array('name' => 'files', 'type' => 'file', 'class' => 'form-control', 'placeholder' => 'Ano'), set_value('file')); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <?php
                        echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
                        echo anchor("Painel_secretaria/calendarios_semestre/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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