<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");
switch ($tela) :
    //================================================================LOGIN========================================================================================================================


    case 'home' :
        include_once ('conteudos/home.php');
        break;

    case 'missao_filosofia' :
        include_once ('conteudos/missao_filosofia.php');
        break;

    case 'cpa' :
        include_once ('conteudos/cpa.php');
        break;

    case 'infraestrutura' :
        include_once ('conteudos/infraestrutura.php');
        break;

    case 'dirigentes' :
        include_once ('conteudos/dirigentes.php');
        break;


    case 'localizacao' :
        include_once ('conteudos/inicioCampus.php');
        break;

    case 'laboratorio' :
        include_once ('conteudos/laboratorio.php');
        break;

    case 'cep' :
        include_once ('conteudos/cep.php');
        break;

    case 'ouvidoria' :
        include_once ('conteudos/ouvidoria.php');
        break;

    case 'fale_conosco' :
        include_once ('conteudos/fale_conosco.php');
        break;

    case 'curriculo' :
        include_once ('conteudos/curriculo.php');
        break;

    case 'npj' :
        include_once ('conteudos/npj.php');
        break;

    case 'npa' :
        include_once ('conteudos/npa.php');
        break;

    case 'npas' :
        include_once ('conteudos/npas.php');
        break;


    case 'noticias' :
        include_once ('conteudos/noticias/noticias.php');
        break;
    case 'ver_noticia' :
        include_once ('conteudos/noticias/ver_noticia.php');
        break;

    case 'biblioteca' :
        include_once ('conteudos/biblioteca.php');
        break;

    case 'informacoes_biblioteca' :
        include_once ('conteudos/biblioteca/informacoes_biblioteca.php');
        break;

    case 'pesquisa_acervo' :
        include_once ('conteudos/biblioteca/pesquisa_acervo.php');
        break;

    case 'comutacao_bibliografica' :
        include_once ('conteudos/biblioteca/comutacao_bibliografica.php');
        break;

    case 'iniciacao_cientifica' :
        include_once ('conteudos/iniciacao_cientifica.php');
        break;

    case 'napp' :
        include_once ('conteudos/napp.php');
        break;

    case 'graduacao_presencial' :
        include_once ('conteudos/graduacao_presencial.php');
        break;

    case 'inscricao' :
        include_once ('conteudos/inscricao.php');
        break;
    case 'graduacao_ead' :
        include_once ('conteudos/graduacao_ead.php');
        break;









    /* 	
      case 'contato' :
      include_once ('conteudos/contato.php');
      break;
      case 'newsletter' :
      include_once ('conteudos/newsletter.php');
      break;



      case 'mural_academico' :
      include_once ('conteudos/mural_academico.php');
      break;

      case 'missao_filosofia' :
      include_once ('conteudos/missao_filosofia.php');
      break;

      case 'localizacao' :
      include_once ('conteudos/inicioCampus.php');
      break;

      case 'dirigentes' :
      include_once ('conteudos/dirigentes.php');
      break;
     */
    case 'cursos_ead' :
        include_once ('conteudos/cursos_ead.php');
        break;

    default :
        echo '<div class="alert-box alert"><p>A tela solicitada não existe</p></div>';
        break;
endswitch;

