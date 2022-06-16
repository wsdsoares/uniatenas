<?php
$uricampus = $this->uri->segment(3);
if($dados['espacoeventos']){
?>
<?php
$urisegment = $this->uri->segment(3);
?>
<style>
.carousel-inner-gallery {
  background: linear-gradient(to top, #dfefff 0%, #ffffff 100%);
}

.WhiteText {
  color: #000;
}

.spacer-md {
  padding-top: 50px;
  padding-bottom: 50px;
}

.carousel-indicators li {
  border: 1px solid #000;

}

.carousel-indicators .active {
  background-color: #000;
}

.animated img {
  max-height: 180px;
}

.animated {
  color: #1e4592;
}

.animated h2 {
  color: #f4630b;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

<section class="bg-testimonial-section eventos" data-container="homeeventos">
  <div class="container well animated fadeIn">
    <div class="row-fluid">
      <div id="my-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner carousel-inner-gallery">
          <?php

                    for ($i = 0; $i < count($dados['espacoeventos']); $i++) {
                        if ($i == 0) {
                            $class = 'active';
                        } else {
                            $class = '';
                        }
                        if ($i % 2 == 0) {
                            $efectdiv = "fadeInLeftBig";
                            $efectH = "fadeInLeftBig";
                            $efectImg = "fadeInRightBig";
                        } elseif ($i % 3 == 0) {
                            $efectdiv = "rotateInDownRight";
                            $efectH = "fadeInUpBig";
                            $efectImg = "rollIn";
                        } elseif ($i % 4 == 0) {

                            $efectdiv = "bounceInLeft";
                            $efectH = "fadeInUpBig";
                            $efectImg = "bounceInDown";
                        }
                        ?>
          <div class="item <?php echo $class; ?>">
            <div class="container-fluid">
              <div class="row spacer-md">
                <div class="col-sm-12 col-md-5 col-md-offset-1">
                  <div class="animated <?php echo $efectdiv; ?> slide-delay-1">
                    <h2 class="WhiteText content-right"><?php echo $dados['espacoeventos'][$i]->name; ?></h2>
                  </div>

                  <h4 class="animated <?php echo $efectH; ?>  slide-delay-2 YellowText text-justify">

                    <?php
                                            echo $dados['espacoeventos'][$i]->description;
                                            ?>
                    <br>
                    <?php
                                            echo anchor('site/espaco_eventos/' . $uricampus, 'Mais informações', array('class' => "btnEdital"));
                                            ?>
                  </h4>

                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="animated  <?php echo $efectImg; ?> text-center">
                    <img src="<?php echo base_url($dados['espacoeventos'][$i]->photocape); ?>" alt=""
                      class="img-responsive" />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php
                    }
                    ?>
        </div>
        <ol class="carousel-indicators">
          <?php
                   
                        for ($i = 0; $i < count($dados['espacoeventos']); $i++) {
                            if ($i == 0) {
                                $class = 'class="active"';
                            } else {
                                $class = '';
                            }
                            ?>

          <li data-target="#my-carousel" data-slide-to="<?php echo $i; ?>" <?php echo $class; ?>></li>


          <?php
                        }
                    
                    ?>
        </ol>

      </div>
    </div>

    <?php
                        
                    }
                    ?>
  </div>
</section>