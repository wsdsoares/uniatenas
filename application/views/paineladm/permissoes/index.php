<div class="block-header">
  <h2></h2>
</div>
<!-- Exportable Table -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <?php
      if ($msg = getMsg()){
          echo $msg;
      }
      ?>
      <div class="header">
        <h2>
          Gestão de <?php echo ($page); ?>
        </h2>

      </div>
      <br />
      <div class="body">
        <div class="row">
          <div class="col-md-3">
            <div class="card" style="min-height:10rem;padding-top:1rem;">
              <div class="center">
                <img src="<?php echo base_url('assets/images/icones/perfil.png')?>" alt="">
                <h4 class="card-title">Perfil para usuários</h4>


                <?php
                echo anchor("Painel_permissoes/lista_perfis", '<span>Visualizar</span>','class="btn btn-lg btn-block btn-info"');
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card" style="min-height:10rem;padding-top:1rem;">
              <div class="center">
                <img src="<?php echo base_url('assets/images/icones/permissao.png')?>" alt="">
                <h4 class="card-title">Permissões</h4>


                <?php
                echo anchor("Painel_permissoes/lista_perfis", '<span>Visualizar</span>','class="btn btn-lg btn-block btn-info"');
                ?>
              </div>
            </div>
          </div>
          <br />
        </div>
      </div>
    </div>

  </div>
</div>