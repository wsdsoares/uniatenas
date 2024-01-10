<div class="block-header">
  <h2>Painel Administrativo</h2>

</div>
<!-- Exportable Table -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo "Página Secretaria - Menu SERVIÇOS >> SECRETARIA"; ?>
        </h2>
        <div>
          <span>
            <i>
              <?php echo "Caso não exista a página cadastrada, não será exibido o menu Secretaria no site principal"; ?>
            </i>
          </span>
        </div>
      </div>
      <div class="body">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <?php
              if (isset($paginaSecretaria) and $paginaSecretaria != '') {
                $tituloBotao = "EDITAR";
              } else {
                $tituloBotao = "CADASTRAR";
              }
              echo anchor("Painel_secretaria/cadastrar_pagina_secretaria/$campus->id", '<i class="material-icons">desktop_mac</i> ' . $tituloBotao . ' página (menu secretaria)', array('class' => 'btn alerts_info'));
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
      if (isset($paginaSecretaria) and $paginaSecretaria != '') {
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
              <?php echo anchor('Painel_secretaria/lista_campus_secretaria', '<i class="material-icons">arrow_back</i> Voltar', array('class' => 'btn btn-warning m-t-15 waves-effect')); ?>
            </div>
          </div>
        </div>
        <div class="body">
          <div class="container">
            <div class="row">
              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Informações Secretaria Acadêmica</h5>
                    <p class="card-text"><small>(Apresentação, descrição)</small></p>
                    <?php
                    echo anchor("Painel_secretaria/lista_itens_secretaria/$campus->id/$paginaSecretaria->id", 'Ver Itens', array('class' => 'btn btn-primary'));
                    ?>

                  </div>
                </div>
              </div>
              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Calendadários</h5>
                    <p class="card-text"><small>(Demais cursos e Internato)</small></p>

                    <?php
                    echo anchor("Painel_secretaria/calendarios_semestre/$campus->id/$paginaSecretaria->id", 'Ver links', array('class' => 'btn btn-primary'));
                    ?>
                  </div>
                </div>
              </div>

              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Atividades Complementares</h5>
                    <p class="card-text"><small>(Planilha - Excel)</small></p>

                    <?php
                    echo anchor("Painel_secretaria/lista_atividades_complementares/$campus->id/$paginaSecretaria->id", 'Ver arquivo', array('class' => 'btn btn-primary'));
                    ?>
                  </div>
                </div>
              </div>

              <div class="col-sm-2 text-center">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">Links ùteis/ Acesso Rápido</h5>
                    <p class="card-text"><small>(Links importantes)</small></p>

                    <?php
                    echo anchor("Painel_secretaria/lista_links_uteis_secretaria/$campus->id/$paginaSecretaria->id", 'Ver links', array('class' => 'btn btn-primary'));
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
                    echo anchor("Painel_secretaria/lista_itens_comutacao_secretaria/$campus->id/$paginaSecretaria->id", 'Ver informações', array('class' => 'btn btn-primary'));
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
                    echo anchor("Painel_secretaria/lista_fotos_slides_secretaria/$campus->id/$paginaSecretaria->id", 'Ver informações', array('class' => 'btn btn-primary'));
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
                    // Painel_secretaria_revistas_periodicos/lista_areas_cursos/1/16
                    // echo anchor("Painel_secretaria_revistas_periodicos/lista_itens_revista_periodicos/$campus->id/$paginaSecretaria->id", 'Ver links', array('class' => 'btn btn-primary'));
                    echo anchor("Painel_secretaria_revistas_periodicos/lista_areas_cursos/$campus->id/$paginaSecretaria->id", 'Ver links', array('class' => 'btn btn-primary'));
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