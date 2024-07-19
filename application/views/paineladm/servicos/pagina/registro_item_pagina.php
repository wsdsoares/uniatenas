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
        <br />
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-7">
            <div class="form-group">
              <div class="form-line">
                <div class="bg-info" style="padding: 10px;margin-bottom:10px;">
                  <?php echo "Lembre-se de colocar um título breve, por exemplo: Estágios Convênios. <br/> Não colocar caracteres especiais, como $ % @ # .... Entre outros."; ?>
                </div>
                <label for="title">Título do Menu (Página)</label>

                <?php
                echo form_input(array('name' => 'titulo_descritivo', 'class' => 'form-control', 'placeholder' => 'Titíulo do menu/página'), set_value('titulo_descritivo'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-3">
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
          <div class="col-sm-3">
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