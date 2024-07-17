<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO - SITE</h2>
</div>
<!-- Input -->
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
        if ($msg = getMsg()) :
          echo $msg;
        endif;
        ?>
        <?php echo form_open_multipart("Painel_servicos/editar_item_pagina_especifica/$campus->id/$pagina->id/$paginaEspecifica->id") ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título *</label>
                <?php
                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title', $paginaEspecifica->title));
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título Breve (ou Título Imagem)</label>
                <?php
                echo form_input(array('name' => 'title_short', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('title_short', $paginaEspecifica->title_short));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <label for="title">Link de Redirecionamento</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">input</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'link_redir', 'class' => 'form-control', 'placeholder' => 'Link Completo da página a ser redirecionada'), set_value('link_redir', $paginaEspecifica->link_redir));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="priority">Ordem <small> (Exibido na página)</small>
                  <br /><small>A ordem será sequencial. Ex.:1 (primeiro), 2 (segundo), etc... </small></label>
                <?php
                echo form_input(array('name' => 'order', 'type' => 'number', 'class' => 'form-control'), set_value('order', $paginaEspecifica->order));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="title">Imagem da página</label>
              <div class="form-line">
                <?php echo form_input(array('name' => 'img_destaque', 'type' => 'file', 'class' => 'form-control'), set_value('img_destaque')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <?php
              echo anchor(base_url(verifyImg($paginaEspecifica->img_destaque)), '<img src="' . base_url(verifyImg($paginaEspecifica->img_destaque)) . '" class="thumbnail">', array('target' => '_blank'));
              ?>
            </div>
          </div>

          <div class="row clearfix">

            <div class="col-sm-12">
              <label for="title">Descrição do item
                <small> (Explicação e inforamções pertinentes ao item)</small>
              </label>
              <?php
              echo form_textarea('description', to_html(set_value('description', $paginaEspecifica->description)));
              ?>
            </div>
            <script type="text/javascript">
              // replace: substitui o formato padrão do textarea (descricao)
              // e aplica as configurações do CKEDitor através do arquivo config.js
              var editor = CKEDITOR.replace('description', {
                customConfig: 'config.js'
              });
            </script>
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
                  echo form_dropdown('status', $optionSituation, set_value('status', $paginaEspecifica->status), array('class' => 'form-control show-tick'));
                  ?>
                </div>
              </div>
            </div>
          </div>

          <div class="row clearfix">
            <div class="col-sm-6">
              <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
              echo anchor("Painel_servicos/lista_item_pagina_especifica/$campus->id/$pagina->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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
</div>