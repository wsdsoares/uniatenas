<?php
$uricampus = $this->uri->segment(3);
?>

<div class="single_banner">
  <div class="container">
    <div class="single_banner_inner">
      <img src="<?php echo base_url($dadosCurso['curso']->capa); ?>" alt="">
      <div class="single_caption">
        <h1>
          <?php echo $dadosCurso['curso']->nameCourse . ' <small> (' . $dadosCurso['curso']->cityCampus . ')</small>'; ?>
        </h1>
        <h2>
          <?php echo '<span>' . $dadosCurso['curso']->nameCampus . '</span> - <strong>' . $dadosCurso['tema'] . "</strong>"; ?>
        </h2>
      </div>
    </div>
  </div>
</div>
<style>
  .btn-default-course {
    margin-top: 30px;
    margin-right: 0px;
    margin-bottom: 30px;
    margin-left: 0px;
    padding: 6px !important;
    font-size: 12px;
    text-transform: uppercase;
    text-decoration: none !important;
    padding: 1.5% 4.5%;
    color: #fff !important;
    background-color: #004775 !important;
    border: 2px solid #004775;
    border-radius: 0;
    font-weight: 700;
    letter-spacing: 1.4px;
  }

  .row.itensGradeCurricular {
    margin-bottom: 3rem;
  }
</style>


<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
        <div class="btn-group" role="group">
          <a type="button" href="#about" class="btn btn-default-course" data-toggle="tab">
            <span class="glyphicon glyphicon-education" aria-hidden="true"></span>
            <div class="hidden-xs">O Curso</div>
          </a>
        </div>
        <?php
        if (!empty($dadosCurso['cursoPeriodos'])) {
          ?>
          <div class="btn-group" role="group">
            <a type="button" href="#services" class="btn btn-default-course" data-toggle="tab">
              <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>
              <div class="hidden-xs">Grade Curricular</div>
            </a>
          </div>
          <?php
        }
        ?>
        <div class="btn-group" role="group">
          <a type="button" href="#portfolio" class="btn btn-default-course" data-toggle="tab">
            <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
            <div class="hidden-xs">Infraestrutura do curso</div>
          </a>
        </div>
        <div class="btn-group" role="group">
          <a type="button" href="#courseGallery" class="btn btn-default-course" data-toggle="tab">
            <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
            <div class="hidden-xs">Fotos</div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<link href="<?php echo base_url('assets/Regna/'); ?>lib/animate/animate.min.css" rel="stylesheet">
<link href="<?php echo base_url('assets/Regna/'); ?>css/style.css" rel="stylesheet">
<div class="container">
  <?php
  if (isset($dadosCurso['informacoesCurso']->link_vestibular) and $dadosCurso['informacoesCurso']->link_vestibular != '') {
    ?>
    <a href="<?php echo $dadosCurso['informacoesCurso']->link_vestibular ?>" target="_blank" class="">
      <img src="<?= base_url('assets/images/financing/inscreva-se-geral.jpg') ?>" class="img-fluid">
    </a>
    <?php
  }
  ?>
