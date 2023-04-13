<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('verificaLogin')) {

    function verificaLogin($redirect = 'painel/login')
    {
        $CI = &get_instance();
        if ($CI->session->userdata('logged') != TRUE) {
            setMsg('<p><img src="' . base_url('assets/images/icons/wait.png') . '"> Acesso Restrito! Faça login para continuar.</p>', 'error');
            redirect($redirect, 'refresh');
        } else {
            return TRUE;
        }
    }
}

if (!function_exists('realizaLogout')) {

    function realizaLogout()
    {
        $CI = &get_instance();
        if ($CI->session->userdata('user')) {
            $CI->session->sess_destroy();
        }
    }
}
if (!function_exists('removerAcentos')) {

    function removerAcentos($texto)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $texto);
    }
}
if (!function_exists('noAccentuation')) {

    function noAccentuation($string = NULL, $concat = NULL)
    {
        if ($string != NULL) {

            // matriz de entrada
            $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û','Ã','À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', '.');

            // matriz de saída
            $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u','A', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');

            // devolver a string
            if (empty($concat)) {
                return str_replace($what, $by, $string);
            } else {
                return str_replace($what, $by, $concat . "_" . $string);
            }
        }
    }
}


if (!function_exists('verifica_login')) {

    function verifica_login($redirect = 'painel/login')
    {
        $CI = &get_instance();
        if ($CI->session->userdata('logged') != TRUE) {
            set_msg('<p>Acesso Restrito! Faça login para continuar.</p>', 'erro');
            redirect($redirect, 'refresh');
        } else {
            return TRUE;
        }
    }
}

if (!function_exists('setMsg')) :

    function setMsg($msg = NULL, $tipo = NULL)
    {
        $CI = &get_instance();
        switch ($tipo):
            case 'error':
                $CI->session->set_userdata('aviso', '
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>' . $msg . '</p>' .
                    '</div>');
                break;
            case 'success':
                $CI->session->set_userdata('aviso', '<div class="alert alert-success">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <p>' . $msg . '</p>' .
                    '</div>');
                break;
            case 'alert':
                $CI->session->set_userdata('aviso', '<div class="alert alert-warning">' .
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <p>' . $msg . '</p>' .
                    '</div>');
                break;

            default:
                $CI->session->set_userdata('aviso', '<div class="alert-box"><p>' . $msg . '</p></div>');
                break;
        endswitch;
    }

endif;

//verifica se existe uma mensagem para ser exibida na tela atual
if (!function_exists('getMsg')) :

    function getMsg($destroy = TRUE)
    {
        $CI = &get_instance();
        $retorno = $CI->session->userdata('aviso');
        if ($destroy)
            $CI->session->unset_userdata('aviso');
        return $retorno;
    }

endif;


if (!function_exists('configUploads')) {

    //define as configurações para upload de imagens/
    //gif|jpg|png|pdf|doc|txt|docx|doc|xls|xlsx
    function configUploads($path = '', $types = '', $tmp_name = NULL, $size = 0)
    {
        $config['upload_path'] = './' . $path . '/';
        $config['allowed_types'] = $types;
        $config['max_size'] = $size;
        $config['overwrite'] = TRUE;
        $config['remove_spaces'] = TRUE;
        if ($tmp_name != NULL) {
            $config['file_name'] = $tmp_name;
        } else {
            $config['encrypt_name'] = TRUE;
        }
        return $config;
    }
}
if (!function_exists('verifyImg')) {

    function verifyImg($img = NULL)
    {
        if ($img != 'NULL') {
            return $img = $img;
        } else {
            return "assets/images/no-image.jpg";
        }
    }
}


//gera um breadcrumb com base no controller atual
if (!function_exists('breadcrumb')) {

    function breadcrumb()
    {
        $CI = &get_instance();
        $CI->load->helper('url');
        $classe = ucfirst($CI->router->class);
        if ($classe == 'Site') :
            $classe = anchor($CI->router->class, 'UniAtenas');
        else :
            $classe = anchor($CI->router->class, $classe);
        endif;
        $metodo = ucwords(str_replace('_', ' ', $CI->router->method));
        if ($metodo && $metodo != 'Index') :
            $metodo = " &raquo; " . anchor($CI->router->class . "/" . $CI->router->method, $metodo);
        else :
            $metodo = '';
        endif;
        return '<p>' . anchor('', 'Você está em: <img src="' . base_url('assets/images/favicon.ico') . '" class="img-breadcrumb">') . ' &raquo; ' . $classe . $metodo . '</p>';
    }
}


if (!function_exists('toBd')) :

    //codifica o html para salvar no BD
    function toBd($string = NULL)
    {

        return htmlentities(preg_replace("@[\n\r]@s", "", $string));
    }

endif;

if (!function_exists('toHtml')) :

    //codifica o BD para o HTML
    function toHtml($string = NULL)
    {
        return html_entity_decode(preg_replace("@[\n\r]@s", "", $string));
    }

endif;

//verifica se exite o caminho e caso ao contrario cria o caminho
if (!function_exists('is_way')) :

    function  is_way($destination)
    {
        if (is_dir($destination)) {
            return $destination;
        } else {
            mkdir($destination, 0777, true);
            return $destination;
        }
    }

endif;

if (!function_exists('unique_name_args')) :

    function unique_name_args($name, $path)
    {
        $diretorio = dir($path);
        $i = 0;
        $nomes_pasta = array();
        while ($arquivo = $diretorio->read()) {
            $x = explode(".", $arquivo);
            $nomes_pasta[$i] = $x[0];
            $i++;
        }
        $diretorio->close();
        if (!in_array($name, $nomes_pasta)) {
            return false;
        } else {
            return true;
        }
    }

endif;