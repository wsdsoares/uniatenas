<!DOCTYPE html>
<html>
<?php
$this->load->view('templates/elements/headPrincipal');


if ($dados['campus']->id == 1) {
    $localCampus = "paracatu";
    $backgdroundPrincipal = "background-paracatu";
    $slogam = " <span>Centro Universitário Atenas</span>";
} elseif ($dados['campus']->id == 2) {
    $backgdroundPrincipal = "background-setelagoas";
    $localCampus = "setelagoas";
    $slogam = " <span>Faculdade Atenas</span>";
} elseif ($dados['campus']->id == 3) {
    $localCampus = "passos";
    $backgdroundPrincipal = "background-passos";
    $slogam = " <span>Faculdade Atenas</span>";
}elseif ($dados['campus']->id == 6) {
    $localCampus = "valenca";
    $backgdroundPrincipal = "background-valenca";
    $slogam = " <span>Faculdade Atenas</span>";
}elseif ($dados['campus']->id == 7) {
    $localCampus = "Sorriso - MT";
    $backgdroundPrincipal = "background-sorriso";
    $slogam = " <span>Faculdade Atenas</span>";
}
?>

<body class="<?php echo $backgdroundPrincipal; ?>">

  <div>
    <div class="img">
      <?php
        echo anchor('atenas', '
                    <img src="' . base_url('assets/images/aprincipal/tocha.png') . '" class="img-responsive"/>
                ');
        ?>
    </div>
    <div class="slogam">
      <?php
        echo $slogam . ' <br/>'.$localCampus;
        ?>
    </div>
    <style>
    .successPrincipal {
      border-color: #4CAF50;
      color: #000;
      background-color: rgba(255, 255, 255, 0.7);
      font-size: 10px;
      font-weight: bolder;
    }

    .successPrincipal:hover {
      background-color: #4CAF50;
      color: white;
    }
    </style>
    <div class="container">
      <div class="homeInicio">
        <?php
            echo anchor('atenas', '
                    <span class="glyphicon glyphicon-credit-card"></span> INÍCIO ', array('class' => "btn successPrincipal"));
            ?>
      </div>
    </div>
    <style>
    main i {
      margin-right: 10px;
    }

    main {
      text-align: center;
      margin: 20px 0;
      padding: 10px;
    }

    main div {
      color: white;
      padding: 15px;
      width: 150px;
      margin: 5px;
      text-align: center;
    }


    main a {
      text-decoration: none;
      background: #333;
      border-radius: 5px;
      padding: 3px 8px;
      margin: 0 5px 0 5px;
    }

    main .btn-vestibular-odontologia {
      background-color: #e6b736;

    }

    main .btn-vestibular-direito {
      background-color: #FF4500;

    }

    main .btn-vestibular-enfermagem {
      background-color: #FF8C00;
    }

    main .btn-bolsaAtenas {
      background-color: #FF4500;
    }

    main .btn-gabarito {
      background-color: #1e4592;
    }

    main .btn-tipos {
      background: #6f8ec8;
    }

    main .btn-process-enem-med {
      background-color: #e6b736;
      color: #0c0c0c;
    }

    main .btn-contatos {
      background-color: #e6b736;
      color: #0c0c0c;
    }

    main .btn-vestibular-ead {
      background-color: #1e4592;
    }

    main .btn-vestibular-agendado {
      background-color: #004f5a;
    }

    main .btn-vesti-trad-medi {
      background-color: #FFF;
      color: #0c0c0c;
    }

    main .btn-huna {
      background-color: #FFF;
      color: #0c0c0c;
    }

    main .btn-vestibular-med {
      background-color: #f05f22;
    }

    main .btn-institucional,
    main .btn-portalprinc,
    main .btn-espaco-eventos,
    main .btn-process-enem-med {
      color: #000;
    }

    main .btn-institucional {
      background: #65933e;
    }

    main .btn-portalprinc {
      background: #6f8ec8;
    }

    main .btn-espaco-eventos {
      background: #E0FFFF;

    }

    main .btn-espaco-prevest {
      background: #ff0000;
    }

    main .btn-pos-graduacao {
      background: #a79409;
    }

    main .btn-vestibular-ead,
    main .btn-vestibular-agendado,
    main .btn-vestibular-med,
    main .btn-pos-graduacao,
    main .btn-vestibular-odontologia,
    main .btn-espaco-prevest,
    main .btn-vestibular-direito,
    main .btn-vestibular-enfermagem,
    main .btn-bolsaAtenas,
    main .btn-gabarito,
    main .btn-tipos {
      color: #fff;
    }

    main .btn-vestibular-ead,
    main .btn-vestibular-agendado,
    main .btn-vestibular-med,
    main .btn-institucional,
    main .btn-portalprinc,
    main .btn-pos-graduacao,
    main .btn-espaco-eventos,
    main .btn-huna,
    main .btn-vestibular-odontologia,
    main .btn-contatos,
    main .btn-espaco-prevest,
    main .btn-vesti-trad-medi,
    main .btn-process-enem-med,
    main .btn-vestibular-direito,
    main .btn-vestibular-enfermagem,
    main .btn-bolsaAtenas,
    main .btn-gabarito,
    main .btn-tipos {
      border: 1px solid #f1f1f1;
      font-weight: bold;
      text-align: center;
      font-family: Montserrat;
      border-radius: 10px;
      padding: 16px;
    }

    .inline-block-centralizado {
      text-align: center;
    }

    .inline-block-centralizado div {
      display: inline;
      text-align: center;
    }

    @media screen and (max-width: 990px) {
      .inline-block-centralizado div {
        display: inline-flex;
        height: 125px;
      }

      main {
        text-align: center;
        margin: -5px -5px;
        padding: 0;
      }

      .optionssite {
        min-width: 145px;
        height: 98px !important;
      }

      .successPrincipal {
        font-size: 12px;
        margin-top: 10px;
      }
    }
    </style>
    <div class="container">
      <div class="row">
        <main class="inline-block-centralizado">
          <?php
                if ($dados['campus']->id == 6) {
                    ?>
          <div class="optionssite">
            <?php
                        $link = 'http://www.atenas.edu.br/uniatenas/assets/vestibularenem/LISTADEAPROVADOSENEM.pdf';
                        echo anchor( 'http://www.atenas.edu.br/uniatenas/assets/vestibularenem/LISTADEAPROVADOSENEM.pdf', '<i class="fas fa-stethoscope"></i>Lista de aprovados', array('class' => 'btn-vesti-trad-medi'));
                        ?>
          </div>
          <?php
                }
                ?>
          <?php
                if ($dados['campus']->id == 6) {
                    ?>
          <div class="optionssite">
            <?php
                         $link = 'http://www.atenas.edu.br/uniatenas/assets/vestibularenem/LISTADEESPERAENEM.pdf';
                        echo anchor('http://www.atenas.edu.br/uniatenas/assets/vestibularenem/LISTADEESPERAENEM.pdf', '<i class="fas fa-book"></i>Lista de espera', array('class' => 'btn-process-enem-med'));
                        ?>
          </div>
          <?php
                }
                ?>
          <?php
                if ($dados['campus']->id == 7) {
                    ?>
          <div class="optionssite">
            <?php
                       
                        echo anchor( 'http://www.atenas.edu.br/uniatenas/assets/vestibularsorriso/LISTA_DE_APROVADOS_-NOTA_DO_ENEM-SORRISO2022.pdf', '<i class="fas fa-stethoscope"></i>Lista de aprovados', array('class' => 'btn-vesti-trad-medi'));
                        ?>
          </div>
          <?php
                }
                ?>
          <?php
                if ($dados['campus']->id == 7) {
                    ?>
          <div class="optionssite">
            <?php
                        echo anchor('http://www.atenas.edu.br/uniatenas/assets/vestibularsorriso/LISTA_DE_ESPERA_-NOTA_DO_ENEM-SORRISO2022.pdf', '<i class="fas fa-book"></i>Lista de espera', array('class' => 'btn-process-enem-med'));
                        ?>
          </div>
          <?php
                }
                ?>
        </main>

      </div>

    </div>
    <div class="container">
      <div class="socialMediaCampus">
        <div class="box" style=" text-align: center">
          <a href="https://www.facebook.com/<?php echo $dados['campus']->facebook; ?>" target="_blank">
            <img src="<?php echo base_url('assets/images/@principal/images/facebook2.png') ?>"
              class="iconesocial img-responsive" />
          </a>
          <a href="https://www.instagram.com/<?php echo $dados['campus']->instagram; ?>" target="_blank">
            <img src="<?php echo base_url('assets/images/@principal/images/instagram2.png') ?>"
              class="iconesocial img-responsive" />
          </a>

          <a href="https://www.youtube.com/<?php echo $dados['campus']->youtube; ?>" target="_blank">
            <img src="<?php echo base_url('assets/images/@principal/images/youtube2.png') ?>"
              class="iconesocial img-responsive" />
          </a>

        </div>
      </div>
    </div>

    <div class="container">
      <footer>
        www.atenas.edu.br<br>
        <?php echo $dados['campus']->phone; ?>
      </footer>
    </div>
  </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

</html>