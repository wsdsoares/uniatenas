<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<?php
include_once 'navbar.php';

$permissionCampusArray = '';
?>
<script type="text/javascript">
  function ativo() {
    const elemento = document.querySelectorAll("<li> .active");
    console.log(elemento);
    alert(elemento);
  }
</script>
<section>
  <aside id="leftsideba" class="sidebar">
    <div class="menu" id="menu">
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
              echo anchor('Painel_Campus/lista_campus_indicadores', '<span>Indicadores <strong>(Item do Rodapé)</strong></span>');
              ?>
            </li>
            <li>
              <?php
              echo anchor('Painel_geral/lista_campus_elementos_site', '<span>Itens do Site <small><strong>(Topo e rodapé página)</strong></small></span>');
              ?>
            </li>
            <li>
              <?php
              echo anchor('Painel_galeria/lista_campus_galeria_fotos', '<span>Galeria <small> <strong>(Fotos diversas do Campus)</strong></small></span>');
              ?>
            </li>
            <li>
              <?php
              echo anchor('Painel_geral/lista_campus_whatsapp', '<span>WhatsApp <small> <strong>(Exibido em todo site)</strong></small></span>');
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
        <!-----------------------------------------------------------------------
          Menu para gestão dos contatos recebidos no site
        ------------------------------------------------------------------------->
        <li class="header">Contatos - Mensages do site</li>
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">view_list</i>
            <span>Dados do contato - Mensagens</span>
          </a>
          <ul class="ml-menu">
            <li>
              <?php
              echo anchor('Painel_mensagens_contatos/lista_campus_mensagens_contatos', '<span>Mensagens Recebidas</span>');
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
            <li>
              <?php
              echo anchor('Painel_campus/lista_campus_infraestrutura', '<span>Infraestrutura <small> <strong>(Locais do Campus)</strong></small></span>');
              ?>
            </li>
          </ul>
        </li>
        <!-----------------------------------------------------------------------
          Menu para gestão dos contatos recebidos no site
        ------------------------------------------------------------------------->
        <li class="header">Menu - Como Ingressar</li>
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">view_list</i>
            <span>Formas de Ingresso</span>
          </a>
          <ul class="ml-menu">
            <li>
              <?php
              echo anchor('Painel_como_ingressar/lista_campus_como_ingressar', '<span>Páginas por Campus</span>');
              ?>
            </li>
          </ul>
        </li>
        <li class="header">Menu - Financeiro</li>
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">view_list</i>
            <span>Financeiro</span>
          </a>
          <ul class="ml-menu">
            <li>
              <?php
              echo anchor('Painel_financeiro/lista_campus_financeiro', '<span>Páginas por Campus</span>');
              ?>
            </li>
          </ul>
        </li>
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
                  <?php echo anchor('Painel_graduacao/todos_cursos/presencial', '<span>Presencial</span>'); ?>
                </li>
                <li>
                  <?php echo anchor('Painel_graduacao/todos_cursos/ead', '<span>EAD</span>'); ?>
                </li>
              </ul>
            </li>
            <li>
              <a href="javascript:void(0);" class="menu-toggle">
                <span>Cursos Por Campus</span>
              </a>
              <ul class="ml-menu">
                <li>
                  <?php echo anchor('Painel_graduacao/lista_campus_cursos/presencial', '<span>Presencial</span>'); ?>
                </li>
                <li>
                  <?php echo anchor('Painel_graduacao/lista_campus_cursos/ead', '<span>EAD</span>'); ?>
                </li>
              </ul>
            </li>
            <li>
              <?php
              //echo anchor('Painel_graduacao/lista_campus_cursos', '<span>Cursos Por Campus</span>');
              ?>
            </li>
          </ul>
        </li>

        <li class="header">Menu - Serviços - Portais</li>
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">view_list</i>
            <span>Portal Aluno/ Professor</span>
          </a>
          <ul class="ml-menu">
            <li>
              <?php
              echo anchor('Painel_portal_alunos/lista_campus_portal_alunos', '<span>Portais</span>');
              ?>
            </li>
          </ul>
        </li>

        <!-----------------------------------------------------------------------
          Menu para gestão dos menus de serviços - Todos os campus CPA, NAPP, NPA, NPAS
        ------------------------------------------------------------------------
        <li class="header">Menu - Serviços</li>
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">assignment</i>
          <span>Coodenação Secretaria</span>
        </a>

        <ul class="ml-menu">
          <li>
            <a href="javascript:void(0);" class="menu-toggle">
              <span>Calendários Semestre</span>
            </a>
            <ul class="ml-menu">
              <li>
                <?php echo anchor('Painel_secretaria/lista_campus_secretaria', '<span>Calendários</span>'); ?>
              </li>
            </ul>
          </li>
        </ul>
        <!-----------------------------------------------------------------------
          Menu para gestão dos itens curriculo - Todos os campus Trabalhe conosco
        ------------------------------------------------------------------------->
        <li class="header">Gestão - Trabalhe Conosco</li>
        <!-- <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">menu_book</i>
            <span>Trabalhe Conosco</span>
          </a>

          <ul class="ml-menu">
            <li>
              <?php echo anchor('TrabalheConosco/curriculosRecebidos', '<span>Curriculos - Recebidos</span>'); ?>
            </li>

            <li>
              <?php echo anchor('TrabalheConosco/vagasTrabalho', '<span>Vagas de trabalho</span>'); ?>
            </li>
            <li>
              <?php echo anchor('TrabalheConosco/areasSetores', '<span>Áreas / Setores</span>'); ?>
            </li>
          </ul>
        </li> -->
        </li>
        <?php //include_once('itens_header/item_h_financeiro.php');
        ?>
        <?php //include_once('itens_header/item_h_mural_institutional_norms.php'); 
        ?>
        <?php //include_once('itens_header/item_h_vestibular.php');
        ?>

        <li class="header">Secretaria Acadêmica</li>
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">assignment</i>
            <span>Coodenação Secretaria</span>
          </a>
          <ul class="ml-menu">
            <li>
              <?php
              echo anchor('Painel_secretaria/lista_campus_secretaria', '<span>Itens</span>');
              ?>
            </li>
            <li>
              <a href="javascript:void(0);" class="menu-toggle">
                <span>Calendários Semestre</span>
              </a>
              <ul class="ml-menu">
                <li>

                  <?php //echo anchor('Painel_secretaria/lista_campus_secretaria', '<span>Calendários</span>'); 
                  ?>
                  <?php echo anchor('Painel_secretaria/lista_campus_secretaria', '<span>Informações</span>'); ?>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li>
          <?php //echo anchor('TrabalheConosco/areasSetores', '<span>Laboratórios</span>');
          ?>
        </li>
        <li>
          <?php //echo anchor('TrabalheConosco/areasSetores', '<span>Núcleos</span>');
          ?>
        </li>

        <li class="header">Biblioteca</li>
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">assignment</i>
            <span>Gestão Biblioteca</span>
          </a>
          <ul class="ml-menu">
            <!-- <li>
              <?php
              echo anchor('Painel_biblioteca_revistas_periodicos/lista_campus_revistas_periodicos', '<span>Revistas/Periódicos <u>(links)</u></span>');
              ?>
            </li> -->
            <!-- <li>
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
            </li> -->
            <li>
              <?php
              echo anchor('Painel_biblioteca/lista_campus_biblioteca', '<span>Item biblioteca</span>');
              ?>
            </li>
          </ul>

        </li>


        <li class="header">Menu Serviços</li>
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">assignment</i>
            <span>Serviços</span>
          </a>
          <ul class="ml-menu">
            <li>
              <?php
              echo anchor('Painel_servicos/lista_campus_servicos/gerais', '<span>Itens Gerais</span>');
              ?>
            </li>
            <li>
              <?php
              echo anchor('Painel_servicos/lista_campus_servicos/nucleos', '<span>Núcleos</span>');
              ?>
            </li>
            <li>
              <?php
              //echo anchor('Painel_servicos/lista_campus_servicos/portais', '<span>Portais</span>');
              ?>
            </li>
            <li>
              <?php
              echo anchor('Painel_napp/lista_campus_napp', '<span>NAPP</span>');
              ?>
            </li>
            <li>
              <?php
              echo anchor('Painel_estagios_convenios/lista_campus_estagios_convenios', '<span>Estágio e Convênios</span>');
              ?>
            </li>
          </ul>

        </li>


        <!--li>
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
                  <?php echo anchor('Mural/informacoesProvas/1', '<span>Paracatu</span>'); ?>
                </li>
                <li>
                  <?php echo anchor('Mural/informacoesProvas/3', '<span>Passos</span>'); ?>
                </li>
                <li>
                  <?php echo anchor('Mural/informacoesProvas/2', '<span>Sete Lagoas</span>'); ?>
                </li>
              </ul>
            </li>
            <li>
              <a href="javascript:void(0);" class="menu-toggle">
                <span>Lista de Salas de Provas</span>
              </a>
              <ul class="ml-menu">
                <li>
                  <?php echo anchor('Mural/informacoesProvas/1', '<span>Paracatu</span>'); ?>
                </li>
                <li>
                  <?php echo anchor('Mural/informacoesProvas/2', '<span>Passos</span>'); ?>
                </li>
                <li>
                  <?php echo anchor('Mural/informacoesProvas/3', '<span>Sete Lagoas</span>'); ?>
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
          </li-->

        <!-- <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">assignment</i>
            <span>TV</span>
          </a>
          <ul class="ml-menu">
            <li>
              <?php echo anchor('mural/tv/1', '<span>Passos</span>'); ?>
            </li>
          </ul>
        </li> -->
        <li class="header">Gestão - Pesquisa e Iniciação</li>
        <li>
          <a href="javascript:void(0);" class="menu-toggle">
            <i class="material-icons">assignment</i>
            <span>PESQUISA</span>
          </a>
          <ul class="ml-menu">
            <li>
              <a href="javascript:void(0);" class="menu-toggle">
                <span>Publicações</span>
              </a>
              <ul class="ml-menu">
                <li>
                  <?php
                  echo anchor('Painel_publicacoes/lista_campus_revistas', '<span>Revistas</span>');
                  ?>
                </li>

                <li>
                  <?php
                  echo anchor('Painel_pesquisa_tcc/lista_campus_tcc', '<span>Monografias - TCC</span>');
                  ?>
                </li>
                <li>
                  <?php
                  //comentado até a definição correta do processo
                  /*echo anchor('publicacoes/anaisMonografia', '
                                              <span>Anais</span>');*/
                  ?>
                </li>
              </ul>
              <?php
              echo anchor('Painel_publicacoes/lista_campus_revistas', '<span>Revistas</span>');
              ?>
              <?php
              echo anchor('Painel_iniciacao_cientifica/lista_campus_iniciacao', '<span>Itens Iniação</span>');
              ?>
              <?php
              echo anchor('Painel_pesquisa_comite/lista_campus_comite', '<span>CEP - Comitê de Ética em Pesquisa</span>');
              ?>
              <?php
              echo anchor('Painel_pesquisa_tcc/lista_campus_tcc', '<span>Página TCC</span>');
              ?>
            </li>
          </ul>
        </li>
        <li class="header"></li>

        <li>
        <li class="header">Gestão - Vestibular Medicina</li>
        <a href="javascript:void(0);" class="menu-toggle">
          <i class="material-icons">assignment</i>
          <span>Vestibular Medicina</span>
        </a>
        <ul class="ml-menu">
          <li>
            <?php
            echo anchor('Painel_vestibular/lista_campus_vestibular', '<span>Itens</span>');
            ?>
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