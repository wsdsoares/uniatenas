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
        <?php echo form_open("Painel_portal_alunos/cadastrar_links_uteis_portal_alunos/$campus->id/$pagina->id") ?>

        <h2 class="card-inside-title">Informações Links Úteis
        </h2>

        <div class="row clearfix">
          <div class="col-xs-5">
            <label for="title">Título Link</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">text_format</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'title', 'class' => 'form-control'), set_value('title'));
                ?>
              </div>
            </div>
          </div>

          <div class="col-sm-2">
            <div class="form-group">
              <div class="form-line">
                <label for="status">Tipo Link</label>
                <?php
                $tipoLink = array(
                  'linksUteis' => 'Link Útil',
                  'acessoRapido' => 'Acesso Rápido'
                );

                echo form_dropdown('tipo', $tipoLink, set_value('tipo'), array('class' => 'form-control show-tick'));
                // echo form_dropdown('status', $optionSituation, set_value('status',$statusLinksUteis), array('class' => 'form-control show-tick'));
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
                // echo form_dropdown('status', $optionSituation, set_value('status',$statusLinksUteis), array('class' => 'form-control show-tick'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-xs-12">
            <label for="title">Link<small> (Ex.: http://www.google.com.br)</small></label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">insert_link</i>
              </span>
              <div class="form-line">
                <?php
                echo form_input(array('name' => 'link_redir', 'class' => 'form-control'), set_value('link_redir'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">

        </div>

        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
            echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
            echo anchor("Painel_portal_alunos/lista_links_uteis_portal_alunos/$campus->id/$pagina->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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