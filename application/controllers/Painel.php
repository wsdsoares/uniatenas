<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Painel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model', 'users');
        $this->load->model('inicio_model', 'inicio');
        $this->load->model('painel_model', 'painelbd');
        date_default_timezone_set('America/Sao_Paulo');
    }

    /** LOGIN DO */

    public function login()
    {
        $this->form_validation->set_rules('user', 'USUÁRIO', 'required');
        $this->form_validation->set_rules('passwd', 'SENHA', 'required');

        if ($this->form_validation->run() == false) {
            if (validation_errors()) :
                set_msg(validation_errors(), 'erro');
            endif;
        } else {

            $dados_form = $this->input->post();

            /**BUSCA DADOS DO USUÁRIO NO BANCO DE DADOS */
            $buscaUsuarioLogado = $this->users->login(array('user' => $dados_form['user'], 'password' => hash('sha256', $dados_form['passwd'])))->row();

            /** Primeira validação - verificar se os usuário que está tentando logar coincide com as informações
             * vindas do banco de dados e também com o formulário *
             */
            if (
                isset($buscaUsuarioLogado->cod_user)
                and $buscaUsuarioLogado->cod_user != false
                and $buscaUsuarioLogado->cod_user == $dados_form['user']
            ) {
                $joinCampusVinculoUsuario = array(
                    'campus' => 'campus.id = users_has_campus.campus_id ',
                    'users' => 'users.id = users_has_campus.users_id',
                );

                $colunasVinculoUsuarioCampus = array(
                    'users_has_campus.campus_id',
                    'campus.city',
                    'campus.shurtName',
                );
                $whereVinculos = array('users_has_campus.users_id' => $buscaUsuarioLogado->id);

                /** Verifica se o usuário, que foi encontrado no banco de dados está vinculado no mínimo a um campus **/
                $verificaVinculoUsuarioCampus = $this->painelbd->where($colunasVinculoUsuarioCampus, 'users_has_campus', $joinCampusVinculoUsuario, $whereVinculos, null, null, null)->result();

                if ($verificaVinculoUsuarioCampus) {
                    $arrayAcessosCampus = array();

                    /** Criando-se um array de com os campus ao qual o usuário tem acesso **/
                    for ($i = 0; $i < count($verificaVinculoUsuarioCampus); $i++) {
                        $arrayAcessosCampus[$i] = $verificaVinculoUsuarioCampus[$i]->campus_id;
                    }

                    //busca todos as permissões do usuário no BANCO DE DADOS
                    $colunasPemissoesUsuario = array('permission.id', 'permission.titulo');
                    $joinPermissoesUsuario = array(
                        'permission' => 'permission.id = permissoes_por_usuario.permission_id',
                        'users' => 'users.id = permissoes_por_usuario.users_id',
                    );
                    $wherePermissoesUsuario = array('permissoes_por_usuario.users_id' => $buscaUsuarioLogado->id, 'users.status' => 1);
                    $arrayPermissoesUsuario = $this->painelbd->where($colunasPemissoesUsuario, 'permissoes_por_usuario', $joinPermissoesUsuario, $wherePermissoesUsuario)->result();

                    /* criando a seção do usuário**/
                    $this->session->set_userdata('logged', true);
                    $this->session->set_userdata('codusuario', $buscaUsuarioLogado->cod_user);
                    $this->session->set_userdata('name', $buscaUsuarioLogado->name);
                    $this->session->set_userdata('email', $buscaUsuarioLogado->email);
                    $this->session->set_userdata('arrayPermissoes', $arrayPermissoesUsuario);
                    $this->session->set_userdata('arrayCampusVinculadosUsuario', $verificaVinculoUsuarioCampus);

                    redirect('painel');
                } else {
                    set_msg('<br>Informações de Usuário e/ou senha não conferem. <br/> Ou seu usuário não está vinculado a nenhum campus.<br/> Entre em contato com um Admistrador!', 'erro');
                    redirect(current_url());
                }
            } else {
                set_msg('<br>Informações de Usuário e/ou senha não conferem.', 'erro');
                redirect(current_url());
            }
        }
        $data = array(
            'titulo' => 'UniAtenas',
        );
        $this->load->view('templates/layoutLogin', $data);
    }

    public function biblioteca()
    {
        //$campus = '1'; //campus Paracatu
        $page = $this->uri->segment(2);
        //$page = 'sdf';
        //$itens = $this->painelbd->getWhere('page_contents', array('title_short' => 'biblioteca'))->result();
        $sqlcontents = 'SELECT
                            pages.id as id,
                            page_contents.id as idcontent,
                            page_contents.title as titulo,
                            page_contents.description as descriptionpage,
                            campus.city as campus,
                            page_contents.data_modify as last_change
                            FROM page_contents
                            INNER JOIN pages on pages.id = page_contents.pages_id
                            INNER JOIN campus on pages.campusid = campus.id
                            where page_contents.title_short = \'biblioteca\';';

        $contents = $this->painelbd->getQuery($sqlcontents)->result_array();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/itens_paginas/biblioteca/show_sobre_biblioteca.php',
            'dados' => array(
                'page' => $page,
                'tipo' => '',
                'contents' => $contents,
            ),
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editarBiblioteca($idContent)
    {
        verificaLogin();
        $sqlcontents = 'SELECT
                            pages.id as id,
                            page_contents.id as idcontent,
                            page_contents.title as titulo,
                            page_contents.description as descriptionpage,
                            campus.city as campus,
                            page_contents.data_modify as last_change
                            FROM page_contents
                            INNER JOIN pages on pages.id = page_contents.pages_id
                            INNER JOIN campus on pages.campusid = campus.id
                            where page_contents.title_short = \'biblioteca\';';

        $contents = $this->painelbd->getQuery($sqlcontents)->result_array();

        $idsAllowed = array_column($contents, 'idcontent');
        if (!(in_array($idContent, $idsAllowed))) {
            redirect('painel/biblioteca');
        }

        //^^^^^^^^ Seleciona os id dos contents para verificar se tem permissão para editar e não ocorrer do usuario digitar qualquer id na url ^^^^^^
        $dados = $this->painelbd->getWhere('page_contents', array('id' => $idContent))->row();
        if (empty($dados)) {
            redirect('painel/index');
        }
        if ($dados->id != $idContent) {
            redirect('paineladm/itens_paginas/biblioteca/show_sobre_biblioteca.php');
        }

        $this->form_validation->set_rules('description', $dados->title, 'required');

        if ($this->form_validation->run() == false) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            //$userLogado = $this->painelbd->getWhere('profile_user', array('coduser' => $_SESSION['codusuario']))->row();
            $dados_form = elements(array('nome', 'cargo'), $this->input->post());
            $dados_form['user_id'] = $_SESSION['codusuario'];
            $dados_form['id'] = $idContent;
            $data = date('Y-m-d h:i:s');
            $dados_form['data_modify'] = $data;
            $dados_form['description'] = $data;
            if ($this->painelbd->salvar('dirigentes', $dados_form) == true) :
                setMsg('<p>Informações atualizadas com sucesso.</p>', 'success');
                redirect('painel/dirigentes');
            else :
                setMsg('<p>Erro! A publicação não foi editada.</p>', 'error');
            endif;
        }

        $data = array(
            'titulo' => 'Uniatenas - Editar Biblioteca',
            'conteudo' => 'paineladm/itens_paginas/biblioteca/editar_biblioteca',
            'dados' => array(
                'page' => 'Biblioteca',
                'info_Biblioteca' => $dados,
                'tipo' => '',
            ),
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    /*public function login()
    {
    $this->form_validation->set_rules('user', 'USUÁRIO', 'required');
    $this->form_validation->set_rules('passwd', 'SENHA', 'required');
    if ($this->form_validation->run() == FALSE):
    if (validation_errors()):
    set_msg(validation_errors(), 'erro');
    endif;
    else:
    $dados_form = $this->input->post();
    $buscaUsuarioLogado = $this->users->getWhere('usuario', array('codusuario' => $dados_form['user'], 'password' => md5($dados_form['passwd'])))->row();
    if (isset($result->codusuario) and $result->codusuario != FALSE and $result->codusuario == $dados_form['user']):
    if ($this->users->do_login($result->codusuario, $result->password) == TRUE):
    $this->session->set_userdata('logged', TRUE);
    $this->session->set_userdata('codusuario', $result->codusuario);
    $this->session->set_userdata('name', $result->nome);
    $this->session->set_userdata('email', $result->email);

    $buscaPermissao = $this->users->getPermissoes($result->codusuario)->result();
    $contador = count($buscaPermissao);
    $permissoes = array();
    $filial = array();
    $perfis = array();
    $filiais = $this->users->where('dbPermissoes', 'filialusuario', array('codusuario' => $result->codusuario))->result();

    for ($i = 0; $i < $contador; $i++) {
    $permissoes[$i] = $buscaPermissao[$i]->codpermissao;
    $perfis[$i] = $buscaPermissao[$i]->codperfil;
    }

    for ($i = 0; $i < count($filiais); $i++) {
    $filial[$i] = $filiais[$i]->codfilial;
    }

    $this->session->set_userdata('permissoes', $permissoes);
    $this->session->set_userdata('perfis', array_unique($perfis, $perfis->codperfil));
    $this->session->set_userdata('filiais', $filial);
    redirect('painel');
    else:
    set_msg('<strong>Usuário </strong>e a <strong>senha</strong> informada não coincidem!</strong>', 'erro');
    endif;

    else:

    set_msg('<img src="' . base_url('assets/images/icons/sorry.png') . '" alt=""><br>Usuário ou senha incorreta. Tente novamente!', 'erro');
    redirect(current_url());
    endif;
    endif;
    $data = array(
    'titulo' => 'UniAtenas',
    );
    $this->load->view('templates/layoutLogin', $data);
    }*/

    public function logout()
    {
        $this->session->unset_userdata(array(null));
        $this->session->sess_destroy();
        set_msg('Logoff efetuado com sucesso!', 'sucesso');
        redirect('painel/login');
    }

    public function index()
    {
        verificaLogin();
        //$usuario = $this->painelbd->getWhere('users', array('user' => $this->session->userdata('user')))->row();
        $page = $this->uri->segment(2);
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/home',
            'dados' => array(
                'page' => $page,
                'pagina_id' => '',
                'tipo' => '',
                //'usuario' => $usuario
            ),
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function dirigentes()
    {

        $listagem = $this->painelbd->getWhere('dirigentes')->result();
        $data = array(
            'titulo' => 'UniAtenas',
            // 'conteudo' => 'paineladm/itens_paginas/dirigentes/lista',
            'conteudo' => 'paineladm/instituicao/dirigentes/lista_dirigentes',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $listagem,
                'tipo' => '',
            ),
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function salvarDirigentes()
    {
        verificaLogin();
    }

    public function editarDirigentes($idDirigente)
    {
        verificaLogin();

        if (empty($idDirigente)) {
            redirect('painel/dirigentes');
        }

        $dados = $this->painelbd->getWhere('dirigentes', array('id' => $idDirigente))->row();
        if (empty($dados)) {
            redirect('painel/dirigentes');
        }

        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('cargo', 'Cargo', 'required');

        if ($this->form_validation->run() == false) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            $userLogado = $this->painelbd->getWhere('users', array('user' => $this->session->userdata('user')))->row();
            $dados_form = elements(array('nome', 'cargo'), $this->input->post());
            $dados_form['status'] = '1';
            $dados_form['users_id'] = $userLogado->id;
            $dados_form['id'] = $this->input->post('idDiritente');
            $data = date('Y-m-d h:i:s');
            $dados_form['dataModificacao'] = $data;
            if ($this->painelbd->salvar('dirigentes', $dados_form) == true) :
                setMsg('<p>Informações atualizadas com sucesso.</p>', 'success');
                redirect('painel/dirigentes');
            else :
                setMsg('<p>Erro! A publicação não foi editada.</p>', 'error');
            endif;
        }

        $data = array(
            'titulo' => 'Uniatenas - Editar Dirigentes',
            'conteudo' => 'paineladm/instituicao/dirigentes/editar',
            'dados' => array(
                'page' => 'Dirigentes',
                'dirigentes' => $dados,
                'tipo' => '',
            ),
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    /* public function inicio() {

set_tema('titulo', 'Início');
set_tema('conteudo', load_modulo('painel', 'inicio', 'painel'));
load_template();
}

public function infraestrutura() {
$title_page = $this->uri->segment(2);
$page = $this->painelbd->get_pages('', $title_page, 'pages')->row();

$pages_content = $this->painelbd->get_contents($page->id, '1')->result();
$dados['tela'] = 'infraestrutura';
$dados['modulo'] = 'pagina_painel';
$dados['diretorio_view'] = 'painel';

$dados['pages_content'] = $pages_content;
set_tema('titulo', 'Faculdade Atenas - Infraestrutura');

//PARAMETROS da Load View- DIRETORIO/AQUIVO - TELA
set_tema('conteudo', load_modulo_tela($dados));

load_template();
}
public function publicacoes() {
$title_page = $this->uri->segment(2);
$page = $this->painelbd->get_pages('', $title_page, 'pages')->row();

$pages_content = $this->painelbd->get_contents($page->id, '1')->result();
$dados['tela'] = 'publicacoes';
$dados['modulo'] = 'pagina_painel';
$dados['diretorio_view'] = 'painel';

$dados['pages_content'] = $pages_content;
set_tema('titulo', 'Faculdade Atenas - Infraestrutura');

//PARAMETROS da Load View- DIRETORIO/AQUIVO - TELA
set_tema('conteudo', load_modulo_tela($dados));

load_template();
}

public function cadastrar_itens_infraestrutura() {
$dados['tela'] = 'cadastrar_itens_infraestrutura';
$dados['modulo'] = 'pagina_painel';
$dados['diretorio_view'] = 'painel';
$dados['page'] = 'infraestrutura';
set_tema('titulo', 'Faculdade Atenas - Infraestrutura');

//PARAMETROS da Load View- DIRETORIO/AQUIVO - TELA
set_tema('conteudo', load_modulo_tela($dados));

load_template();
}

public function edit_infraestrutura() {
$id = $this->uri->segment(3);
if ($id > 0):
//id informado, continuar com a edição
if ($pages_content = $this->painelbd->get_byid($id)):
$dados['pages_content'] = $pages_content;
$dados['id'] = $pages_content->id;
else:
set_msg('<p>Conteúdo inexistente! Escolha um conteúdo para editar!</p>');
redirect('painel/infraestrutura', 'refresh');
endif;
else:
set_msg('<p>Você precisa escolher um conteúdo para editar!</p>');
redirect('painel/infraestrutura', 'refresh');
endif;

$this->form_validation->set_rules('title','TITULO','trim|required');
$this->form_validation->set_rules('title_short','TITULO BREVE','trim|required');
$this->form_validation->set_rules('description','DESCRIÇÃO','trim|required');
$this->form_validation->set_rules('order','ORDEM','trim|required');

$pages_content = $this->painelbd->get_contents($page->id, '1')->result();
$dados['tela'] = 'infraestrutura';
$dados['modulo'] = 'pagina_painel';
$dados['diretorio_view'] = 'painel';

$dados['pa  ges_content'] = $pages_content;
set_tema('titulo', 'Faculdade Atenas - Infraestrutura');

//PARAMETROS da Load View- DIRETORIO/AQUIVO - TELA
set_tema('conteudo', load_modulo_tela($dados));

load_template();
}

 */
}

/* End of file painel.php */
/* Location: ./application/controllers/painel.php */