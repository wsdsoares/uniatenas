<?php
$contatoPaginaEspecifica = $dados['contatoPaginaEspecifica'] != "" ? $dados['contatoPaginaEspecifica'] : '';

if ($contatoPaginaEspecifica != '') {
  $statusContato = $dados['contatoPaginaEspecifica']->status;
  $descricaoContato = $dados['contatoPaginaEspecifica']->description;
} else {
  $statusContato = '';
  $descricaoContato = '';
}
?>
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
      <?php
      ?>
      <div class="body">
        <?php
        if ($msg = getMsg()) {
          echo $msg;
        }
        ?>
        <?php echo form_open("Painel_servicos/cadastrar_contato_pagina_especifica/$campus->id/$pagina->id") ?>

        <h2 class="card-inside-title">Informações de contato
        </h2>

        <div class="row clearfix">
          <div class="col-sm-6">
            <label for="title">Menu/Página</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">web</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'title', 'class' => 'form-control', 'readonly' => "readonly"), set_value('title', strtoupper($pagina->title) . " --- Item: Contatos"));
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="status">Status <small>(1 -Visível, 0 - Oculto)</small></label>
                <?php
                $optionSituation = array(
                  '1' => 'Visível - Ativo',
                  '0' => 'Oculto - Inativo'
                );
                echo form_dropdown('status', $optionSituation, set_value('status', $statusContato), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">

          <div class="col-sm-12">
            <label for="title">Informações de contato</label>
            <?php
            echo form_textarea('description', to_html(set_value('description', $descricaoContato)));
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
          <div class="col-sm-12">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
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