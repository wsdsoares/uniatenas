<?php
$uricampus = $this->uri->segment(3);
if (!empty($fotos[0])) {
    ?>
<section class="bg-testimonial-section galeria" data-container="galeria">
  <div class="testimonial-overlay">
    <div class="container">
      <div class="row">
        <div class="testimonial-option" style="height: auto">
          <div class="section-header text-center">
            <h2>Galeria de Fotos</h2>
          </div>
          <style>
          .img_teste img {
            border-radius: 7px;
            max-height: 250px;
          }

          .img_teste h4 {
            text-align: center;
            margin: 5px;
          }

          .img-reguler img {
            max-width: 5px;
          }

          .galeria-fotos {
            background: red;
          }
          </style>
          <style>

          </style>
          <div class="testimonial-container">
            <div class="swiper-wrapper">
              <?php
                $i = 0;
                foreach ($fotos as $itens) { ?>
              <div class="swiper-slide">
                <a href="<?php echo base_url("site/galeria/$uricampus");?>">
                  <img class='' src='<?php echo base_url($itens['fotos']->file); ?>' alt="UniAtenas" />
                </a>
                <a href="<?php echo base_url("site/galeria/$uricampus");?>">
                  <div class="titulo-galeria">
                    <h4><?php echo $itens['title']; ?></h4>
                  </div>
                </a>
              </div>

              <?php
                $i++;
                }
                ?>
            </div>
          </div>
          <div class="swiper-pagination "></div>
          <div class="text-center">
            <?php
                            $nomeIns = "";
                            if($uricampus == "paracatu"):
                                $nomeIns = "UNIATENAS";
                            else:
                                $nomeIns = "Faculdade Atenas";
                            endif;
                            echo anchor("site/galeria/$uricampus", "Mais Fotos - $nomeIns", array('class' => 'btnEdital'));
                            ?>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>
<?php
}
?>