<div class="block-header">
  <h2>Painel Administrativo</h2>
</div>
<!-- Exportable Table -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo $page; ?>
        </h2>
        <div>
          <span>
            <i><?php echo "Caso não exista a página cadastrada, não será exibido o menu 'Trabalhe Conosco' no site principal"; ?></i>
          </span>
        </div>
      </div>
      <div class="body">
        <div class="container">
          <div class="row">
            <div class="col-xs-4">
              <br />
              <?php
              if (isset($paginaTrabalheConosco) and $paginaTrabalheConosco != '') {
                $tituloBotao = "EDITAR";
              } else {
                $tituloBotao = "CADASTRAR";
              }
              echo anchor("Painel_trabalhe_conosco/cadastrar_pagina_trabalhe_conosco/$campus->id/", '<i class="material-icons">desktop_mac</i> ' . $tituloBotao . ' página (menu Trabalhe Conosco)', array('class' => 'btn alerts_info'));
              ?>
            </div>

            <div class="col-xs-4">
              <?php echo anchor("Painel_trabalhe_conosco/lista_campus_trabalhe_conosco", '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect')); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <?php
      if ($msg = getMsg()) {
        echo $msg;
      }
      ?>
      <div class="header">
        <h2>
          <?php echo $page; ?>
        </h2>
      </div>

      <br />
      <?php
      if (isset($paginaTrabalheConosco) and $paginaTrabalheConosco != '') {
      ?>
        <div class="botoes-acoes-formularios">
          <div class="container">
            <div class="row">
              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Items página trabalhe conosco</h5>
                    <p class="card-text"><small>(Descrições, imagens do termo de aceite)</small></p>
                    <?php
                    echo anchor("Painel_trabalhe_conosco/lista_itens_trabalhe_conosco/$campus->id/$paginaTrabalheConosco->id", 'Ver Itens', array('class' => 'btn btn-primary'));
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  <?php
      }
  ?>
  </div>
</div>