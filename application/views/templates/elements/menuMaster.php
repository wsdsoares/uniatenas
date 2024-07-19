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

$wehreArrayLinkvestibular = array(
  'gerais_elementos_site.tipo' => 'link_vestibular',
  'gerais_elementos_site.id_campus' => $informacoesCampus->id,
  'gerais_elementos_site.status' => 1
);
$linkVetibularTopo = $this->bancosite->where('*', 'gerais_elementos_site', null, $wehreArrayLinkvestibular)->row();

$wehreArrayLinkBiblioteca = array(
  'gerais_elementos_site.tipo' => 'link_biblioteca',
  'gerais_elementos_site.id_campus' => $informacoesCampus->id,
  'gerais_elementos_site.status' => 1
);
$linkBibliotecaTopo = $this->bancosite->where('*', 'gerais_elementos_site', null, $wehreArrayLinkBiblioteca)->row();

$verificaPaginaFinanceiro = $this->bancosite->where('*', 'pages', null, array('title' => 'financeiro', 'campusid' => $informacoesCampus->id, 'status' => 1))->row();
$verificaPaginaNapp = $this->bancosite->where('*', 'pages', null, array('title' => 'napp', 'campusid' => $informacoesCampus->id, 'status' => 1))->row();
$verificaPaginaRevistas = $this->bancosite->where('*', 'pages', null, array('title' => 'revistas', 'campusid' => $informacoesCampus->id, 'status' => 1))->row();
$verificaPaginaComoIngressar = $this->bancosite->where(array('pages.id', 'pages.title'), 'pages', null, array('title' => 'comoingressar', 'campusid' => $informacoesCampus->id, 'status' => 1))->row();
$verificaPaginaEstagiosConvenios = $this->bancosite->where('*', 'pages', null, array('title' => 'estagiosConvenios', 'campusid' => $informacoesCampus->id, 'status' => 1))->row();

$joinCountCursosEad = array(
  'courses' => 'courses.id = campus_has_courses.courses_id',
  'campus' => 'campus.id = campus_has_courses.campus_id'
);
$verificaCursosEaD = $this->bancosite->where(array('courses.id'), 'campus_has_courses', $joinCountCursosEad, array('campus_has_courses.campus_id' => $informacoesCampus->id))->num_rows();

$whereArraySubmenuNucleos = array('pages.campusid' => $informacoesCampus->id, 'pages.pagina' => 'servicos', 'pages.status' => 1, 'pages.tipo_pagina' => 'nucleos');
$existePaginaServicosSubmenuNucleos =  $this->bancosite->where(array('pages.id'), 'pages', null, $whereArraySubmenuNucleos)->num_rows();
$verificaPaginaServicosSubmenuNucleos =  $this->bancosite->where(array('pages.id', 'pages.title', 'pages.titulo_descritivo'), 'pages', null, $whereArraySubmenuNucleos)->result();

// echo '<br>';
// echo '<br>';
// echo '<br>';
// echo '<br>';
// echo '<br>';
// echo '<pre>';
// print_r($verificaPaginaServicosSubmenuNucleos);
// // print_r($verificaPaginaServicosSubmenuNucleos);
// echo '</pre>';

// $colunasItensSubmneuNucleos = array(
//   'pages.id', 'pages.title', 'pages.tipo_pagina'
// );
// $listaItensSubmenuPaginaServicos =  $this->painelbd->where($colunasItensSubmneuNucleos, 'pages', null, array('pages.campusid' => $uriCampus, 'pages.pagina' => 'servicos'))->result();

// $whereConteudoPaginaServicosNucleos = array('page_contents.pages_id' => $page->id, 'page_contents.tipo' => 'informacoesPagina', 'page_contents.status' => 1);
// $pages_content = $this->bancosite->where('*', 'page_contents', null, $whereConteudoPagina)->result();

// $joinConteudoServicosItensGerais = array(
//   'courses' => 'courses.id = campus_has_courses.courses_id',
//   'campus' => 'campus.id = campus_has_courses.campus_id'
// );
// $verificaItensServicosGerais = $this->bancosite->where(array('courses.id'), 'campus_has_courses', $joinConteudoServicosItensGerais, array('campus_has_courses.campus_id' => $informacoesCampus->id))->num_rows();



