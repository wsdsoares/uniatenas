<div class="block-header">
  <h2>PAINEL ADMINISTRATIVO</h2>
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
        <?php echo form_open_multipart("Painel_biblioteca/editar_itens_comutacao_biblioteca/$campus->id/$pagina->id/$informacoesBibliteca->id") ?>
        <h2 class="card-inside-title">Informações</h2>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título *</label>
                <?php
                  echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Ex.: Apresentação'), set_value('title',$informacoesBibliteca->title));
                  ?>
              </div>
            </div>
          </div>
          <div class="col-xs-3">
            <div class="form-group">
              <div class="form-line">
                <label for="status">Descrição Comutação</label>
                <?php
                  if($informacoesBibliteca->order=='comutacao'){
                    $checkedComutacao = TRUE;
                  }else{
                    $checkedComutacao = FALSE;
                  }
                  echo form_checkbox('order', 'comutacao', $checkedComutacao);
                ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-xs-3">
            <div class="form-group">
              <div class="form-line">
                <label for="status">Status <small>(1 -Visível, 0 - Oculto)</small></label>
                <?php
                    $optionSituation = array(
                        '1' => 'Visível - Ativo',
                        '0' => 'Oculto - Inativo'
                    );
                    
                    echo form_dropdown('status', $optionSituation, set_value('status',$informacoesBibliteca->status), array('class' => 'form-control show-tick'));
                    ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Link de redirecionamento</label>
                <?php
                  echo form_input(array('name' => 'link_redir', 'class' => 'form-control', 'placeholder' => 'http://www.site.com.br '), set_value('link_redir',$informacoesBibliteca->link_redir));
                  ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">

          <div class="col-sm-12">
            <label for="title">Descrição do item da Biblioteca
              <small> (Explicação e inforamções)</small>
            </label>
            <?php
              echo form_textarea('description', to_html(set_value('description',$informacoesBibliteca->description)));
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
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
              echo anchor("Painel_biblioteca/lista_itens_comutacao_biblioteca/$campus->id/$pagina->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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