</div>
<section id="about">
  <div class="container">
    <div class="row about-container">
      <div class="col-lg-12 content order-lg-1 order-2 dados_gerais">
        <h2 class="title">Sobre o curso de
          <?php echo $dadosCurso['curso']->nameCourse; ?>
        </h2>
        <?php
        echo to_html(substr($dadosCurso['informacoesCurso']->description, 0));
        ?>
      </div>
      <div class="col-sm-12">
        <style>
          ul li {
            list-style-type: circle;
          }
        </style>
        <h3>Em quais áreas posso atuar?</h3>
        <div class="icon-box wow fadeInUp">
          <ul>
            <div class="col-sm-5">
              <h4 class="title">
                <?php
                $string = $dadosCurso['informacoesCurso']->actuation;
                $dadosC = explode('<li>', $string);
                $qtdeAction = count($dadosC);

                for ($i = 0; $i < ($qtdeAction / 2); $i++) {
                  echo '<li>';
                  echo "<p class='noJustify'>$dadosC[$i]</p>";
                  echo '</li>';
                }
                //echo $dadosCurso['informacoesCurso']->actuation;
                ?>
              </h4>
            </div>
            <div class="col-sm-5">
              <h4 class="title">
                <?php
                for ($i; $i < $qtdeAction; $i++) {
                  echo '<li>';
                  echo "<p class='noJustify'>$dadosC[$i]</p>";
                  echo '</li>';
                }
                ?>
              </h4>
            </div>
          </ul>
        </div>
        <?php
        if (isset($dadosCurso['informacoesCurso']->link_vestibular) and $dadosCurso['informacoesCurso']->link_vestibular != '') {
          ?>
          <div class="col-sm-12 col-md-12 text-center">
            <a href="<?php echo $dadosCurso['informacoesCurso']->link_vestibular ?>" target="_blank"
              class="btn btns btn-lg">
              VESTIBULAR ONLINE
            </a>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
</section>


<!--==========================
  Services Section
============================-->
<section id="services">
  <div class="container wow fadeIn">
    <?php
    if (!empty($dadosCurso['cursoPeriodos'])) {
      ?>
      <div class="section-header">
        <h3 class="section-title">Grade Curricular</h3>
        <p class="section-description">Visualize abaixo, os conteúdos que serão estudados no curso.</p>
      </div>
      <?php
    } else {
      ?>

      <div class="section-header">
        <h3 class="section-title"></h3>
        <p class="section-description"></p>
      </div>
      <?php
    }
    ?>

    <div class="row itensGradeCurricular">
      <div class="col-sm-12">
        <?php
        $i = 0;
        foreach ($dadosCurso['cursoPeriodos'] as $periodos) {
          ?>
          <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.<?php echo $i; ?>s">
            <div class="box" style="background:rgba(211,211,211,0.3);min-height:280px;margin-bottom:3rem;">

              <h4 class="title"><i class="fa fa-book"></i>
                <?php
                if ($dadosCurso['informacoesCurso']->id == 8) {
                  if ($periodos->period == 9 or $periodos->period == 11) {
                    if ($periodos->period == 9) {
                      echo "9º e 10";
                    } elseif ($periodos->period == 11) {
                      echo "11º e 12";
                    }
                  } else {
                    echo $periodos->period;
                  }
                } else {
                  echo $periodos->period;
                }
                ?>º Período
              </h4>
              <p>
                <?php
                foreach ($dadosCurso['gradeCurricular'] as $disciplina)
                  if ($periodos->period == $disciplina->period) {
                    ?>
                  <p>
                    <i class="fas fa-caret-right"></i>
                    <?php
                    echo $disciplina->discipline;
                    ?>
                  </p>
                  <?php
                  }
                ?>

              </p>
              <?php
              if (isset($dadosCurso['informacoesCurso']->link_vestibular) and $dadosCurso['informacoesCurso']->link_vestibular != '') {
                ?>
                <div class="col-sm-12 col-md-12 text-center">
                  <a href="<?php echo $dadosCurso['informacoesCurso']->link_vestibular ?>" target="_blank"
                    class="btn btns btn-lg">
                    VESTIBULAR ONLINE
                  </a>
                </div>
                <?php
              }
              ?>

            </div>
          </div>
          <?php
          $i = $i + 2;
        }
        ?>
      </div>
      <div class="col-sm-12">
        <?php
        if ($dados['dadosCurso']['curso']->idCourseCampus == 51) {
          ?>
          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
            <div class="boxcoordenador boxitens" style="height: 100px;">
              <div class="icon">
                <a href="http://www.atenas.edu.br/uniatenas/assets/temps/temp_Edital_Vestibular_Odontologia___PASSOS.pdf"
                  target="_blank"><i class="fas fa-file-alt"></i></a>
              </div>
              <h4 class="title">
                <a href="http://www.atenas.edu.br/uniatenas/assets/temps/temp_Edital_Vestibular_Odontologia___PASSOS.pdf"
                  target="_blank">Edital Vestibular Odontologia</a>
              </h4>
              <a href="http://www.atenas.edu.br/uniatenas/assets/temps/temp_Edital_Vestibular_Odontologia___PASSOS.pdf"
                target="_blank">
                <img src="<?php echo base_url('assets/images/icons/pdf.png'); ?>" />
              </a>
            </div>
          </div>
          <?php
        }
        ?>
        <?php
        if (
          !empty($dados['dadosCurso']['informacoesCurso']->filesGrid)
          and $dados['dadosCurso']['informacoesCurso']->matriz_visivel != NULL
          and $dados['dadosCurso']['informacoesCurso']->matriz_visivel != ''
        ) {
          ?>
          <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
            <div class="boxcoordenador boxitens" style="height: 100px;">
              <div class="icon">
                <a href="<?php echo base_url($dados['dadosCurso']['informacoesCurso']->filesGrid); ?>" target="_blank"><i
                    class="fas fa-file-alt"></i></a>
              </div>
              <h4 class="title">
                <a href="<?php echo base_url($dados['dadosCurso']['informacoesCurso']->filesGrid); ?>"
                  target="_blank">Arquivo - Grade Curricular</a>
              </h4>
              <a href="<?php echo base_url($dados['dadosCurso']['informacoesCurso']->filesGrid); ?>" target="_blank">
                <img src="<?php echo base_url('assets/images/icons/pdf.png'); ?>" />
              </a>
            </div>
          </div>
          <?php
        }
        ?>
        <div class="col-lg-3 col-md-6 wow fadeInUp text-center" data-wow-delay="0.6s">
          <div class="boxcoordenador boxitens">
            <div class="icon text-center">
              <i class="fas fa-gavel"></i>
            </div>

            <h4 class="title">
              Ato de Autorização / Reconhecimento</a>

            </h4>
            <?php
            if (isset($dados['dadosCurso']['informacoesCurso']->autorization)) {
              ?>
              <a href="<?php echo base_url($dados['dadosCurso']['informacoesCurso']->autorization); ?>" target="_blank">
                <img src="<?php echo base_url('assets/images/icons/pdf.png'); ?>" />
              </a>
              <?php
            }
            ?>
            <?php
            if (isset($dados['dadosCurso']['informacoesCurso']->recognition)) {
              ?>
              <a href="<?php echo ($dados['dadosCurso']['informacoesCurso']->recognition); ?>" target="_blank">
                <img src="<?php echo base_url('assets/images/icons/pdf.png'); ?>" />
              </a>
              <?php
            }
            ?>
          </div>
        </div>
        <?php
        // echo '<pre>';
        // //print_r($dados['dadosCurso']['dirigentes']);
        // echo '</pre>';
        foreach ($dados['dadosCurso']['dirigentes'] as $row) {

          ?>
          <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
            <div class="boxcoordenador boxitens">
              <div class="icon"><a><i class="fas fa-graduation-cap"></i></a></div>

              <h4 class="title">
                <?php echo $row->cargo; ?>
              </h4>
              <h4>
                <?php
                echo $row->nome;
                ?>

                <h4>
                  <?php
                  if (!empty($row->email) and $row->email != null) {
                    echo 'Email: ' . $row->email;
                  }
                  ?>
                </h4>
                <h4>
                  <?php
                  if (!empty($row->telefone) and $row->telefone != null) {
                    echo 'Telefone(s): ' . $row->telefone;
                  }
                  ?>
                </h4>
              </h4>

            </div>
          </div>
          <?php
        }
        ?>
        <?php
        if (isset($dadosCurso['informacoesCurso']->link_vestibular) and $dadosCurso['informacoesCurso']->link_vestibular != '') {
          ?>
          <div class="col-sm-12 col-md-12 text-center">
            <a href="<?php echo $dadosCurso['informacoesCurso']->link_vestibular ?>" target="_blank"
              class="btn btns btn-lg">
              VESTIBULAR ONLINE
            </a>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
</section>

<style>
  .carbox {
    min-height: 350px;
    display: block;
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    transition: box-shadow .25s;
  }

  .carbox:hover {
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }

  .img-carbox {
    width: 100%;
    height: 200px;
    border-top-left-radius: 2px;
    border-top-right-radius: 2px;
    display: block;
    overflow: hidden;
  }

  .img-carbox img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: all .25s ease;
  }

  .carbox-content {
    padding: 15px;
    text-align: left;
  }

  .carbox-title {
    margin-top: 0px;
    font-weight: 700;
    font-size: 8px;
  }

  .carbox-title a {
    color: #000;
    text-decoration: none !important;
  }

  .carbox-read-more {
    border-top: 1px solid #D4D4D4;
  }

  .carbox-read-more a {
    background-color: #13574b !important;
    border: 2px solid #13574b;
    color: #fff;
    text-decoration: none !important;
    padding: 10px;
    font-weight: 600;
    text-transform: uppercase
  }

  .carbox-read-more a:hover {
    background-color: #fff !important;
    border: 2px solid #13574b;
    color: #000;
    text-decoration: none !important;
    padding: 10px;
    font-weight: 600;
    text-transform: uppercase
  }

  .carbox h4 a {
    font-size: 13px;
  }

  p {
    margin: 0px;
    text-align: left !important;
  }
</style>

<section id="portfolio">
  <div class="container wow fadeInUp">
    <div class="section-header">
      <h3 class="section-title">Infraestrutura do Curso e Fotos</h3>
      <p class="section-description"></p>
    </div>

    <div class="row" id="portfolio-wrapper">
      <?php
      for ($i = 0; $i < count($dadosCurso['categoriaFotos']); $i++) {
        ?>

        <div class="col-lg-3">
          <div class="carbox">
            <?php
            echo anchor("graduacao/galeria_fotos/$uricampus/" . $dadosCurso['curso']->idCourseCampus . '/' . $dadosCurso['categoriaFotos'][$i]->idCategory, '
                            <img src="' . base_url($dadosCurso['categoriaFotos'][$i]->photoCategory) . '" />', array('class' => "img-carbox"));
            ?>
            <div class="carbox-content">
              <h4 class="carbox-title">
                <?php
                echo anchor("graduacao/galeria_fotos/$uricampus/" . $dadosCurso['curso']->idCourseCampus . '/' . $dadosCurso['categoriaFotos'][$i]->idCategory, $dadosCurso['categoriaFotos'][$i]->titleCategory);
                ?>
              </h4>
            </div>
            <div class="carbox-read-more">
              <?php
              echo anchor("graduacao/galeria_fotos/$uricampus/" . $dadosCurso['curso']->idCourseCampus . '/' . $dadosCurso['categoriaFotos'][$i]->idCategory, ' Ver mais...', array("class" => "btn btn-link btn-block"));
              ?>
            </div>
          </div>
        </div>

        <?php
      }
      ?>
    </div>
  </div>
</section>


<!--==========================
  Contact Section
============================--->
<?php
if (!empty($dadosCurso['fotosCurso'])) {
  ?>
<section id="courseGallery">
  <div class="container wow fadeInUp">
    <div class="section-header">
      <h3 class="section-title">Galeria de Fotos</h3>
      <p class="section-description">Abaixo, você pode visualizar algumas fotos de eventos, atividades e ações
        desenvolvidas pelo curso de <span class="SpanNameCourse"><strong>
            <?php echo $dadosCurso['curso']->nameCourse; ?>
          </strong></span>
      </p>
      <?php
      if (isset($dadosCurso['informacoesCurso']->link_vestibular) and $dadosCurso['informacoesCurso']->link_vestibular != '') {
        ?>
      <div class="col-sm-12 col-md-12 text-center">
        <a href="<?php echo $dadosCurso['informacoesCurso']->link_vestibular ?>" target="_blank"
          class="btn btns btn-lg">
          VESTIBULAR ONLINE
        </a>
      </div>
      <?php
      }
      ?>
    </div>
  </div>

  <div class="container wow fadeInUp mt-5">
    <div class="tab-pane fade in" id="tab4">
      <h3>Galeria de fotos do curso</h3>
      <div class="row">

        <?php
        foreach ($dadosCurso['fotosCurso'] as $foto) {
          ?>
        <div class="col-lg-3 col-sm-5 col-xs-12">
          <h5 class="text-center titlePhotosCourse">
            <?php
            echo $foto->title
              ?>

          </h5>
          <div class="flip-box">
            <div class="flip-box-inner">
              <div class="flip-box-front">
                <img class="img-responsive" src="<?php echo base_url($foto->files); ?>"
                  alt="<?php echo $foto->subtitle; ?>" />
              </div>
              <div class="flip-box-back">
                <h2>
                  <?php
                  echo $foto->title
                    ?>
                </h2>

              </div>
            </div>
          </div>
        </div>

        <?php
        }
        ?>
      </div>
      <br />
      <div class="col-xs-offset-4 col-xs-4" style="margin-bottom: 10px;">
        <div class="carbox-read-more">
          <?php
          echo anchor("graduacao/galeria_fotos_curso/$uricampus/" . $dadosCurso['curso']->idCourseCampus, ' Ver todas as fotos', array("class" => "btn btn-link btn-block"));
          ?>
        </div>
      </div>

      <style>
        /* The flip box container - set the width and height to whatever you want. We have added the border property to demonstrate that the flip itself goes out of the box on hover (remove perspective if you don't want the 3D effect */
        h5.titlePhotosCourse {
          font-size: 15px;
          color: #f4630b;
          padding-top: 5px;
          background: #f1f1f1;
          height: 50px;
        }

        .flip-box {
          background-color: transparent;
          /*width: 310px;*/
          min-height: 220px;
          border: 1px solid #f1f1f1;
          perspective: 1000px;
          /* Remove this if you don't want the 3D effect */
        }

        .flip-box img {
          text-align: center;
          max-height: 220px;
        }

        /* This container is needed to position the front and back side */
        .flip-box-inner {
          position: relative;
          width: 100%;
          height: 100%;
          transition: transform 0.8s;
          transform-style: preserve-3d;
        }

        /* Do an horizontal flip when you move the mouse over the flip box container */
        .flip-box:hover .flip-box-inner {
          transform: rotateY(180deg);
        }

        /* Position the front and back side */
        .flip-box-front,
        .flip-box-back {
          position: absolute;
          width: 100%;
          height: 100%;
          backface-visibility: hidden;
        }

        /* Style the front side (fallback if image is missing) */
        .flip-box-front {
          background-color: #bbb;
          color: black;
        }

        /* Style the back side */
        .flip-box-back {
          background-color: #f1f1f1;
          color: white;
          transform: rotateY(180deg);
        }
      </style>
    </div>
  </div>
</section>
<?php
}
?>

<!--==========================
https://bootsnipp.com/snippets/40Z3Q
  Footer
============================-->

<footer id="footer">

  <div class="container">
    <?php
    if (isset($dadosCurso['informacoesCurso']->link_vestibular) and $dadosCurso['informacoesCurso']->link_vestibular != '') {
      ?>
      <div class="col-sm-12 col-md-12 text-center">
        <a href="<?php echo $dadosCurso['informacoesCurso']->link_vestibular ?>" target="_blank" class="btn btns btn-lg">
          VESTIBULAR ONLINE
        </a>
      </div>
      <?php
    }
    ?>
    <div class="copyright">
      <i class="fas fa-at"></i> Siga-nos em nossas redes sociais <strong>UniAtenas</strong>.
    </div>

    <div class="credits">
      <a href="https://www.facebook.com/uniatenasoficial/" style="color:#fff; padding-right: 10px;font-size: 16px">
        <i class="fab fa-facebook-f"></i>
        <span class="top-page hidden-xs">Facebook</span>
      </a>
      <a href="https://www.instagram.com/uniatenasoficial" style="color:#fff; padding-right: 10px;font-size: 16px">
        <i class="fab fa-instagram"></i>
        <span class="top-page hidden-xs"> Instagram</span>
      </a>
      <a href="https://www.youtube.com/user/tvatenas" style="color:#fff; padding-right: 10px;font-size: 16px">
        <i class="fab fa-youtube"></i>
        <span class="top-page hidden-xs">TV - UniAtenas</span>
      </a>
    </div>
  </div>
</footer>
<script src="<?php echo base_url('assets/Regna/'); ?>lib/jquery/jquery.min.js"></script>
<script src="<?php echo base_url('assets/Regna/'); ?>lib/jquery/jquery-migrate.min.js"></script>
<script src="<?php echo base_url('assets/Regna/'); ?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets/Regna/'); ?>lib/easing/easing.min.js"></script>
<script src="<?php echo base_url('assets/Regna/'); ?>lib/wow/wow.min.js"></script>
<script src="<?php echo base_url('assets/Regna/'); ?>lib/waypoints/waypoints.min.js"></script>
<script src="<?php echo base_url('assets/Regna/'); ?>lib/counterup/counterup.min.js"></script>
<script src="<?php echo base_url('assets/Regna/'); ?>lib/superfish/hoverIntent.js"></script>
<script src="<?php echo base_url('assets/Regna/'); ?>lib/superfish/superfish.min.js"></script>

<script src="<?php echo base_url('assets/Regna/'); ?>contactform/contactform.js"></script>

<!-- Template Main Javascript File -->
<script src="<?php echo base_url('assets/Regna/'); ?>js/main.js"></script>