<?php
$uricampus = $this->uri->segment(3);
$isead = $this->uri->segment(1) == 'ead';
?>
<style>
.address-polo {
  background: #DCDCDC;
  border-radius: 1px;
  border: 2px solid #A9A9A9;
  margin-bottom: 30px;
}

.address-polo p {
  font-size: 12px;
  text-align: justify;
}

.address-polo address {
  padding-top: 10px;
  padding-right: 10px;
  padding-left: 10px;

}

.local-polo {

  position: relative;
  top: 15%;
}

.campusCity {
  height: 100px;
}

.dropdownLocalPolo {
  margin-top: 25px;
  width: 530px;
  height: 40px;
  font-size: 12px;
  color: #0c0c0c;
}

@media screen and (max-width: 991px) {
  .itensAddress-polo {
    margin-top: 15px;
  }

  .titleCampusEad {
    text-align: center;
  }

  .local-polo {
    text-align: center;
  }
}

.titleCampusEad {
  top: 15%;
}

.titleCampusEad p {
  font-family: "Century Gothic";
  font-weight: bold;
  font-size: 25px;
  color: #f4630b;
  margin-top: 30px;
}
</style>
<section class="course-content">
  <div class="container">
    <div class="row">
      <div class="our-courses">
        <div class="section-header title-principals">
          <h2>Nossos Cursos </h2>
          <span class="double-border"></span>
          <p>Gradue-se nos melhores cursos do país.</p>
        </div>

        <div id="filters" class="button-group ">
          <button class="button is-checked" data-filter="*">Todos os cursos</button>
          <button class="button" data-filter=".cat-1">Exatas</button>
          <button class="button" data-filter=".cat-2">Saúde</button>
          <button class="button" data-filter=".cat-3">Humanas</button>

        </div>
        <div class="course-items">
          <?php
          $cat='';
          foreach ($campusCursos as $row) {
            if ($row->areas_id == 1) {
              $cat = 'cat-1';
            }elseif ($row->areas_id == 2){
              $cat = 'cat-2';
            }elseif ($row->areas_id == 3){
              $cat = 'cat-3';
            }
            ?>
          <div class="item <?php echo $cat; ?>" data-category="transition">
            <div class="item-inner">
              <?php
                if($isead){
                    $pathcurso = "ead/uniatenas/$row->id";
                }else{
                    $pathcurso = "graduacao/eadUniatenas/$uricampus/$row->id";
                }
                echo anchor($pathcurso, '
                <h4 class="title-ead">'.$row->name.'</h4>
                <div class="course-img">
                    <div class="course-overlay"></div>
                    <img src="'.base_url($row->capa) . '" alt="recent-project-img-1">
                </div>');

              if(isset($row->link_vestibular) and $row->link_vestibular != ''){
              ?>
              <div class="our-course-content">
                <h4>
                  <a href="<?php echo $row->link_vestibular; ?>" class="download-btn">
                    VESTIBULAR ONLINE<span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                  </a>
                </h4>
              </div>
              <?php 
              }
              ?>
            </div>

          </div>
          <?php
          }
          ?>

        </div>
      </div>
    </div>
  </div>
</section>
<!--Em caso de correção do primeiro e segundo script, não mecher no arquivo que esta na pasta usar, nesse caso
usar a pasta src do diretorio assets/js/bundleJs/src. Pois o script esta utiliazando esc-6 atraves do babel.
Então deve ser feito uma instalação do babel no ambiente dev e fazer upload só da pasta usar.
 -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bundleJs/usar/eadRender.js"></script>
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