<div class="block-header">
  <h2>Painel Administrativo</h2>
</div>
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <?php
      if ($msg = getMsg()){
        echo $msg;
      }
      ?>
      <div class="header">
        <div class="row clearfix">
          <div class="botoes-acoes-formularios">
            <div class="container">
              <div class="col-md-6">
                <h2>
                  <?php echo $page; ?>
                </h2>
              </div>
              <div class="col-md-6">
                <?php echo anchor('Painel_permissoes/lista_perfis', '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect'));?>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="body">
        <div class="row clearfix">
          <div class="col-sm-12">
            <div class="form-line">
              <label for="title">Nome Perfil</label>
              <?php 
                echo form_input(array('type' => 'text', 'disabled'=>'disabled','class' => 'form-control input-disabled', 'placeholder' => $perfil->name));
                ?>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="form-line">
              <label for="title">Lista Permissões</label>
            </div>
          </div>
          <?php echo form_open("Painel_permissoes/lista_permissoes_perfis/$perfil->id");?>
          <?php
          echo count($permissoes);
          
          //foreach($permissoes as $item){
          for($i=0; $i < count($permissoes); $i++){
          ?>
          <div class="col-sm-3">
            <div class="form-group">
              <div class="itens-permissoes">
                <label for=""><?php echo $permissoes[$i]->titulo;?></label>
                <div class="item">

                  <?php echo form_checkbox('permissoes[]', $permissoes[$i]->titulo_curto.'-visualizar', set_checkbox('permissoes[]',TRUE));?>
                  <label for="checkbox">Visualizar</label>
                </div>
                <div class="item">
                  <?php echo form_checkbox('permissoes[]', $permissoes[$i]->titulo_curto.'-inserir', set_checkbox('permissoes[]',TRUE));?>
                  <label for="checkbox">Inserir</label>
                </div>
                <div class="item">
                  <?php echo form_checkbox('permissoes[]', $permissoes[$i]->titulo_curto.'-atualizar', set_checkbox('permissoes[]',TRUE));?>
                  <label for="checkbox">Atualizar</label>
                </div>
                <div class="item">
                  <?php echo form_checkbox('permissoes[]', $permissoes[$i]->titulo_curto.'-deletar', set_checkbox('permissoes[]',TRUE));?>
                  <label for="checkbox">Deletar</label>
                </div>
              </div>
            </div>
          </div>
          <?php 
          }
          ?>

          <?php 
          echo form_input(array('name' => 'perfil', 'type' => 'hidden', 'class' => 'form-control'), set_value('perfil',$perfil->id));
          echo form_submit(array('name' => 'submit', 'class' => 'btn btn-lg btn-primary m-t-15 m-r-15 waves-effect'), 'SALVAR'); ?>
          <?php echo form_close();?>
        </div>



      </div>
    </div>
  </div>