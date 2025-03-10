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
        <?php echo form_open_multipart("Painel_iniciacao_cientifica/cadastrar_informacoes_iniciacao_cientifica/$campus->id/$pagina->id") ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título *</label>
                <?php
                  echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Ex.: Apresentação'), set_value('title'));
                  ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Sub Título</label>
                <?php
                  echo form_input(array('name' => 'title_short', 'class' => 'form-control', 'placeholder' => 'Ex.: Apresentação do setor de pesquisa '), set_value('title_short'));
                  ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="priority">Ordem <small> (Exibido dentro da página)</small>
                  <br /><small>A ordem será sequencial. Ex.:1 (primeiro), 2 (segundo), etc... </small></label>
                <?php 
                echo form_input(array('name' => 'order', 'type' => 'number', 'class' => 'form-control'), set_value('order')); 
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

          <div class="col-sm-12">
            <label for="title">Descrição do item da Iniciação Científica
              <small> (Explicação e inforamções)</small>
            </label>
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
          <div class="col-sm-6">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Cadastrar');
              echo anchor("Painel_iniciacao_cientifica/lista_informacoes_iniciacao_cientifica/$campus->id/$pagina->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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