if (isset($verificaPaginaComoIngressar) and $verificaPaginaComoIngressar != '') {

  $listaMenuItensComoIngressar =  $this->bancosite->getQuery(
    "SELECT 
      page_contents.id,
      page_contents.title,
      page_contents.title_short

    FROM 
      page_contents
    INNER JOIN pages ON pages.id = page_contents.pages_id
    INNER JOIN campus ON campus.id= pages.campusid
    WHERE 
        pages.title = 'comoingressar'AND 
        pages.campusid = $informacoesCampus->id AND 
        page_contents.status=1
    ORDER BY page_contents.order ASC"
  )->result();
}
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
                      if (isset($linkBibliotecaTopo)) {
                      ?>
                    <?php
                        //$linkBibliotecaTopo 

                        echo anchor($linkBibliotecaTopo->link, '<i class="fas fa-book"></i><span class="top-page-alunos hidden-xs">' . $linkBibliotecaTopo->nome . '</span>');
                        ?>
                    <?php
                      }
                      ?>
                </div>

                <?php
                if (isset($linkVetibularTopo)) {
                ?>
                <div class="log-reg">
                  <a href="<?php print($linkVetibularTopo->link) ?>" class="mx-auto download-btn-top">
                    <i class=" fa fa-graduation-cap" aria-hidden="true"></i><?php echo $linkVetibularTopo->nome ?>
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
                        <?php
                        echo anchor('graduacao/cursos/' . $informacoesCampus->shurtName, 'Presencial');
                        ?>
                      </li>
                      <?php
                      if ($verificaCursosEaD > 0) {
                      ?>
                      <li><?php echo anchor('graduacao/ead/' . $informacoesCampus->shurtName, 'EaD'); ?></li>
                      <?php
                      }
                      ?>
                    </ul>
                  </li>
                  <?php
                  if (isset($verificaPaginaComoIngressar)) {
                  ?>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                      Como ingressar<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu menu-simpes" role="menu">
                      <?php
                        if ($listaMenuItensComoIngressar) {
                          foreach ($listaMenuItensComoIngressar as $itemIngressar) {
                        ?>
                      <li>
                        <?php echo anchor("graduacao/como_ingressar/$informacoesCampus->shurtName/$itemIngressar->title_short", "$itemIngressar->title"); ?>
                      </li>
                      <?php
                          }
                        }
                        ?>
                    </ul>
                  </li>
                  <?php
                  }
                  ?>
                  <li>
                    <?php
                    if (isset($verificaPaginaFinanceiro)) {
                      echo anchor('financeiro/inicio/' . $informacoesCampus->shurtName, 'Financeiro');
                    }
                    ?>
                  </li>
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

                              if (isset($verificaPaginaEstagiosConvenios)) {
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
                              <?php ?>

                              <?php ?>
                            </ul>
                          </li>
                        </ul>
                      </li>
                      <!-- 
                      c 
                      $itemPaginaServicosSubmenuNucleos 
                      -->
                      <?php
                      if ($existePaginaServicosSubmenuNucleos > 0) {
                      ?>
                      <li class="col-sm-6">
                        <ul>
                          <li class="dropdown-header hidden-xs">Núcleos</li>
                          <li>
                            <ul>
                              <?php
                                foreach ($verificaPaginaServicosSubmenuNucleos as $submenuServicosNucleos) {
                                ?>
                              <li class="itensMenu">
                                <?php
                                    $tituloMenu = isset($submenuServicosNucleos->titulo_descritivo) ? $submenuServicosNucleos->titulo_descritivo : $submenuServicosNucleos->title;
                                    echo anchor("servicos/nucleos/$informacoesCampus->shurtName/$submenuServicosNucleos->title", '<i class="fas fa-angle-right"></i> ' . $tituloMenu);
                                    ?>
                              </li>
                              <?php
                                }
                                ?>
                            </ul>
                          </li>
                        </ul>
                      </li>
                      <?php
                      }
                      ?>
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
                      //if ($informacoesCampus->id == '1' or $informacoesCampus->id == '3') {

                      if (isset($verificaPaginaRevistas)) {
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