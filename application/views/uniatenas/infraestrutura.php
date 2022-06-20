<script>
$(document).ready(function() {

  $('#myCarousel *').carousel({
    interval: 3000
  });

  //Handles the carousel thumbnails
  $('[id^=carousel-selector-] ').click(function() {
    var id_selector = $(this).attr("id");
    try {
      var id = /-(\d+)$/.exec(id_selector)[1];
      console.log(id_selector, id);
      jQuery('#myCarousel *').carousel(parseInt(id));
    } catch (e) {
      console.log('Regex failed!', e);
    }
  });
  // When the carousel slides, auto update the text
  $('#myCarousel *').on('slid.bs.carousel', function(e) {
    var id = $('.item.active *').data('slide-number');
    $('#carousel-text *').html($('#slide-content-' + id).html());
    //$('.carousel-inner').selectpicker('refresh');
    //$('.carousel-control').selectpicker('refresh');
  });


});
</script>
<style>
.quadro {
  width: 170px;
  height: 80px;
  border-color: #0c199c;
  background-color: #ffffff;
  margin-right: 15px;
  margin-bottom: 10px;
  padding: 5px;
}

.quadro p {
  color: #002e92;
  white-space: normal;
  font-size: 13px;
  font-weight: 800;
}

.fotos {
  height: 100px;
  object-fit: cover;
  width: 100%;
}

.photoConetend {
  margin-left: 15px;
}

.photoDiv {
  margin-bottom: 15px;
  margin-top: 15px;
  background-color: #FFFFFF;
}

.contendeBu {
  margin-left: 31px;
}

.fotosCarroc {
  object-fit: cover;
  max-height: 330px;
  width: 100%;
}
</style>
<section class="bg-single-services">
  <div class="container">
    <div class="row">
      <div class="single-services">
        <div class="row">
          <div class="col-md-12 contendeBu">
            <?php
            $classe = '';
            foreach ($pages_content as $iitem):
              if ($iitem->order == 'serviceA'):
                  $classe = 'active';
              else:
                  $classe = '';
              endif;
              ?>
            <button href="#<?php echo $iitem->order; ?>" class="btn quadro <?php echo $classe; ?>"
              aria-controls="<?php echo $iitem->order; ?>" role="tab" data-toggle="tab">
              <p><?php echo $iitem->title; ?></p>
            </button>

            <?php
            endforeach;
            ?>


          </div>
          <hr>
          <div class="col-md-12">
            <div class="tab-content">
              <?php
            $i = 0;
            foreach ($pages_content as $textos):
                if ($textos->order == 'serviceA'):
                    $classe = 'active';
                else:
                    $classe = '';
                endif;

                ?>
              <div role="tabpanel" class="tab-pane <?php echo $classe; ?>" id="<?php echo $textos->order; ?>">
                <div class="single-services-content">
                  <div class="col-12">
                    <h3 class="text-center"><?php echo $textos->title; ?></h3>
                  </div>
                  <div class="row">
                    <div class="col-md-7">
                      <?php   
                    if(!empty($textos->array_fotos["photo"])):?>
                      <div class="carousel slide" id="myCarousel">
                        <div class="carousel-inner">
                          <?php
                        $ifotos = 0;
                        foreach ($textos->array_fotos["photo"] as $photo) {
                            if ($ifotos == 0):
                                $classephoto = 'active';

                            else:
                                $classephoto = '';
                            endif;
                            ?>
                          <div class="<?php echo $classephoto; ?> item" data-slide-number="<?= $ifotos; ?>">
                            <img src="<?php echo base_url() . $photo->file; ?>" class="img-responsive fotosCarroc">
                          </div>
                          <?php
                            $ifotos += 1;
                        } ?>
                        </div>

                      </div>
                      <?php
                    endif; ?>
                    </div>
                    <p>
                      <?php
                    echo $textos->description; ?>
                    </p>
                  </div>
                </div>
                <?php   if(!empty($textos->array_fotos["photo"])):?>
                <div class="content photoConetend" id="slider-thumbs">
                  <ul class="hide-bullets">
                    <li class="col-sm-12">
                      <?php
                      $idfotos = 0;
                      foreach ($textos->array_fotos["photo"] as $photo) {
                          ?>
                      <button class="col-md-2 photoDiv" id="carousel-selector-<?php echo $idfotos; ?>">
                        <img src="<?php echo base_url() . $photo->file; ?>" alt="single-services-img-4"
                          class="img-responsive fotos" />
                      </button>
                      <?php
                      $idfotos = $idfotos + 1;

                      } ?>
                    </li>
                  </ul>
                </div>
                <?php
                                    endif; ?>
              </div>
              <?php
                                $i = +1;
                            endforeach;
                            ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- .row -->
  </div>
  <!-- .container -->
</section>

<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>" crossorigin="anonymous"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>