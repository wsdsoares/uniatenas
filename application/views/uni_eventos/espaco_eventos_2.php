<style>
    .card {
        background-color: #fff;
        border: 1px solid transparent;
        border-radius: 6px;
    }

    .card > .card-link {
        color: #333;
    }

    .card > .card-link:hover {
        text-decoration: none;
    }

    .card > .card-link .card-img img {
        border-radius: 6px 6px 0 0;
    }

    .card .card-img {
        position: relative;
        padding: 0;
        display: table;
    }

    .card .card-img .card-caption {
        position: absolute;
        right: 0;
        bottom: 16px;
        left: 0;
    }

    .card .card-body {
        display: table;
        width: 100%;
        padding: 12px;
    }

    .card .card-header {
        border-radius: 6px 6px 0 0;
        padding: 8px;
    }

    .card .card-footer {
        border-radius: 0 0 6px 6px;
        padding: 8px;
    }

    .card .card-left {
        position: relative;
        float: left;
        padding: 0 0 8px 0;
    }

    .card .card-right {
        position: relative;
        float: left;
        padding: 8px 0 0 0;
    }

    .card .card-body h1:first-child,
    .card .card-body h2:first-child,
    .card .card-body h3:first-child,
    .card .card-body h4:first-child,
    .card .card-body .h1,
    .card .card-body .h2,
    .card .card-body .h3,
    .card .card-body .h4 {
        margin-top: 0;
    }

    .card .card-body .heading {
        display: block;
    }

    .card .card-body .heading:last-child {
        margin-bottom: 0;
    }

    .card .card-body .lead {
        text-align: center;
    }

    @media ( min-width: 768px ) {
        .card .card-left {
            float: left;
            padding: 0 8px 0 0;
        }

        .card .card-right {
            float: left;
            padding: 0 0 0 8px;
        }

        .card .card-4-8 .card-left {
            width: 33.33333333%;
        }

        .card .card-4-8 .card-right {
            width: 66.66666667%;
        }

        .card .card-5-7 .card-left {
            width: 41.66666667%;
        }

        .card .card-5-7 .card-right {
            width: 58.33333333%;
        }

        .card .card-6-6 .card-left {
            width: 50%;
        }

        .card .card-6-6 .card-right {
            width: 50%;
        }

        .card .card-7-5 .card-left {
            width: 58.33333333%;
        }

        .card .card-7-5 .card-right {
            width: 41.66666667%;
        }

        .card .card-8-4 .card-left {
            width: 66.66666667%;
        }

        .card .card-8-4 .card-right {
            width: 33.33333333%;
        }
    }

    /* -- default theme ------ */
    .card-default {
        border-color: #ddd;
        background-color: #fff;
        margin-bottom: 24px;
    }

    .card-default > .card-header,
    .card-default > .card-footer {
        color: #333;
        background-color: #ddd;
    }

    .card-default > .card-header {
        border-bottom: 1px solid #ddd;
        padding: 8px;
    }

    .card-default > .card-footer {
        border-top: 1px solid #ddd;
        padding: 8px;
    }

    .card-default > .card-body {
    }

    .card-default > .card-img:first-child img {
        border-radius: 6px 6px 0 0;
    }

    .card-default > .card-left {
        padding-right: 4px;
    }

    .card-default > .card-right {
        padding-left: 4px;
    }

    .card-default p:last-child {
        margin-bottom: 0;
    }

    .card-default .card-caption {
        color: #fff;
        text-align: center;
        text-transform: uppercase;
    }


    /* -- price theme ------ */
    .card-price {
        border-color: #999;
        background-color: #ededed;
        margin-bottom: 24px;
    }

    .card-price > .card-heading,
    .card-price > .card-footer {
        color: #333;
        background-color: #fdfdfd;
    }

    .card-price > .card-heading {
        border-bottom: 1px solid #ddd;
        padding: 8px;
    }

    .card-price > .card-footer {
        border-top: 1px solid #ddd;
        padding: 8px;
    }

    .card-price > .card-img:first-child img {
        border-radius: 6px 6px 0 0;
    }

    .card-price > .card-left {
        padding-right: 4px;
    }

    .card-price > .card-right {
        padding-left: 4px;
    }

    .card-price .card-caption {
        color: #fff;
        text-align: center;
        text-transform: uppercase;
    }

    .card-price p:last-child {
        margin-bottom: 0;
    }

    .card-price .price {
        text-align: center;
        color: #337ab7;
        font-size: 3em;
        text-transform: uppercase;
        line-height: 0.7em;
        margin: 24px 0 16px;
    }

    .card-price .price small {
        font-size: 0.4em;
        color: #66a5da;
    }

    .card-price .details {
        list-style: none;
        margin-bottom: 24px;
        padding: 0 18px;
    }

    .card-price .details li {
        text-align: center;
        margin-bottom: 8px;
    }

    .card-price .buy-now {
        text-transform: uppercase;
    }

    .card-price table .price {
        font-size: 1.2em;
        font-weight: 700;
        text-align: left;
    }

    .card-price table .note {
        color: #666;
        font-size: 0.8em;
    }
