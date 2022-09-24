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
          if ($msg = getMsg()):
            echo $msg;
          endif;
          ?>
        <?php echo form_open_multipart("Painel_publicacoes/registro_revistas/$campus->id") ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título da Revista <small>*</small></label>
                <?php
                  echo form_input(array('name' => 'titulo', 'class' => 'form-control', 'placeholder' => 'Título'), set_value('titulo'));
                  ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-xs-12" style="background:#DCDCDC;border:1px dotted #808080">
            <small>(Revista - <br />Modalidade - Interna (Link e revistas gerenciadas no painel
              ADM)\nModalidade - <br />EXTERNA (Link para sistema OJS ou Outro sistema de gestão))</small>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-4">
            <label for="title">Modalidade <small>*</small></label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">map</i>
              </span>
              <div class="form-line">
                <?php
                $modalidadeRevista = array(
                  'INTERNA'=>'Interna',
                  'EXTERNA'=> 'EXTERNA (OJS ou Outros');
                echo form_dropdown('modalidade', $modalidadeRevista, set_value('modalidade'), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <label for="title">Link de Redirecionamento <small> (Preencher somente em caso de revista
                EXTERNA)</small></label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">input</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'linkRedirect', 'class' => 'form-control', 'placeholder' => 'Link Completo da página/sistema a ser redirecionado'), set_value('linkRedirect'));
                  ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <label for="title">Capa da Revista<small>*</small></label>
              <div class="form-line">capa
                <?php echo form_input(array('name' => 'capa', 'type' => 'file', 'class' => 'form-control'), set_value('capa')); ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <label for="title">ISSN</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">input</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'issn', 'class' => 'form-control', 'placeholder' => 'ISSN'), set_value('issn'));
                  ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
              echo form_textarea('description', to_html(set_value('description')));
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
              echo anchor("Painel_publicacoes/lista_revistas/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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