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
        <?php echo form_open_multipart("Painel_portal_alunos/cadastrar_itens_portal_alunos/$campus->id/$pagina->id") ?>
        <h2 class="card-inside-title">Links de acesso à Portais externos ou internos</h2>
        <div class="row clearfix">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Título</label>
                <?php
                echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Ex.: Portal Aluno'), set_value('title'));
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Link</label>
                <?php
                echo form_input(array('name' => 'link_redir', 'class' => 'form-control', 'placeholder' => 'Ex.: http://www.portalaluno.com.br'), set_value('link_redir'));
                ?>
              </div>
            </div>
          </div>

        </div>

        <div class="row clearfix">

          <div class="col-sm-3">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Imagem </label>
                <?php echo form_input(array('name' => 'img_destaque', 'type' => 'file', 'class' => 'form-control'), set_value('img_destaque')); ?>
              </div>
            </div>
          </div>

        </div>

        <div class="row clearfix">
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="priority">Ordem <small> (Exibido dentro da página)</small>
                  <br /><small>A ordem será sequencial. </small></label>
                <?php
                echo form_input(array('name' => 'order', 'type' => 'number', 'min' => '1', 'class' => 'form-control'), set_value('order'));
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
            echo anchor("Painel_portal_alunos/lista_itens_portal_alunos/$campus->id/$pagina->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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