</style>

<script>
    $(document).ready(function () {
        $('#carouselEvents').carousel({
            interval: 5000
        });

        var clickEvent = false;
        $('#carouselEvents').on('click', '.nav a', function () {
            clickEvent = true;
            $('.nav li').removeClass('active');
            $(this).parent().addClass('active');
        }).on('slid.bs.carousel', function (e) {
            if (!clickEvent) {
                var count = $('.nav').children().length - 1;
                var current = $('.nav li.active');
                current.removeClass('active').next().addClass('active');
                var id = parseInt(current.data('slide-to'));
                if (count == id) {
                    $('.nav li').first().addClass('active');
                }
            }
            clickEvent = false;
        });
    });
</script>
<div class="container">
    <div class="section-header text-center">
        <h3>Espaço para eventos</h3>
    </div>
    <div class="col-xs-12">
        <div class="information-library-campus text-justify">
            <p>
                <?php echo $dados['conteudoPag'][0]->description; ?>
            </p>
        </div>
    </div>
</div>

<div class="container">

    <div id="carouselEvents" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            for ($i = 0; $i < count($dados['espacoEventos']); $i++) {
                ?>
                <div class="item <?php
                if ($i == 0) {
                    echo 'active';
                }
                ?>">
                    <img src="<?php echo base_url($dados['espacoEventos'][$i]->photocape); ?>">

                </div>
                <?php
            }
            ?>
        </div>

        <ul class="nav nav-pills nav-justified">
            <?php
            for ($i = 0; $i < count($dados['espacoEventos']); $i++) {
                if ($i == 0) {
                    $class = 'active';
                } else {
                    $class = "null";
                }
                ?>
                <li data-target="#carouselEvents" data-slide-to="<?php echo $i; ?>" class="<?php echo $class; ?>">
                    <a href="#"><?php echo $dados['espacoEventos'][$i]->name; ?>
                    </a>
                </li>
                <?php
               
            }
            ?>
        </ul>
    </div>
</div>
<br/>
<br/>
<div class="container">
    <div class="row">
        <div class="section-header text-center">
            <h3>Galeria de fotos do espaços para eventos</h3>
        </div>
    </div>
    <?php
   
    ?>
    <div class="row">
        <?php
        //for ($i = 0;$i < count($dados['fotosEspaco']);$i++) {

      
            ?>
            <div class="col-sm-4">
                <h4 class="text-center"><?php //echo $dados['fotosEspaco'][$i]['name']; ?></h4>
                <div class="card card-price">
                    <div class="card-img">
                        <a href="#">
                            <img src="<?php //echo base_url($dados['fotosEspaco'][$i]['photos'])?>" class="img-responsive">
                            <div class="card-caption">
                                <span class="h2">Many Items</span>
                                <p>Gluten free</p>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="lead">So many choices.</div>
                        <ul class="details">
                            <li>A stitch in time saves nine.</li>
                            <li>All good things come to those who wait.</li>
                            <li>There's a pony in that pile.</li>
                        </ul>
                        <table class="table">
                            <tr>
                                <th></th>
                                <th>Price</th>
                                <th>Shipping</th>
                            </tr>
                            <tr>
                                <td>Small</td>
                                <td class="price">$20</td>
                                <td class="note">$3 ground service</td>
                            </tr>
                            <tr>
                                <td>Medium</td>
                                <td class="price">$30</td>
                                <td class="note">$6 ground service</td>
                            </tr>
                            <tr>
                                <td>Large</td>
                                <td class="price">$45</td>
                                <td class="note">$7 ground service</td>
                            </tr>
                        </table>
                        <a href="#" class="btn btn-primary btn-lg btn-block buy-now">
                            Buy now <span class="glyphicon glyphicon-triangle-right"></span>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        //}
        ?>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-footer">
            </div>
        </div>
    </div>
</div>