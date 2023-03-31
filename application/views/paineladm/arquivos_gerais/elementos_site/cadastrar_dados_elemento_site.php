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
        if ($msg = getMsg()){
            echo $msg;
        }
        ?>
        <?php echo form_open("Painel_geral/cadastrar_dados_elemento_site/$campus->id") ?>

        <h2 class="card-inside-title">Informações dos elementos/itens do site </h2>
        <div class="row clearfix">
          <div class="col-md-3">
            <label for="title">Nome do item</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mode_edit</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'nome', 'class' => 'form-control', 'placeholder' => 'Nom ou Titulo do item'), set_value('nome'));
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <label for="title">Link <small> (caso tenha)</small></label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">insert_link</i>
              </span>

              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'link', 'class' => 'form-control', 'placeholder' => 'http://link.com.br'), set_value('link'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Tipo <small>(Topo Site, Rodapé)</small></label>
                <?php
                    $optionTipo= array(
                        'topo_site' => 'Topo - Site',
                        'rodape' => 'Rodapé - Site',
                        'link_vestibular' => 'Link vestibular - Top Site',
                        'link_biblioteca' => 'Link Biblioteca - Topo Site',
                    );
                    echo form_dropdown('tipo', $optionTipo, set_value('tipo'), array('class' => 'form-control show-tick'));
                    ?>
              </div>
            </div>
          </div>
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
          <div class="col-sm-12">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
              echo anchor("Painel_geral/lista_dados_elementos_site/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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