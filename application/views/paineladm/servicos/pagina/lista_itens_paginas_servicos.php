<div class="block-header">
  <h2>Painel Administrativo</h2>
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
        <p>
          <?php echo "Caso não exista o ITEM GEAL cadastrado, não será exibido no SUBMENU de SERVIÇOS no site principal"; ?>
        </p>
        <br />

      </div>
      <div class="botoes-acoes-formularios">
        <div class="container">
          <br />
          <div class="col-xs-offset-6 col-xs-6">
            <?php echo anchor("Painel_servicos/lista_itens_servicos/$campus->id", '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect')); ?>
          </div>

        </div>
      </div>
      <br />
      <?php
      if (isset($itensSubmenuPaginaServicos) and $itensSubmenuPaginaServicos != '') {
      ?>
        <div class="body">

          <div class="row">
            <?php

            foreach ($itensSubmenuPaginaServicos as $submenu) {
            ?>
              <div class="col-sm-2 text-center">
                <div class="card">
                  <h5 class="card-title">SUBMENU - <?php echo $submenu->title; ?></h5>
                  <span style="background:#D3D3D3	;padding:2%;">TIPO: <b><?php echo $submenu->tipo_pagina; ?></b></span>
                  <p class="card-text"><small>(Gerenciar dados e informações. <br /> Textos, fotos,
                      contatos)</small>
                  </p>

                  <?php
                  echo anchor("Painel_servicos/lista_item_pagina_especifica/$campus->id/$submenu->id", 'Gerenciar', array('class' => 'btn btn-success'));
                  ?>

                </div>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</div>