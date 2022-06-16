<header class="header">


    <!-- Start Menu -->
    <div class="bg-main-menu menu-scroll">
        <div class="container-fluid">
            <div class="row">
                <!-- Start Header Top -->
                <div class="bg-header-top">
                    <div class="container">
                        <div class="row">
                            <ul class="header-contact">
                                <li class="campus">
                                    <div class="styled-select">
                                        <span>Campus: </span>

                                        <select name="campus" id="link">
                                            <?php
                                            foreach ($dados as $campus) {
                                                ?>
                                                <option value="<?php echo ''.str_replace(' ','_',trim(strtolower($campus->city))); ?>"><?php echo $campus->city ;?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </li>
                                <li><a href="https://www.facebook.com/uniatenasoficial/"><i class="fa fa-facebook"></i> Facebook</a></li>
                                <li><a href="https://www.instagram.com/uniatenas/"><i class="fa fa-instagram"></i> Instagram</a></li>
                                <li><a href="https://www.youtube.com/user/tvatenas"><i class="fa fa-youtube"></i> TV - UniAtenas</a></li>
                            </ul>
                            <div class="log-reg">
                                <a href="https://webmail-seguro.com.br/atenas.edu.br/"><i class="fa fa-envelope"></i> Webmail</a>
                                <a href="http://atenas.edu.br/site_atenas/inicio/portais"><i class="fa fa-lock"></i> Portal Acadêmico</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Header Top -->
                <div class="container">
                    <div class="main-menu new-menu">


                        <nav class="navbar">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed"
                                        data-toggle="collapse"
                                        data-target="#bs-example-navbar-collapse-1"
                                        aria-expanded="false">
                                    <span class="sr-only">Barra de Navegação</span> <span
                                        class="icon-bar"></span> <span class="icon-bar"></span> <span
                                        class="icon-bar"></span>
                                </button>
                                <?php echo anchor('site', '<img src="' . base_url() . 'assets/images/logo.png" alt="logo" class="img-responsive" />', array('class' => '')); ?>
                            </div>

                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav headerNew">
                                    <li>
                                        <?php echo anchor('site', 'Início'); ?>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Instituição <span class="caret"></span></a>
                                        <ul class="dropdown-menu sub-menu">
                                            <li><a href="http://localhost/projetos_faculdade/site_faculdade/inicio/missao_filosofia">
                                                    <i class="fa fa-angle-right" aria-hidden="true"></i> Missão | Visão | Valores</a>
                                            </li>
                                            <li>
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/inicio/dirigentes">
                                                    <i class="fa fa-angle-right" aria-hidden="true"></i>Dirigentes
                                                </a>
                                            </li>
                                            <li>
                                                <?php echo anchor('Site/infraestrutura', '
                                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                        Infraestrutura
                                                    ');
                                                ?>
                                            </li>
                                            <li>
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/inicio/localizacao">
                                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                    Localização
                                                </a>
                                            </li> 
                                            <li>
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/inicio/cpa">
                                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                                    Comissão Própria de Avaliação
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Graduação <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu sub-menu">
                                            <li>
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/graduacao/index"><i class="fa fa-angle-right" aria-hidden="true"></i> Presencial</a>
                                            </li>
                                            <li>
                                                <?php echo anchor('Site/graduacaoEad"','<i class="fa fa-angle-right" aria-hidden="true"></i> EAD'); ?>
                                            </li>
                                        </ul>
                                    </li>

                                    <li><?php echo anchor('http://www.faculdadeatenas.edu.br/posgraduacao/posgraduacao.php', 'Pós-Graduação'); ?></li>

                                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Serviços <span class="caret"></span></a>
                                        <ul class="dropdown-menu sub-menu">
                                            <li>
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/inicio/secretaria"><i class="fa fa-angle-right" aria-hidden="true"></i> Secretaria</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> Tesouraria</a>
                                            </li>
                                            <li>
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/inicio/hefa"><i class="fa fa-angle-right" aria-hidden="true"></i> Hospital de Ensino - HEFA</a>
                                            </li>
                                            <li>
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/inicio/biblioteca"><i class="fa fa-angle-right" aria-hidden="true"></i>Biblioteca</a>
                                            </li>
                                            <hr>
                                            <li>
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/inicio/napp"><i class="fa fa-angle-right" aria-hidden="true"></i>Atendimento Psicopedagógico (NAPP)</a>
                                            </li>
                                            <li>
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/inicio/npj"><i class="fa fa-angle-right" aria-hidden="true"></i>Atendimento Jurídico (NPJ)</a>
                                            </li>
                                            <li>
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/inicio/npa"><i class="fa fa-angle-right" aria-hidden="true"></i>Atendimento Empresarial (NPA)</a>
                                            </li>
                                            <li >
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/inicio/npas"><i class="fa fa-angle-right" aria-hidden="true"></i>NPAS - Fábrica de Sofwtare</a>
                                            </li>
                                        </ul>
                                    </li>


                                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pesquisa <span class="caret"></span></a>
                                        <ul class="dropdown-menu sub-menu">
                                            <li>
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/inicio/iniciacao_cientifica"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Pesquisa e Iniciação Científica</a>
                                            </li>
                                            <li>
                                                <a href="http://localhost/projetos_faculdade/site_faculdade/inicio/cep"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Comitê de Ética em Pesquisa</a>
                                            </li>

                                        </ul>
                                    </li>


                                        <!--li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Eventos <span class="caret"></span></a>
                                            <ul class="dropdown-menu sub-menu">
                                                <li>
                                                    <a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Ver nossos espaços</a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i>Solicitar orçamento</a>
                                                </li>
                                            </ul>
                                        </li-->

                                    <li><a href="http://localhost/projetos_faculdade/site_faculdade/inicio/ouvidoria">Contate-nos</a></li>
                                </ul>
                                <!--div class="menu-right-option pull-right">
                                    <div class="search-box">
                                        <i class="fa fa-search first_click" aria-hidden="true"
                                           style="display: block;"></i> <i
                                           class="fa fa-times second_click" aria-hidden="true"
                                           style="display: none;"></i>
                                    </div>
                                    <div class="search-box-text">
                                        <form action="#">
                                            <input type="text" name="search" id="all-search"
                                                   placeholder="Digite aqui sua busca">
                                        </form>
                                    </div>
                                </div-->
                            </div>
                        </nav>
                    </div>
                </div>
                <!-- .main-menu -->
            </div>
            <!-- .row -->
        </div>
        <!-- .container -->
    </div>
    <!-- End Menu -->
</header>