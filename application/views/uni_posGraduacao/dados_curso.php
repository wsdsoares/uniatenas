<style>
  *,
  html {
    scroll-behavior: smooth !important;
  }

  .topoPosGraduacao {
    background: rgba(0, 71, 117, 1.0);
    height: 80px;
  }

  .titutlo-pos-graduacao {
    color: #f1f1f1;
    font-size: 22px;
    margin-top: 25px;
  }

  .texto-descricao-curso,
  .area-funcionamento p {
    margin-bottom: 3%;
  }

  .area-funcionamento p {
    line-height: 150%;
  }

  .imagem-banner-pos {
    margin-top: 2%;
  }

  .about-container,
  .area-funcionamento p {
    line-height: 30px;
  }

  h3.titulos-pagina {
    margin: top 10px;
    margin-bottom: 20px;
  }
</style>
<style>
  .disciplina-pos {
    display: flex;
    justify-content: space-between !important;
    line-height: 30px;
  }
</style>
<?php
$uricampus = $this->uri->segment(3);
?>
<!-- <div class="container-fluid topoPosGraduacao">
  <div class="row">
    <div class="container">
      <h4 class="titutlo-pos-graduacao">
        Pós Graduação em <?php echo $dadosCurso['curso']->nameCourse; ?>
      </h4>
    </div>
  </div>
</div> -->

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
<style>
  * p {
    text-align: justify !important;
  }

  .title {
    background: #cdcdcd;
    padding: 10px;
  }

  .titulo-modulo {
    font-weight: bold;
    color: #000;
  }

  .disciplina-pos p {
    text-align: left !important;
  }
</style>

<div class="container">
  <div class="row">
    <a href="#">
      <div class="container text-center imagem-banner-pos">
        <!-- <img src="<?php echo site_url(); ?>assets/images/pos-graduacao/1/103/pos-graduacao-2.png" alt="banner-pos"> -->
        <img src="<?php echo site_url() . $dadosCurso['informacoesCurso']->capa; ?>" alt="banner-pos">
      </div>
  </div>
  </a>
  <div class="row">
    <div class="col-xs-12">
      <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
        <div class="btn-group" role="group">
          <a type="button" href="#sobre" class="btn btn-default-course">
            <span class="glyphicon glyphicon-education" aria-hidden="true"></span>
            <div class="hidden-xs">O CURSO</div>
          </a>
        </div>
        <div class="btn-group" role="group">
          <a type="button" href="#funcionamento" class="btn btn-default-course">
            <span class="glyphicon glyphicon-screenshot" aria-hidden="true"></span>
            <div class="hidden-xs">FUNCIONAMENTO</div>
          </a>
        </div>
        <div class="btn-group" role="group">
          <a type="button" href="#modulos-curso-pos" class="btn btn-default-course">
            <span class="glyphicon glyphicon-screenshot" aria-hidden="true"></span>
            <div class="hidden-xs">MÓDULOS</div>
          </a>
        </div>
        <div class="btn-group" role="group">
          <a type="button" href="#documentacao" class="btn btn-default-course">
            <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
            <div class="hidden-xs">DOCUMENTAÇÃO</div>
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
<section id="sobre">
  <div class="container">
    <div class="row about-container">
      <div class="col-xs-12 content order-lg-1 order-2">
        <h3 class="titulos-pagina">SOBRE O CURSO </h3>
        <div class="texto-descricao-curso">
          <?php
          echo to_html(substr($dadosCurso['informacoesCurso']->description, 0));
          ?>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="funcionamento">
  <div class="container">
    <div class="row about-container">
      <div class="col-xs-12 area-funcionamento" id="funcionamento">
        <h3 class="titulos-pagina">FUNCIONAMENTO</h3>

        <?php
        echo $dadosCurso['informacoesCurso']->actuation;
        ?>

        <div class="col-sm-12 col-md-12 text-center">
          <a href="<?php echo $dadosCurso['informacoesCurso']->link_vestibular ?>" target="_blank" class="btn btns btn-lg">
            INSCREVA-SE AGORA!
          </a>
        </div>

      </div>
    </div>
  </div>
</section>
<section id="modulos-curso-pos">
  <div class="container wow fadeIn">
    <?php
    if (!empty($dadosCurso['modulosCursosPos'])) {
    ?>
      <div style="text-align:left !important;padding-bottom:10px;">
        <h3 class="section-title text-uppercase">MÓDULOS</h3>
      </div>
    <?php
    }
    ?>

    <div class="row itensGradeCurricular">
      <div class="col-sm-12">
        <div class="row">
          <?php
          $i = 0;
          foreach ($dadosCurso['modulosCursosPos'] as $modulo) {
          ?>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.<?php echo $i; ?>s">
              <div class="box" style="background:rgba(211,211,211,0.3);min-height:150px;margin-bottom:3rem;">
                <div class="title">
                  <h4>MÓDULO <?php echo $modulo->modulo; ?></h4>
                  <h4><?php echo $modulo->nome_modulo; ?></h4>
                </div>
                <?php
                foreach ($dadosCurso['disciplinasPos'] as $disciplinas)
                  if ($modulo->modulo == $disciplinas->modulo) {
                ?>
                  <div class="disciplina-pos">
                    <div class="col-xs-11">
                      <p> <?php echo '<i class="fas fa-caret-right"></i> ' . $disciplinas->disciplina; ?></p>
                    </div>

                    <p> <?php echo $disciplinas->carga_horaria; ?> H</p>

                  </div>
                <?php
                  }
                ?>
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

              </div>
            </div>
          <?php
            $i = $i + 2;
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>
<style>
  .conteudo-pagina-curso p {
    margin-bottom: 20px;
    line-height: 30px;
  }

  .conteudo-pagina-curso ul li {
    list-style: inside;
  }
</style>
<section id="documentacao">
  <div class="container">
    <?php
    if (!empty($dadosCurso['conteudosCursos'])) :
    ?>
      <div class="conteudos">
        <?php foreach ($dadosCurso['conteudosCursos'] as $conteudo) : ?>
          <div class="">
            <h3 class="section-title text-uppercase"><?php echo $conteudo->titulo; ?></h3>
          </div>
          <div class="conteudo-pagina-curso">
            <?php echo $conteudo->descricao; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php
    endif;
    ?>
  </div>
</section>

<footer id="footer">

  <div class="container">
    <?php
    //if (isset($dadosCurso['informacoesCurso']->link_vestibular) and $dadosCurso['informacoesCurso']->link_vestibular != '') {
    if (1) {
    ?>
      <div class="col-sm-12 col-md-12 text-center">
        <a href="<?php echo $dadosCurso['informacoesCurso']->link_vestibular ?>" target="_blank" class="btn btns btn-lg">
          INSCREVA-SE AGORA!
        </a>
      </div>
    <?php
    }
    ?>
    <div class="copyright">
      <i class="fas fa-at"></i> Siga-nos em nossas redes sociais <strong>UniAtenas</strong>.
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