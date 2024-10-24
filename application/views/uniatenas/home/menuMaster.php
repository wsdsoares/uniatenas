
<div data-container="menu" class="headermenu">

    <header class="header navbar navbar-fixed-top">
        <!-- Start Menu -->
        <div class="bg-main-menu">
            <div class="container-fluid">
                <div class="row">

                    <div class="bg-header-top">
                        <div class="container">
                            <div class="row">
                                <ul class="header-contact">

                                    <li><a href="https://www.facebook.com/uniatenasoficial/"><i class="fab fa-facebook-f"></i> <span class="top-page">Facebook</span></a></li>
                                    <li><a href="https://www.instagram.com/uniatenas/"><i class="fab fa-instagram"></i><span class="top-page"> Instagram</span></a></li>
                                    <li><a href="https://www.youtube.com/user/tvatenas"><i class="fab fa-youtube"></i><span class="top-page">TV - UniAtenas</span></a></li>
                                </ul>
                                <div class="log-reg">
                                    <a href="https://webmail-seguro.com.br/atenas.edu.br/"><i class="fa fa-envelope"></i> <span class="top-page">Webmail</span></a>
                                    <?php
                                    echo anchor('PortalAlunos/portais', '<i class="fas fa-user-lock"></i><span class="top-page-alunos"> Portal Acadêmico</span></a>');
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <ul class="exo-menu">
                            <div class="logooficial">
                                <?php echo anchor('site', '<img src="' . base_url() . 'assets/images/logo.png" alt="logo" class="img-fluid" />', array('class' => 'logooficial')); ?>
                            </div>
                            <li><?php echo anchor('site','Home'); ?></li>

                            <li class="drop-down"><a href="#">Instituição</a>
                                <!--Drop Down-->
                                <ul class="drop-down-ul animated fadeIn">
                                    <li><a href="#">Missão | Visão | Valores</a></li>
                                    <li><a href="#">Dirigentes</a></li>
                                    <li><a href="#">Infraestrutura</a></li>
                                    <li><a href="#">Localização</a></li>
                                    <li><a href="#">Comisão Própria de Avaliação</a></li>

                                </ul>
                                <!--//End drop down-->

                            </li>
                            <li class="mega-drop-down"><a href="#">Graduação</a>
                                <div class="animated fadeIn mega-menu">
                                    <div class="mega-menu-wrap">
                                        <div class="row">
                                            <div class="col-md-5 col-sm-5 col-xs-12">
                                                <h4 class="row mega-title">Campus - Paracatu</h4>
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <ul class="stander">
                                                                <li><?php echo anchor('graduacao/presencial/1','Administração');?></li>
                                                                <li class="menu-new-courses"><a href="#">Agronomia*</a></li>
                                                                <li><a href="#">Direito</a></li>
                                                                <li><a href="#">Educação Física - Bacharelado</a></li>
                                                                <li><a href="#">Educação Física - Licenciatura</a></li>
                                                                <li><a href="#">Enfermagem</a></li>
                                                                <li><a href="#">Engenharia Civil</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <ul class="stander">
                                                                <li><a href="#">Farmácia</a></li>
                                                                <li><a href="#">Medicina</a></li>
                                                                <li class="menu-new-courses"><a href="#">Medicina Veterinária*</a></li>
                                                                <li><a href="#">Nutrição</a></li>
                                                                <li><a href="#">Pedagogia</a></li>
                                                                <li><a href="#">Psicologia</a></li>
                                                                <li><a href="#">Sistemas de Informação</a></li>

                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-xs-12">
                                                <h4 class="row mega-title">Campus - Passos</h4>
                                                <ul class="stander">
                                                    <li><a href="#">Medicina</a></li>
                                                </ul>
                                            </div>

                                            <div class="col-md-2 col-xs-12">
                                                <h4 class="row mega-title">Campus - Sete Lagoas</h4>
                                                <ul class="stander">
                                                    <li><a href="#">Medicina</a></li>
                                                </ul>
                                            </div>

                                            <div class="col-md-3 col-xs-12">
                                                <h4 class="row mega-title">EaD - UniAtenas</h4>
                                                <ul class="stander menu-ead">
                                                    <li><a href="#">Administração</a></li>
                                                    <li><a href="#">Contabilidade</a></li>
                                                    <li><a href="#">Educação Física Licenciatura</a></li>
                                                    <li><a href="#">Engenharia de Produção</a></li>
                                                    <li><a href="#">Logística</a></li>
                                                    <li><a href="#">Pedagogia</a></li>
                                                    <li><a href="#">Processos Gerenciais</a></li>
                                                    <li><a href="#">Recursos Humanos</a></li>
                                                </ul>
                                                <a class="view-more btn btn-sm " href="#">Ver mais...</a>
                                            </div>

                                        </div>
                                    </div>	
                                </div>
                            </li>

                            <li class="mega-drop-down">
                                <a href="#">Serviços</a>
                                <div class="animated fadeIn mega-menu">
                                    <div class="mega-menu-wrap">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <h4 class="row mega-title">Gerais</h4>
                                                <ul class="stander">
                                                    <li><a href="#">Biblioteca</a></li>
                                                    <li><a href="#">Estágio e Convênios</a></li>
                                                    <li><a href="#">HEFA - Hospital de Ensino</a></li>
                                                    <li><a href="#">Secretaria</a></li>
                                                    <li><a href="#">Tesouraria</a></li>

                                                    <li><a href="#">Portal Aluno</a></li>

                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h4 class="row mega-title">Núcleos</h4>
                                                <ul class="description">
                                                    <li>
                                                        <a href="#">Atendimento Psicopedagógico (NAPP)</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Atendimento Jurídico (NPJ)</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Atendimento Empresarial (NPA)</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">NPAS - Fábrica de Software)</a>
                                                    </li>
                                                </ul>
                                            </div>


                                        </div>
                                    </div>	
                                </div>
                            </li>
                            <li class="drop-down">
                                <a href="#">Pesquisa</a>
                                <!--Drop Down-->
                                <ul class="drop-down-ul animated fadeIn">
                                    <li><a href="#"> Pesquisa e Iniciação Científica</a></li>
                                    <li><a href="#">Comitê de Ética em Pesquisa</a></li>
                                </ul>
                                <!--//End drop down-->

                            </li>

                            <li><a href="#">Trabalhe Conosco</a></li>

                            <li>
                                <?php
                                echo anchor('site/contato', 'Contato');
                                ?>
                                
                            </li>
                            <a href="#" class="toggle-menu visible-xs-block"><i class="fa fa-4x fa-bars"></i></a>		
                        </ul>
                    </div>

                </div>
            </div>
            <!-- .container -->
        </div>
        <!-- End Menu -->
    </header>
</div>

<?php
$pagina = $this->uri->segment(2);
$controller = $this->uri->segment(1);

if ((isset($pagina)) and $controller != 'Site') {
    ?>
    <nav aria-label="breadcrumb" class="topbreadcrumb">
        <ol class="breadcrumb ">
            <div class="container">
                <?php
                echo breadcrumb();
                ?>
            </div>
        </ol>
    </nav>
    <?php
}
?>
