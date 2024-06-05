<style>
  h4.titleCourse {
    color: #fff;
  }

  .grid {
    /* padding-top: 20px; */
    margin: 0 auto;
    list-style: none;
    text-align: center;
  }

  .grid li {
    border: 1px solid #2372a3;
    border-top-right-radius: 15px;
    border-bottom-left-radius: 15px;
    margin: 0;
    padding: 10px;
    text-align: center;
    position: relative;
  }

  .cat-uniasselvi .grid li {
    border: 1px solid #ff5000;
  }

  .grid figcaption h3 {
    margin: 0;
    padding: 0;
    color: #fff;
  }

  @media screen and (max-width: 31.5em) {
    .grid {
      padding: 10px 10px 100px 10px;
    }

    .grid li,
    #navi {
      width: 100%;
      min-width: 300px;
    }

  }

  *,
  *:after,
  *:before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }

  .lista-cursos a {
    cursor: pointer;
  }

  .lista-cursos a:hover {
    filter: gray;
    /* IE6-9 */
    filter: grayscale(1);
    /* Microsoft Edge and Firefox 35+ */
    -webkit-filter: grayscale(1);
    /* Google Chrome, Safari 6+ & Opera 15+ */

  }
</style>
<?php
$uriLocal = $this->uri->segment(3);
?>
<section class="course-content">
  <div class="container">
    <div class="cursoPos">
      <div class="our-courses">
        <div class="section-header">
          <h2>Pós Graduação</h2>
        </div>

        <div id="filters" class="button-group ">
          <button class="button is-checked" data-filter="*">Todas</button>
          <?php if ($uriLocal == 'paracatu') {
          ?>
            <button class="button" data-filter=".cat-1">Exatas</button>
          <?php
          }
          ?>
          <button class="button" data-filter=".cat-2">Saúde</button>
          <?php if ($uriLocal == 'paracatu') {
          ?>
            <button class="button" data-filter=".cat-3">Humanas / Social</button>
            <button class="button" data-filter=".cat-4">EaD</button>
          <?php
          }
          ?>
        </div>

        <div class="course-items-pos">
          <?php

          $cat = '';
          foreach ($campusCursos as $cursoPos) :
            if ($cursoPos->areas_id == 1) {
              $cat = 'cat-1';
            } elseif ($cursoPos->areas_id == 2) {
              $cat = 'cat-2';
            } elseif ($cursoPos->areas_id == 3) {
              $cat = 'cat-3';
            } elseif ($cursoPos->areas_id == 4) {
              $cat = 'cat-4';
            }

            $idEfeito = mb_substr($cursoPos->name, 0, 3);


          ?>
            <div class="item <?php echo $cat; ?>">
              <ul class="grid cs-style-3">
                <div class="col-xs-5">
                  <li class="lista-cursos-pos">
                    <a href="<?php echo site_url('posgraduacao/dados_curso/' . $campus->shurtName . '/' . $cursoPos->idCourseCampus); ?>">
                      <style>
                        figure img {
                          min-height: 118px;
                          min-width: 400px;
                        }
                      </style>
                      <figure>
                        <img src="<?php echo base_url($cursoPos->capa); ?>" alt="<?php echo $cursoPos->name; ?>" class="img-responsive">
                      </figure>
                    </a>
                    <?php
                    // if (isset($cursoPos->link_vestibular) and $cursoPos->link_vestibular != '') { // TODO - COMENTANDO PARA TESTE
                    if ($cursoPos->link_vestibular == '') {

                    ?>
                      <div class="col-sm-12 col-md-12 text-center">
                        <a href="<?php echo site_url('posgraduacao/dados_curso/' . $campus->shurtName . '/' . $cursoPos->idCourseCampus); ?>" class="btn btns btn-lg">
                          INSCREVA-SE AGORA!
                        </a>
                      </div>
                    <?php
                    }
                    ?>

                  </li>
                </div>
              </ul>
            </div>
          <?php
          endforeach;
          ?>
          <?php
          foreach ($campusCursos as $cursoPos) :
            if ($cursoPos->areas_id == 1) {
              $cat = 'cat-1';
            } elseif ($cursoPos->areas_id == 2) {
              $cat = 'cat-2';
            } elseif ($cursoPos->areas_id == 3) {
              $cat = 'cat-3';
            } elseif ($cursoPos->areas_id == 4) {
              $cat = 'cat-4';
            }

            $idEfeito = mb_substr($cursoPos->name, 0, 3);


          ?>
            <div class="item <?php echo $cat; ?>">
              <ul class="grid cs-style-3">
                <div class="col-xs-5">
                  <li class="lista-cursos-pos">
                    <a href="<?php echo site_url('posgraduacao/dados_curso/' . $campus->shurtName . '/' . $cursoPos->idCourseCampus); ?>">
                      <style>
                        figure img {
                          min-height: 118px;
                          min-width: 400px;
                        }
                      </style>
                      <figure>
                        <img src="<?php echo base_url($cursoPos->capa); ?>" alt="<?php echo $cursoPos->name; ?>" class="img-responsive">
                      </figure>
                    </a>
                    <?php
                    // if (isset($cursoPos->link_vestibular) and $cursoPos->link_vestibular != '') { // TODO - COMENTANDO PARA TESTE
                    if ($cursoPos->link_vestibular == '') {

                    ?>
                      <div class="col-sm-12 col-md-12 text-center">
                        <a href="<?php echo site_url('posgraduacao/dados_curso/' . $campus->shurtName . '/' . $cursoPos->idCourseCampus); ?>" class="btn btns btn-lg">
                          INSCREVA-SE AGORA!
                        </a>
                      </div>
                    <?php
                    }
                    ?>

                  </li>
                </div>
              </ul>
            </div>
          <?php
          endforeach;
          ?>
        </div>

        <!--div class="item cat-uniasselvi" data-category="transition">
          <div class="item-inner">
            <h3 class="text-center">Cursos a distância</h3>


            <center>
              <ul class="grid cs-style-3">


                <li>
                  <figure>
                    <h4 class="title-ead">EaD - UniAtenas</h4>
                    <img src="<?php echo base_url('assets/images/courses/ead/capas/peadUniatenas.jpg'); ?>" alt="EaD - UniAtenas" class="img-responsive">
                    <figcaption>
                      <h4 class="titleCourse">EaD - UniAtenas</h4>
                      <?php
                      echo anchor('graduacao/ead/paracatu', 'Ver todos os cursos');
                      ?>
                    </figcaption>
                  </figure>
                </li>


              </ul>
            </center>
          </div>
        </div-->

      </div>

    </div>
</section>
<style>
  .campus_ativo {
    background: #71ed4a !important;
  }
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.waypoints.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.counterup.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/swiper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/lightcase.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.map.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins.isotope.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.isotope.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/custom.js"></script>