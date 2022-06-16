<style>
    .process-step .btn:focus {
        outline: none
    }

    .process {
        display: table;
        width: 100%;
        position: relative
    }

    .process-row {
        display: table-row
    }

    .process-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important
    }

    text.Orange-label {
        color: Orange;
    }

    .process-row:before {
        top: 40px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-order: 0
    }

    .process-step {
        display: table-cell;
        text-align: center;
        position: relative
    }

    .process-step p {
        margin-top: 4px
    }

    .btn-circle {
        width: 80px;
        height: 80px;
        text-align: center;
        font-size: 12px;
        border-radius: 50%
    }

    p.Orange-label {
        color: Orange;
    }
</style>
<script>
    $(function () {
        $('.btn-circle').on('click', function () {
            $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');
            $(this).addClass('btn-info').removeClass('btn-default').blur();
        });

        $('.next-step, .prev-step').on('click', function (e) {
            var $activeTab = $('.tab-pane.active');

            $('.btn-circle.btn-info').removeClass('btn-info').addClass('btn-default');

            if ($(e.target).hasClass('next-step')) {
                var nextTab = $activeTab.next('.tab-pane').attr('id');
                $('[href="#' + nextTab + '"]').addClass('btn-info').removeClass('btn-default');
                $('[href="#' + nextTab + '"]').tab('show');
            } else {
                var prevTab = $activeTab.prev('.tab-pane').attr('id');
                $('[href="#' + prevTab + '"]').addClass('btn-info').removeClass('btn-default');
                $('[href="#' + prevTab + '"]').tab('show');
            }
        });
    });
</script>
<style>
    .transition-timer-carousel .carousel-caption {
        background: -moz-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(0, 0, 0, 0)), color-stop(4%, rgba(0, 0, 0, 0.1)), color-stop(32%, rgba(0, 0, 0, 0.5)), color-stop(100%, rgba(0, 0, 0, 1))); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%); /* IE10+ */
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.1) 4%, rgba(0, 0, 0, 0.5) 32%, rgba(0, 0, 0, 1) 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#000000', GradientType=0); /* IE6-9 */
        width: 100%;
        left: 0px;
        right: 0px;
        bottom: 0px;
        text-align: left;
        padding-top: 5px;
        padding-left: 15%;
        padding-right: 15%;
    }

    .transition-timer-carousel .carousel-caption .carousel-caption-header {
        margin-top: 10px;
        font-size: 24px;
    }

    @media (min-width: 970px) {
        /* Lower the font size of the carousel caption header so that our caption
        doesn't take up the full image/slide on smaller screens */
        .transition-timer-carousel .carousel-caption .carousel-caption-header {
            font-size: 36px;
        }
    }

    @media (max-width: 320px) {
        /* Lower the font size of the carousel caption header so that our caption
        doesn't take up the full image/slide on smaller screens */
        .transition-timer-carousel .carousel-caption .carousel-caption-header {
            font-size: 18px;
        }
    }

    .transition-timer-carousel .carousel-indicators {
        bottom: 0px;
        margin-bottom: 5px;
    }

    .transition-timer-carousel .carousel-control {
        z-index: 11;
    }

    .transition-timer-carousel .transition-timer-carousel-progress-bar {
        height: 5px;
        background-color: #5cb85c;
        width: 0%;
        margin: -5px 0px 0px 0px;
        border: none;
        z-index: 11;
        position: relative;
    }

    .transition-timer-carousel .transition-timer-carousel-progress-bar.animate {

        -webkit-transition: width 4.25s linear;
        -moz-transition: width 4.25s linear;
        -o-transition: width 4.25s linear;
        transition: width 4.25s linear;
    }
