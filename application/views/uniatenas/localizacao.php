<style>
    .hovereffect {
        width: 100%;
        height: 100%;
        float: left;
        overflow: hidden;
        position: relative;
        text-align: center;
        cursor: default;
    }

    .hovereffect .overlay {
        width: 100%;
        height: 100%;
        position: absolute;
        overflow: hidden;
        top: 0;
        left: 0;
        opacity: 0;
        filter: alpha(opacity=0);
        background-color: rgba(0, 0, 0, 0.5);
        -webkit-transition: all 0.4s cubic-bezier(0.88, -0.99, 0, 1.81);
        transition: all 0.4s cubic-bezier(0.88, -0.99, 0, 1.81);
    }

    .hovereffect img {
        display: block;
        position: relative;
        -webkit-transition: all 0.4s cubic-bezier(0.88, -0.99, 0, 1.81);
        transition: all 0.4s cubic-bezier(0.88, -0.99, 0, 1.81);
    }

    .hovereffect h2 {
        text-transform: uppercase;
        color: #fff;
        text-align: center;
        position: relative;
        font-size: 17px;
        background: rgba(0, 0, 0, 0.6);
        -webkit-transform: translatey(-100px);
        -ms-transform: translatey(-100px);
        transform: translatey(-100px);
        -webkit-transition: all 0.4s cubic-bezier(0.88, -0.99, 0, 1.81);
        transition: all 0.4s cubic-bezier(0.88, -0.99, 0, 1.81);
        padding: 10px;
    }

    .hovereffect a.info {
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        color: #fff;
        border: 1px solid #fff;
        background-color: transparent;
        opacity: 0;
        filter: alpha(opacity=0);
        -webkit-transition: all 0.4s ease;
        transition: all 0.4s ease;
        margin: 5px 0 0;
        padding: 7px 14px;
    }

    .hovereffect a.info:hover {
        box-shadow: 0 0 5px #fff;
    }

    .hovereffect:hover img {
        -ms-transform: scale(1.2);
        -webkit-transform: scale(1.2);
        transform: scale(1.2);
    }

    .hovereffect:hover .overlay {

        opacity: 1;
        filter: alpha(opacity=100);
    }

    .hovereffect:hover h2, .hovereffect:hover a.info {
        opacity: 1;
        filter: alpha(opacity=100);
        -ms-transform: translatey(0);
        -webkit-transform: translatey(0);
        transform: translatey(0);
    }

    .hovereffect:hover a.info {
        -webkit-transition-delay: .2s;
        transition-delay: .2s;
    }

    .overlay span {
        color: #fff;
        font-weight: bold;
    }
</style>
<section id="contact">
    <div class="container">
        <div class="section-header">
            <h4>Localização - Onde Estamos</h4>
        </div>
        <div class="row">
            <main class="hm-gradient">
                <div class="container">

                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="hovereffect">
                            <img class="img-responsive"
                                 src="<?php echo base_url('assets/images/campus/uniatenas.png'); ?>" alt="">
                            <div class="overlay">
                                <h2>UniAtenas - Paracatu (MG)</h2>
                                <p>
                                    <span>Telefone:
                                        <span>(38) 3672-3737</span>
                                    </span>
                                </p>
                                <span>R. Euridamas Avelino de Barros nº 60, Bairro Lavrado, Paracatu (MG) CEP: 38602-018</span>
                                <a class="info" href="https://goo.gl/maps/RJzizB8qNqz4L1mNA" target="_blank">Abrir Localização</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="hovereffect">
                            <img class="img-responsive"
                                 src="<?php echo base_url('assets/images/campus/passos.png'); ?>" alt="">
                            <div class="overlay">
                                <h2>Faculdade Atenas - Passos (MG)</h2>
                                <p>
                                    <span>Telefone:
                                        <span>(35) 3115-1200</span>
                                    </span>
                                </p>
                                <span>R. Amarantos, Nº 1.000, B. Jardim Colégio de Passos, Passos (MG) CEP 37.900.380</span>
                                <a class="info" href="https://goo.gl/maps/VRcQZmmL9LSf6X5F8" target="_blank">Abrir Localização</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="hovereffect">
                            <img class="img-responsive"
                                 src="<?php echo base_url('assets/images/campus/setelagoas.png'); ?>" alt="">
                            <div class="overlay">
                                <h2>Faculdade Atenas - Sete Lagoas (MG)</h2>
                                <p>
                                    <span>Telefone:
                                        <span>(31) 3509-2000</span>
                                    </span>
                                </p>
                                <span>Av. Pref. Alberto Moura - Progresso, Sete Lagoas (MG) CEP 35.702-3830</span>
                                <a class="info" href="https://goo.gl/maps/Viy3FRXyeNhgzPJY6" target="_blank">Abrir Localização</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>