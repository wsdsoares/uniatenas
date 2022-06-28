<style>
@import url('https://fonts.googleapis.com/css?family=IBM+Plex+Sans:400,500,600,700&display=swap');


.news-primary {
  width: 100%;
}

.news-header {
  background: url('https://ace-v2.workflow24.co.uk/wp-content/uploads/2019/10/process-swoosh.svg'), radial-gradient(rgba(0, 56, 80, 0.9) 10%, rgba(0, 55, 79, 1) 60%);
  background-repeat: no-repeat;
  background-size: contain, 100% 100%;
  padding: 10px 10px 10px 10px;
  background-position: center center, top center;
}

.news-header-content {
  max-width: 1100px;
  margin: 0 auto;
}

.news-title {
  margin: 0px;
  /*text-transform: uppercase;*/
  width: 95%;
  font-family: 'Open Sans', sans-serif;
  font-weight: 800;
  font-size: 18px;
  line-height: 1;
  color: #fff;
}

.feature-photo {
  width: 100%;
  background-position: center center;
  background-size: cover;
  border-radius: 6px;
}

.news-body {
  max-width: 1100px;
  margin: 7px auto;
  font-family: 'IBM Plex Sans', sans-serif;
  color: #0B5064;
  font-size: 15px;
  display: flex;
  flex-direction: row;
  padding: 0px 20px;
}

.news-body-text {
  padding: 0px 50px 0px 20px;
}

.last-news {
  background: #ffa000;
}


.photoFeatured {
  max-height: 400px;
  box-shadow: 0px 5px 10px rgba(50, 50, 93, 0.25)
}

.allphotos {
  background: #1c7430;
  color: #fff;
}
</style>


<?php
$uricampus = $this->uri->segment(3);
$imagem = verifyImg($news->img_destaque);
?>
<section class="news-section p-b-70">
  <div class="row">
    <div class="section-header text-center">
      <h3>Notícias <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h3>
    </div>
  </div>
  <div class="container">

    <div class="row news-one">
      <div class="news-primary">
        <div class="news-header">
          <div class="news-header-content">
            <h1 class="news-title"><?php echo $news->title; ?></h1>
            <div class="feature-photo">
              <?php
              if ($imagem != 'images/no-image.jpg') {
              ?>
              <img src="<?php echo base_url($imagem); ?>" class="photoFeatured">
              <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="news-body">
        <div class="row news-one">
          <div class="news-body-text col-md-9 col-xs-12">
            <div class="dados_gerais"><?php echo toHtml($news->description); ?></div>
            <?php
            if (!empty($dados['photosNews'])) {
            ?>
            <div class="col-xs-12 allphotos">
              Visualize abaixo algumas fotos da notícia
            </div>
            <div class="new-imgs">
              <?php
              foreach ($dados['photosNews'] as $photos) {
              ?>

              <a class="example-image-link col-md-3 col-xs-6" href="<?php echo base_url($photos->file); ?>"
                data-lightbox="example-set"
                data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                <img class="example-image" src="<?php echo base_url($photos->file); ?>" alt="" />
              </a>

              <?php
              }
              ?>
            </div>
            <?php
            }
            ?>
          </div>
          <div class="col-md-3 col-xs-12 list-news">
            <h5 class="last-news">Últimas notícias</h5>

            <?php
            $totalNoticias = count($recentNews);
            if($totalNoticias >3){
                for ($i = 0; $i < 3; $i++) {
                ?>
            <div class="news-list-information">
              <a href="<?php echo $recentNews[$i]->id ?>">
                <h6 style="font-size:12px;">
                  <?php
                        echo $recentNews[$i]->title;
                    ?>
                </h6>

                <img src="<?php echo base_url(verifyImg($recentNews[$i]->img_destaque)); ?>" alt="Notícias - UniAtenas"
                  class="img-responsive" />

              </a>
            </div>
            <?php
                }
            }
            ?>
            <p class="btn-see-more col-sm-9">
              <?php echo anchor('Site/Noticias/' . $uricampus, '<span>Ver mais...</span>');
                            ?>
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>

</section>