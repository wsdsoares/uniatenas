<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
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
        if ($msg = getMsg()) {
          echo $msg;
        }
        ?>
        <?php echo form_open("Painel_estagios_convenios/editar_empresas_conveniadas/$campus->id/$pagina->id/$empresaConveniada->id") ?>

        <h2 class="card-inside-title"><?php echo 'Estágios e Convênios - CONTEÚDOS' ?> </h2>
        <div class="row clearfix">
          <div class="col-md-6">
            <label for="title">Titulo</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mode_edit</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'empresa', 'class' => 'form-control', 'placeholder' => 'Titulo'), set_value('empresa', $empresaConveniada->empresa));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="separacao-forms"></div>
        <div class="row clearfix">
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="cityid">Cidade <small>(UF)</small></label>
                <?php

                echo form_dropdown('cityid', $opcoesCidadesConveniadas, set_value('cityid', $empresaConveniada->cityid), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="separacao-forms"></div>

        <div class="row clearfix">
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="status">Status <small>(1 -Visível, 0 - Oculto)</small></label>
                <?php
                $optionSituation = array(
                  '1' => 'Visível - Ativo',
                  '0' => 'Oculto - Inativo'
                );
                echo form_dropdown('status', $optionSituation, set_value('status', $empresaConveniada->status), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
            echo anchor("Painel_estagios_convenios/lista_empresas_conveniadas/$campus->id/$pagina->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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