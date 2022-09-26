<?php
$uricampus = $this->uri->segment(3);
$uricuros = $this->uri->segment(4);


?>
<script>
$(document).ready(function() {

  $('#myCarousel').carousel({
    interval: 5000
  });

  //Handles the carousel thumbnails
  $('[id^=carousel-selector-]').click(function() {
    var id_selector = $(this).attr("id");
    try {
      var id = /-(\d+)$/.exec(id_selector)[1];
      console.log(id_selector, id);
      jQuery('#myCarousel').carousel(parseInt(id));
    } catch (e) {
      console.log('Regex failed!', e);
    }
  });
  // When the carousel slides, auto update the text
  $('#myCarousel').on('slid.bs.carousel', function(e) {
    var id = $('.item.active').data('slide-number');
    $('#carousel-text').html($('#slide-content-' + id).html());
  });
});
</script>
<style>
.hide-bullets {
  list-style: none;
  margin-left: -40px;
  margin-top: 20px;
}

.thumbnail {
  padding: 0;
}

.carousel-inner>.item>img,
.carousel-inner>.item>a>img {
  width: 100%;
}

.col-sm-3 a {
  border: 1px solid transparent;
  border-radius: 0;
  transition: all 3s ease;
}

.col-sm-3 a:hover {
  border: 1px solid #ff4647;
  border-radius: 100% 60% 30% 10%;
  background: linear-gradient(rgba(56, 123, 131, 0.7), rgba(56, 123, 131, 0.7));
}
</style>
<div class="container">
  <div class="row">
    <div class="section-header text-center">
      <h3>Galeria de Fotos <br />
        <?php echo $catArray['title'].' - '. $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h3>
    </div>
  </div>
  <div class="btn-back">
    <?php echo anchor($breadurl , '
            Voltar', array('class' => "btn btn-danger"));
        ?>
  </div>
  <br>
  <div id="main_area">
    <div class="row">
      <div class="col-sm-6" id="slider-thumbs">
        <ul class="hide-bullets">
          <?php
          for ($i = 0; $i < count($catArray['fotos']); $i++) {
            if($catArray['fotos'][$i]->status != null){
            ?>
          <li class="col-sm-3">
            <a class="thumbnail" id="carousel-selector-<?php echo $i; ?>">
              <img src="<?php echo base_url($catArray['fotos'][$i]->file); ?>" class="img-responsive">
            </a>
          </li>
          <?php
            }
          }
          ?>
        </ul>
      </div>
      <div class="col-sm-6">
        <div class="col-xs-12" id="slider">
          <div class="row">
            <div class="col-sm-12" id="carousel-bounding-box">
              <div class="carousel slide" id="myCarousel">
                <div class="carousel-inner">
                  <?php
                                    for ($i = 0; $i < count($catArray['fotos']); $i++) {
                                        if ($i == 0) {
                                            $active = "active";
                                        } else {
                                            $active = '';
                                        }
                                        ?>
                  <div class="<?php echo $active; ?> item" data-slide-number="<?php echo $i; ?>">
                    <img src="<?php echo base_url($catArray['fotos'][$i]->file); ?>" class="img-responsive">
                  </div>

                  <?php
                                    }
                                    ?>


                </div>
                <!-- Carousel nav -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>