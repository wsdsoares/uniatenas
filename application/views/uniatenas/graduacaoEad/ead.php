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
<!--section-- class="bg-page-ead">
    <div name="polos" style="display: none"><?php echo json_encode($polos); ?></div>
    <div class="container">
        <div class="row">
            <div class="bg-page-graduacao-ead">

            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="campusCity">
                    <div class="col-md-2 titleCampusEad">
                        <p>Cursos - EaD</p>
                    </div>
                    <div class="col-md-5 col-xs-12 local-polo">
                        <select class="dropdownLocalPolo">
                            <option value="limp">Selecione o polo</option>
                            <option value="0">TODOS OS POLOS</option>
                            <option value="4">João Pinheiro(MG)</option>
                            <option value="1">Paracatu(MG)</option>
                            <option value="2">Passos(MG)</option>
                            <option value="5">Vazante(MG)</option>
                        </select>
                    </div>
                    <div class="col-md-5 col-xs-12 itensAddress-polo">
                        <div class="address-polo" >
                            <address>
                                <p>
                                    <span style="float: left;">
                                        <spam style="float: left" id="endereco"> <strong>Endereço:</strong> Rua Euridamas Avelino de Barros, 60, Lavrado - 38.602-000, Paracatu (MG).</span>
                                    <br>
                                    </span>
                                    <strong>Email: </strong> <a href="mailto:jim@rock.com" id="email">jim@rock.com</a><br>
                                    <strong>Telefone: </strong> <a href="tel:+13115552368" id="telefone">(311) 555-2368</a>
                                    <br>
                                    <strong>Celular: </strong> <a href="tel:+13115552368" id="celular">(311) 555-2368</a></p>
                            </address>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section-->

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
                                if($isead){
                                    $pathcurso = "ead/uniatenas/$row->id";
                                }else{
                                    $pathcurso = "graduacao/eadUniatenas/$uricampus/$row->id";
                                }
                                echo anchor($pathcurso, '
                                <h4 class="title-ead">'.$row->name.'</h4>
                                <div class="course-img">
                                    <div class="course-overlay"></div>
                                    <img src="'.base_url($row->icone) . '" alt="recent-project-img-1">
                                </div>');
                                ?>
                                <div class="our-course-content">
                                    <h4>
                                        <!--?php
                                        echo anchor("graduacao/inscricaoEad/$uricampus/$row->id", '
                                            INSCREVA-SE
                                            <span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                                        ', array('class' => "download-btn"));
                                        ?-->
                                        <a href="http://177.69.195.21:8080/prova/entrar"
                                           class="download-btn">
                                            VESTIBULAR ONLINE<span><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                                        </a>
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
                <div class="col-sm-12 col-md-12 m-t-30 text-center">
                    <a class="btn btn-default btn-lg">Ver mais detalhes</a>
                </div-->
                </div>
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
