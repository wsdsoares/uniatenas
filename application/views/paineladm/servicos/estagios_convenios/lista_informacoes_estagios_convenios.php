<div class="block-header">
  <h2>Painel Administrativo</h2>
</div>
<!-- Exportable Table -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo "Página estágio e convênios - Menu ESTÁGIOS E CONVÊNIOS do SITE"; ?>
        </h2>
        <div>
          <span>
            <i><?php echo "Caso não exista a página cadastrada, não será exibido o menu 'Estágios e Convênios' no site principal"; ?></i>
          </span>
        </div>
      </div>
      <div class="body">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <?php
              if (isset($paginaEstagiosConvenios) and $paginaEstagiosConvenios != '') {
                $tituloBotao = "EDITAR";
              } else {
                $tituloBotao = "CADASTRAR";
              }
              echo anchor("Painel_estagios_convenios/cadastrar_pagina_estagios_convenios/$campus->id/", '<i class="material-icons">desktop_mac</i> ' . $tituloBotao . ' página (menu estágio e convênios)', array('class' => 'btn alerts_info'));
              ?>
            </div>
            <div class="col-xs-6">
              <?php
              if (isset($paginaEstagiosConvenios) and $paginaEstagiosConvenios != '') {
                echo anchor("Painel_estagios_convenios/cadastrar_contato_pagina_estagios_convenios/$campus->id/$paginaEstagiosConvenios->id", '<i class="material-icons">contact_phone</i> ' . $tituloBotao . ' contatos (estágio e convênios)', array('class' => 'btn btn-blue1'));
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
      if (isset($paginaEstagiosConvenios) and $paginaEstagiosConvenios != '') {
      ?>
        <div class="botoes-acoes-formularios">
          <div class="container">
            <div class="row">
              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Itens da Estágio</h5>
                    <p class="card-text"><small>(Apresentação e outros)</small></p>
                    <?php
                    echo anchor("Painel_estagios_convenios/lista_itens_estagios_convenios/$campus->id/$paginaEstagiosConvenios->id", 'Ver Itens', array('class' => 'btn btn-primary'));
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
                    echo anchor("Painel_estagios_convenios/lista_links_uteis_pagina_estagios_convenios/$campus->id/$paginaEstagiosConvenios->id", 'Ver links', array('class' => 'btn btn-primary'));
                    ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Documentos</h5>
                    <p class="card-text"><small>(Lista de Documentos para o estágio)</small></p>
                    <?php
                    echo anchor("Painel_estagios_convenios/lista_documentos_estagios_convenios/$campus->id/$paginaEstagiosConvenios->id", 'Ver informações', array('class' => 'btn btn-primary'));
                    ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Instituições Convêniadas</h5>
                    <p class="card-text"><small>(Empresas parceiras)</small></p>
                    <?php
                    echo anchor("Painel_estagios_convenios/cadastrar_atendimento_pagina_estagios_convenios/$campus->id/$paginaEstagiosConvenios->id", 'Ver informações', array('class' => 'btn btn-primary'));
                    ?>
                  </div>
                </div>
              </div>
              <!-- <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Instituições Convêniadas</h5>
                    <p class="card-text"><small>(Empresas parceiras)</small></p>
                    <?php
                    echo anchor("Painel_estagios_convenios/cadastrar_atendimento_pagina_estagios_convenios/$campus->id/$paginaEstagiosConvenios->id", 'Ver informações', array('class' => 'btn btn-primary'));
                    ?>
                  </div>
                </div> -->
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