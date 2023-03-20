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
        <?php echo form_open_multipart("Painel_biblioteca/cadastrar_fotos_slides_biblioteca/$campus->id/$pagina->id") ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-5">
            <div class="form-group">
              <div class="form-line">
                <label for="priority">Título Foto</label>
                <?php 
                echo form_input(array('name' => 'title', 'placeholder' => 'Título do Slide', 'class' => 'form-control'), set_value('title')); 
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-7">
            <div class="form-group">

              <div class="form-line">
                <label for="priority">Foto (1240 px X 400px) </label>
                <?php echo form_input(array('name' => 'file', 'type' => 'file', 'class' => 'form-control'), set_value('file')); ?>
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
                  echo form_dropdown('status', $optionSituation, set_value('status'), array('class' => 'form-control show-tick'));
                  ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
            echo anchor("Painel_biblioteca/lista_fotos_slides_biblioteca/$campus->id/$pagina->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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