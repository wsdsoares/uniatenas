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
        <?php echo form_open_multipart("Painel_Campus/editar_indicador/$campus->id/$indicador->id") ?>

        <h2 class="card-inside-title">Informações do Indicador </h2>
        <div class="row clearfix">
          <div class="col-md-6">
            <label for="title">Nome</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">mode_edit</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'nome', 'class' => 'form-control', 'placeholder' => 'Ex: Hospital Infantil '), set_value('nome',$dados['indicador']->nome));
                ?>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <label for="title">Acessar Arquivo Atual</label>
            <div class="input-group">
              <?php
              if($indicador->arquivo!='' and !empty($indicador->arquivo)){
                echo anchor(base_url(verifyImg($indicador->arquivo)), '<img src="' . base_url(verifyImg($indicador->arquivo)) . '" class="thumbnail">', array('target' => '_blank'));
                }else{
                  echo '<span> Não há imagem cadastrada. <span>';
                }
              ?>
            </div>
          </div>
        </div>
        <div class="separacao-forms"></div>

        <div class="row clearfix" style="background:#f1f1f1">
          <div class="col-sm-6">
            <div class="form-group">
              <div class="form-line">
                <label for="title">Imagem
                  <small> (Arquivo no formato PNG com fundo brancou ou transparente)</small>
                </label>
                <?php echo form_input(array('name' => 'arquivo', 'type' => 'file', 'class' => 'form-control'), set_value('arquivo')); ?>
              </div>
            </div>
          </div>

        </div>

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
              echo anchor("Painel_Campus/lista_indicadores/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));

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