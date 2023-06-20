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
$linkportalAluno = 'http://177.69.195.6:8080/portalatenas/usuarios/login';
$linkportalEaD = 'https://atenas.brightspace.com/';
$linkprofessor = 'http://177.69.195.4/Corpore.Net/Login.aspx';
?>
<div class="container">
    <div class="row">
        <div class="section-header text-center">
            <h3>Secretaria Acadêmica
                - <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h3>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <?php
                for ($i = 0; $i < count($dados['conteudoPag']); $i++) {
                ?>
                    <div class="col-xs-12">
                        <div class="information-library-campus text-justify">
                            <p>
                                <?php echo $dados['conteudoPag'][$i]->description; ?>
                            </p>
                        </div>
                    </div>
                <?php
                }
                ?>

                <hr>
                <div class="col-xs-12">
                    <div class="row">
                        <?php
                        if (!empty($dados['calendars'])) {
                        ?>
                            <div class="section-header text-center">
                                <h3 class="text-center"><i class="fas fa-calendar-alt"></i> Calendários Acadêmicos</h3>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="cards">
                                    <div class="cards-title">
                                        Calendário Escolar
                                    </div>
                                    <div class="cards-body">

                                        <?php
                                        foreach ($dados['calendars'] as $calendars) {
                                            echo "<h4><b> $calendars->name</b></h4>";
                                            echo anchor(base_url($calendars->files), 'Acessar', array('class' => 'btn info', 'target' => 'blank'));
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        if (!empty($dados['calendarsMedicine'])) {
                        ?>

                            <div class="col-sm-6 col-xs-12">
                                <div class="cards">
                                    <div class="cards-title">
                                        Calendário Escolar (Internato)
                                    </div>
                                    <div class="cards-body">
                                        <?php
                                        foreach ($dados['calendarsMedicine'] as $calendars) {
                                            echo "<h4><b> $calendars->name</b></h4>";
                                            echo anchor(base_url($calendars->files), 'Acessar', array('class' => 'btn info', 'target' => 'blank'));
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (!empty($dados['conteudoContato']->description)) {
        ?>
            <div class="col-lg-4 col-xs-6">

                <div class="widget-sidebar">
                    <h2 class="title-widget-sidebar"><?php echo $dados['conteudoContato']->title; ?></h2>
                    <div class="content-widget-sidebar">
                        <ul>
                            <li class="recent-post-alunos">
                                <div class="col-sm-2 col-xs-2">
                                    <div class="ico-wrap">
                                        <i class="fas fa-at fa-3x"></i>
                                    </div>
                                    </a>
                                </div>

                                <div class="col-sm-10 col-xs-10 ">
                                    <small>
                                        <div class=" "><?php echo $dados['conteudoContato']->description; ?></div>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="col-lg-4">
            <div class="widget-sidebar">
                <h2 class="title-widget-sidebar">#LINKS UTEIS</h2>
                <div class="content-widget-sidebar">
                    <ul>
                        <li class="recent-post-alunos" style="background: #f1f1f1">
                            <div class="col-sm-3 col-xs-4">
                                <a href="<?php echo $linkprofessor; ?>" target="_blank">
                                    <div class="ico-wrap">
                                        <span class="mbr-iconfont fas fa-chalkboard fa"></span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-sm-9 col-xs-8">
                                <?php
                                echo anchor("PortalAlunos/portal/$uricampus", 'Portal Acadêmico');
                                ?>
                                <p>
                                    <small><i class="fa fa-pager" data-original-title="" title=""></i>
                                        Avisos, informações, links uteis, entre outros.
                                        <?php echo $campus->name . '. ' . $campus->city; ?>
                                    </small>
                                </p>

                            </div>
                        </li>

                        <br />
                    </ul>
                </div>
            </div>
            <?php
            if (!empty($dados['horasComplementares'])) {
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
<br />
<br />