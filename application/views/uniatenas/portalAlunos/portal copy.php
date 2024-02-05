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

<?php
if ($campus->id == 1) {
    $linkPortal = "http://177.69.195.6:8080/portalatenas/usuarios/login";
    $linkBank = "https://www.santander.com.br/atendimento-para-voce/boletos/emissao-boleto-vencido";
    $nameBank = "Santander";
} elseif ($campus->id == 2) {
    $nameBank = "Banco do Brasil";
    $linkBank = "https://www63.bb.com.br/portalbb/boleto/boletos/hc21e,802,3322,10343.bbx";
    $linkPortal = "http://177.69.195.6:8080/portalsetelagoas/usuarios/login";
} elseif ($campus->id == 3) {
    $nameBank = "Banco do Brasil";
    $linkBank = "https://www63.bb.com.br/portalbb/boleto/boletos/hc21e,802,3322,10343.bbx";
    $linkPortal = "http://177.69.195.6:8080/portalpassos/usuarios/login";
} elseif ($campus->id == 6) {
    $nameBank = "Banco do Brasil";
    $linkBank = "https://www63.bb.com.br/portalbb/boleto/boletos/hc21e,802,3322,10343.bbx";
    $linkPortal = "http://177.69.195.6:8080/portalpassos/usuarios/login";
}


$urlCity =  str_replace(' ', '', trim(strtolower($dados['campus']->city)));
?>

<div class="container">
    <div class="row">
        <div class="section-header">
            <h3>
                Portal <?php echo $dados['campus']->name . ' - ' . $dados['campus']->city . '(' . $dados['campus']->uf . ')'; ?></h3>
        </div>
        <div class="row portais-educaionais">
            <div class="itens-portal">

                <div class="col-sm-3 col-xs-6 portalIcon">
                    <?php
                    echo anchor('https://atenas.brightspace.com/', '<img src="' . base_url("assets/images/portais/portal_ead.jpg") . '">');
                    /*echo anchor('http://faculdadeatenas.blackboard.com', '<img src="' . base_url("assets/images/portais/portal_ead.jpg") . '">');*/
                    ?>
                </div>
                <div class="col-sm-3 col-xs-6 portalIcon">
                    <a href='http://177.69.195.4/EducaMobile/Account/Login'>
                        <img src="<?php echo base_url('assets/images/portais/poratal_eduConnect.png') ?>">
                    </a>
                </div>
                <div class="col-sm-3 col-xs-6 portalIcon">
                    <?php
                    echo anchor('http://177.69.195.4/FrameHTML/WEB/APP/EDU/PORTALEDUCACIONAL/login/', '<img src="' . base_url("assets/images/portais/portal_aluno.jpg") . '">');
                    ?>
                </div>
                <div class="col-sm-3 col-xs-6 portalIcon">
                    <a href='<?php echo $linkPortal; ?>'>
                        <img src="<?php echo base_url('assets/images/portais/portal_interno.jpg') ?>">
                    </a>
                </div>

                <div class="col-sm-3 col-xs-6 portalIcon">
                    <a href='http://177.69.195.4/Corpore.Net/Login.aspx'>
                        <img src="<?php echo base_url('assets/images/portais/portal_professor.jpg') ?>">
                    </a>
                </div>
                <div class="col-sm-3 col-xs-6 portalIcon">
                    <a href='http://177.69.195.4/Corpore.Net/Login.aspx'>
                        <img src="<?php echo base_url('assets/images/portais/portal_colaborador.jpg') ?>">
                    </a>
                </div>
                <div class="col-sm-3 col-xs-6 portalIcon">
                    <a href='http://177.69.195.6:5000/app/'>
                        <img src="<?php echo base_url('assets/images/portais/portal_atenas.jpeg') ?>">
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="container">
            <div class="section-header text-center">
                <h3>Avisos <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h3>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <div class="avisos-portal-alunos">
                                <img src="<?php echo base_url('assets/images/portais/news/banner-principal-alunos.png'); ?>" class="img-responsive">

                                <div class="text-center">
                                    <span><a href="https://play.google.com/store/apps/details?id=com.educonnect.totvs"><i class="fab fa-google-play"></i> Google Play</a></span>
                                    <br>
                                    <span><a href="https://apps.apple.com/br/app/totvs-educonnect/id1255287155"><i class="fab fa-1x fa-apple-pay"></i> Apple Store</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="avisos-portal-alunos">
                                <img src="<?php echo base_url('assets/images/qrEduConnect.jpg'); ?>" class="img-responsive">

                                <div class="text-center">
                                    <span><a href="<?php echo base_url('assets/images/qrEduConnect.jpg'); ?>">Após baixar o app, escaneie o qr code!😉</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="widget-sidebar">
                        <h2 class="title-widget-sidebar">#LINKS UTEIS</h2>
                        <div class="content-widget-sidebar">
                            <ul>
                                <li class="recent-post-alunos">
                                    <div class="col-xs-5">
                                        <div class="post-img">
                                            <a href="<?php echo $linkBank; ?>">
                                                <img src="<?php echo base_url('assets/images/portais/reemisao_boleto.png'); ?>" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <a href="<?php echo $linkBank; ?>">
                                            <h4>Reemissão Boleto Vencido</h4>
                                        </a>
                                        <p>
                                            <small><i class="fa fa-pager" data-original-title="" title=""></i>
                                                Boletos - Campus <?php echo $campus->name . '. ' . $nameBank; ?>
                                            </small>
                                        </p>
                                    </div>
                                </li>
                                <br />
                                <br />


                            </ul>
                        </div>
                    </div>

                    <div class="widget-sidebar">
                        <h2 class="title-widget-sidebar">Acesso rápido</h2>
                        <div class="last-post-aluno">
                            <a href="http://177.69.195.4/FrameHTML/web/app/edu/PortalEducacional/login/?redirect=relatorios" class="accordionAluno">Declaração de Vínculo</a>
                        </div>


                    </div>

                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<br />
<br />