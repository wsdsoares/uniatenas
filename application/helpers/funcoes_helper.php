<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

//carrega um módulo do sistema devolvendo a tela solicitada
function load_modulo($modulo = NULL, $tela = NULL, $diretorio = NULL) {
    $CI = & get_instance();
    if ($modulo != NULL):
        return $CI->load->view("$diretorio/$modulo", array('tela' => $tela), TRUE);
    else:
        return FALSE;
    endif;
}

//carrega um módulo do sistema devolvendo a tela solicitada
function load_modulo_tela($dados) {
    $CI = & get_instance();
    if ($dados != NULL):
        return $CI->load->view($dados['diretorio_view'].'/'.$dados['modulo'], $dados, TRUE);
    else:
        return FALSE;
    endif;
}

//seta valores ao array $tema da classe sistema
function set_tema($prop, $valor, $replace = TRUE) {
    $CI = & get_instance();
    $CI->load->library('sistema');
    if ($replace):
        $CI->sistema->tema[$prop] = $valor;
    else:
        if (!isset($CI->sistema->tema[$prop]))
            $CI->sistema->tema[$prop] = '';
        $CI->sistema->tema[$prop] .= $valor;
    endif;
}

//retorna os valores do array $tema da classe sistema
function get_tema() {
    $CI = & get_instance();
    $CI->load->library('sistema');
    return $CI->sistema->tema;
}

//inicializa o painel adm carregando os recursos necessários
function init_painel() {
    $CI = & get_instance();
    $CI->load->library(array('parser', 'sistema', 'session', 'form_validation'));
    $CI->load->helper(array('form', 'url', 'array', 'text'));

    set_tema('titulo_padrao', 'Faculdade Atenas');

    //Utilização do layout padrão com cabeçalhos e rodapés
    set_tema('template', 'layout_painel');
}
//inicializa o painel adm carregando os recursos necessários
function init_site() {
    $CI = & get_instance();
    $CI->load->library(array('parser', 'sistema', 'session', 'form_validation'));
    $CI->load->helper(array('form', 'url', 'array', 'text'));

    set_tema('titulo_padrao', 'Faculdade Atenas');

    //Utilização do layout padrão com cabeçalhos e rodapés
    set_tema('template', 'layout');
}
//inicializa o painel adm carregando os recursos necessários
function init_site_sete_lagoas() {
    $CI = & get_instance();
    $CI->load->library(array('parser', 'sistema', 'session', 'form_validation'));
    $CI->load->helper(array('form', 'url', 'array', 'text'));

    set_tema('titulo_padrao', 'Faculdade Atenas');

    //Utilização do layout padrão com cabeçalhos e rodapés
    set_tema('template', 'layout_sete_lagoas');
}
//inicializa o painel adm carregando os recursos necessários
function init_painel_login() {
    $CI = & get_instance();
    $CI->load->library(array('parser', 'sistema', 'session', 'form_validation'));
    $CI->load->helper(array('form', 'url', 'array', 'text'));

    //Utilização do layout padrão com cabeçalhos e rodapés
    set_tema('template', 'layout_login');
}

function init_painel_cursos() {
    $CI = & get_instance();
    $CI->load->library(array('parser', 'sistema', 'session', 'form_validation'));
    $CI->load->helper(array('form', 'url', 'array', 'text'));

    set_tema('titulo_padrao', 'Faculdade Atenas');

    //Utilização do layout padrão com cabeçalhos e rodapés
    set_tema('template', 'layout_cursos');
}


function init_painel_adm() {
    $CI = & get_instance();
    $CI->load->library(array('parser', 'sistema', 'session', 'form_validation'));
    $CI->load->helper(array('form', 'url', 'array', 'text'));

    set_tema('titulo_padrao', 'Prontuário - Controle - Faculdade Atenas');

    //Utilização do layout padrão com cabeçalhos e rodapés
    set_tema('template', 'layout_painel');
}




//inicializa o tinymce para criação de textarea com editor html
function init_htmleditor() {
    set_tema('headerinc', load_js(base_url('htmleditor/jquery.tinymce.js'), NULL, TRUE), FALSE);
    set_tema('headerinc', incluir_arquivo('htmleditor', 'includes', FALSE), FALSE);
}

//retorna ou printa o conteúdo de uma view
function incluir_arquivo($view, $pasta = 'includes', $echo = TRUE) {
    $CI = & get_instance();
    if ($echo == TRUE):
        echo $CI->load->view("$pasta/$view", '', TRUE);
        return TRUE;
    endif;
    return $CI->load->view("$pasta/$view", '', TRUE);
}

//carrega um template passando o array $tema como parâmetro
function load_template() {
    $CI = & get_instance();
    $CI->load->library('sistema');
    $CI->parser->parse($CI->sistema->tema['template'], get_tema());
}

