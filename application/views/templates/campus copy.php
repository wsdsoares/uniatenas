<!DOCTYPE html>
<html>
<?php
$this->load->view('templates/elements/headPrincipal');

// if ($dados['campus']->id == 1) {
//     $dados['campus']->shurtName = "paracatu";
//     $backgdroundPrincipal = "background-paracatu";
// } elseif ($dados['campus']->id == 2) {
//     $backgdroundPrincipal = "background-setelagoas";
//     $dados['campus']->shurtName = "setelagoas";
// } elseif ($dados['campus']->id == 3) {
//     $dados['campus']->shurtName = "passos";
//     $backgdroundPrincipal = "background-passos";
// } elseif ($dados['campus']->id == 6) {
//     $dados['campus']->shurtName = "valenca";
//     $backgdroundPrincipal = "background-valenca";
// } elseif ($dados['campus']->id == 7) {
//     $dados['campus']->shurtName = "sorriso";
//     $backgdroundPrincipal = "background-sorriso";
// }
?>

<body class="<?php echo 'background-' . $dados['campus']->shurtName; ?>">

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
            $slogam = $dados['campus']->name . ' - ' . $dados['campus']->city . '(' . $dados['campus']->uf . ')';
            echo $slogam;
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

    main .btn-vestibular-passos {
      background-color: #B22222;
    }

    main .btn-vestibular-enfermagem {
      background-color: #FF8C00;
    }

    main .btn-eadFren {
      background-color: #C87602;
    }

    main .btn-vestibular-direito {
      background-color: #FF4500;

    }

    main .btn-process-enem-med {
      background-color: #e6b736;
      color: #0c0c0c;
    }

    main .btn-bolsaAtenas {
      background-color: #FF4500;
    }

    main .btn-bolsaAtenasresult {
      background-color: #B22222;
    }

    main .btn-tipos {
      background: #6f8ec8;
    }

    main .btn-gabarito {
      background-color: #1e4592;
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
    main .btn-tipos,
    main .btn-gabarito,
    main .btn-bolsaAtenasresult,
    main .btn-eadFren,
    main .btn-vestibular-passos {
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
    main .btn-tipos,
    main .btn-gabarito,
    main .btn-bolsaAtenasresult,
    main .btn-eadFren,
    main .btn-vestibular-passos {
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
                    if ($dados['campus']->id == 1 or $dados['campus']->id == 2) {
                    ?>
          <div class="options">
            <?php
                            echo anchor('graduacao/cursos/' . $dados['campus']->shurtName, '<i class="fas fa-graduation-cap"></i><span>Vestibular Agendado</span>', array('class' => 'btn-vestibular-agendado'));
                            ?>
          </div>
          <?php
                    }
                    if ($dados['campus']->id == 1 or $dados['campus']->id == 2 or $dados['campus']->id == 3) {
                    ?>
          <div class="options">
            <?php
                            echo anchor('graduacao/ead/' . $dados['campus']->shurtName, '<i class="fas fa-mouse-pointer"></i><span>Vestibular EaD</span>', array('class' => 'btn-vestibular-ead'));
                            ?>
          </div>
          <?php
                    }
                    ?>

          <?php
                    if ($dados['campus']->id == 6) {
                    ?>
          <div class="options    ">
            <?php
                            echo anchor('http://177.69.195.21:8080/prova/entrar', '<i class="fas fa-mouse-pointer"></i><span>Vestibular Online</span>', array('class' => 'btn-bolsaAtenas'));
                            ?>
          </div>
          <?php
                    }
                    ?>

          <?php
                    // Trocar h # do Acnhor abaixo e colocar o link do vestibular de sorriso
                    if ($dados['campus']->id == 7) {
                        // $linkVestibular = "http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=89#/es/informacoes";
                        // $linkEnen = "http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=90#/es/informacoes";
                        // $bolsaatenas = "http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=92#/es/informacoes";
                        
                        $linkEnen = "http://www.atenas.edu.br/uniatenas/atenas/resultadoEnem/sorriso";
                        $bolsaatenas = "http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=92#/es/informacoes";

                    ?>

          <div class="options">
            <?php
                            echo anchor('Vestibular/inicio', '<i class="fas fa-mouse-pointer"></i><span>Resultado - Vestibular Tradicional</span>', array('class' => 'btn-bolsaAtenas'));
                            ?>
          </div>
          <div class="options">
            <?php
                            echo anchor($linkEnen, '<i class="fas fa-book"></i>Resultado Vestibular (Nota do ENEM) - Medicina', array('class' => 'btn-process-enem-med'));
                            //echo anchor($linkEnen, '<i class="fas fa-book"></i>Vestibular (Nota do ENEM)', array('class' => 'btn-process-enem-med'));
                            ?>
          </div>

          <div class="options">
            <?php
                            echo anchor($bolsaatenas, '<i class="fas fa-book"></i>Bolsa Atenas', array('class' => 'btn-vestibular-agendado'));
                            ?>
          </div>
          <?php
                    }
                    ?>


          <?php
                    if ($dados['campus']->id == 6) {
                    ?>
          <div class="options">
            <?php
                            echo anchor('http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=85#/es/informacoes', '<i class="fas fa-book"></i><span>Bolsa Atenas</span>', array('class' => 'btn-bolsaAtenasresult'));
                            ?>
          </div>
          <?php
                    }
                    ?>
          <?php
                    if ($dados['campus']->id == 6) {
                    ?>
          <div class="options">
            <?php
                            echo anchor('http://www.atenas.edu.br/uniatenas/assets/Tipos/GabaritoValenca.pdf', '<i class="fas fa-user-check"></i><span>Gabarito</span>', array('class' => 'btn-gabarito'));
                            ?>
          </div>
          <?php
                    }
                    ?>

          <?php
                    if ($dados['campus']->id == 6) {
                    ?>
          <div class="options">
            <?php
                            echo anchor('http://atenas.edu.br/uniatenas/assets/temps/temp_comunicado_calenca.pdf', '<i class="fas fa-mouse-pointer"></i><span>Comunicado: Retorno as Aulas</span>', array('class' => 'btn-tipos'));
                            ?>
          </div>
          <?php
                    }


                    ?>






          <?php
                    if ($dados['campus']->id == 1 or $dados['campus']->id == 2 or $dados['campus']->id == 3) {
                    ?>
          <!--div class="options">
                        <?php
                        $urlVestibular = '';
                        if ($dados['campus']->id == 1) {
                            //$urlVestibular = 'http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=58#/es/informacoes';
                            $urlVestibular = 'http://www.atenas.edu.br/vestibular/vestibular/inicio';
                        } else if ($dados['campus']->id == 2) {
                            //$urlVestibular ='http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=59#/es/informacoes';
                            $urlVestibular = 'http://www.atenas.edu.br/vestibular/vestibular/inicio';
                        } else if ($dados['campus']->id == 3) {
                            //$urlVestibular = 'http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=60#/es/informacoes';
                            $urlVestibular = 'http://www.atenas.edu.br/vestibular/vestibular/inicio';
                        }



                        echo anchor($urlVestibular, '<i class="fas fa-stethoscope"></i><span>Vestibular Medicina</span>', array('class' => 'btn-vestibular-med'));
                        ?>
                    </div-->



          <?php
                    }
                    if ($dados['campus']->id == 3 or $dados['campus']->id == 2) {
                    ?>
          <div class="options">
            <?php
                            if ($dados['campus']->id == 3) {
                                echo anchor('graduacao/presencial/passos/51/' . $dados['campus']->shurtName, '<i class="fas fa-tooth"></i><span>Vestibular Odontologia</span>', array('class' => 'btn-vestibular-odontologia'));
                            } else {
                                echo anchor('graduacao/presencial/setelagoas/52/' . $dados['campus']->shurtName, '<i class="fas fa-tooth"></i><span>Vestibular Odontologia</span>', array('class' => 'btn-vestibular-odontologia'));
                            }
                            ?>
          </div>
          <?php
                        if ($dados['campus']->id == 2) {
                        ?>
          <div class="options">
            <?php
                                echo anchor('http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=73#/es/informacoes', '<i class="fas fa-stethoscope"></i><span>Vestibular Medicina 2022</span>', array('class' => 'btn-vestibular-passos'));
                                ?>
          </div>

          <?php
                        }
                        ?>


          <?php
                    }
                    if ($dados['campus']->id == 1) {
                    ?>
          <!--div class="options">
                                <?php
                                echo anchor('posgraduacao/inicio/' . $dados['campus']->shurtName, '<i class="fas fa-book"></i><span>Pós-Graduação</span>', array('class' => 'btn-pos-graduacao'));
                                ?>
                            </div-->
          <?php
                    }
                    ?>
        </main>
        <main class="inline-block-centralizado">
          <?php

                    if ($dados['campus']->id == 6) {
                    ?>
          <div class="options">
            <?php
                            echo anchor('http://atenas.edu.br/uniatenas/assets/temps/temp_calendario_valenca_2022.pdf', '<i class="fas fa-mouse-pointer"></i><span>Calendário Escolar</span>', array('class' => 'btn-tipos'));
                            ?>
          </div>
          <?php
                    }
                    if ($dados['campus']->id == 6) {
                    ?>
          <div class="optionssite">
            <?php
                            $link = 'http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=69#/es/informacoes';
                            echo anchor('http://www.atenas.edu.br/uniatenas/Vestibular/inicio', '<i class="fas fa-stethoscope"></i>Resultado vestibular - Tradicional', array('class' => 'btn-vesti-trad-medi'));
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
                            $link = 'http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=70#/es/informacoes';
                            echo anchor('http://www.atenas.edu.br/uniatenas/atenas/resultadoEnem/valenca', '<i class="fas fa-book"></i>Resultado vestibular ENEM - Medicina', array('class' => 'btn-process-enem-med'));
                            ?>
          </div>
          <?php
                    }
                    ?>



          <?php
                    if ($dados['campus']->id == 1 or $dados['campus']->id == 2 or $dados['campus']->id == 3) {
                    ?>
          <div class="optionssite">
            <?php
                            echo anchor('site/inicio/' . $dados['campus']->shurtName, '<i class="fas fa-home"></i>Site Institucional', array('class' => 'btn-institucional'));
                            ?>
          </div>
          <?php
                    }
                    ?>

          <?php
                    if ($dados['campus']->id == 2) {
                    ?>
          <div class="options">
            <?php
                            echo anchor('graduacao/presencial/setelagoas/53', '<i class="fas fa-gavel"></i><span>Vestibular Direito</span>', array('class' => 'btn-vestibular-direito'));
                            ?>
          </div>

          <?php
                    }
                    ?>


          <?php
                    if ($dados['campus']->id == 3) {
                    ?>
          <div class="options">
            <?php
                            echo anchor('graduacao/presencial/passos/57', '<i class="fas fa-gavel"></i><span>Vestibular Direito</span>', array('class' => 'btn-vestibular-direito'));
                            ?>
          </div>

          <?php
                    }
                    ?>

          <?php
                    if ($dados['campus']->id == 2) {
                    ?>
          <div class="options">
            <?php
                            echo anchor('graduacao/presencial/setelagoas/54', '<i class="fas fa-stethoscope"></i><span>Vestibular Enfermagem</span>', array('class' => 'btn-vestibular-enfermagem'));
                            ?>
          </div>

          <?php
                    }
                    ?>

          <?php
                    if ($dados['campus']->id == 3) {
                    ?>
          <div class="options">
            <?php
                            echo anchor('http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=74#/es/informacoes', '<i class="fas fa-stethoscope"></i><span>Vestibular Medicina 2022</span>', array('class' => 'btn-vestibular-passos'));
                            ?>
          </div>

          <?php
                    }
                    ?>
          <?php
                    if ($dados['campus']->id == 1) {
                    ?>
          <div class="options">
            <?php
                            echo anchor('http://177.69.195.4/FrameHTML/web/app/Edu/PortalProcessoSeletivo/?c=1&f=1&ps=72#/es/informacoes', '<i class="fas fa-stethoscope"></i><span>Vestibular Medicina 2022</span>', array('class' => 'btn-vestibular-passos'));
                            ?>
          </div>

          <?php
                    }
                    ?>
          <?php
                    if ($dados['campus']->id == 1) {
                    ?>
          <div class="optionssite">
            <?php
                            echo anchor('Huna/inicio/' . $dados['campus']->shurtName, '<i class="fas fa-clinic-medical"></i>HUNA', array('class' => 'btn-huna'));
                            ?>
          </div>
          <?php
                    }
                    ?>
          <?php
                    if ($dados['campus']->id == 1 or $dados['campus']->id == 2 or $dados['campus']->id == 3 or $dados['campus']->id == 6) {
                    ?>
          <div class="optionssite">
            <?php
                            echo anchor('PortalAlunos/portal/' . $dados['campus']->shurtName, '<i class="fas fa-user"></i>Portais', array('class' => 'btn-portalprinc'));
                            ?>
          </div>
          <?php
                    }
                    ?>

          <?php
                    if ($dados['campus']->id == 6) {
                    ?>
          <!--div class="optionssite">
                        <?php
                        echo anchor('https://faculdadeatenas.blackboard.com/', '<i class="fas fa-user"></i>Portal EaD', array('class' => 'btn-eadFren'));
                        ?>
                    </div-->
          <?php
                    }
                    ?>


          <?php
                    if ($dados['campus']->id == 1) {
                    ?>

          <div class="options">
            <?php
                            echo anchor('site/espaco_eventos/' . $dados['campus']->shurtName, '<i class="fas fa-home"></i>Espaço Eventos', array('class' => 'btn-espaco-eventos'));
                            ?>
          </div>
          <?php
                    }
                    ?>
        </main>

        <main class="inline-block-centralizado">
          <?php

                    if ($dados['campus']->id == 6) {
                    ?>
          <div class="options">
            <?php
                            echo anchor('http://atenas.edu.br/uniatenas/assets/temps/temp_comunicado_veteranos_valenca.pdf', '<i class="fas fa-mouse-pointer"></i><span>Comunicado aos Veteranos</span>', array('class' => 'btn-bolsaAtenasresult'));
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