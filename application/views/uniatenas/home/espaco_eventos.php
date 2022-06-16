

<!------ Include the above in your HEAD tag ---------->
<style>
    #custom_carousel .item {

        color:#000;
        background-color:#eee;
        padding:20px 0;
    }
    #custom_carousel .controls{
        overflow-x: auto;
        overflow-y: hidden;
        padding:0;
        margin:0;
        white-space: nowrap;
        text-align: center;
        position: relative;
        background:#ddd
    }
    #custom_carousel .controls li {
        display: table-cell;
        width: 1%;
        max-width:90px
    }
    #custom_carousel .controls li.active {
        background-color:#eee;
        border-top:3px solid orange;
    }
    #custom_carousel .controls a small {
        overflow:hidden;
        display:block;
        font-size:10px;
        margin-top:5px;
        font-weight:bold
    }

    img.fotoespacoevento {
        width: 350px;
        height: 250px;
    }
</style>
<section class="espacoeventos">
    <div class="container">
        <div class="section-header">
            <h3>Espaço para Eventos</h3>
        </div>
        <div class="topoeventos" >
            <div class="row">
                <div class="col-md-8">
                    <div class="iconeseventos">
                        <div class="col-md-4 col-sm-4 col-xs-12">

                            <i class="fas fa-university fa-4x"></i>

                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <i class="fas fa-business-time fa-4x"></i>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <i class="fas fa-glass-cheers fa-4x"></i>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">

                    <p>Aqui no UniAtenas temos o espaço ideal para realizar seu evento.
                        <strong>Casamentos</strong>, <strong>Festas de 15 Anos</strong>, <strong>Bodas</strong>,
                        <strong>Palestras</strong>, <strong>Treinamentos</strong>, entre outros...
                        <br>

                        Todos os nossos espaços são extremamente confortáveis. Temos uma infraestrutura completa e o visual incrível do UniAtenas.
                    </p>
                </div>
            </div>  
        </div>
        <div class="row">
            <div class="locaisEventos">

                <div class="col-xs-12">
                    <div id="custom_carousel" class="carousel slide" data-ride="carousel" data-interval="2500">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-3 fotoespacoevento">
                                            <img src="<?php echo base_url('assets/images/events/anfiteattro1.jpg'); ?>" class="img-responsive">
                                        </div>
                                        <div class="col-md-9">
                                            <h2>Anfiteatro</h2>
                                            <p>Area: 500m2.</p>
                                            <p>Capacidade:600 pessoas.</p>
                                        </div>
                                    </div>
                                </div>            
                            </div> 
                            <div class="item">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="<?php echo base_url('assets/images/events/auditoriohefa.jpg'); ?>" class="img-responsive">
                                        </div>
                                        <div class="col-md-9">
                                            <h2>Auditório HEFA</h2>
                                            <p>Area: 500m2.</p>
                                            <p>Capacidade:600 pessoas.</p>
                                        </div>
                                    </div>
                                </div>               
                            </div> 
                            <div class="item">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="<?php echo base_url('assets/images/events/sala-aula.jpg'); ?>" class="img-responsive">
                                        </div>
                                        <div class="col-md-9">
                                            <h2>Sala de Aula</h2>
                                            <p>Area: 500m2.</p>
                                            <p>Capacidade:600 pessoas.</p>
                                        </div>
                                    </div>
                                </div>               
                            </div> 
                            <div class="item">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="<?php echo base_url('assets/images/events/salao-nobre.jpg'); ?>" class="img-responsive">
                                        </div>
                                        <div class="col-md-9">
                                            <h2>Salão Nobre</h2>
                                            <p>Area: 500m2.</p>
                                        </div>
                                    </div>
                                </div>               
                            </div> 
                            <div class="item">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img src="<?php echo base_url('assets/images/events/uniatenas.jpg'); ?>" class="img-responsive">
                                        </div>
                                        <div class="col-md-9">
                                            <h2>UniAtenas</h2>
                                            <p>Area: 500m2.</p>
                                        </div>
                                    </div>
                                </div>               
                            </div> 
                            <!-- End Item -->
                        </div>
                        <!-- End Carousel Inner -->
                        <div class="controls">
                            <ul class="nav">
                                <li data-target="#custom_carousel" data-slide-to="0" class="active"><a href="#"><img src="<?php echo base_url('assets/images/events/anfiteattro1.jpg'); ?>" style="width:50px; height:50px;"><small>Anfiteatro</small></a></li>
                                <li data-target="#custom_carousel" data-slide-to="1"><a href="#"><img src="<?php echo base_url('assets/images/events/auditoriohefa.jpg'); ?>" style="width:50px; height:50px;"><small>Auditório</small></a></li>
                                <li data-target="#custom_carousel" data-slide-to="2"><a href="#"><img src="<?php echo base_url('assets/images/events/auditoriohefa.jpg'); ?>" style="width:50px; height:50px;"><small>Salão Nobre</small></a></li>
                                <li data-target="#custom_carousel" data-slide-to="3"><a href="#"><img src="<?php echo base_url('assets/images/events/sala-aula.jpg'); ?>" style="width:50px; height:50px;"><small>Salas Aula</small></a></li>
                                <li data-target="#custom_carousel" data-slide-to="4"><a href="#"><img src="<?php echo base_url('assets/images/events/uniatenas.jpg'); ?>" style="width:50px; height:50px;"><small>UniAtenas</small></a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <br/>

        <div class="content_course">
            <center>
                <button class="btn btn-info">
                    Algumas fotos de nossos espaços
                </button>
            </center>
            <br/>
            <article>
                <div class="row">
                    <div class="section-header">
                        <h4>Anfiteatro</h4>
                    </div>
                    <div class="new-imgs">

                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/anfiteatro/1.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/anfiteatro/1.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/anfiteatro/2.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/anfiteatro/2.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/anfiteatro/3.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/anfiteatro/3.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/anfiteatro/4.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/anfiteatro/4.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/anfiteatro/5.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/anfiteatro/5.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/anfiteatro/6.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/anfiteatro/6.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/anfiteatro/7.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/anfiteatro/7.jpg'); ?>" alt=""/>
                        </a>


                    </div>
                     <div class="section-header">
                        <h4>Auditório HEFA</h4>
                    </div>
                    <div class="new-imgs">

                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/auditoriohefa/1.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/auditoriohefa/1.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/auditoriohefa/2.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/auditoriohefa/2.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/auditoriohefa/3.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/auditoriohefa/3.jpg'); ?>" alt=""/>
                        </a>
                    </div>
                    
                     <div class="section-header">
                        <h4>Salão Nobre</h4>
                    </div>
                    <div class="new-imgs">

                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salaonobre/1.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salaonobre/1.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salaonobre/2.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salaonobre/2.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salaonobre/3.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salaonobre/3.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salaonobre/4.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salaonobre/4.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salaonobre/5.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salaonobre/5.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salaonobre/6.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salaonobre/6.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salaonobre/7.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salaonobre/7.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salaonobre/8.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salaonobre/8.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salaonobre/9.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salaonobre/9.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salaonobre/10.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salaonobre/10.jpg'); ?>" alt=""/>
                        </a>
                    </div>
                    
                     <div class="section-header">
                        <h4>Salas de Aula</h4>
                    </div>
                    <div class="new-imgs">

                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salasaula/1.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salasaula/1.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salasaula/2.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salasaula/2.jpg'); ?>" alt=""/>
                        </a>
                        <a class="example-image-link" href="<?php echo base_url('assets/images/events/salasaula/3.jpg'); ?>" data-lightbox="example-set" data-title="Clique nos cantos direito ou esquerdo da imagem para avançar ou voltar.">
                            <img class="example-image" src="<?php echo base_url('assets/images/events/salasaula/3.jpg'); ?>" alt=""/>
                        </a>
                    </div>
                    
                </div>
            </article>
        </div>
    </div>
</section>
<br>
<br>