//carrega um ou vários arquivos .css de uma pasta
function load_css($arquivo = NULL, $pasta = 'css', $media = 'all') {
    if ($arquivo != NULL):
        $CI = & get_instance();
        $CI->load->helper('url');
        $retorno = '';
        if (is_array($arquivo)):
            foreach ($arquivo as $css):
                $retorno .= '<link rel="stylesheet" type="text/css" href="' . base_url("$pasta/$css.css") . '" media="' . $media . '" />';
            endforeach;
        else:
            $retorno .= '<link rel="stylesheet" type="text/css" href="' . base_url("$pasta/$arquivo.css") . '" media="' . $media . '" />';
        endif;
    endif;
    return $retorno;
}

//carrega um ou vários arquivos .js de uma pasta ou servidor remoto
function load_js($arquivo = NULL, $pasta = 'js', $remoto = FALSE) {
    if ($arquivo != NULL):
        $CI = & get_instance();
        $CI->load->helper('url');
        $retorno = '';
        if (is_array($arquivo)):
            foreach ($arquivo as $js):
                if ($remoto):
                    $retorno .= '<script type="text/javascript" src="' . $js . '"></script>';
                else:
                    $retorno .= '<script type="text/javascript" src="' . base_url("$pasta/$js.js") . '"></script>';
                endif;
            endforeach;
        else:
            if ($remoto):
                $retorno .= '<script type="text/javascript" src="' . $arquivo . '"></script>';
            else:
                $retorno .= '<script type="text/javascript" src="' . base_url("$pasta/$arquivo.js") . '"></script>';
            endif;
        endif;
    endif;
    return $retorno;
}

//mostra erros de validação em forms
function erros_validacao() {
    if (validation_errors()):
        echo '<div class="alert alert-danger alert-dismissible ">' . validation_errors('<a class="text-danger">', '</a>') . '</div>';
    endif;
}

if (!function_exists('verifica_login')):
    function verifica_login($redirect ='acesso/login') {
        $CI = & get_instance();
        if ($CI->session->userdata('logged') != TRUE):
            set_msg('<p>Acesso Restrito! Faça login para continuar.</p>','erro');
            redirect($redirect, 'refresh');
        endif;
    }
endif;

if (!function_exists('to_bd')):

    //codifica o html para salvar no BD
    function to_bd($tring = NULL) {
        return htmlentities($string);
    }

endif;

if (!function_exists('to_html')):

    //codifica o BD para o HTML
    function to_html($tring = NULL) {
        return html_entity_decode($string);
    }

endif;


if (!function_exists('config_upload')):
    //define as configurações para upload de imagens/
    //gif|jpg|png|pdf|doc|txt|docx|doc|xls|xlsx
    function config_upload($path='',$types='jpg|png|jpeg|svg',$size=100000000000){
        $config['upload_path'] = './'.$path.'/';
        $config['allowed_types'] = $types;
        $config['max_size'] = $size;
        return $config;
    }
endif;

