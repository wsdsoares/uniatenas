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

    .titleSPIC {
        min-height: 80px;
    }

    a.iconSPIC i {
        margin-top: 20px;
    }
     text.Orange-label{
         color: Orange;
     }
</style>
<div class="container">
    <div class="dados_gerais">
        <div class="container">
            <div class="section-header">
                <h3 class="text-center">Comitê de Ética em Pesquisa com Seres Humanos</h3>
            </div>

        </div>
    </div>

    <div class="container">
        <div class="col-md-8">
            <div class="row">
                <div role="tabpanel">
                    <div class="col-sm-3">
                        <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">
                            <?php
                            for ($i = 0; $i < count($conteudo); $i++) {
                                $active = $i == 0 ? 'active' : '';
                                ?>
                                <li role="presentation" class="brand-nav <?php echo $active; ?>">
                                    <a href="#tab<?php echo $i; ?>" aria-controls="tab<?php echo $i; ?>" role="tab"
                                       data-toggle="tab"><?php echo $conteudo[$i]->title ?></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-sm-9">
                        <div class="tab-content">
                            <?php
                            for ($i = 0; $i < count($conteudo); $i++) {
                                $active = $i == 0 ? 'active' : '';
                                ?>
                                <div role="tabpanel" class="tab-pane <?php echo $active; ?>" id="tab<?php echo $i; ?>">
                                    <div class="row">
                                        <?php
                                        if (!empty($dados['conteudo'][$i]->title_short)) {
                                            ?>
                                            <h4 class="text-center dados_gerais">
                                                <?php
                                                echo $dados['conteudo'][$i]->title_short;
                                                ?>
                                            </h4>
                                            <?php
                                        } ?>
                                        <div class="col-md-11">
                                            <?php
                                            if($i !=2):
                                                echo $dados['conteudo'][$i]->description;
                                            elseif ($i ==2):?>
                                            <div class="col-md-13">
                                                <div class="col-sm-4 col-xs-8">
                                                    <h4 class="text-center titleSPIC">Manual Aba Alterar Meus Dados</h4>
                                                    <div class="card text-center boxSite">
                                                        <a href="<?php echo base_url('assets/files/spic/plataformaBrasil/Manual-Aba-Alterar-Meus-Dados.pdf') ?>"
                                                           class="iconSPIC" target="_blank">
                                                            <img src="<?php echo base_url('assets/images/icons/livros.png'); ?>">

                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-xs-8">
                                                    <h4 class="text-center titleSPIC">Manual Alteração de Pesquisador
                                                        Responsável</h4>
                                                    <div class="card text-center boxSite">
                                                        <a href="<?php echo base_url('assets/files/spic/plataformaBrasil/Manual-Alteracaoo-de-Pesquisador-Responsavel.pdf') ?>"
                                                           class="iconSPIC" target="_blank">
                                                            <img src="<?php echo base_url('assets/images/icons/livros.png'); ?>">

                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-xs-8">
                                                    <h4 class="text-center titleSPIC">Manual Cadastro de Usuário</h4>
                                                    <div class="card text-center boxSite">
                                                        <a href="<?php echo base_url('assets/files/spic/plataformaBrasil/Manual-Cadastro-de-Usuario.pdf') ?>"
                                                           class="iconSPIC" target="_blank">
                                                            <img src="<?php echo base_url('assets/images/icons/livros.png'); ?>">

                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-xs-8">
                                                    <h4 class="text-center titleSPIC">Manual Envio de Notificação</h4>
                                                    <div class="card text-center boxSite">
                                                        <a href="<?php echo base_url('assets/files/spic/plataformaBrasil/Manual-Envio-de-Notificacao.pdf') ?>"
                                                           class="iconSPIC" target="_blank">
                                                            <img src="<?php echo base_url('assets/images/icons/livros.png'); ?>">

                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-xs-8">
                                                    <h4 class="text-center titleSPIC">Manual Funcionalidades da Aba
                                                        Pesquisador</h4>
                                                    <div class="card text-center boxSite">
                                                        <a href="<?php echo base_url('assets/files/spic/plataformaBrasil/Manual-Funcionalidades-da-Aba-Pesquisador.pdf') ?>"
                                                           class="iconSPIC" target="_blank">
                                                            <img src="<?php echo base_url('assets/images/icons/livros.png'); ?>">

                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-xs-8">
                                                    <h4 class="text-center titleSPIC">Manual Submissão de Emenda</h4>
                                                    <div class="card text-center boxSite">
                                                        <a href="<?php echo base_url('assets/files/spic/plataformaBrasil/Manual-Submissao-de-Emenda.pdf') ?>"
                                                           class="iconSPIC" target="_blank">
                                                            <img src="<?php echo base_url('assets/images/icons/livros.png'); ?>">

                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-xs-8">
                                                    <h4 class="text-center titleSPIC">Manual Submissão de Projeto de
                                                        Pesquisa</h4>
                                                    <div class="card text-center boxSite">
                                                        <a href="<?php echo base_url('assets/files/spic/plataformaBrasil/Manual-Submissao-de-Projeto-de-Pesquisa.pdf') ?>"
                                                           class="iconSPIC" target="_blank">
                                                            <img src="<?php echo base_url('assets/images/icons/livros.png'); ?>">

                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-xs-8">
                                                    <h4 class="text-center titleSPIC">Manual Submissão de Recurso</h4>
                                                    <div class="card text-center boxSite">
                                                        <a href="<?php echo base_url('assets/files/spic/plataformaBrasil/Manual-Submissao-de-Recurso.pdf') ?>"
                                                           class="iconSPIC" target="_blank">
                                                            <img src="<?php echo base_url('assets/images/icons/livros.png'); ?>">

                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endif;
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
        </div>
        </div>
        <div class="col-lg-4 col-xs-6">
            <?php if(!empty($contatos)): ?>
                    <div class="widget-sidebar">
                        <h2 class="title-widget-sidebar">Contatos</h2>
                        <div class="content-widget-sidebar">
                            <ul>
                                <li class="recent-post-alunos">
                                    <div class="col-sm-2 col-xs-2">
                                        <i class="far fa-address-card fa-2x"></i>
                                        </a>
                                    </div>

                                    <div class="col-sm-10 col-xs-10 ">
                                        <?php foreach ($contatos as $phone): ?>
                                            <small>
                                                <div class=" ">
                                                    <?php if ($phone->email != "" || $phone->email != null): ?>
                                                        <p>
                                                            <label>E-mail:</label>
                                                        <p>
                                                            <text class="Orange-label"><?= $phone->email ?></text>
                                                        </p>
                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if ($phone->phonesetor != "" || $phone->phonesetor != null): ?>
                                                        <p class="Orange-label">
                                                            <label>Telefone: </label>
                                                            <text class="Orange-label"><?= $phone->phonesetor ?></text>
                                                        </p>
                                                    <?php endif; ?>
                                                    <p>
                                                        <label>Telefone: </label>
                                                        <text class="Orange-label"><?= $campus->phone; ?></text>
                                                    </p>
                                                    <?php if ($phone->ramal != "" || $phone->ramal != null): ?>
                                                        <p>
                                                            <label>Ramal: </label>
                                                            <text class="Orange-label"><?= $phone->ramal; ?></text>
                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if ($phone->phone != "" || $phone->phone != null): ?>
                                                        <p>
                                                            <label>Cel. Corporativo:</label>
                                                            <text class="Orange-label"><?= $phone->phone; ?></text>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </small>
                                        <?php
                                        endforeach;
                                        ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
            <?php endif; ?>
            <?php
            if (!empty($dados['conteudoContato']->description)) {
                ?>
                <div class="widget-sidebar">
                    <h2 class="title-widget-sidebar"><?php echo $dados['conteudoContato']->title; ?></h2>
                    <div class="content-widget-sidebar">
                        <ul>
                            <li class="recent-post-alunos">
                                <div class="col-sm-2 col-xs-4">
                                    <div class="ico-wrap">
                                        <i class="fas fa-mobile-alt fa-2x"></i>
                                    </div>
                                    </a>
                                </div>

                                <div class="col-sm-8 col-xs-8 ">
                                    <small>
                                        <div class=" "><?php echo $dados['conteudoContato']->description; ?></div>
                                    </small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <br>
                <br><br/>
                <?php
            }
            ?>
            <div class="widget-sidebar">
                <h2 class="title-widget-sidebar">#Links Úteis</h2>
                <div class="last-post-aluno">
                    <a target="_blank" href="http://www.periodicos.capes.gov.br/"
                       class="accordionAluno">Periódicos Capes</a>
                </div>
                <hr>

                <div class="last-post-aluno">
                    <a target="_blank" href="https://scholar.google.com/" class="accordionAluno">Google Acadêmico</a>
                </div>
                <hr>
                <div class="last-post-aluno">
                    <a target="_blank" href="https://scielo.org/" class="accordionAluno">Scielo</a>
                </div>
                <hr>
                <div class="last-post-aluno">
                    <a target="_blank" href="https://www.redalyc.org/" class="accordionAluno">Redalyc</a>
                </div>
            </div>
        </div>

    </div>
</div>


<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>



