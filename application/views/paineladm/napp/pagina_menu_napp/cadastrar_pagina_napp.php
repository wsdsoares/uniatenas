<?php 
$paginaNappStatus = $dados['paginaNapp'] !="" ? $dados['paginaNapp'] : '';
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
          if ($msg = getMsg()){
            echo $msg;
          }
          ?>
        <?php echo form_open("Painel_napp/cadastrar_pagina_napp/$campus->id") ?>

        <h2 class="card-inside-title">Informações do Página
        </h2>

        <div class="row clearfix">
          <div class="col-sm-4">
            <label for="title">Menu/Página</label>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">web</i>
              </span>
              <div class="form-line">
                <?php
                  echo form_input(array('name' => 'title', 'class' => 'form-control','readonly'=>"readonly"), set_value('title','MENU - NAPP'));
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

                    $status = isset($dados['paginaNapp']->status) ? $dados['paginaNapp']->status : '0';
                    echo form_dropdown('status', $optionSituation, set_value('status',$status), array('class' => 'form-control show-tick'));
                    ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
              echo anchor("Painel_napp/lista_informacoes_napp/$campus->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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