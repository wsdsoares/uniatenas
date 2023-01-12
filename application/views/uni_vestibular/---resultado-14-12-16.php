<body id="page-top">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">

    <a class="navbar-brand js-scroll-trigger" href="#page-top">
      <span class="d-block d-lg-none">UniAtenas</span>
      <span class="d-none d-lg-block">
        <img class="img-fluid img-profile rounded-circle mx-auto mb-2"
          src="<?php echo base_url('assets/images/UniAtenasRedondo.png'); ?>">
      </span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#inicio">Início</a>
        </li>
        <?php
                /*<!--li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#aprovados">Lista Aprovados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#listaespera">Lista Espera</a>
                </li>
                 */
                ?>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="#consulta">Consulta WWSDA</a>
        </li>

        <li class="nav-item">
          <?php
                    echo anchor('http://www.atenas.edu.br/site_atenas/', 'Site UniAtenas', array('class' => "nav-link js-scroll-trigger"));
                    ?>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container-fluid p-0 fundoparacatu">

    <section class="resume-section p-3 p-lg-5 d-flex d-column" id="inicio">
      <div class="my-auto">
        <h2 class="mb-0">Vestibular
          <span class="text-primary">UniAtenas - Paracatu</span>
        </h2>
        <div class="subheading mb-5">Av. Euridamas Avelino de Barros · Lavrado, Paracatu - MG · (038) 3672-3737·

        </div>

        <div class="social-icons" style="text-align: center;">
          <div class="col-auto">
            <?php
                /*
                        <a href="#aprovados" class="js-scroll-trigger btn-result">
                            <span>Aprovados</span>
                        </a>
                        <a href="#listaespera" class="js-scroll-trigger btn-result">
                            <span>Lista Espera</span>
                        </a>
                          */
                ?>
            <a href="#consulta" class="js-scroll-trigger btn-result">
              <span>Consulta</span>
            </a>

            <a href="https://www.facebook.com/uniatenasoficial/" style="margin-left: 10px;">
              <i class="fab fa-facebook-f"></i>
            </a>
          </div>
        </div>
      </div>
    </section>
    <?php
        /*
        <!--section class="resume-section p-3 p-lg-5 d-flex flex-column" id="aprovados">
            <div class="my-auto result-vest">
                <h3 class="mb-5">Lista de Aprovados - Paracatu</h3>
                <ul class="fa-ul mb-0">
                    <li class="list-inline-item">
                        <a href="" data-toggle="modal" data-target="#candidatosAprovados">
                            <div class="pdf-files" >
                                <span class="mb-5">Visualizar</span><br>
                                <i class="fas fa-file-pdf fa-3x"></i>
                            </div>
                        </a>
                    </li>

                </ul>
            </div>
            <div id="candidatosAprovados" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="modal-header">

                            <h4 class="modal-title">Lista de candidatos aprovados.</h4>
                        </div>
                        <div class="modal-body">

                            <embed src="http://www.atenas.edu.br/faculdade/paracatu/assets/files/vestibularparacatu/Gabarito-Medicina-UniAtenas-2019-paracatu.pdf"
                                   frameborder="0" width="100%" height="400px">

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="resume-section p-3 p-lg-5 d-flex flex-column" id="listaespera">
            <div class="my-auto result-vest">
                <h3 class="mb-5">Lista de Espera - Paracatu</h3>
                <ul class="fa-ul mb-0">
                    <li class="list-inline-item">
                        <a href="" data-toggle="modal" data-target="#candidatosEspera">
                            <div class="pdf-files" >
                                <span class="mb-5">Visualizar</span><br>
                                <i class="fas fa-file-pdf fa-3x"></i>
                            </div>
                        </a>
                    </li>

                </ul>
            </div>
            <div id="candidatosEspera" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="modal-header">

                            <h4 class="modal-title">Lista de Espera</h4>
                        </div>
                        <div class="modal-body">

                            <embed src="http://www.atenas.edu.br/faculdade/paracatu/assets/files/vestibularparacatu/Gabarito-Medicina-UniAtenas-2019-paracatu.pdf"
                                   frameborder="0" width="100%" height="400px">

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section-->
        */
        ?>
    <section class="resume-section p-3 p-lg-5 d-flex flex-column vestibular" id="consulta">
      <div class="my-auto">
        <h3 class="mb-5">Vestibular Tradicional Medicina - Paracatu</h3>
        <div id="retornoResultado"></div>
        <div class="subheading mb-3">Resultado</div>
        <div class="col-md-12">

          <div class="form-group">
            <?php echo form_open("vestibular/resultado_geral" ) ?>

            <label class="" for="textinput">Digite seu CPF ou seu número inscrição:</label>

            <input id="inputDataVest" name="inputDataVest" onkeypress="return onlynumber();" maxlength="11" type="text"
              placeholder="Apenas Números..." class="form-control input-lg" required="required" />

            <br />
            <input type="button" id="btnDataVest" value="Consultar Resultado" name="btnDataVest"
              class="btn btn-success btn-lg">
            <?php echo form_close() ?>
          </div>

        </div>


      </div>
    </section>

  </div>


</body>