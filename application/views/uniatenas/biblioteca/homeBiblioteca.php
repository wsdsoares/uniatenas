<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style>
  section.comutacaoBibliografica {
    padding-top: 4rem;
    padding-bottom: 5rem;
    background-color: #f1f4fa;
  }

  .wrap {
    display: flex;
    background: white;
    padding: 1rem 1rem 1rem 1rem;
    border-radius: 0.5rem;
    box-shadow: 7px 7px 30px -5px rgba(0, 0, 0, 0.1);
    margin-bottom: 2rem;
    min-height: 110px;
  }

  .wrap:hover {
    background: linear-gradient(100deg, #ece0d9 0%, #edb492 100%);
    color: #fff;
  }

  .ico-wrap {
    margin: auto;
  }

  .mbr-iconfont {
    font-size: 4.5rem !important;
    color: #313131;
    margin: 1rem;
    padding-right: 1rem;
  }

  .vcenter {
    margin: auto;
  }

  .mbr-section-title3 {
    text-align: left;
  }

  h2.mbr-fonts-style {
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
  }

  .display-5 {
    font-family: 'Source Sans Pro', sans-serif;
    font-size: 1.4rem;
  }

  .mbr-bold {
    font-weight: 700;
  }

  p {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    line-height: 25px;
  }

  .display-6 {
    font-family: 'Source Sans Pro', sans-serif;
  }

  text.Orange-label {
    color: Orange;
  }
</style>
<style>
  .transition-timer-carousel .carousel-caption {
    background: -moz-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
    /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0, 0, 0, 0)), color-stop(4%, rgba(0, 0, 0, 0.1)), color-stop(32%, rgba(0, 0, 0, 0.5)), color-stop(100%, rgba(0, 0, 0, 1)));
    /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
    /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
    /* Opera 11.10+ */
    background: -ms-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
    /* IE10+ */
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%);
    /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#000000', GradientType=0);
    /* IE6-9 */
    width: 100%;
    left: 0px;
    right: 0px;
    bottom: 0px;
    text-align: left;
    padding-top: 5px;
    padding-left: 15%;
    padding-right: 15%;
  }

  .transition-timer-carousel .carousel-caption .carousel-caption-header {
    margin-top: 10px;
    font-size: 24px;
  }

  @media (min-width: 970px) {

    /* Lower the font size of the carousel caption header so that our caption
        doesn't take up the full image/slide on smaller screens */
    .transition-timer-carousel .carousel-caption .carousel-caption-header {
      font-size: 36px;
    }
  }

  @media (max-width: 320px) {

    /* Lower the font size of the carousel caption header so that our caption
        doesn't take up the full image/slide on smaller screens */
    .transition-timer-carousel .carousel-caption .carousel-caption-header {
      font-size: 18px;
    }
  }

  .transition-timer-carousel .carousel-indicators {
    bottom: 0px;
    margin-bottom: 5px;
  }

  .transition-timer-carousel .carousel-control {
    z-index: 11;
  }

  .transition-timer-carousel .transition-timer-carousel-progress-bar {
    height: 5px;
    background-color: #5cb85c;
    width: 0%;
    margin: -5px 0px 0px 0px;
    border: none;
    z-index: 11;
    position: relative;
  }

  .transition-timer-carousel .transition-timer-carousel-progress-bar.animate {

    -webkit-transition: width 4.25s linear;
    -moz-transition: width 4.25s linear;
    -o-transition: width 4.25s linear;
    transition: width 4.25s linear;
  }
</style>

<?php
$uricampus = $this->uri->segment(3);
?>

<div class="container">
  <div class="row">
    <div class="section-header text-center">
      <h3>Biblioteca <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h3>
    </div>
  </div>
