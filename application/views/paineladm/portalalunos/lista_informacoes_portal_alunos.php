<div class="block-header">
  <h2>Painel Administrativo</h2>
</div>
<!-- Exportable Table -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo "Página Portal do Aluno - Menu SERVIÇOS e Menu Portal Acadêmico"; ?>
        </h2>
        <div>
          <span>
            <i>
              <?php echo "Caso não exista a página cadastrada, não será exibido o menu Portal dos alunos no site principal"; ?>
            </i>
          </span>
        </div>
      </div>
      <div class="body">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <?php
              if (isset($paginaPortalAlunos) and $paginaPortalAlunos != '') {
                $tituloBotao = "EDITAR";
              } else {
                $tituloBotao = "CADASTRAR";
              }
              echo anchor("Painel_portal_alunos/cadastrar_pagina_portal_alunos/$campus->id", '<i class="material-icons">desktop_mac</i> ' . $tituloBotao . ' página (menu portal alunos)', array('class' => 'btn alerts_info'));
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
      if (isset($paginaPortalAlunos) and $paginaPortalAlunos != '') {
      ?>
        <div class="botoes-acoes-formularios">
          <div class="container">
            <?php
            /*
            if (isset($paginaFinanceiro) and $paginaFinanceiro != '') {
              ?>
          <div class="col-xs-6">
            <?php echo anchor("Painel_financeiro/cadastrar_informacoes_financeiro/$campus->id", '<i class="material-icons">add_box</i> CADASTRAR item da página Financeiro', array('class' => 'btn btn-primary m-t-15 waves-effect')); ?>
          </div>
          <?php
            }*/
            ?>
            <div class="col-xs-6">
              <?php echo anchor('Painel_portal_alunos/lista_campus_portal_alunos', '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect')); ?>
            </div>
          </div>
        </div>
        <div class="body">
          <div class="container">
            <div class="row">
              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Itens portais</h5>
                    <p class="card-text"><small>(Links e Imaagens Portais)</small></p>
                    <?php
                    echo anchor("Painel_portal_alunos/lista_itens_portal_alunos/$campus->id/$paginaPortalAlunos->id", 'Ver Itens', array('class' => 'btn btn-primary'));
                    ?>

                  </div>
                </div>
              </div>
              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Avisos</h5>
                    <p class="card-text"><small>(Links, imagens ou PDF's)</small></p>
                    <?php
                    echo anchor("Painel_portal_alunos/lista_itens_portal_alunos/$campus->id/$paginaPortalAlunos->id", 'Ver Itens', array('class' => 'btn btn-primary'));
                    ?>

                  </div>
                </div>
              </div>

              <div class="col-sm-3 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Links ùteis/ Acesso Rápido</h5>
                    <p class="card-text"><small>(Links importantes)</small></p>

                    <?php
                    echo anchor("Painel_portal_alunos/lista_links_uteis_portal_alunos/$campus->id/$paginaPortalAlunos->id", 'Ver links', array('class' => 'btn btn-primary'));
                    ?>
                  </div>
                </div>
              </div>
              <!--div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Comutação Bibliográfica</h5>
                    <p class="card-text"><small>(Links + acesseos)</small></p>
                    <?php
                    echo anchor("Painel_portal_alunos/lista_itens_comutacao_portal_alunos/$campus->id/$paginaPortalAlunos->id", 'Ver informações', array('class' => 'btn btn-primary'));
                    ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Foto do Slide</h5>
                    <p class="card-text"><small>(Fotos biblioteca)</small></p>
                    <?php
                    echo anchor("Painel_portal_alunos/lista_fotos_slides_portal_alunos/$campus->id/$paginaPortalAlunos->id", 'Ver informações', array('class' => 'btn btn-primary'));
                    ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Revistas e Periódicos</h5>
                    <p class="card-text"><small>(Links externos)</small></p>
                    <?php
                    // Painel_portal_alunos_revistas_periodicos/lista_areas_cursos/1/16
                    // echo anchor("Painel_portal_alunos_revistas_periodicos/lista_itens_revista_periodicos/$campus->id/$paginaPortalAlunos->id", 'Ver links', array('class' => 'btn btn-primary'));
                    echo anchor("Painel_portal_alunos_revistas_periodicos/lista_areas_cursos/$campus->id/$paginaPortalAlunos->id", 'Ver links', array('class' => 'btn btn-primary'));
                    ?>
                  </div>
                </div>
              </div-->
            </div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</div>