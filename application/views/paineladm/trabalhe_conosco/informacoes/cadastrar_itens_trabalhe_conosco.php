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
        if ($msg = getMsg()) {
          echo $msg;
        }
        ?>
        <?php echo form_open("Painel_trabalhe_conosco/cadastrar_itens_trabalhe_conosco/$campus->id/$paginaTrabalheConosco->id") ?>

        <h2 class="card-inside-title">Informações/ Itens Trabalhe Conosco </h2>
        <div class="row clearfix">
          <div class="col-md-6">
            <label for="title">Titulo do item <small>(*Obrigatório)</small></label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mode_edit</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Titulo'), set_value('title'));
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Tipo Item
                  <small>(Termo, Botão,ImagensTermo)</small><small>(*Obrigatório)</small>
                </label>
                <?php
                $optionSituation = array(
                  'informacoesPagina' => 'Descrição da página',
                  'imagem' => 'Termo de Aceite - Imagem',
                  'linkExterno' => 'Link Externo',
                  'aceiteTrabalheConosco' => 'Texto Termo Aceite',
                  'textoBotao' => 'Texto Botão'
                );
                echo form_dropdown('tipo', $optionSituation, set_value('tipo'), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-md-6">
            <label for="title">Link do Termo de Aceite</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mode_edit</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'link_redir', 'class' => 'form-control', 'placeholder' => 'Link do termo de aceite'), set_value('link_redir'));
                ?>
              </div>
            </div>
          </div>

        </div>
        <div class="separacao-forms"></div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Descrição do texto exibido na página inicial do trabalhe conosco
                  <small> (Explicação e inforamções pertinentes)</small>
                </label>
                <?php
                echo form_textarea(array('name' => 'description', 'class' => 'form-control', 'placeholder' => 'Explicação e inforamções pertinentes ao campus.'), toHtml(set_value('description')));
                ?>
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
          // replace: substitui o formato padrão do textarea (descricao)
          // e aplica as configurações do CKEDitor através do arquivo config.js
          var editor = CKEDITOR.replace('description', {
            customConfig: 'config.js'
          });
        </script>
        <div class="separacao-forms"></div>

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
          <div class="col-sm-12">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
            echo anchor("Painel_trabalhe_conosco/lista_itens_trabalhe_conosco/$campus->id/$pagina->id/$paginaConteudos->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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