</div>
<?php
if (count($conteudoFotosSlideBiblioteca) > 0) {
?>
  <div class="container">
    <div class="row">
      <div id="transition-timer-carousel" class="carousel slide transition-timer-carousel" data-ride="carousel">
        <ol class="carousel-indicators">
          <?php
          for ($i = 0; $i < count($conteudoFotosSlideBiblioteca); $i++) {
            if ($i == 0) {
              $ativo = "active";
            } else {
              $ativo = '';
            }
          ?>
            <li data-target="#transition-timer-carousel" data-slide-to="<?php echo $i; ?>" class="<?php echo $ativo; ?>""></li>
        <?php
          }
        ?>
      </ol>

      <div class=" carousel-inner">
              <?php
              for ($i = 0; $i < count($conteudoFotosSlideBiblioteca); $i++) {
                if ($i == 0) {
                  $ativo = "active";
                } else {
                  $ativo = '';
                }
              ?>
                <div class="item <?php echo $ativo; ?>">
                  <img src="<?php echo base_url($conteudoFotosSlideBiblioteca[$i]->file); ?>" style="background-size: cover; width:1440px; height: 400px;" />
                  <div class="carousel-caption">
                    <h1 class="carousel-caption-header">Fotos da biblioteca
                      - <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?>
                    </h1>

                  </div>
                </div>
              <?php
              }
              ?>
      </div>

      <a class="left carousel-control" href="#transition-timer-carousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
      </a>
      <a class="right carousel-control" href="#transition-timer-carousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
      </a>
      <hr class="transition-timer-carousel-progress-bar animate" />
    </div>
  </div>
  </div>
<?php
}
?>
<div class="container">
  <div class="row">
    <div class="container">

      <div class="row">
        <div class="col-md-8">
          <?php
          for ($i = 0; $i < count($dados['conteudoPag']); $i++) {
          ?>
            <div class="section-header text-center">
              <!-- <h3>Sobre a Biblioteca</h3> -->
              <h3> <?php echo $dados['conteudoPag'][$i]->title; ?></h3>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="information-library-campus text-justify">
                  <p>
                    <?php echo $dados['conteudoPag'][$i]->description; ?>
                  </p>
                </div>
              </div>
              <hr>
            </div>
          <?php
          }
          ?>
        </div>

        <div class="col-lg-4">

          <style>
            li.lista-link-uteis a h4 {
              cursor: pointer;
            }

            li.lista-link-uteis a h4:hover {
              color: #f4630b !important;
            }

            .widget-sidebar {
              margin-bottom: 2em;
            }
          </style>
          <?php
          if (!empty($dados['conteudoAcessoRapido']) and $dados['conteudoAcessoRapido'] != '') {
          ?>
            <div class="widget-sidebar col-xs-12">

              <h2 class="title-widget-sidebar">#Acesso Rápido</h2>
              <div class="content-widget-sidebar">
                <ul>
                  <?php
                  foreach ($dados['conteudoAcessoRapido'] as $linksAcessoRapido) {
                  ?>
                    <li class="lista-link-uteis">
                      <a target="_blank" href="<?php echo $linksAcessoRapido->link_redir; ?>">
                        <h4>
                          <i class="fa fa-external-link"></i>
                          <?php echo $linksAcessoRapido->title; ?>
                        </h4>
                      </a>
                    </li>
                  <?php
                  }
                  ?>
                </ul>
              </div>
            </div>
          <?php
          }
          ?>

          <?php
          if (!empty($dados['conteudoLinksUteis']) and $dados['conteudoLinksUteis'] !== '') {
          ?>
            <div class="widget-sidebar col-xs-12">

              <h2 class="title-widget-sidebar">#Links Úteis</h2>
              <?php
              foreach ($dados['conteudoLinksUteis'] as $linksUteis) {
              ?>
                <div class="last-post-aluno">
                  <a target="_blank" href="<?php echo $linksUteis->link_redir; ?>" class="accordionAluno"><?php echo $linksUteis->title; ?></a>
                </div>
                <hr>
              <?php
              }
              ?>
            </div>
          <?php
          }
          ?>
        </div>
      </div>

    </div>
  </div>
</div>
<?php
if (isset($existeLinkRevistasPeriodicos) and $existeLinkRevistasPeriodicos !== '') {
?>
  <section>
    <div class="col-md-8">
      <div class="row">
        <!-- <div class="col-xs-12">
        <div class="information-library-campus text-justify">
          <p>
            <?php echo $dados['conteudoPag'][0]->description; ?>
          </p>
        </div>
      </div>
      <hr> -->
        <div class="col-xs-12">
          <div class="row">
            <div class="col-xs-12 text-center">
              <div class="boxLibrary">
                <h3 class="text-center" style="color:#000;">Links externos Revistas / Periódicos</h3>
                <div class="boxLibrary-content">
                  <hr />
                  <!-- Achar a informação antiga que estava na pagina-->
                  <!--p><?php echo $dados['conteudoPag'][1]->description; ?></p-->
                  <br />
                  <div class="btnAcessMagazinesLinks">
                    <?php echo anchor('site/revistas_periodicos/' . $uricampus, 'Acessar', array('class' => "btn btn-primary")); ?>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
}
?>
<br />
<br />
<?php
//if ($conteudoComutacao !== '') {
?>
<section class="comutacaoBibliografica">
  <div class="container">

    <div class="row mbr-justify-content-center">
      <div class="container">
        <div class="section-header text-center">
          <h3><?php echo "$conteudoComutacao->title: $campus->name  -  $campus->city   ($campus->uf)"; ?>
          </h3>
        </div>
      </div>
      <div class="container">
        <div class="text">
          <p>
            <?php
            echo $conteudoComutacao->description;
            ?>
          </p>
        </div>
      </div>
      <?php
      if ($conteudoLinkComutacao != '') {
        foreach ($conteudoLinkComutacao as $linksComutacao) {
      ?>

          <div class="col-lg-6 mbr-col-md-10">
            <a target="_blank" href="<?php echo $linksComutacao->link_redir ?>">
              <div class="wrap">
                <div class="ico-wrap">
                  <span class="mbr-iconfont fa-link fa"></span>
                </div>
                <div class="text-center">
                  <h2 class="mbr-fonts-style mbr-bold mbr-section-title3 display-5">
                    <span><?php echo $linksComutacao->title ?></span>
                  </h2>
                  <?php echo $linksComutacao->description ?>
                </div>
              </div>
            </a>
          </div>
      <?php
        }
      }
      ?>
    </div>
  </div>
</section>
<?php
//}
?>
<script>
  $(document).ready(function() {
    //Events that reset and restart the timer animation when the slides change
    $("#transition-timer-carousel").on("slide.bs.carousel", function(event) {
      //The animate class gets removed so that it jumps straight back to 0%
      $(".transition-timer-carousel-progress-bar", this)
        .removeClass("animate").css("width", "0%");
    }).on("slid.bs.carousel", function(event) {
      //The slide transition finished, so re-add the animate class so that
      //the timer bar takes time to fill up
      $(".transition-timer-carousel-progress-bar", this)
        .addClass("animate").css("width", "100%");
    });

    //Kick off the initial slide animation when the document is ready
    $(".transition-timer-carousel-progress-bar", "#transition-timer-carousel")
      .css("width", "100%");
  });
</script>