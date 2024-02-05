<style>
    .ico-wrap {
        margin: auto;
    }

    .mbr-iconfont {
        font-size: 4.5rem !important;
        color: #313131;
        margin: 1rem;
        padding-right: 1rem;
    }
</style>
<style>
    .cards-title {
        background: #0c5460;
        padding: 10px;
    }

    .cards {
        background: #f1f1f1;
    }

    .cards-title {
        text-align: center;
        color: #fff;
    }

    .cards-body {
        padding: 15px;
    }

    .cards-body a {
        margin-bottom: 25px;
    }

    /* Blue */
    .info {
        border-color: #2196F3;
        color: dodgerblue;
    }

    .info:hover {
        background: #2196F3;
        color: white;
    }
</style>
<?php
$uricampus = $this->uri->segment(3);
?>
<div class="container">
    <div class="row">
        <div class="section-header text-center">
            <h3> <?php echo $title; ?>
                - <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h3>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="row portais-educaionais">
                <div class="itens-portal">
                    <?php
                    for ($i = 0; $i < count($dados['conteudoPag']); $i++) {
                        $file_extension = pathinfo($dados['conteudoPag'][$i]->img_destaque, PATHINFO_EXTENSION);
                        if ($file_extension) { ?>
                            <a href=" <?php echo $dados['conteudoPag'][$i]->link_redir ?>">
                                <img src="<?php echo base_url() . $dados['conteudoPag'][$i]->img_destaque; ?>" alt="single-services-img-4" class="img-responsive img-rounded" />
                            </a>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">

            <style>
                li.lista-link-uteis a h4 {
                    cursor: pointer;
                }

                li.lista-link-uteis a h4:hover {
                    color: #f4630b !important;
                }

                .widget-sidebar {
                    margin-bottom: 2em;
                }
            </style>
            <?php
            if (!empty($dados['conteudoAcessoRapido']) and $dados['conteudoAcessoRapido'] != '') {
            ?>
                <div class="widget-sidebar col-xs-12">

                    <h2 class="title-widget-sidebar">#Acesso Rápido</h2>
                    <div class="content-widget-sidebar">
                        <ul>
                            <?php
                            foreach ($dados['conteudoAcessoRapido'] as $linksAcessoRapido) {
                            ?>
                                <li class="lista-link-uteis">
                                    <a target="_blank" href="<?php echo $linksAcessoRapido->link_redir; ?>">
                                        <h4>
                                            <i class="fa fa-external-link"></i>
                                            <?php echo $linksAcessoRapido->title; ?>
                                        </h4>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            <?php
            }
            ?>

            <?php

            if (!empty($dados['conteudoLinksUteis']) and $dados['conteudoLinksUteis'] !== '') {
            ?>
                <div class="widget-sidebar col-xs-12">

                    <h2 class="title-widget-sidebar"># UNITENAS - Links Úteis</h2>
                    <?php
                    foreach ($dados['conteudoLinksUteis'] as $linksUteis) {
                    ?>
                        <div class="last-post-aluno">
                            <a target="_blank" href="<?php echo $linksUteis->link_redir; ?>" class="accordionAluno"><?php echo $linksUteis->title; ?></a>
                        </div>
                        <hr>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
            <?php
            if (!empty($dados['horasComplementares']) and $dados['horasComplementares'] != '') {
            ?>
                <div class="widget-sidebar">
                    <h2 class="title-widget-sidebar">#Utilidades</h2>
                    <div class="last-post-aluno">
                        <?php
                        echo anchor($dados['horasComplementares']->files, $dados['horasComplementares']->name, array('class' => "accordionAluno"));
                        ?>
                    </div>
                    <hr>
                </div>
            <?php
            }
            ?>
        </div>

    </div>
</div>