<?php
$uricampus = $this->uri->segment(3);
?>
<section class="services-section">
    <div class="container">
        <div class="dados_gerais">
            <div class="container">
                <div class="row">
                    <div class="section-header text-center">
                        <h3>
                             <?php echo $revistas->titulo; ?> - <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="services-option">
                <div class="col-xs-12">
                    <div class="btn-back">
                        <?php echo anchor("iniciacaoCientifica/revistas/$uricampus", '
                        Voltar', array('class' => "btn btn-danger"));
                        ?>
                    </div>
                    <br>
                    <?php
                    foreach ($years as $item) {
                        ?>
                        <div class="col-md-2 col-sm-2 col-xs-3">
                            <div class="services-box" >
                                <?php
                                echo anchor("iniciacaoCientifica/artigos_cientificos/$uricampus/$revista_id/$item->year", ' 
                                <div class="services-items" style="background:#f1f1e3;width:100px;text-align:center;">
                                    <i class="pe-7s-bookmarks"></i>
                                    <div class="services-content">
                                        <h4 style="text-align: center;margin-left:30px;">
                                            ' . $item->year . '</h4>
                                    </div>
                                </div>
                                ');
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



