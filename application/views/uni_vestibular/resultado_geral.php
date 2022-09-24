<?php
/*if ($situacaoVestibular->idSituation != '4' or  $situacaoVestibular->idSituation !=5) {
    redirect('http://vestibular.uniatenas.edu.br');
}*/

?>
<style>
div input {
  margin: 0 auto;
}

.inputBusca {
  max-width: 300px;
  text-align: center;
}
</style>

<body id="page-top">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">

    <a class="navbar-brand js-scroll-trigger" href="#page-top">
      <span class="d-block d-lg-none"><?php echo $campus->name;?></span>
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
          <a class="nav-link js-scroll-trigger" href="http://www.atenas.edu.br/uniatenas/Vestibular/inicio">Consulta
            <?php echo $situacaoVestibular->vestibularSituation; ?> </a>
        </li>
        <?php
            if (!empty($fileListaAprovados) and $situacaoVestibular->idSituation ==5) {
            foreach($fileListaAprovados as $listaAprovados)
              {?>

        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="<?php echo  $listaAprovados->files; ?>" target="_blank">
            <?php echo $listaAprovados->name;?>
          </a>
        </li>
        <?php
              }
            }
            if (!empty($fileListaEspera) and $situacaoVestibular->idSituation ==5) {
              foreach($fileListaEspera as $listaEspera)
              {
                ?>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="<?php echo $listaEspera->files; ?>" target="_blank">
            <?php echo $listaEspera->name;?>
          </a>
        </li>
        <?php
            }
            }
            ?>
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
    $fundo = 'fundoparacatu';
    $campusBuscaBanco = 'paracatu';
} elseif ($idCampus == 3) {
    $campusBuscaBanco = 'passos';
    $fundo = 'fundopassos';
} elseif ($idCampus == 2) {
    $fundo = 'fundosetelagoas';
    $campusBuscaBanco = 'setelagoas';  
}elseif ($idCampus == 6) {
    $fundo = 'fundovalenca';
    $campusBuscaBanco = 'valenca';  
}elseif ($idCampus == 7) {
    $fundo = 'fundosorriso';
    $campusBuscaBanco = 'sorriso';  
}elseif ($idCampus == 8) {
  $fundo = 'fundoportoseguro';
  $campusBuscaBanco = 'sorriso';  
} else {
    $fundo = '';
}

?>
  <div class="container-fluid p-0 <?php echo $fundo; ?>">

    <section class="resume-section p-3 p-lg-5 d-flex flex-column vestibular" id="consulta">
      <div class="my-auto">
        <h3 class="mb-5">Vestibular Tradicional e Nota do ENEM - Medicina 2022 <br />
          <?php echo $campus->name . ' - ' . $campus->city;
                ?></h3>
        <?php
            if ($resultadosOficiais !== 0) {
                ?>
        <div class="subheading mb-3">
          <!-- <span class="text-center">Resultado <?php echo $situacaoVestibular->vestibularSituation; ?></span> -->
          <span class="text-center">Divulgação do Resultado Final </span>
        </div>
        <?php
            }
            ?>
        <div id="retornoResultado"></div>
        <div class="col-md-12">
          <div class="text-center">
            <?php
            
                    if ($resultadosOficiais !== 0) {
                        ?>
            <?php

                        if ($msg = getMsg()):
                            echo $msg;
                        endif;
                        ?>
            <?php
                        echo form_open('Vestibular/resultado_geral/');
                        ?>

            <label class="" for="textinput">Digite seu CPF ou seu número de inscrição:</label>

            <!--input id="inputDataVest" name="inputDataVest" onkeypress="return onlynumber();" maxlength="11"
                               type="text" placeholder="Apenas Números..." class="form-control input-lg"
                               required="required"/-->

            <br />
            <div>
              <?php
                            echo form_input(array('name' => 'inputDataVest', 'class' => 'inputBusca form-control text-center', 'placeholder' => 'Apenas números'), set_value(''), 'autocomplete="off" maxlength="11" onkeypress="return isNumber(event)"');
                            ?>
            </div>
            <br />
            <?php
                        echo form_submit(array('class' => 'btn btn-info btn-lg', 'value' => 'Consultar informações', 'target="_blank"'));
                        ?>
            <!--input type="button" id="btnDataVest"
                               value="Consultar Resultado -  <?php echo $campus->city . ' (MG)'; ?>" name="btnDataVest"
                               class="btn btn-info btn-lg"-->
            <input type="hidden" id="btnDataVestCampus" value="<?php echo $campusBuscaBanco; ?>"
              name="btnDataVestCampus" class="btn btn-info btn-lg">

            <?php
                        echo form_hidden('actionQuery', 'actionQuery');
                        echo form_hidden('typeSearch', $acaoVestibular);
                        echo form_hidden('campus', $campus->id);
                        echo form_hidden('idCampus', $campus->id);


                        echo form_close();
                    } else {
                        ?>
            <span class="alert alert-warning">Os resultados ainda não estão disponíveis!</span>
            <?php

                    }
                    ?>
          </div>

        </div>


      </div>
    </section>

  </div>


</body>