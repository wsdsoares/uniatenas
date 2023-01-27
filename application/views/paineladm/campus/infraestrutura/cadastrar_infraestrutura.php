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
      <div class="body">
        <?php
     
        if ($msg = getMsg()){
            echo $msg;
        }
        
        ?>
        <?php echo form_open_multipart("Painel_Campus/cadastrar_infraestrutura/$campus->id") ?>
        <div class="row clearfix">
          <div class="col-md-6">
            <label for="title">Nome da Local/ Área / Setor da infraestrutura <small><i>(Título)</i></small></label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mode_edit</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'title', 'class' => 'form-control', 'placeholder' => 'Ex: Laboratório de informática '), set_value('title'));
                ?>
              </div>
            </div>
          </div>
        </div>
        <h2 class="card-inside-title">Informações do local/ambiente do campus </h2>
        <div class="row clearfix">
          <div class="col-sm-12">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Descrição do local da infraestrutura
                  <small> </small>
                </label>
                <?php
                  echo form_textarea(array('name' => 'description', 'class' => 'form-control', 'placeholder' => '(Explicação como é o ambiente. Ex.: Sala de aula com tantos metros quadrados... etc.)'), toHtml(set_value('description')));
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
          <div class="col-sm-4">
            <div class="form-group">
              <div class="form-line">
                <label for="campusid">Ordem <small>(Ordem exibição dos itens - Lista de começar em 0 primeiro item da
                    lista)</small></label>
                <?php
                   echo form_input(array('name' => 'order', 'type'=>'number','class' => 'form-control', 'placeholder' => 'Ex: 1'), set_value('order'));
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
              echo anchor("Painel_Campus/lista_infraestrutura/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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