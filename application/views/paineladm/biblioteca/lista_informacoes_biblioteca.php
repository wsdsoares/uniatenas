<div class="block-header">
  <h2>Painel Administrativo</h2>

</div>
<!-- Exportable Table -->
<div class="row clearfix">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="header">
        <h2>
          <?php echo "Página Biblioteca - Menu BIBLIOTECA DO SITE"; ?>
        </h2>
        <div>
          <span>
            <i><?php echo "Caso não exista a página cadastrada, não será exibido o menu biblioteca no site principal"; ?></i>
          </span>
        </div>
      </div>
      <div class="body">
        <div class="container">
          <div class="row">
            <div class="col-xs-6">
              <?php 
                if(isset($paginaBiblioteca) and $paginaBiblioteca != '' ){
                  $tituloBotao = "EDITAR";
                }else{
                  $tituloBotao = "CADASTRAR";
                }
                echo anchor("Painel_biblioteca/cadastrar_pagina_biblioteca/$campus->id", '<i class="material-icons">desktop_mac</i> '.$tituloBotao.' página (menu biblioteca)', array('class' => 'btn alerts_info'));
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
      if ($msg = getMsg()){
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
      if(isset($paginaBiblioteca) and $paginaBiblioteca != '' ){
      ?>
      <div class="botoes-acoes-formularios">
        <div class="container">
          <div class="row">
            <div class="col-sm-2 text-center">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Informações Biblioteca</h5>
                  <p class="card-text"><small>(Apresentação, descrição, comutação, etc)</small></p>
                  <?php
                    echo anchor("Painel_biblioteca/lista_itens_biblioteca/$campus->id/$paginaBiblioteca->id", 'Ver Itens', array('class' => 'btn btn-primary'));
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
                    echo anchor("Painel_biblioteca/lista_links_uteis_biblioteca/$campus->id/$paginaBiblioteca->id", 'Ver links', array('class' => 'btn btn-primary'));
                  ?>
                </div>
              </div>
            </div>
            <div class="col-sm-2 text-center">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Comutação Bibliográfica</h5>
                  <p class="card-text"><small>(Links + acesseos)</small></p>
                  <?php
                    echo anchor("Painel_biblioteca/lista_itens_comutacao_biblioteca/$campus->id/$paginaBiblioteca->id", 'Ver informações', array('class' => 'btn btn-primary'));
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
                    echo anchor("Painel_biblioteca/lista_fotos_slides_biblioteca/$campus->id/$paginaBiblioteca->id", 'Ver informações', array('class' => 'btn btn-primary'));
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
                  // Painel_biblioteca_revistas_periodicos/lista_areas_cursos/1/16
                    // echo anchor("Painel_biblioteca_revistas_periodicos/lista_itens_revista_periodicos/$campus->id/$paginaBiblioteca->id", 'Ver links', array('class' => 'btn btn-primary'));
                    echo anchor("Painel_biblioteca_revistas_periodicos/lista_areas_cursos/$campus->id/$paginaBiblioteca->id", 'Ver links', array('class' => 'btn btn-primary'));
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