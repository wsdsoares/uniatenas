<?php
$year = date('Y');
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
          <?php echo $page;?>
        </h2>
      </div>
      <div class="body">
        <?php
        if ($msg = getMsg()){
          echo $msg;
        }
        ?>
        <?php echo form_open("Painel_biblioteca_revistas_periodicos/cadastrar_area_curso_link/$campus->id/$pagina->id") ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-xs-7">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título Área/Curso</label>
                <?php
                  echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Ex.: Geral / Pedagogia'), set_value('title'));
                  ?>
              </div>
            </div>
          </div>
          <div class="col-xs-3">
            <div class="form-group">
              <div class="form-line">
                <label for="status">Status <small>(1 -Visível, 0 - Oculto)</small></label>
                <?php
                    $optionSituation = array(
                        '1' => 'Visível - Ativo',
                        '0' => 'Oculto - Inativo'
                    );
                    
                    echo form_dropdown('status', $optionSituation, set_value('status'), array('class' => 'form-control show-tick'));
                    // echo form_dropdown('status', $optionSituation, set_value('status',$statusLinksUteis), array('class' => 'form-control show-tick'));
                    ?>
              </div>
            </div>
          </div>

        </div>

        <div class="row clearfix">
          <div class="col-sm-6">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
              echo anchor("Painel_biblioteca_revistas_periodicos/lista_areas_cursos/$campus->id/$pagina->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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