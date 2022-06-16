<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");
switch ($tela):

    case 'home':
        include_once('itens_home/home.php');
        break;
    case 'infraestrutura':
        include_once('itens_paginas/infraestrutura/infraestrutura.php');
        break;
    case 'cadastrar_itens_infraestrutura':
        include_once('itens_paginas/infraestrutura/cadastrar.php');
        break;
    
    /**
     * Informações secretaria
     */
    case 'calendarios_semestre':
        include_once('itens_paginas/secretaria/calendarios_semestre.php');
        break;

    case 'cadastrar_calendarios_semestre':
        include_once('itens_paginas/secretaria/cadastrar.php');
        break;


    case 'calendarios_provas':
        include_once('itens_mural/provas/calendarios_provas.php');
        break;

    case 'cadastrar_calendarios_prova':
        include_once('itens_paginas/infraestrutura/cadastrar.php');
        break;
    /**
     * Informações da SPIC
     */
    case 'publicacoes':
        include_once('itens_spic/publicacoes/publicacoes.php');
        break;

    default:
        echo '<div class="alert-box alert"><p>A tela solicitada não existe</p></div>';
        break;
endswitch;
