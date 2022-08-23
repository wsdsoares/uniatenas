<?php
$uricampus = $this->uri->segment(3);

$colunasTabelaCampus = array(
    'campus.facebook',
    'campus.instagram',
    'campus.youtube',
    'campus.shurtName',
    'campus.logo',
    'campus.id',
    'campus.name',
);

$informacoesCampus = $this->bancosite->where($colunasTabelaCampus, 'campus', NULL, array('campus.shurtName' => $uricampus))->row();

$wehreArrayLinkvestibular= array('gerais_elementos_site.tipo'=>'link_vestibular', 'gerais_elementos_site.id_campus'=>$informacoesCampus->id);
$linkVetibularTopo = $this->bancosite->where('*','gerais_elementos_site',null,$wehreArrayLinkvestibular)->row();

$verificaPaginaFinanceiro = $this->bancosite->where('*','pages', null, array('title' => 'financeiro','campusid'=>$informacoesCampus->id))->row();
if(isset($verificaPaginaFinanceiro) and $verificaPaginaFinanceiro != '') {

  $listaMenuItensFinanceiro =  $this->bancosite->getQuery(
    "SELECT 
      page_contents.id,
      page_contents.title
    FROM 
      page_contents
    INNER JOIN pages ON pages.id = page_contents.pages_id
    INNER JOIN campus ON campus.id= pages.campusid
    WHERE 
        pages.title = 'financeiro'AND 
        pages.campusid = $informacoesCampus->id AND 
        page_contents.order <>'contatos' AND 
        page_contents.status=1 and
        page_contents.order >= 1
    ORDER BY page_contents.order ASC")->result();

  echo '<pre>';
  echo '<br/>';
  echo '<br/>';
  echo '<br/>';
  echo '<br/>';
  print_r($listaMenuItensFinanceiro);
  echo '</pre>';
}
$verificaPaginaComoIngressar = $this->bancosite->where('*','pages', null, array('title' => 'comoingressar','campusid'=>$informacoesCampus->id))->row();




?>
<div data-container="menu" class="headermenu">
  <header class="header navbar-fixed-top">
    <div class="bg-main-menu">
      <div class="container-fluid">
        <div class="row">
          <div class="bg-header-top">
            <div class="container">
              <div class="row">
                <ul class="header-contact">
                  <li>
                    <?php echo anchor('https://www.facebook.com/' . $informacoesCampus->facebook, '
                                            <i class="fab fa-facebook-f"></i>
                                            <span class="top-page hidden-xs">Facebook</span>
                                        ', array('target' => "_blank")); ?>
                  </li>
                  <li>
                    <?php echo anchor('https://www.instagram.com/' . $informacoesCampus->instagram, '
                                            <i class="fab fa-instagram"></i>
                                            <span class="top-page hidden-xs"> Instagram</span>
                                        ', array('target' => "_blank")); ?>
                  </li>
                  <li>
                    <?php echo anchor('https://www.youtube.com/' . $informacoesCampus->youtube, '
                                            <i class="fab fa-youtube"></i>
                                            <span class="top-page hidden-xs">TV - UniAtenas</span>
                                        ', array('target' => "_blank")); ?>
                  </li>
                </ul>
                <div class="log-reg">
                  <?php if ($informacoesCampus->shurtName == 'paracatu') { ?>
                  <a href="https://outlook.live.com/owa/">

                    <?php } else { ?>
                    <a href="https://webmail-seguro.com.br/atenas.edu.br/">
                      <?php } ?>
                      <i class="fa fa-envelope"></i> <span class="top-page hidden-xs">Webmail</span>
                    </a>
                    <?php
                                            echo anchor('PortalAlunos/portal/' . $informacoesCampus->shurtName, '<i class="fas fa-user-lock"></i><span class="top-page-alunos hidden-xs"> Portal Acadêmico</span>');
                                            ?>
                    <?php
                                            echo anchor('site/biblioteca/' . $informacoesCampus->shurtName, '<i class="fas fa-book"></i><span class="top-page-alunos hidden-xs"> Biblioteca</span>');
                                            ?>
                </div>

                <?php 
                if(isset($linkVetibularTopo)){
                ?>
                <div class="log-reg">
                  <a href="<?php print($linkVetibularTopo->link)?>" class="mx-auto download-btn-top">
                    <i class=" fa fa-graduation-cap" aria-hidden="true"></i><?php echo $linkVetibularTopo->nome?>
                  </a>
                </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>


          <div class="container">
            <nav class="navbar">
              <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                  <span class="sr-only">Menu Navegação</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <div class="logooficial">
                  <?php echo anchor('atenas/inicio/' . $informacoesCampus->id, '<img src="' . base_url($informacoesCampus->logo) . '" alt="logo" class="img-responsive logoPrincipal" />', array('class' => 'logooficial')); ?>
                </div>
              </div>
              <div class="collapse js-navbar-collapse">

                <ul class="nav navbar-nav uniatenas-menu">
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                      aria-expanded="false">Instituição<span class="caret"></span></a>
                    <ul class="dropdown-menu menu-simpes" role="menu">
                      <li>
                        <?php echo anchor('site/nossaHistoria/' . $informacoesCampus->shurtName, 'História ' . $informacoesCampus->name); ?>
                      </li>
                      <li>
                        <?php echo anchor('site/dirigentes/' . $informacoesCampus->shurtName, 'Dirigentes'); ?>
                      </li>
                      <li>
                        <?php echo anchor('site/infraestrutura/' . $informacoesCampus->shurtName, 'Infraestrutura'); ?>
                      </li>
                      <li>
                        <?php echo anchor('site/localizacao/' . $informacoesCampus->shurtName, 'Localização - Campus'); ?>
                      </li>
                      <?php
                      if ($informacoesCampus->id == '1' or $informacoesCampus->id == '2' or $informacoesCampus->id == '3' or $informacoesCampus->id == '6') {
                      ?>
                      <li>
                        <?php echo anchor('site/trabalheConosco/' . $informacoesCampus->shurtName, 'Trabalhe Conosco'); ?>
                      </li>

                      <?php
                        }
                        ?>
                      <li>
                        <?php echo anchor('site/CPA/' . $informacoesCampus->shurtName, 'Comissão Própria de Avaliação'); ?>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                      aria-expanded="false">Graduação<span class="caret"></span></a>
                    <ul class="dropdown-menu menu-simpes" role="menu">
                      <li>
                        <?php echo anchor('graduacao/cursos/' . $informacoesCampus->shurtName, 'Presencial'); ?>
                      </li>
                      <?php
                      if ($informacoesCampus->id == '1'
                        or $informacoesCampus->id == '2' 
                        or $informacoesCampus->id == '3') {
                      ?>
                      <li><?php echo anchor('graduacao/ead/' . $informacoesCampus->shurtName, 'EaD'); ?></li>
                      <?php
                      }
                      ?>
                    </ul>
                  </li>

                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                      Como ingressar<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu menu-simpes" role="menu">

                      <?php 
                      
                      if ($informacoesCampus->shurtName == "paracatu") { ?>
                      <li>
                        <?php echo anchor("graduacao/como_ingressar/$informacoesCampus->shurtName/vestibularagendado", 'Vestibular Agendado'); ?>
                      </li>
                      <?php 
                      }
                        if ($informacoesCampus->id != 3) {
                        ?>
                      <li>
                        <?php echo anchor("graduacao/como_ingressar/$informacoesCampus->shurtName/notaenem", 'Nota do Enem'); ?>
                      </li>

                      <?php
                      }
                      if ($informacoesCampus->id == '1') {
                      ?>
                      <li>
                        <?php echo anchor("graduacao/como_ingressar/$informacoesCampus->shurtName/segundagraduacao", 'Segunda Graduação'); ?>
                      </li>
                      <li>
                        <?php echo anchor("graduacao/como_ingressar/$informacoesCampus->shurtName/transferencia", 'Transferência'); ?>
                      </li>
                      <li>
                        <?php echo anchor("graduacao/como_ingressar/$informacoesCampus->shurtName/reingresso", 'Reingresso'); ?>
                      </li>
                      <li>
                        <?php echo anchor("graduacao/como_ingressar/$informacoesCampus->shurtName/reopcaodecurso", 'Reopção de Curso '); ?>
                      </li>
                      <?php
                                            }
                                            ?>
                      <li>
                        <?php echo anchor("graduacao/como_ingressar/$informacoesCampus->shurtName/vestibulartradicional", 'Vestibular Tradicional'); ?>
                      </li>
                    </ul>
                  </li>

                  <li>
                    <?php 
                    if(isset($verificaPaginaFinanceiro)){
                      echo anchor('financeiro/inicio/' . $informacoesCampus->shurtName, 'Financeiro'); 
                    }
                    ?>
                  </li>
                  <?php
                    if ($informacoesCampus->id == '1') {
                    ?>
                  <!--li><?php echo anchor('posgraduacao/inicio/' . $informacoesCampus->shurtName, 'Pós-Graduação'); ?></li-->
                  <?php
                                    }
                                    ?>
                  <li class="dropdown mega-dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Serviços <span class="caret"></span></a>
                    <ul class="dropdown-menu mega-dropdown-menu ">
                      <li class="col-sm-6">
                        <ul>
                          <li class="dropdown-header hidden-xs">Gerais</li>
                          <li>
                            <ul>
                              <li class="itensMenu">
                                <?php
                                                                echo anchor('site/biblioteca/' . $informacoesCampus->shurtName, '<i class="fas fa-angle-right"></i> Biblioteca');
                                                                ?>

                              </li>
                              <?php
                                                            if ($informacoesCampus->id == '2' || $informacoesCampus->id == '1') {
                                                            ?>
                              <li class="itensMenu">
                                <?php echo anchor('EstagiosConvenios/inicio/' . $informacoesCampus->shurtName, '<i class="fas fa-angle-right"></i> Estágios e convênios'); ?>
                              </li>
                              <?php
                                                            }
                                                            if ($informacoesCampus->id == '1') {
                                                            ?>
                              <li class="itensMenu">
                                <?php echo anchor('Huna/inicio/' . $informacoesCampus->shurtName, '<i class="fas fa-angle-right"></i> HUNA
                                                                        -
                                                                        Hospital Universitário Atenas'); ?>
                                <a href="#"></a>
                              </li>
                              <?php
                                                            }
                                                            ?>
                              <li class="itensMenu">
                                <?php echo anchor("site/secretaria_academica/$informacoesCampus->shurtName", '<i class="fas fa-angle-right"></i>
                                                                    Secretaria Acadêmica'); ?>
                              </li>

                            </ul>
                          </li>
                        </ul>
                      </li>
                      <li class="col-sm-6">
                        <ul>
                          <li class="dropdown-header hidden-xs">Núcleos</li>
                          <li>
                            <ul>
                              <li class="itensMenu">
                                <?php echo anchor('site/napp/' . $informacoesCampus->shurtName, '<i class="fas fa-angle-right"></i> Atendimento Psicopedagógico(NAPP) '); ?>
                              </li>
                              <?php
                                                            if ($informacoesCampus->id == '1') {
                                                            ?>
                              <li class="itensMenu">
                                <?php echo anchor('site/npj/' . $informacoesCampus->shurtName, '<i class="fas fa-angle-right"></i> Atendimento Jurídico (NPJ) '); ?>
                              </li>
                              <li class="itensMenu">
                                <?php echo anchor('site/npa/' . $informacoesCampus->shurtName, '<i class="fas fa-angle-right"></i> Atendimento Empresarial (NPA) '); ?>
                              </li>
                              <li class="itensMenu">
                                <?php echo anchor('site/npas/' . $informacoesCampus->shurtName, '<i class="fas fa-angle-right"></i> Atendimento Tecnológico (NPAS) '); ?>
                              </li>
                              <?php
                                                            }
                                                            ?>
                            </ul>
                          </li>
                        </ul>
                      </li>
                      <li class="hidden-xs"><a href="#" style=""></a></li>
                      <li class="divider hidden-xs"></li>
                      <li class="dropdown-header hidden-xs">Portais</li>
                      <li>
                        <?php echo anchor("PortalAlunos/portal/$informacoesCampus->shurtName", 'Portal do Aluno'); ?>
                      </li>
                      <li><a href="http://177.69.195.4/Corpore.Net/Login.aspx">Portal do
                          Professor</a></li>
                    </ul>
                  </li>
                  <li class="dropdown">
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                      aria-expanded="false">Pesquisa<span class="caret"></span></a>
                    <ul class="dropdown-menu menu-simpes" role="menu">
                      <li class="itensMenu">
                        <?php echo anchor('IniciacaoCientifica/inicio_pesquisa/' . $informacoesCampus->shurtName, 'Pesquisa e Iniciação Científica'); ?>
                      </li>
                      <li class="itensMenu">
                        <?php echo anchor('IniciacaoCientifica/comite_etica/' . $informacoesCampus->shurtName, 'Comitê de Ética em Pesquisa'); ?>
                      </li>
                      <?php
                                            if ($informacoesCampus->id == '1' or $informacoesCampus->id == '3') {
                                            ?>
                      <li class="itensMenu">
                        <?php echo anchor('IniciacaoCientifica/revistas/' . $informacoesCampus->shurtName, 'Revistas'); ?>
                      </li>
                      <?php
                                            }
                                            ?>
                      <?php
                                            if ($informacoesCampus->id == '1') {
                                            ?>
                      <li class="itensMenu">
                        <?php echo anchor('IniciacaoCientifica/trabalho_conclusao_curso/' . $informacoesCampus->shurtName, 'Trabalho de Conclusão de Curso'); ?>
                      </li>
                      <?php
                                            }
                                            ?>
                    </ul>
                  </li>
                  </li>
                  <li><?php echo anchor('site/contato/' . $informacoesCampus->shurtName, 'Contato'); ?></li>

                </ul>

              </div>
            </nav>
          </div>

        </div>
      </div>
    </div>
  </header>
</div>
<br />

<?php

?>