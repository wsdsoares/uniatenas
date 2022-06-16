<?php
$uricampus = $this->uri->segment(3);
?>
<style>
    .magazinesTitle h4 {
        padding: 20px;
    }

    button.btn-default {
        color: #fff !important;
    }

    button.btn-default:hover {
        background: #fff !important;
        color: #000 !important;
    }
</style>
<section class="services-section">
    <div class="container">

        <div class="row">
            <div class="section-header text-center">
                <h3>Revistas Científicas
                    - <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h3>
            </div>
        </div>
    </div>

    <div class="container">
        <!--div class="btn-back">
            <?php echo anchor('site/pesquisa_inicicao_cientifica', 'Voltar', array('class' => "btn btn-danger")); ?>
        </div-->

        <div class="row">
            <div class="services-option">
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="information-library-campus text-justify">
                                <p>
                                    <?php echo $conteudoPag[0]->description; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($revistas as $rev) {
                            if($rev->linkRedirect == NULL){
                                $linkRevista = "iniciacaoCientifica/revista_cientifica/$uricampus/$rev->id";
                            }else{
                                $linkRevista = $rev->linkRedirect;
                            }
                            if($rev->capa != null) {


                                ?>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class='magazinesTitle'>
                                            <div class='col-xs-12'>
                                                <h4 class="text-center">
                                                    <?php echo $rev->titulo; ?>
                                                </h4>
                                                <div class="row">
                                                    <div class='col-xs-3'>
                                                        <?php echo anchor($linkRevista, "
                                                        <img src='" . base_url($rev->capa) . "' style='max-height: 250px;tex-align:center;' class='img-responsive'/>
                                                        <button class='btn btn-default'>Acessar</button>");
                                                        ?>
                                                    </div>
                                                    <div class='col-xs-9 dados_gerais text-justify'>
                                                        <?php echo $rev->description; ?>
                                                        <?php
                                                        if ($rev->id == 2) {
                                                            ?>
                                                            <img src="<?php echo base_url(); ?>assets/images/sectors/spic/indexador-Latindex.jpg"
                                                                 style="max-width: 100px;"/>
                                                            <img src="<?php echo base_url(); ?>assets/images/sectors/spic/LivRe.png"
                                                                 style="max-width: 100px;"/>
                                                            <?php
                                                        } elseif ($rev->id == 3) {
                                                            ?>
                                                            <img src="<?php echo base_url(); ?>assets/images/sectors/spic/indexador-Latindex.jpg"
                                                                 style="max-width: 100px;"/>
                                                            <img src="<?php echo base_url(); ?>assets/images/sectors/spic/LivRe.png"
                                                                 style="max-width: 100px;"/>
                                                            <?php
                                                        } elseif ($rev->id == 7) {
                                                            ?>
                                                            <img src="<?php echo base_url(); ?>assets/images/sectors/spic/indexador-Latindex.jpg"
                                                                 style="max-width: 100px;"/>
                                                            <img src="<?php echo base_url(); ?>assets/images/sectors/spic/LivRe.png"
                                                                 style="max-width: 100px;"/>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>