<div class="container">


    <div class="dados_gerais">
        <div class="container">
            <div class="section-header">
                <h3 class="text-center"><?php echo $conteudoPag[0]->title; ?></h3>
            </div>
            <div class="row">
                <div class="col-sm-12 ">
                    <?php echo $conteudoPag[0]->description; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-md-9 col-xs-12">
                <div role="tabpanel">
                    <div class="col-sm-3">
                        <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">
                            <li role="presentation" class="brand-nav active">
                                <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Revistas</a>
                            </li>
                            <li role="presentation" class="brand-nav">
                                <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Documentações /
                                    Manuais / Normas</a>
                            </li>
                            <li role="presentation" class="brand-nav">
                                <a href="#tab3" aria-controls="tab4" role="tab" data-toggle="tab">Monografias</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-9">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="tab1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php
                                        echo anchor('site/publicacoes/1', '
                                        <p>
                                            <img src="' . base_url('assets/images/campus/uniatenas.png') . '" class="img-responsive">
                                        </p>
                                        <p>
                                            Revistas Uniatenas - Campus - Paracatu(MG)
                                        </p>
                                        '); ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?php
                                        echo anchor('site/publicacoes/3', '
                                        <p>
                                            <img src="' . base_url('assets/images/campus/passos.png') . '" class="img-responsive">
                                        </p>
                                        <p>
                                            Revistas Uniatenas - Campus - Passos (MG)
                                        </p>
                                        '); ?>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="tab2">
                                <div class="col-xs-4">
                                    <div class="card text-center boxSite">
                                        <?php
                                        echo anchor(base_url('assets/files/spic/MANUAL-DE-ELABORACAO-DE-TCC-I-E-TCC-II-2019.pdf'), '

                                            <i class="fas fa-file-pdf fa-3x" aria-hidden="true"></i>
                                            <p>Manual de elaboração do trabalho de conclusão de curso.</p>
                                            ');
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="card text-center boxSite">
                                        <?php
                                        echo anchor(base_url('assets/files/spic/normas-gerais-para-publicacao-de-artigos.pdf'), '

                                            <i class="fas fa-file-pdf fa-3x" aria-hidden="true"></i>
                                            <p>Normas de publicação artigos.</p>
                                            ');
                                        ?>
                                    </div>
                                </div>


                            </div>
                            <div role="tabpanel" class="tab-pane" id="tab3">
                                <div class="col-xs-4">
                                    <div class="card text-center boxSite">
                                        <?php
                                        echo anchor('http://177.69.195.6:8080/portalatenas/usuarios/login', '

                                            <i class="fas fa-lock fa-3x" aria-hidden="true"></i>
                                            <p>Monografias  Publicações.</p>
                                            ');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-12 linksUteisIniciacao">

                <div class="panel panel-primary ">

                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-link "></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Links Úteis</div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .toplinks span {
                            float: right;
                            margin-top: 10%;
                            text-align: center;
                        }

                        .toplinks img {
                            width: 150px;
                        }


                    </style>
                    <div class="col-xs-12">
                        <a href="http://www.capes.gov.br/" target="_blanck">
                            <div class="col-xs-6 toplinks">
                                <img src="<?php echo base_url() ?>assets/images/several/banner_capes.png"
                                     class="img-responsive "/>
                            </div>
                            <div class="col-xs-6 toplinks">
                                <span>CAPES</span>
                            </div>

                        </a>
                    </div>
                    <div class="col-xs-12">
                        <a href="http://cnpq.br/" target="_blanck">

                            <div class="col-xs-6 toplinks">
                                <img src="<?php echo base_url() ?>assets/images/several/banner_cnpq.png"
                                     class="img-responsive"/>
                            </div>
                            <div class="col-xs-6 toplinks">
                                <span>CNPq</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12">
                        <a href="http://www.periodicos.capes.gov.br/" target="_blanck">
                            <div class="col-xs-6 toplinks">
                                <img src="<?php echo base_url() ?>assets/images/several/banner_periodicos.png"
                                     class="img-responsive"/>
                            </div>
                            <div class="col-xs-6 toplinks">
                                <span>CNPq</span>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12">
                        <a href="http://www.fapemig.br/" target="_blanck">
                            <div class="col-xs-6 toplinks">
                                <img src="<?php echo base_url() ?>assets/images/several/banner_fapemig.png"
                                     class="img-responsive"/>
                            </div>
                            <div class="col-xs-6 toplinks">
                                <span>FAPEMIG</span>
                            </div>

                        </a>
                    </div>

                    <div class="col-xs-12">
                        <?php echo anchor('site/revistas_periodicos', '
                            <div class="col-xs-6 toplinks">
                                <img src="' . base_url('assets/images/several/revistas-cientificas.png') . '"
                                     class=""/>
                            </div>
                            <div class="col-xs-6 toplinks">
                                <span>Revistas e Periódicos </span>
                            </div>');
                        ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (!empty($filesPage)) {
    ?>
    <style>

    </style>
    <section>
        <div class="container">

            <div class="filesPage">
                <h3 class="text-center">Documentos</h3>
                <?php
                foreach ($filesPage as $file) {
                    ?>
                    <div class="col-sm-4">
                        <div class="fileItem">
                            <a href="<?php echo $file->files; ?>" target="_blank">
                                <img border="0" src="<?php echo base_url('assets/images/icons/downfile.png'); ?>"/>
                                <span><?php echo $file->name; ?></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
    </section>
    <?php
}
?>


<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>



