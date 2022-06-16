<section class="services-section">
    <div class="container">

        <div class="dados_gerais">
            <div class="container">
                <h2 class="text-center">Revistas
                    <small><?php echo $campus->name . ' - ' . $campus->city; ?></small>
                </h2>
                <div class="section-header text-center">
                    <span class="double-border"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="btn-back">
            <?php echo anchor('site/pesquisa_inicicao_cientifica', 'Voltar', array('class' => "btn btn-danger")); ?>

        </div>
        <div class="row">
            <div class="services-option">
                <div class="col-xs-9">
                    <div class="row">
                        <?php
                        foreach ($revistas as $rev) {
                            ?>
                            <div class="col-md-3 col-sm-3 col-xs-3" style="text-align: center;">
                                <div class="services-box">
                                    <?php
                                    if($campus->id==3){
                                        $link = 'http://www.atenas.edu.br/revista/index.php/higeia';
                                    }else{
                                        $link = 'site/revistaCientifica/' . $rev->id;
                                    }
                                    ?>
                                    <div class='services-items'>
                                        <?php echo anchor($link, "
                                        <div class='services-content'>
                                            <h4 style='height: 50px;'>
                                                $rev->titulo
                                            </h4>
                                            <p><img src=" . base_url($rev->capa) . " style='max-height: 250px;tex-align:center;'/>
                                             </p>
                                        </div>");
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-xs-3 sidebar sidebarpublicacces">
                    <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">
                        <li role="presentation" class="brand-nav active"><a href="" aria-controls="tab1" role="tab"
                                                                            data-toggle="tab">Revistas</a></li>
                        <li role="presentation"
                            class="brand-nav"><?php echo anchor('site/publicacoes/1', 'Paracatu'); ?></li>
                        <li role="presentation"
                            class="brand-nav"><?php echo anchor('site/publicacoes/3', 'Passos'); ?></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</section>
