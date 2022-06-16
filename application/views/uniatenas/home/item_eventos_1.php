<?php 
$urisegment = $this->uri->segment(3);
?>
<script>
    $(document).ready(function () {

        var clickEvent = false;
        $('#myCarousel').carousel({
            interval: 4000
        }).on('click', '.list-group li', function () {
            clickEvent = true;
            $('.list-group li').removeClass('active');
            $(this).addClass('active');
        }).on('slid.bs.carousel', function (e) {
            if (!clickEvent) {
                var count = $('.list-group').children().length - 1;
                var current = $('.list-group li.active');
                current.removeClass('active').next().addClass('active');
                var id = parseInt(current.data('slide-to'));
                if (count == id) {
                    $('.list-group li').first().addClass('active');
                }
            }
            clickEvent = false;
        });
    })

    $(window).load(function () {
        var boxheight = $('#myCarousel .carousel-inner').innerHeight();
        var itemlength = $('#myCarousel .item').length;
        var triggerheight = Math.round(boxheight / itemlength + 1);
        $('#myCarousel .list-group-item').outerHeight(triggerheight);
    });
</script>
<style>
    .active h4{
        color:#fff;
    }
    .bg-upcoming-events{
        background: #f1f1f1;
    }
    #myCarousel .carousel-caption {
        left:0;
        right:0;
        bottom:0;
        text-align:left;
        padding:5px;
        background: rgba(219,219,219,0.9);
        text-shadow:none;
    }

    #myCarousel .list-group {
        position:absolute;
        top:0;
        right:0;
    }
    #myCarousel .list-group-item {
        border-radius:0px;
        cursor:pointer;
    }
    #myCarousel .list-group .active {
        background-color:#eee;	
    }

    @media (min-width: 992px) { 
        #myCarousel {padding-right:33.3333%;}
        #myCarousel .carousel-controls {display:none;} 	
    }
    @media (max-width: 991px) { 
        .carousel-caption p,
        #myCarousel .list-group {display:none;} 
    }
</style>
<section class="bg-upcoming-events" data-container="eventos">
    <div class="container">
        <div class="row">
            <div class="upcoming-events">
                <div class="section-header text-center">
                    <h2>Espaço para eventos</h2>
                    <span class="double-border"></span>
                    <h3>O Lugar ideial para realizar seus eventos.</h3>
                </div>
                <div class="row">

                    <div id="myCarousel" class="carousel slide" data-ride="carousel">

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">

                            <div class="item active">
                                <img src="<?php echo base_url('assets/images/events/anfiteattro1.jpg') ?>" style="width:760px;max-height: 400px;">
                                <div class="carousel-caption">
                                    <h4><a href="#">Auditório/Anfiteatro</a></h4>
                                    <p>O lugar ideal para realizar seus eventos
                                        <?php
                                        echo anchor("site/espaco_eventos/$urisegment", 'Ver mais',array('class'=>'btnEdital'));
                                        ?>
                                    </p>

                                </div>
                            </div><!-- End Item -->

                            <div class="item">
                                <img src="<?php echo base_url('assets/images/events/auditoriohefa.jpg') ?>" style="width:760px;max-height: 400px;">
                                <div class="carousel-caption">
                                    <h4><a href="#">Auditório HEFA</a></h4>
                                    <p>O lugar ideal para realizar seus eventos
                                        <?php
                                        echo anchor("site/espaco_eventos/$urisegment", 'Ver mais',array('class'=>'btnEdital'));
                                        ?>
                                    </p>
                                </div>
                            </div><!-- End Item -->

                            <div class="item">
                                <img src="<?php echo base_url('assets/images/events/sala-aula.jpg') ?>" style="width:760px;max-height: 400px;">
                                <div class="carousel-caption">
                                    <h4><a href="#">Salas de Aula</a></h4>
                                    <p>O lugar ideal para realizar seus eventos
                                        <?php
                                        echo anchor("site/espaco_eventos/$urisegment", 'Ver mais',array('class'=>'btnEdital'));
                                        ?>
                                    </p>
                                </div>
                            </div><!-- End Item -->

                            <div class="item">
                                <img src="<?php echo base_url('assets/images/events/salao-nobre.jpg') ?>" style="width:760px;max-height: 400px;">
                                <div class="carousel-caption">
                                    <h4><a href="#">Salão Nobre</a></h4>
                                    <p>O lugar ideal para realizar seus eventos
                                        <?php
                                        echo anchor("site/espaco_eventos/$urisegment", 'Ver mais',array('class'=>'btnEdital'));
                                        ?>
                                    </p>
                                </div>
                            </div>

                            <div class="item">
                                <img src="<?php echo base_url('assets/images/events/uniatenas.jpg') ?>" style="width:760px;max-height: 400px;">
                                <div class="carousel-caption">
                                    <h4><a href="#">Espaço UniAtenas</a></h4>
                                    <p>O lugar ideal para realizar seus eventos
                                        <?php
                                        echo anchor("site/espaco_eventos/$urisegment", 'Ver mais',array('class'=>'btnEdital'));
                                        ?>
                                    </p>
                                </div>
                            </div>

                        </div>


                        <ul class="list-group col-sm-4">
                            <li data-target="#myCarousel" data-slide-to="0" class="list-group-item active"><h4>Anfiteatro/ Auditório</h4></li>
                            <li data-target="#myCarousel" data-slide-to="1" class="list-group-item"><h4>Auditório do HUNA</h4></li>
                            <li data-target="#myCarousel" data-slide-to="2" class="list-group-item"><h4>Salas de Aula</h4></li>
                            <li data-target="#myCarousel" data-slide-to="3" class="list-group-item"><h4>Salão Nobre</h4></li>
                            <li data-target="#myCarousel" data-slide-to="4" class="list-group-item"><h4>UniAtenas</h4></li>
                        </ul>

                        <div class="carousel-controls">
                            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>

                    </div>
                    <center>
                        <?php
                        echo anchor("site/espaco_eventos/", 'Ver mais',array('class'=>'btnEdital'));
                        ?>
                    </center>
                </div>
            </div>
        </div>
    </div>
</section>

