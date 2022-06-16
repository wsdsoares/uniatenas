<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");
switch ($tela):

    case 'inicio':
        include_once('itens_home/home.php');
        break;

    /*     * *****************
     * Página Inicial
     * **************** */

    case 'slideshow':
        include_once('itens_iniciar/slideshow.php');
        break;

    case 'cadastrar_slides':
        include_once('itens_iniciar/cadastrar_slides.php');
        break;



    case 'videos':
        include_once('itens_iniciar/videos/videos.php');
        break;

    case 'cadastrar_videos':
        include_once('itens_iniciar/videos/cadastrar_videos.php');
        break;

    /*     * *****************
     * SPIC - INICIAÇÃO CIENTÍFICA
     * **************** */
    case 'anais_monografia':
        include_once('spic/anais/anais_monografia.php');
        break;

    case 'cadastrar_anais_monografia':
        include_once('spic/anais/cadastrar_anais_monografia.php');
        break;
    /*     * *****************
     * Comunicação - Notícias
     * **************** */
    case 'noticias':
        include_once('noticias/noticias.php');
        break;

    case 'cadastrar_noticias':
        include_once('noticias/cadastrar_noticias.php');
        break;

    /*     * *****************
     * Página Inicial
     * **************** */
    case 'dirigentes':
        include_once('institucional/dirigentes/dirigentes.php');
        break;

    case 'cadastrar_dirigentes':
        include_once('institucional/dirigentes/cadastrar_dirigentes.php');
        break;


    case 'coordenadores_curso':
        include_once('institucional/coordenadores_curso/coordenadores_curso.php');
        break;

    case 'cadastrar_coordenadores_curso':
        include_once('institucional/coordenadores_curso/cadastrar_coordenadores_curso.php');
        break;




    /*     * *****************
     * Secretaria
     * **************** */
    //Avisos
    case 'avisos':
        include_once('itens_painel/avisos/avisos.php');
        break;
    case 'diplomas':
        include_once('itens_painel/diplomas/diplomas.php');
        break;
    case 'cadastrar_avisos':
        include_once('itens_painel/avisos/cadastrar_avisos.php');
        break;
    case 'cadastrar_lista_diplomas':
        include_once('itens_painel/diplomas/cadastrar_lista_diplomas.php');
        break;

    //Horários Especiais
    case 'horarios_especiais':
        include_once('itens_painel/avisos/horarios_especial/horarios_especiais.php');
        break;
    case 'cadastrar_horarios_especiais':
        include_once('itens_painel/avisos/horarios_especial/cadastrar_horarios_especiais.php');
        break;





    /**/
    /*     * *****************
     * Dowloads
     * **************** */
    case 'uploads':
        include_once('itens_painel/uploads.php');
        break;
    /*     * *****************
     * Dowloads
     * **************** */
    case 'viewpdf':
        include_once('itens_painel/viewpdf.php');
        break;


    default:
        echo '<div class="alert-box alert"><p>A tela solicitada não existe</p></div>';
        break;
endswitch;
