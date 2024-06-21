<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>

<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php
          echo $page;
          ?>
        </h2>
      </div>
      <div class="body">
        <?php
        if ($msg = getMsg()) {
          echo $msg;
        }
        ?>
        <!-- <?php //echo form_open_multipart("Painel_estagios_convenios/cadastrar_documentos_estagios_convenios/$campus->id/$conteudoItemEstagiosConvenios->id") 
              ?> -->
        <?php echo form_open("Painel_servicos/registro_item_pagina/$campus->id") ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-xs-5">
            <p>
              <?php echo "Nesse Item, colocar texto Breve (Limite 30 caracteres). <br/> Quer criar o item >> Estágios Convênios <br/> <br/> No Campo abaixo coloque: EstagiosConvenios"; ?>
            </p>
            <div class="form-group">
              <div class="form-line">

                <label for="title">Nome do Menu</label>

                <?php
                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => '', 'maxlength' => '30'), set_value('title'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-xs-3">
            <div class="form-group">
              <div class="form-line">
                <label for="status">Tipo Página <small>( Geral ou Núcleo)</small></label>
                <?php
                $tipoPagina = array(
                  'item_geral' => 'Geral',
                  'nucleos' => 'Núcelo'
                );

                echo form_dropdown('tipo_pagina', $tipoPagina, set_value('tipo_pagina'), array('class' => 'form-control show-tick'));
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
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
            echo anchor("Painel_servicos/lista_informacoes_servicos/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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