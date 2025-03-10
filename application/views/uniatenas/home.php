<?php
$uricampus = $this->uri->segment(3);
?>
<style>
  .fa,
  .fab,
  .fal,
  .far,
  .fas {
    line-height: unset;
  }
</style>
<section class="body">
  <div id="slider" class="carousel slide fadeInDown" data-ride="carousel">
    <ol class="carousel-indicators">
      <?php
      $count = count($slideshow);
      for ($i = 0; $i < $count; $i++) {
      ?>
        <li data-target="#slider" data-slide-to="<?php echo $i; ?>" class="<?php $active = $i == 0 ? 'active' : ''; ?> "></li>
      <?php
      }
      ?>
    </ol>

    <div class="carousel-inner" role="listbox">
      <?php
      foreach ($slideshow as $key => $slider) {
        if ($key == 0) {
          $ativo = 'active';
        } else {
          $ativo = '';
        }

      ?>
        <div class="item <?php echo $ativo; ?>">
          <a class="sliderLink" href="<?php print($slider->linkRedir) ?>" target="_blank">
            <div class="slider-item">
              <img src="<?php echo base_url() . $slider->files; ?>" class="img-responsive">
              <div class="slider-content-area">
                <div class="container">
                  <div class="row">
                    <div class="col-md-10">
                      <div class="slider-content">
                        <h3></h3>
                        <h2></h2>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      <?php
      }
      ?>
    </div>
    <a class="left carousel-control" href="#slider" role="button" data-slide="prev">
      <span class="fa fa-angle-left" aria-hidden="true"></span>
    </a>
    <a class="right carousel-control" href="#slider" role="button" data-slide="next">
      <span class="fa fa-angle-right" aria-hidden="true"></span>
    </a>

  </div>
</section>

<section class="bg-scrool">
  <div class="container">
    <div class="row">
      <ul class="scrool-home">
        <li><a href="" data-container="link" data-link="noticias">Notícias</a></li>
        <!--li><a href="" data-container="link" data-link="cursos">Cursos</a></li-->
        <li><a href="" data-container="link" data-link="homeeventos">Espaço Eventos</a></li>
        <li><a href="" data-container="link" data-link="galeria">Galeria</a></li>
        <?php
        if ($uricampus == "paracatu") {
        ?>
          <li class="border-rigth"><a href="<?php echo base_url("/site/telefones/$uricampus") ?>" data-container="link">Telefones Úteis</a></li>
        <?php
        }
        ?>
      </ul>
    </div>
  </div>

</section>
<?php
if ($news) { ?>
  <section class="bg-news" data-container="noticias" id="noticias">
    <div class="container">
      <div class="col-md-12">
        <div class="section-header">
          <h3>Notícias</h3>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-xs-12">
          <div class="row">
            <?php
            $totalNoticias = count($news);
            if ($totalNoticias > 3) {
              $totalNoticias = 3;
            } else {
              $totalNoticias = count($news);
            }

            if ($totalNoticias > 0) :

              for ($i = 0; $i < $totalNoticias; $i++) {
            ?>
                <div class="col-sm-4 col-xs-12">
                  <div class="news">
                    <div class="news-capa">
                      <?php
                      echo anchor('site/ver_noticia/' . $campus->shurtName . '/' . $news[$i]->id, '<img src="' . base_url() . $news[$i]->img_destaque . '" class="img-responsive"/>');
                      ?>
                      <h6>
                        <span><?php echo date('d/m/y', strtotime($news[$i]->datestart)); ?></span>
                      </h6>
                    </div>

                    <div class="newstitle">
                      <h4>
                        <?php echo anchor('site/ver_noticia/' . $campus->shurtName . '/' . $news[$i]->id, toHtml($news[$i]->title)); ?>
                      </h4>
                    </div>

                  </div>
                </div>
            <?php
              }
            endif;
            ?>
          </div>
          <div class="see-all-news">
            <p class="btn-see-all text-center">
              <?php
              echo anchor("site/noticias/$campus->shurtName", '<span>Ler todas as notícias.</span>');
              ?>
            </p>
          </div>
        </div>
        <div class="col-md-offset-1 col-md-3 col-xs-12 text-center">
          <h4>Informações</h4>
          <div class="bannerRigth">
            <div class="col-md-12">
              <img src="<?php echo base_url('assets/images/bannerLateral.png') ?>" alt="Banner" class="img-responsive" />
            </div>
            <?php
            if ($dados['campus']->id == 1) {
            ?>
              <div class="col-md-12">
                <?php echo anchor('graduacao/inscricao/' . $uricampus, ' 
            <img src="' . base_url('assets/images/bannerLateral2.png') . '" alt="Banner"
              class="img-responsive"/>');
                ?>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
        <!-- <div class="col-md-offset-1 col-md-3 col-xs-12 text-center">
        <h4>E-MEC</h4>
        <div class="bannerRigth">
          <div class="col-md-12">
            <img src="<?php echo base_url('assets/images/institucional-qrcodes/Emec-Uniatenas.png') ?>" alt="Banner"
              class="img-responsive" />
          </div>
          <div class="col-md-12">
            <style>
            .e-mec-texto {}
            </style>
            <span class="e-mec-texto" style="color: #00619d;font-weight: bold;">Consulte aqui o cadastro da Instituição
              no Sistema E-MEC.</span>
          </div>
        </div>
      </div> -->
      </div>
  </section>
<?php
}
include_once 'home/item_eventos.php';
include_once 'home/item_galeria.php';

?>