<?php
if (!defined("BASEPATH"))
    exit("No direct script access allowed");
switch ($tela):
    case 'noticias':
        include_once('noticias/noticias.php');
        break;
    case 'cadastrar':
        include_once('noticias/cadastrar.php');
        break;
    default:
        echo '<div class="alert-box alert"><p>A tela solicitada não existe</p></div>';
        break;
endswitch;
