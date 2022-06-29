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
        <?php echo form_open("Painel_usuarios/vincular_campus_usuario/$listaUsuario->id") ?>

        <h2 class="card-inside-title">Vincular campus ao usuário</h2>
        <div class="row clearfix">
          <div class="col-md-12">
            <span>Usuário: </span><label><u><?php echo $listaUsuario->name?></u></label>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-sm-4">
            <?php 
            foreach($campus as $item){
            ?>
            <input type='checkbox' name='checkbox_campus[]' value='<?php echo $item->id ?>'>
            <?php echo $item->name.' '.$item->city; ?><br>
            <?php
            }
            ?>
          </div>
        </div>

        <div class="row clearfix">
          <div class="col-sm-12">
            <?php
              echo form_submit(array('name' => 'cadastrar', 'class' => 'btn btn-primary m-t-15 waves-effect'), 'Salvar');
              echo anchor("Painel_usuarios/lista_vinculo_campus_usuario/$listaUsuario->id", 'Voltar', array('class' => "btn btn-danger m-t-15 waves-effect"));
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