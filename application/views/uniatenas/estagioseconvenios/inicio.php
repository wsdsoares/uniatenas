<style>
    text.Orange-label {
        color: Orange;
    }

    .estagiosConvenios>p {
        text-align: justify !important;
    }
</style>
<section class="body-page">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="section-header">
                    <h3 class="text-center"><?php echo $conteudoPag[0]->title; ?></h3>
                </div>
                <div role="tabpanel">
                    <div class="col-sm-3">
                        <a class="list-group-item active"></a>
                        <ul class="nav nav-pills brand-pills nav-stacked sidebarList" role="tabpanel">
                            <?php
                            for ($i = 0; $i < count($conteudoPag); $i++) {
                                if ($i == 0) {
                                    $active = "active";
                                } else {
                                    $active = "";
                                }
                            ?>
                                <li role="presentation" class="brand-nav <?php echo $active; ?>">
                                    <a href="#tab<?php echo $i; ?>" aria-controls="tab<?php echo $i; ?>" role="tab" data-toggle="tab"><?php echo $conteudoPag[$i]->title ?></a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-sm-9">
                        <div class="tab-content">
                            <style>
                                .conteudoPagina p {
                                    text-align: justify !important;
                                }
                            </style>
                            <?php
                            for ($i = 0; $i < count($conteudoPag); $i++) {
                                if ($i == 0) {
                                    $active = "active";
                                } else {
                                    $active = "";
                                }
                            ?>

                                <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="tab<?php echo $i; ?>">
                                    <div class="row">
                                        <div class="col-xs-12 conteudoPagina">
                                            <?php echo $conteudoPag[$i]->description; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php

                                        $consultaArquivos =
                                            "SELECT * FROM at_site.page_contents_files
                                                where page_contents_files.status=1
                                                    and page_contents_files.id_page_contents =" . $conteudoPag[$i]->id;

                                        $arquivosConteudosEstagiosConvenios = $this->bancosite->getQuery($consultaArquivos)->result();

                                        foreach ($arquivosConteudosEstagiosConvenios as $itensArquivos) {
                                        ?>
                                            <div class="col-xs-3">
                                                <h4 class="text-center titleSPIC"><?php echo $itensArquivos->title; ?></h4>
                                                <div class="card text-center boxSite" id="teste">
                                                    <a href="<?php echo base_url($itensArquivos->files) ?>" class="iconSPIC" target="_blank">
                                                        <i class="fas fa-file-pdf fa-3x" aria-hidden="true"></i>
                                                        <p>Visualizar</p>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php
                                        }
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
            <div class="col-md-3">
                <?php
                if (!empty($dados['contatosPagina'])) {
                ?>
                    <div class="widget-sidebar">
                        <h2 class="title-widget-sidebar">Contatos</h2>
                        <div class="content-widget-sidebar">
                            <ul>
                                <li class="recent-post-alunos">
                                    <div class="col-sm-2 col-xs-2">
                                        <i class="far fa-address-card fa-2x"></i>
                                        </a>
                                    </div>
                                    <div class="col-sm-12 col-xs-12 ">
                                        <?php
                                        // foreach ($contatos as $phone){
                                        foreach ($contatosPagina as $informacoesContato) {
                                        ?>
                                            <small>
                                                <?php
                                                echo $informacoesContato->description;
                                                ?>
                                            </small>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>


<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>