if (!function_exists('set_msg')):

    function set_msg($msg = NULL, $tipo = NULL) {
        $CI = & get_instance();
        switch ($tipo):
            case 'erro':
                $CI->session->set_userdata('aviso', '
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <p>' . $msg . '</p>' .
                        '</div>');
                break;
            case 'sucesso':
                $CI->session->set_userdata('aviso', '<div class="alert alert-success">' .
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
if (!function_exists('get_msg')):

    function get_msg($destroy = TRUE) {
        $CI = & get_instance();
        $retorno = $CI->session->userdata('aviso');
        if ($destroy)
            $CI->session->unset_userdata('aviso');
        return $retorno;
    }

endif;

//verifica se o usuário atual é administrador
function is_admin($set_msg = FALSE) {
    $CI = & get_instance();
    $user_admin = $CI->session->userdata('user_perfil');
    if (!isset($user_admin) || $user_admin != TRUE):
        if ($set_msg)
            set_msg('msgerro', '<div class="alert alert-danger"><strong>Seu usuário não tem permissão para executar esta operação</strong>.</div>', 'sucesso');
        return FALSE;
    else:
        return TRUE;
    endif;
}



//seta um registro na tabela de auditoria
function auditoria($operacao, $obs = '', $query = TRUE) {
    $CI = & get_instance();
    $CI->load->library('session');
    $CI->load->model('auditoria_model', 'auditoria');
    if ($query):
        $last_query = $CI->db->last_query();
    else:
        $last_query = '';
    endif;
    if (esta_logado(FALSE)):
        $user_id = $CI->session->userdata('user_codusuario');
        $user_login = $CI->usuarios->get_byid($user_id)->row()->login;
    else:
        $user_login = 'Desconhecido';
    endif;
    $dados = array(
        'codusuario' => $user_login,
        'operacao' => $operacao,
        'query' => $last_query,
        'observacao' => $obs,
    );
    $CI->auditoria->do_insert($dados);
}

//gera uma miniatura de uma imagem caso ela ainda não exista
function thumb($imagem = NULL, $largura = 100, $altura = 75, $geratag = TRUE) {
    $CI = & get_instance();
    $CI->load->helper('file');
    $thumb = $largura . 'x' . $altura . '_' . $imagem;

    //echo $imagem;

    /* $thumbinfo = get_file_info('./assets/uploads/thumbs/'.$thumb);
      if ($thumbinfo!=FALSE):
      $retorno = base_url('assets/uploads/thumbs/'.$thumb);
      else:
      $CI->load->library('image_lib');
      $config['image_library'] = 'gd2';
      $config['source_image'] = './assets/uploads/'.$imagem;
      $config['new_image'] = './assets/uploads/thumbs/'.$thumb;
      $config['maintain_ratio'] = TRUE;
      $config['width'] = $largura;
      $config['height'] = $altura;
      $CI->image_lib->initialize($config);
      if ($CI->image_lib->resize()):
      $CI->image_lib->clear();
      $retorno = base_url('assets/uploads/thumbs/'.$thumb);
      else:
      $retorno = FALSE;
      endif;
      endif; */
    $retorno = FALSE;
    if ($geratag && $retorno != FALSE)
        $retorno = '<img src="' . $retorno . '" alt="" />';
    //return $retorno;
    return 'ALGO - ' . $imagem;
}

//gera um slug basedo no título
function slug($string = NULL) {
    $string = remove_acentos($string);
    return url_title($string, '-', TRUE);
}

//remove acentos e caracteres especiais de uma string
function remove_acentos($string = NULL) {
    $procurar = array('À', 'Á', 'Ã', 'Â', 'É', 'Ê', 'Í', 'Ó', 'Õ', 'Ô', 'Ú', 'Ü', 'Ç', 'à', 'á', 'ã', 'â', 'é', 'ê', 'í', 'ó', 'õ', 'ô', 'ú', 'ü', 'ç');
    $substituir = array('A', 'A', 'A', 'A', 'E', 'E', 'I', 'O', 'O', 'O', 'U', 'U', 'C', 'a', 'a', 'a', 'a', 'e', 'e', 'i', 'o', 'o', 'o', 'u', 'u', 'c');
    return str_replace($procurar, $substituir, $string);
}

//gera o resumo de uma string
function resumo_post($string = NULL, $palavras = 50, $decodifica_html = TRUE, $remove_tags = TRUE) {
    if ($string != NULL):
        if ($decodifica_html)
            $string = to_html($string);
        if ($remove_tags)
            $string = strip_tags($string);
        $retorno = word_limiter($string, $palavras);
    else:
        $retorno = FALSE;
    endif;
    return $retorno;
}

//converter dados do bd para html válido
function to_html($string = NULL) {
    return html_entity_decode($string);
}

//salva ou atualiza uma config no bd
function set_setting($nome, $valor = '') {
    $CI = & get_instance();
    $CI->load->model('settings_model', 'settings');
    if ($CI->settings->get_bynome($nome)->num_rows() == 1):
        if (trim($valor) == ''):
            $CI->settings->do_delete(array('nome_config' => $nome), FALSE);
        else:
            $dados = array(
                'nome_config' => $nome,
                'valor_config' => $valor
            );
            $CI->settings->do_update($dados, array('nome_config' => $nome), FALSE);
        endif;
    else:
        $dados = array(
            'nome_config' => $nome,
            'valor_config' => $valor
        );
        $CI->settings->do_insert($dados, FALSE);
    endif;
}

//retorna uma config do bd
function get_setting($nome) {
    $CI = & get_instance();
    $CI->load->model('settings_model', 'settings');
    $setting = $CI->settings->get_bynome($nome);
    if ($setting->num_rows() == 1):
        $setting = $setting->row();
        return $setting->valor_config;
    else:
        return NULL;
    endif;
}

function verificarLink($url, $limite = 25) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);        // Inicia uma nova sessão do cURL
    curl_setopt($curl, CURLOPT_TIMEOUT, $limite); // Define um tempo limite da requisição
    curl_setopt($curl, CURLOPT_NOBODY, true);     // Define que iremos realizar uma requisição "HEAD"
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, false); // Não exibir a saída no navegador
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Não verificar o certificado do site

    curl_exec($curl);  // Executa a sessão do cURL
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200; // Se a resposta for OK, a URL está ativa
    curl_close($curl); // Fecha a sessão do cURL

    return $status;
}

if (!function_exists('verifica_login')):
    function verifica_login($redirect ='acesso/login') {
        $CI = & get_instance();
        if ($CI->session->userdata('logged') != TRUE):
            set_msg('<p>Acesso Restrito! Faça login para continuar.</p>','erro');
            redirect($redirect, 'refresh');
        endif;
    }
endif;

