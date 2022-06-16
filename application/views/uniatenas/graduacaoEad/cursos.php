
<section class="bg-page-header bg-page-graduacao-ead">
    <div class="page-header-overlay">
        <div class="container">
            <div class="row">

            </div>
        </div>
    </div>
</section>
<!-- End Page Header Section -->

<section class="course-content">
    <div class="container">
        <div class="row">
            <div class="our-courses">
                <div class="section-header title-principals">
                    <h2>Nossos Cursos</h2>
                    <span class="double-border"></span>
                    <p>Gradue-se nos melhores cursos do país.</p>
                </div>
                <!-- .section-header -->

                <div id="filters" class="button-group ">
                    <button class="button is-checked" data-filter="*">Todos os cursos</button>
                    <button class="button" data-filter=".cat-1">Exatas</button>
                    <button class="button" data-filter=".cat-2">Saúde</button>
                    <button class="button" data-filter=".cat-3">Humanas / Social</button>
                   <!--  <button class="button" data-filter=".cat-uniasselvi">Uniasselvi</button> -->

                </div>
                <div class="course-items">
                    <?php
                    $cat='';
                    foreach ($cursos as $row) {
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
                                echo anchor("Site/graduacaoEad/$row->types/$row->id", '
                                <h4 class="title-ead">'.$row->name.'</h4>
                                <div class="course-img">
                                    <div class="course-overlay"></div>
                                    <img src="'.base_url($row->icone) . '" alt="recent-project-img-1">
                                </div>');
                                ?>
                                <div class="our-course-content">
                                    <h4>
                                        <?php
                                        echo anchor("Site/InscricaoEad/$row->types/$row->id", '
                                            INSCREVA-SE
                                            <span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                                        ', array('class' => "download-btn"));
                                        ?> 
                                    </h4>
                                </div>
                            </div>

                        </div>
                        <?php
                    }
                    ?>
          <!--
                    <div class="item cat-uniasselvi" data-category="transition">
                        <div class="item-inner">
                            <?php
                            echo anchor("Site/graduacaoEad/eadUniasselvi/uniasselvi", '
                                 <h4 class="title-ead">Demais Cursos</h4>
                            <div class="course-img">
                                <div class="course-overlay"></div>
                                <img src="http://www.atenas.edu.br/uniatenas/assets/images/courses/ead/demais_cursos.jpg" alt="recent-project-img-1">
                                <ul class="course-link">
                                    <li class="c-link">
                                        
                                        
                                    </li>
                                </ul>
                                        
                            </div>');
                           
              ?>
                
              <div class="our-course-content">
                                <h4>
              
                                    <?php
                                    echo anchor("Site/graduacaoEad/eadUniasselvi/uniasselvi", '
                                    Saiba mais
                                        <span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                                        ', array('class' => "download-btn"));
                                    ?> 

                                </h4>
                            </div>
              
                        </div>
                    </div>

                </div>
                <!--div class="col-sm-12 col-md-12 m-t-30 text-center">
                    <a class="btn btn-default btn-lg">Ver mais detalhes</a>
                </div-->
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
