<style>
h4.titleCourse {
  color: #fff;
}

.grid {
  padding-top: 20px;
  margin: 0 auto;
  list-style: none;
  text-align: center;
}

.grid li {
  border: 1px solid #2372a3;
  border-top-right-radius: 15px;
  border-bottom-left-radius: 15px;
  width: 320px;
  margin: 0;
  padding: 10px;
  text-align: center;
  position: relative;
}

.cat-uniasselvi .grid li {
  border: 1px solid #ff5000;
}

.grid figure {
  margin: 0;
  position: relative;
  border-top-right-radius: 15px;
  border-bottom-left-radius: 15px;
}

.grid figure img {
  max-width: 100%;
  display: block;
  position: relative;
}

.grid figcaption {
  position: absolute;
  top: 0;
  left: 0;
  /*padding: 20px;*/
  background: #2c3f52;
  color: #ed4e6e;
}

.grid figcaption h3 {
  margin: 0;
  padding: 0;
  color: #fff;
}

.grid figcaption span:before {
  content: 'Detail: ';
}

.grid figcaption a {
  text-align: center;
  padding: 5px 10px;
  border-radius: 2px;
  display: inline-block;
  margin-left: 2px;

  background: #ed4e6e;
  color: #fff;
}

.cs-style-3 figure {
  overflow: hidden;
}

.cs-style-3 figure img {
  transition: transform 0.4s;
  -webkit-transition: -webkit-transform 0.4s;
  -moz-transition: -moz-transform 0.4s;
}

.no-touch .cs-style-3 figure:hover img,
.cs-style-3 figure:hover img {
  transform: translateY(-50px);
  -moz-transform: translateY(-50px);
  -webkit-transform: translateY(-50px);
}

.cs-style-3 figcaption {
  text-align: center;
  height: 100px;
  width: 100%;
  top: auto;
  bottom: 0;
  opacity: 0;
  transform: translateY(100%);
  -webkit-transform: translateY(100%);
  -moz-transform: translateY(100%);
  transition: transform 0.4s, opacity 0.1s 0.3s;
  -moz-transition: -moz-transform 0.4s, opacity 0.1s 0.3s;
  -webkit-transition: -webkit-transform 0.4s, opacity 0.1s 0.3s;
  -webkit-backface-visibility: hidden;
  -moz-backface-visibility: hidden;
  backface-visibility: hidden;
}

.no-touch .cs-style-3 figure:hover figcaption,
.cs-style-3 figure:hover figcaption {
  opacity: 1;
  transform: translateY(0px);
  -moz-transform: translateY(0px);
  -webkit-transform: translateY(0px);
  -webkit-transition: -webkit-transform 0.4s, opacity 0.1s;
  -moz-transition: -moz-transform 0.4s, opacity 0.1s;
  transition: transform 0.4s, opacity 0.1s;
}

.cs-style-3 figcaption a {
  bottom: 20px;

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
</style>

<section class="course-content">
  <div class="container">
    <div class="row">
      <div class="our-courses">
        <div class="section-header title-principals">
          <h2>Nossos Cursos</h2>
          <span class="double-border"></span>
          <p>Gradue-se nos melhores cursos do país.</p>
        </div>

        <div id="filters" class="button-group ">
          <button class="button is-checked" data-filter="*">Todos os cursos</button>
          <button class="button" data-filter=".cat-1">Exatas</button>
          <button class="button" data-filter=".cat-2">Saúde</button>
          <button class="button" data-filter=".cat-3">Humanas</button>
          <button class="button" data-filter=".cat-4">EaD</button>
        </div>
        <div class="course-items">
          <?php
          $cat = '';
          foreach ($campusCursos as $row) {
            if ($row['areas_id'] == 1) {
              $cat = 'cat-1';
            } elseif ($row['areas_id'] == 2) {
              $cat = 'cat-2';
            } elseif ($row['areas_id'] == 3) {
              $cat = 'cat-3';
            } elseif ($row['areas_id'] == 4) {
              $cat = 'cat-4';
            }

            $idEfeito = mb_substr($row['name'], 0, 3);

            ?>
          <div class="item <?php echo $cat; ?>" data-category="transition">
            <ul class="grid cs-style-3">
              <div class="col-sm-6">
                <li>
                  <figure>
                    <h4 class="title-ead"><?php echo $row['name']; ?></h4>
                    <img src="<?php echo base_url($row['capa']); ?>" alt="<?php echo $row['name']; ?>"
                      class="img-responsive">
                    <figcaption>
                      <h4 class="titleCourse"><?php echo $row['name']; ?></h4>
                      <?php
                      foreach ($row['campus'] as $courseCampus) {
                      ?>
                      <?php
                        echo anchor('graduacao/presencial/' . $courseCampus->id, $courseCampus->city);
                        ?>
                      <?php
                        }
                        ?>
                    </figcaption>
                  </figure>
                </li>
              </div>
            </ul>
          </div>
          <?php
                    }
                    ?>
        </div>
        <div class="item cat-uniasselvi" data-category="transition">
          <div class="item-inner">
            <h3 class="text-center">Cursos a distância.</h3>
            <ul class="grid cs-style-3">
              <div class="col-sm-6">
                <li>
                  <figure>
                    <h4 class="title-ead">EaD - UniAtenas</h4>
                    <img src="<?php echo base_url('assets/images/courses/ead/peadUniatenas.jpg'); ?>"
                      alt="EaD - UniAtenas" class="img-responsive">
                    <figcaption>
                      <h4 class="titleCourse">EaD - UniAtenas</h4>
                      <a href="http://dribbble.com/shots/1115960-Music?list=users">Ver todos os
                        cursos</a>
                    </figcaption>
                  </figure>
                </li>
              </div>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-12 m-t-30 text-center">
        <a class="btn btn-default btn-lg">Inscreva-se agora!</a>
      </div>
    </div>
  </div>
</section>

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