</style>
<?php
$potho = 'assets/images/gallery/library/fotoptu1.png';
$potho2 = 'assets/images/gallery/library/fotoptu2.png';
$potho3 = 'assets/images/gallery/library/fotoptu3.png';
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<div class="container">
    <div class="row">
        <div class="section-header text-center">
            <h3><?php echo 'HUNA - Hospital Universitário Atenas - '. $campus->city . ' (' . $campus->uf . ')'; ?></h3>
        </div>
    </div>
    <div class="row">
        <!-- The carousel -->
        <div id="transition-timer-carousel" class="carousel slide transition-timer-carousel" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#transition-timer-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#transition-timer-carousel" data-slide-to="1"></li>
                <li data-target="#transition-timer-carousel" data-slide-to="2"></li>
                <li data-target="#transition-timer-carousel" data-slide-to="3"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
            <?php
            $i = 1;
            foreach ($fotos as $foto){
                if($i == 1){
                    $ative = "active";
                }else{
                    $ative = "";
                }
                ?>

                <div class="item <?=$ative?>">
                    <img class="img-fluid img-thumbnail" src="<?php echo base_url($foto->file); ?>" style="width: 1170px; height: 390px; object-fit: cover; width:100% "/>
                    <div class="carousel-caption">
                        <h1 class="carousel-caption-header">Fotos do Huna
                            - <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h1>

                    </div>
                </div>
            <?php $i += 1;} ?>
            </div>

            <a class="left carousel-control" href="#transition-timer-carousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#transition-timer-carousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
            <hr class="transition-timer-carousel-progress-bar animate"/>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="container" style="margin: 46px 0 48px 0">
            <div class="section-header text-center">
                <a href="<?=base_url('/site/galeria_fotos/'.$urlcamp.'/'.$fotosCat.'/huna');?>" class="btn btn-success btn-sm" href="#">Galeria de Fotos - Huna</a>
            </div>
        </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="process">
                    <div class="process-row nav nav-tabs">
                        <div class="process-step">
                            <button type="button" class=" btn-info btn-circle" data-toggle="tab" href="#menu1"><i
                                        class="fas fa-hospital-alt fa-3x"></i></button>
                            <p><small><?php echo $dados['conteudoPag'][0]->title; ?></small></p>
                        </div>
                        <div class="process-step">
                            <button type="button" class=" btn-info btn-circle" data-toggle="tab" href="#menu2"><i
                                        class="fas fa-clock fa-3x"></i></button>
                            <p><small><?php echo $dados['conteudoPag'][1]->title; ?></small></p>
                        </div>
                        <div class="process-step">
                            <button type="button" class=" btn-info btn-circle" data-toggle="tab" href="#menu3"><i
                                        class="fas fa-stethoscope fa-3x"></i></button>
                            <p><small><?php echo $dados['conteudoPag'][4]->title; ?></small></p>
                        </div>
                        <div class="process-step">
                            <button type="button" class=" btn-info btn-circle" data-toggle="tab" href="#menu4">
                                <i class="fa fa-calendar-plus-o fa-3x" aria-hidden="true"></i>
                            </button>
                            <p><small><?php echo $dados['conteudoPag'][5]->title; ?></small></p>
                        </div>

                    </div>
                </div>
                <div class="tab-content">
                    <div id="menu1" class="tab-pane fade active in">
                        <div class="section-header text-center">
                            <h3><?php echo $dados['conteudoPag'][0]->title_short; ?></h3>
                        </div>
                        <p><?php echo $dados['conteudoPag'][0]->description; ?>.</p>
                        <ul class="list-unstyled list-inline pull-right">
                            <li>
                                <button type="button" class="btn btn-info next-step">próximo <i
                                            class="fa fa-chevron-right"></i></button>
                            </li>
                        </ul>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <div class="section-header text-center">
                            <h3><?php echo $dados['conteudoPag'][1]->title_short; ?></h3>
                        </div>
                        <p><?php echo $dados['conteudoPag'][1]->description; ?>.</p>
                        <ul class="list-unstyled list-inline pull-right">
                            <li>
                                <button type="button" class="btn btn-info prev-step"><i class="fa fa-chevron-left"></i>
                                    voltar
                                </button>
                            </li>
                            <li>
                                <button type="button" class="btn btn-info next-step">próximo <i
                                            class="fa fa-chevron-right"></i></button>
                            </li>
                        </ul>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        <div class="section-header text-center">
                            <h3><?php echo $dados['conteudoPag'][4]->title_short; ?></h3>
                        </div>
                        <p><?php echo $dados['conteudoPag'][4]->description; ?>.</p>
                        <ul class="list-unstyled list-inline pull-right">

                            <button type="button" class="btn btn-info prev-step"><i class="fa fa-chevron-left"></i>
                                voltar
                            </button>
                            <li>
                                <button type="button" class="btn btn-info next-step">próximo <i
                                            class="fa fa-chevron-right"></i></button>
                            </li>
                        </ul>
                    </div>
                    <div id="menu4" class="tab-pane fade">
                        <div class="section-header text-center">
                            <h3><?php echo $dados['conteudoPag'][5]->title_short; ?></h3>
                        </div>
                        <p><?php echo $dados['conteudoPag'][5]->description; ?>.</p>
                        <ul class="list-unstyled list-inline pull-right">

                            <li>
                                <button type="button" class="btn btn-info prev-step"><i class="fa fa-chevron-left"></i>
                                    voltar
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4">
            <div class="widget-sidebar">
                <h2 class="title-widget-sidebar"><?php echo $dados['conteudoPag'][2]->title; ?></h2>
                <div class="content-widget-sidebar">
                    <ul>
                        <li class="recent-post-alunos">
                            <div class="col-sm-3 col-xs-4">
                                <div class="ico-wrap">
                                    <i class="fas fa-mobile-alt fa-2x"></i>
                                </div>
                                </a>
                            </div>
                            <div class="col-sm-9 col-xs-8 ">
                                <small>
                                    <div class=" "><?php echo $dados['conteudoPag'][2]->description; ?></div>
                                </small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="widget-sidebar">
                <h2 class="title-widget-sidebar"><?php echo $dados['conteudoPag'][3]->title; ?></h2>
                <div class="content-widget-sidebar">
                    <ul>
                        <li class="recent-post-alunos">
                            <div class="col-sm-3 col-xs-4">
                                <a target="blank" href="https://www.google.com.br/search?client=opera&hs=06a&sxsrf=ACYBGNRKHKySOw3joRpwnxcy8geUv-HM6Q:1569440790185&q=Rua%20Euridamas%20Avelino%20de%20Barros%2C%20n%C2%BA%2060%20%E2%80%93%20Lavrado%2C%20Paracatu%2FMG.&sa=X&ved=2ahUKEwiR2q3G3uzkAhXOEbkGHR6xD60QvS4wAHoECAoQEg&biw=1320&bih=658&dpr=1&npsic=0&rflfq=1&rlha=0&rllag=-17228203,-46888900,656&tbm=lcl&rldimm=17283646869125714587&rldoc=1&tbs=lrf:!2m1!1e2!3sIAE,lf:1,lf_ui:2#rlfi=hd:;si:7210518833530095322;mv:[[-17.2249028,-46.8805074],[-17.2304849,-46.8955299]]">
                                    <div class="ico-wrap">
                                        <i class="fas fa-map-marked-alt fa-2x"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-9 col-xs-8 ">
                                <small>
                                    <div class=" "><?php echo $dados['conteudoPag'][3]->description; ?></div>
                                </small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<br/>
<br/>