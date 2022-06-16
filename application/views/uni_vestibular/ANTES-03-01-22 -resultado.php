<body id="page-top">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">

        <a class="navbar-brand js-scroll-trigger" href="#page-top">
            <span class="d-block d-lg-none">UniAtenas</span>
            <span class="d-none d-lg-block">
                <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="<?php echo base_url('assets/images/UniAtenasRedondo.png'); ?>">
            </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#consulta">Consulta</a>
                </li>


                <?php/*
                if ($idCampus == 1) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="http://www.atenas.edu.br/faculdade/paracatu/assets/files/vestibularparacatu/LISTA-APROVADOS-VESTIBULAR-TRADICIONAL-PARACATU2019.pdf">Lista aprovados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="http://www.atenas.edu.br/faculdade/paracatu/assets/files/vestibularparacatu/LISTA-ESPERA-VESTIBULAR-TRADICIONAL-PARACATU2019.pdf">Lista espera</a>
                    </li>
                    <?php
                } elseif ($idCampus == 2) {
                    ?>
                   
                    <?php
                } elseif ($idCampus == 3) {
                    ?>
                     <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="http://www.atenas.edu.br/faculdade/paracatu/assets/files/vestibularsetelagoas/SETE-LAGOAS-LISTA-APROVADOS-VESTIBULAR-TRADICIONAL-SETELAGOAS2019.pdf">Lista aprovados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="http://www.atenas.edu.br/faculdade/paracatu/assets/files/vestibularsetelagoas/SETE-LAGOAS-LISTA-ESPERA-VESTIBULAR-TRADICIONAL-SETELAGOAS2019.pdf">Lista espera</a>
                    </li>
                    <?php
                }elseif ($idCampus == 6) {
                ?>
                 <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="http://www.atenas.edu.br/uniatenas/assets/vestibulartradicional/LISTADEAPROVADOS.pdf">Lista aprovados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="http://www.atenas.edu.br/uniatenas/assets/vestibulartradicional/LISTADEESPERA.pdf">Lista espera</a>
                    </li>
                    <?php
                }
               */ ?>

                <li class="nav-item">
                    <?php
                    echo anchor('http://www.atenas.edu.br/uniatenas/', 'Site UniAtenas', array('class' => "nav-link js-scroll-trigger"));
                    ?>
                </li>
            </ul>
        </div>
    </nav>
  <?php
  
  if ($idCampus == 1) {
    $fundo ='fundoparacatu';
  } elseif ($idCampus == 2) {
    $fundo ='fundopassos';
  } elseif ($idCampus == 3) {
    $fundo ='fundosetelagoas';
  }elseif ($idCampus == 6) {
    $fundo ='fundosetelagoas';
  }else{
    $fundo='';
  }
  ?>
    <div class = "container-fluid p-0 <?php echo $fundo; ?>">

        <section class = "resume-section p-3 p-lg-5 d-flex flex-column vestibular" id = "consulta">
            <div class = "my-auto">
                <h3 class = "mb-5">Vestibular Tradicional Medicina - <?php echo $campus . ' - ' . $local;
                    ?></h3>
                <div class="subheading mb-3">Resultado</div>
                <div id="retornoResultado" ></div>
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif
                ?>


                <div class="col-md-12">

                    <div class="form-group">
                        <label class="" for="textinput">Digite seu CPF ou seu número de inscrição: --</label>
                        
                        <?php echo form_open("vestibular/buscaResultado" ) ?>

                            <input id="inputDataVest" name="inputDataVest" onkeypress="return onlynumber();" maxlength="11" type="text"  placeholder="Apenas Números..." class="form-control input-lg" required="required" />
                            <?php //echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => 'Titulo'), set_value('name', $listagem->nameVestibular));?>


                            <input type="submit" id="btnDataVest"  value="Consultar Resultado Paracatu" name="btnDataVest" class="btn btn-success btn-lg">
                        <?php ///echo form_submit('enviar', 'enviar', array('class' => 'btns ','type'=>'button')); ?>
                        


                        <br/>
                        <?php
                        
                        if ($idCampus == 1) {
                            ?>
                            
                            <?php
                        } elseif ($idCampus == 2) {
                            ?>
                            <input type="button" id="btnDataVest2"  value="Consultar Resultado Passos" name="btnDataVest" class="btn btn-success btn-lg">
                            <?php
                        } elseif ($idCampus == 3) {
                            ?>
                            <input type="button" id="btnDataVest3"  value="Consultar Resultado Sete Lagoas" name="btnDataVest" class="btn btn-success btn-lg">
                            <?php
                        }
                        ?>
                        <?php echo form_close() ?>

                    </div>

                </div>


            </div>
        </section>

    </div>


</body>