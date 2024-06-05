<div class="block-header">
  <h2>Painel Administrativo</h2>
</div>
<!-- Exportable Table -->
<?php
$titutloPagina = "Iniciação Científica";
?>
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo "Página ", $titutloPagina . "- Menu PESQUISA DO SITE"; ?>

        </h2>
        <div>
          <span>
            <i><?php echo "Caso não exista a página cadastrada, não será exibido o menu '" . $titutloPagina . "' no site principal"; ?></i>
          </span>
        </div>
      </div>
      <div class="body">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <?php
              if (isset($paginaIniciacaoCientifica) and $paginaIniciacaoCientifica != '') {
                $tituloBotao = "EDITAR";
              } else {
                $tituloBotao = "CADASTRAR";
              }
              echo anchor("Painel_iniciacao_cientifica/cadastrar_pagina_iniciacao_cientifica/$campus->id/", '<i class="material-icons">desktop_mac</i> ' . $tituloBotao . ' página (menu) <small>' . $titutloPagina . '</small>', array('class' => 'btn alerts_info'));
              ?>
            </div>
            <div class="col-xs-6">
              <?php
              if (isset($paginaIniciacaoCientifica) and $paginaIniciacaoCientifica != '') {
                echo anchor("Painel_iniciacao_cientifica/cadastrar_contato_pagina_iniciacao_cientifica/$campus->id/$paginaIniciacaoCientifica->id", '<i class="material-icons">contact_phone</i> ' . $tituloBotao . ' contatos <small>(' . $titutloPagina . ')</small>', array('class' => 'btn btn-blue1'));
              }
              ?>
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
      if (isset($paginaIniciacaoCientifica) and $paginaIniciacaoCientifica != '') {
      ?>
        <div class="botoes-acoes-formularios">
          <div class="container">
            <div class="row">
              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Itens da Iniciação</h5>
                    <p class="card-text"><small>(Apresentação e outros)</small></p>
                    <?php
                    echo anchor("Painel_iniciacao_cientifica/lista_informacoes_iniciacao_cientifica/$campus->id/$paginaIniciacaoCientifica->id", 'Ver Itens', array('class' => 'btn btn-primary'));
                    ?>

                  </div>
                </div>
              </div>

              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Links ùteis</h5>
                    <p class="card-text"><small>(Links importantes)</small></p>

                    <?php
                    echo anchor("Painel_iniciacao_cientifica/lista_links_uteis_pagina_iniciacao_cientifica/$campus->id/$paginaIniciacaoCientifica->id", 'Ver links', array('class' => 'btn btn-primary'));
                    ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Atendimento</h5>
                    <p class="card-text"><small>(Horários/Local)</small></p>
                    <?php
                    echo anchor("Painel_iniciacao_cientifica/cadastrar_atendimento_pagina_iniciacao_cientifica/$campus->id/$paginaIniciacaoCientifica->id", 'Ver informações', array('class' => 'btn btn-primary'));
                    ?>
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
</div>