<?php
$uricampus = $this->uri->segment(3);
?>
<div class="dados_gerais">
  <div class="container">
    <h2 class="text"><?php echo 'Trabalhe Conosco - ' . $campus->name . ' - ' . $campus->city; ?></h2>
    <div class="row">
      <?php
      // echo '<pre>';
      // print_r($conteudoPag);
      // echo '<-->';
      // print_r($imagemLGPD);
      // print_r($linkRedir);
      // echo '</pre>';
      ?>
      <style>
      .panelResume {
        background: #16A085;
      }

      .panelResume span {
        color: #000;
        font-weight: bold;
      }
      </style>
      <br />

      <div class="col-sm-12">
        <div class="panelResume">
          <div class="panel-heading">
            <div class="text-center">
              <span></span>
            </div>
          </div>
          <?php
          if (!empty($conteudoPag)) {
          ?>
          <div class="col-xs-12 panelsite">
            <p><?php echo $conteudoPag[0]->description; ?></p>
            <p class="text-center">

            <div class="">

              <<<<<<< HEAD <body onselectstart='return false' ondragstart='return false' oncontextmenu='return false'>
                <div class="container">
                  <div class="text-center">
                    =======

                    <body onselectstart='return false' ondragstart='return false' oncontextmenu='return false'>
                      <div class="container">
                        <div class="text-center">

                          <button type="button" class="btnEdital" data-toggle="modal" data-target="#myModal">
                            Cadastrar Curriculum
                          </button>

                        </div>
                        >>>>>>> 54e959cb5eb68be92e2227c3a220aba2e940f5de
                        <?php
                          // if (!empty($imagemLGPD)) {
                          ?>
                        <button type="button" class="btnEdital" data-toggle="modal" data-target="#myModal">
                          Cadastrar Curriculum
                        </button>
                        <?php
                          // }
                          ?>
                      </div>
                      <?php
                        if (!empty($imagemLGPD)) {
                        ?>
                      <<<<<<< HEAD <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Termo de aceite - LGPD</h4>
                            </div>
                            <div class="modal-body">
                              <?php foreach ($imagemLGPD as $imagem) { ?>

                              <img src='<?php echo base_url($imagem->file); ?>' width="100%" height="100%" />

                              <?php } ?>
                              <div class="modal-footer">
                                <input type="checkbox" id="aceito" name="aceito" value="Aceito o Termo">
                                <label for="aceito"> Aceito termo de Uso do Portal RM Banco de Talentos
                                </label><br /><br />
                                <button type="button" class="btnEdital" data-dismiss="modal" id="confirmar"
                                  style="visibility: hidden;"
                                  onclick="window.location='<?php echo $linkRedir->link_redir ?>'">Confirmar</button>
                                <button type="button" class="btnEdital" data-dismiss="modal" id="Fechar"
                                  tyle="background:red !important; border-color:red !important;">Fechar</button>
                                =======
                                <div id="myModal" class="modal fade" role="dialog">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Termo de aceite - LGPD</h4>
                                      </div>
                                      <div class="modal-body">
                                        <?php
                                            foreach ($imagemLGPD as $imagem) {
                                            ?>
                                        <img src='<?php echo base_url($imagem->file); ?>' width="100%" height="100%" />
                                        <?php
                                            }
                                            ?>
                                        <div class="modal-footer">
                                          <input type="checkbox" id="aceito" name="aceito" value="Aceito o Termo">
                                          <label for="aceito"> Aceito termo de Uso do Portal RM Banco de Talentos
                                          </label><br /><br />
                                          <button type="button" class="btnEdital" data-dismiss="modal" id="confirmar"
                                            style="visibility: hidden;"
                                            onclick="window.location='<?php echo $linkRedir->link_redir ?>'">Confirmar</button>
                                          <button type="button" class="btnEdital" data-dismiss="modal" id="Fechar"
                                            tyle="background:red !important; border-color:red !important;">Fechar</button>
                                        </div>

                                      </div>
                                      >>>>>>> 54e959cb5eb68be92e2227c3a220aba2e940f5de
                                    </div>

                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php } ?>
                          </div>
                        </div>
                        <script>
                        var aceite = document.getElementById("aceito");
                        document.getElementById('aceito')
                          .addEventListener('click', function(event) {
                            if (aceite.checked) {
                              document.getElementById('confirmar').style.visibility = "visible";
                            } else {
                              document.getElementById('confirmar').style.visibility = "hidden";
                            }
                          });
                        </script>
                    </body>
                  </div>

                  </p>
                </div>
                <?php
              }
                ?>
            </div>
          </div>

        </div>
      </div>v