<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<?php
include_once 'navbar.php';

$permissionCampusArray = '';
?>
<section>
  <aside id="leftsideba" class="sidebar">
    <div class="menu">
      <ul class="list">

        <li class="header">Informações Gerais</li>

        <li class="active">
          <?php echo anchor('painel/index', '<i class="material-icons">call_to_action</i><span>DASHBOARD</span>'); ?>
        </li>
        <!-----------------------------------------------------------------------
          Menu para gestão dos campus
        ------------------------------------------------------------------------->
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">account_balance</i> <span>Campus</span>
          </a>

          <ul class="ml-menu">
            <li>
              <?php
                echo anchor('Painel_campus/lista_campus', '<span>Todos os Campus</span>');
              ?>
            </li>
            <li>
              <?php
                echo anchor('Painel_campus/lista_campus_botoes_acessos', '<span>Botões de Acesso Rápido</span>');
                // echo anchor('Painel_campus/lista_botoes_acesso_rapido_camp', '<span>Botões de Acesso Rápido</span>');
              ?>
            </li>
            <li>
              <?php
                // echo anchor('Painel_Campus/lista_indicadores', '<span>Indicadores <strong>(Item do Rodapé)</strong></span>');
                echo anchor('Painel_Campus/lista_campus_indicadores', '<span>Indicadores <strong>(Item do Rodapé)</strong></span>');
              ?>
            </li>
          </ul>
        </li>

        <!-----------------------------------------------------------------------
          Menu para gestão de arquivos temporários
        ------------------------------------------------------------------------->

        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">folder_shared</i>
            <span>Arquivos e fotos temp</span>
          </a>

          <ul class="ml-menu">
            <li>
              <?php
              echo anchor('Painel_arquivos_temporarios/lista_campus_temps', '<span>Fotos/Arquivos</span>');
              ?>
            </li>
          </ul>
        </li>
        <!-----------------------------------------------------------------------
          Menu para gestão dos campus
        ------------------------------------------------------------------------->
        <li class="header">Menu Instituição</li>
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">account_balance</i> <span>Instituição</span>
          </a>

          <ul class="ml-menu">

            <li>
              <?php
                echo anchor('Painel_campus/lista_dirigentes', '<span>Dirigentes <strong>(Diretores/Reitores)</strong></span>');
              ?>
            </li>
            <li>
              <?php
                echo anchor('Painel_campus/lista_campus_nossa_historia', '<span>História <strong>(Missão, visão e valores)</strong></span>');
              ?>
            </li>
            <li>
              <?php
                echo anchor('Painel_cpa/lista_campus_cpa', '<span>CPA <small> <strong>(Comissão Própria de Avaliação)</strong></small></span>');
              ?>
            </li>
          </ul>
        </li>




        <!-----------------------------------------------------------------------
          Menu para gestão de todas as informações da página inicial
        ------------------------------------------------------------------------->
        <li class="header">Pagína Inicial - Home</li>
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">view_list</i>
            <span>Página Inicial - HOME</span>
          </a>
          <ul class="ml-menu">
            <li>
              <?php
                /*************************
                 * Banners da página inicial
                 * ***********************/
                // echo anchor('Painel_home/slideshow', '<span>Banners Principal - Slide</span>');
                echo anchor('Painel_home/lista_campus', '<span>Banners Principal - Slide</span>');
                ?>
            </li>
          </ul>
        </li>
        <li>
          <?php 
          echo anchor('Painel_noticias/lista_campus_noticias', '<i class="material-icons">newspaper</i><span>Notícias</span>');
          ?>
        </li>
        <!-- <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">assignment</i>
            <span>Notícias</span>
          </a>
          <ul class="ml-menu">
            <li>
              <?php
              // echo anchor('Painel_noticias/lista_campus_noticias', '<span>Notícias</span>');
              // echo anchor('Painel_noticias/noticias', '<span>Notícias</span>');
              ?>
            </li>
          </ul>
        </li> -->

        <!-----------------------------------------------------------------------
          Menu para gestão das opçoes referente à graduação - Todos os cursos e gestao dos cursos por campus
        ------------------------------------------------------------------------->
        <li class="header">Gestão - Graduação</li>
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">menu_book</i>
            <span>Graduação Cursos</span>
          </a>

          <ul class="ml-menu">
            <li>
              <a href="javascript:void(0);" class="menu-toggle">
                <span>Todos os Cursos</span>
              </a>
              <ul class="ml-menu">
                <li>
                  <?php echo anchor('Painel_graduacao/todos_cursos/presencial', '<span>Presencial</span>');?>
                </li>
                <li>
                  <?php echo anchor('Painel_graduacao/todos_cursos/ead', '<span>EAD</span>');?>
                </li>
              </ul>
            </li>
            <li>
              <?php
                echo anchor('Painel_graduacao/lista_campus_cursos', '<span>Cursos Por Campus</span>');
                ?>
            </li>
          </ul>
        </li>

        <!-----------------------------------------------------------------------
          Menu para gestão das informações do menu instituição
        ------------------------------------------------------------------------->
        <li class="header">Instituição</li>
        <li>

          <?php
            include_once('itens_header/item_h_instituicao.php');
          ?>

        </li>

        <li>

          <?php include_once('itens_header/item_h_financeiro.php');?>
          <?php include_once('itens_header/item_h_mural_institutional_norms.php'); ?>
          <?php include_once('itens_header/item_h_vestibular.php');?>

          <?php include_once('itens_header/item_h_secretaria.php');?>
        </li>
        <li>
          <?php echo anchor('TrabalheConosco/areasSetores', '<span>Corpo Docente</span>');?>
        </li>
        <li>
          <?php echo anchor('TrabalheConosco/areasSetores', '<span>Laboratórios</span>');?>
        </li>
        <li>
          <?php echo anchor('TrabalheConosco/areasSetores', '<span>Núcleos</span>');?>
        </li>


        <ul class="ml-menu">
          <li>
            <a href="javascript:void(0);" class="menu-toggle">
              <span>Vagas</span>
            </a>
            <ul class="ml-menu">

              <li>
                <a href="javascript:void(0);">
                  <span>Currículos - Recebidos</span>
                </a>
              </li>

            </ul>
          </li>
        </ul>

        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">assignment</i>
            <span>Gestão Curriculos</span>
          </a>

          <ul class="ml-menu">
            <li>
              <?php echo anchor('TrabalheConosco/curriculosRecebidos', '<span>Curriculos - Recebidos</span>');?>
            </li>

            <li>
              <?php echo anchor('TrabalheConosco/vagasTrabalho', '<span>Vagas de trabalho</span>');?>
            </li>
            <li>
              <?php echo anchor('TrabalheConosco/areasSetores', '<span>Áreas / Setores</span>');?>
            </li>


          </ul>
          <ul class="ml-menu">
            <li>
              <a href="javascript:void(0);" class="menu-toggle">
                <span>Vagas</span>
              </a>
              <ul class="ml-menu">

                <li>
                  <a href="javascript:void(0);">
                    <span>Currículos - Recebidos</span>
                  </a>
                </li>

              </ul>
            </li>
          </ul>
        </li>


        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">assignment</i>
            <span>Gestão Biblioteca</span>
          </a>
          <ul class="ml-menu">
            <li>
              <a href="javascript:void(0);" class="menu-toggle">
                <span> Revistas e Periódicos</span>
              </a>
              <ul class="ml-menu">
                <li>
                  <?php echo anchor('biblioteca/linksRevistasPeriodicos', '<span>Links</span>'); ?>
                </li>
                <li>
                  <?php echo anchor('biblioteca/linksAreasCursos', '<span>Areas/ Cursos</span>'); ?>
                </li>
              </ul>
            </li>
          </ul>

        </li>



        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">assignment</i>
            <span>Mural Site</span>
          </a>
          <ul class="ml-menu">
            <li>
              <a href="javascript:void(0);" class="menu-toggle">
                <span>Calendário - Provas</span>
              </a>
              <ul class="ml-menu">
                <li>
                  <?php echo anchor('Mural/informacoesProvas/1', '<span>Paracatu</span>');?>
                </li>
                <li>
                  <?php echo anchor('Mural/informacoesProvas/3', '<span>Passos</span>'); ?>
                </li>
                <li>
                  <?php echo anchor('Mural/informacoesProvas/2', '<span>Sete Lagoas</span>');?>
                </li>
              </ul>
            </li>
            <li>
              <a href="javascript:void(0);" class="menu-toggle">
                <span>Lista de Salas de Provas</span>
              </a>
              <ul class="ml-menu">
                <li>
                  <?php echo anchor('Mural/informacoesProvas/1', '<span>Paracatu</span>');?>
                </li>
                <li>
                  <?php echo anchor('Mural/informacoesProvas/2', '<span>Passos</span>'); ?>
                </li>
                <li>
                  <?php echo anchor('Mural/informacoesProvas/3', '<span>Sete Lagoas</span>');  ?>
                </li>
              </ul>
            </li>
            <li>
              <a href="javascript:void(0);" class="menu-toggle">
                <span>Lista dos Mapas de Vista</span>
              </a>
              <ul class="ml-menu">
                <li>
                  <?php echo anchor('Mural/mapaDeVista/1', '<span>Paracatu</span>'); ?>
                </li>
              </ul>
            </li>
          </ul>
        </li>

        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">assignment</i>
            <span>TV</span>
          </a>
          <ul class="ml-menu">
            <li>
              <?php echo anchor('mural/tv/1', '<span>Passos</span>'); ?>
            </li>
          </ul>
        </li>
        <li>
          <?php include_once('itens_header/item_h_iniciacao.php');?>
        </li>
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">assignment</i>
            <span>PROCESSO SELETIVO</span>
          </a>
          <ul class="ml-menu">
            <li>
              <a href="javascript:void(0);" class="menu-toggle">
                <span>Inscrições</span>
              </a>
              <ul class="ml-menu">
                <li>
                  <?php echo anchor('ProcessoSeletivo/insricoesEad', '<span>EAD - Uniatenas</span>');?>
                </li>
                <li>
                  <?php echo anchor('publicacoes/anais', '<span>Presenciais</span>');?>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </div>

    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
      <div class="copyright">
        &copy; <a href="javascript:void(0);">UNIATENAS - PAINEL</a>.
      </div>
      <div class="version">
        <b>Version: </b> 1.0.2
      </div>
    </div>
  </aside>

</section>