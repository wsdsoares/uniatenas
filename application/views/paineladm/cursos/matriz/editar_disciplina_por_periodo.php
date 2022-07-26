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
          if ($msg = getMsg()){
              echo $msg;
          }
         ?>
        <?php echo form_open("Painel_graduacao/editar_disciplina_por_periodo/$disciplinaCurso->id/$cursoPorCampus->campus_coursesid/$cursoPorCampus->campusid/$modalidade") ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Nome da Disciplina *</label>
                <?php
                echo form_input(array('name' => 'discipline', 'class' => 'form-control', 'placeholder' => 'Nome da Disciplina'), set_value('discipline',$disciplinaCurso->discipline));
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <div class="form-line">
                <label for="priority">Período</label>
                <?php 
                echo form_input(array('name' => 'period', 'type' => 'number', 'class' => 'form-control'), set_value('period',$disciplinaCurso->period)); 
                ?>
              </div>
            </div>
          </div>
        </div>
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
                echo form_dropdown('status', $optionSituation, set_value('status',$disciplinaCurso->status), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-sm-6">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-success m-t-15 waves-effect'), 'Salvar');
            echo anchor("Painel_graduacao/lista_dados_matriz/$cursoPorCampus->campus_coursesid/$cursoPorCampus->campusid/$modalidade", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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