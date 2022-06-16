<style>

    .btn-submit {
        background: #FFD34E;
        border: 0px;
        display: inline-block;
        font-size: 16px;
        text-transform: uppercase;
        padding: 10px 40px;
        font-weight: normal;
        border-radius: 0px;
        letter-spacing: 1px;
        color: #333;
        position: relative;
        overflow: hidden;
        -webkit-transition: all 0.4s ease-in-out;
        -moz-transition: all 0.4s ease-in-out;
        -o-transition: all 0.4s ease-in-out;
        -ms-transition: all 0.4s ease-in-out;
        transition: all 0.4s ease-in-out;
        margin-top: 25px;
        border: 2px solid #FFD34E;
    }

    .btn-submit:hover {
        background: #fff;
    }

    /****/

    #cta-1 {
        padding: 20px 0px;
    }

    .cta-info h3 {
        font-size: 24px;
    }


    #feature {
        background-color: #f8f8f8;
    }

    .head-title {
        color: #2b2b2b;
        font-size: 32px;
        font-weight: 700;
    }

    .botm-line {
        background-color: #2b2b2b;
        width: 34px;
        height: 3px;
        display: inline-block;
    }

    .section-title:hover .botm-line {
        width: 70px;
        /* For Safari 3.1 to 6.0 */
        -webkit-transition-property: width;
        -webkit-transition-duration: 2s;
        -webkit-transition-timing-function: linear;
        -webkit-transition-delay: 1s;
        /* Standard syntax */
        transition-property: width;
        transition-duration: 2s;
        transition-timing-function: linear;
        transition-delay: 1s;
    }

    p {
        color: #888;
    }

    .icon {
        position: relative;
        height: 48px;
        width: 48px;
        float: left;
        margin-top: 14px;
        margin-bottom: 20px;
    }

    .icon i {
        font-size: 35px;
    }

    .icon-text {
        margin-left: 73px;
        padding: 0px 25px 25px 0px;
    }

    h3.txt-tl {
        font-size: 24px;
        line-height: 1.35;
    }

    /****/

    .parallax {
        background-attachment: fixed;
        background-repeat: repeat-y;
        background-position: center center;
    }

    .bg-image-2 {
        background: url('../assets/images/financing/cta-banner.jpg') no-repeat center fixed;
        -webkit-background-size: 100% auto;
        -moz-background-size: 100% auto;
        -o-background-size: 100% auto;
        background-size: 100% auto;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }

    .section {
        position: relative;
        padding: 88px 0 67px 0;
        display: block;
    }

    .cta-txt {
        padding: 10px;
        background: #fff;

    }

    .cta-txt h3 {
        color: #ffa000;
        font-size: 32px;
        margin-bottom: 10px;
        font-weight: 700;
        opacity: 1.0;

    }

    .cta-txt p {
        opacity: 1.0;
        color: #000;
        font-weight: bold;
        font-size: 18px;

    }


    .location-info p span {
        display: inline-block;
    }

    .location-info p span {
        width: 40px;
        font-size: 24px;
        color: #666;
        vertical-align: middle;
    }

    .location-info p {
        margin-bottom: 5px;
    }

    .location-info p {
        font-size: 18px;
        line-height: 32px;
        color: #000;
    }

    .footer-social a {
        font-size: 18px;
        color: #666;
    }

    /****/

    @media (min-width: 451px) and (max-width: 900px) {
        .section-title {
            margin-bottom: 15px;
        }
    }

    @media (min-width: 20px) and (max-width: 450px) {


        .section-title {
            margin-bottom: 15px;
        }

        .cta-txt h3 {
            font-size: 28px;
        }
    }

    .cardFinancial {
        min-height: 250px;
    }
    p.txt-para{
        background: red;
    }
</style>

<div class="section-header">
    <h3> Saiba algumas informações a respeito formas de pagar por seus estudos. <br/><?php echo $dados['campus']->name . ' - ' . $dados['campus']->city . '(' . $dados['campus']->uf . ')'; ?>
    </h3>
</div>
<?php
if ($campus->id == 1) {
    ?>
    <section id="cta-1">
        <div class="container">
            <div class="row text-center">

                <img src="<?php echo base_url('assets/images/financing/inscreva-se-geral.jpg') ?>" class="img-fluid">

            </div>
        </div>
    </section>
    <?php
}
?>
<section id="feature" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-3 wow fadeInLeft delay-05s">
                <div class="section-title">

                    <h2 class="head-title"><?php echo $conteudoPag[0]->title_short; ?></h2>
                    <hr class="botm-line">
                    <p class="sec-para"><?php echo $conteudoPag[0]->description; ?></p>
                </div>
            </div>
            <div class="col-md-9">
                <?php

                for ($i = 1; $i < count($dados['conteudoPag']); $i++) {
                    ?>
                    <div class="cardFinancial col-md-6 wow fadeInRight delay-02s">
                        <div class="icon">
                            <i class="fas fa-money-check-alt"></i>
                        </div>
                        <div class="icon-text">
                            <h3 class="txt-tl"><?php echo $dados['conteudoPag'][$i]->title; ?></h3>
                            <p class="txt-para">
                                <?php

                                $max = 150;
                                $str = $dados['conteudoPag'][$i]->description;
                                to_html(substr_replace($str, (strlen($str) > $max ? '...' : ''), $max));

                                echo $texto = mb_substr($str, 0, mb_strrpos(mb_substr($str, 0, $max), ' '), 'UTF-8') . '...';

                                echo anchor('financiamentos/inicio/');

                                ?>
                                <a href="#" class="btn btn-primary btn-sm btn-block buy-now">
                                    Saiba mais <span class="glyphicon glyphicon-triangle-right"></span>
                                </a>
                            </p>

                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>
<section class="section-padding parallax bg-image-2 section wow fadeIn delay-08s" id="cta-2">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="cta-txt">
                    <h3>A oportunidade de realizar seu sonho</h3>
                    <p>Venha estudar em uma das melhores instituições do país. Venha construir aqui a sua história!</p>
                </div>
            </div>
            <?php
            if ($campus->id == 1) {
                ?>
                <div class="col-md-4 text-center">
                    <a href="#" class="btn btn-submit">Inscreva-se agora.</a>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>
