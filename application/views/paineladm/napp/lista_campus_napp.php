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
        <h2>
          Gestão de <?php echo ($page); ?>
        </h2>
      </div>
      <br />
      <div class="body">
        <div class="row">
          <?php 
          foreach($dados['campus'] as $campus){
          ?>
          <div class="col-md-3">
            <div class="card" style="height:10rem;padding-top:1rem;">
              <div class="center">
                <h4 class="card-title"><?php echo $campus->name.'<br/> '.$campus->city.'('.$campus->uf.')'; ?></h4>

                <?php
                echo anchor("Painel_napp/lista_informacoes_napp/$campus->id", '<span>Ver itens do NAPP</span>','class="btn btn-lg btn-block btn-info"');
                ?>
              </div>
            </div>
          </div>
          <?php 
          }
          ?>
          <br />
        </div>
      </div>
    </div>

  </div>
</div>