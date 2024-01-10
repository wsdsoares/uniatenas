<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Painel_portal_alunos extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('acesso_model', 'acesso');
    $this->load->model('inicio_model', 'inicio');
    $this->load->model('painel_model', 'painelbd');
    $this->load->model('Cpainel_model', 'bd');
    date_default_timezone_set('America/Sao_Paulo');
    verificaLogin();
  }

  public function lista_campus_portal_alunos()
  {
    verificaLogin();

    $colunasResultadoCursos =
      array(
        'campus.id',
        'campus.name',
        'campus.city',
        'campus.uf'
      );

    $listagemDosCampus = $this->painelbd->where('*', 'campus', NULL, array('visible' => 'SIM'))->result();
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/portalalunos/lista_campus_portal_alunos',
      'dados' => array(
        'page' => "Lista informações Portais (Aluno/Professor) ",
        'campus' => $listagemDosCampus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_informacoes_portal_alunos($uriCampus = NULL)
  {
    verificaLogin();

    $pagina = 'portalalunos';
    $verificaExistePaginaPortalAlunos = $this->painelbd->where('*', 'pages', null, array('pages.campusid' => $uriCampus, 'pages.title' => $pagina))->row();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/portalalunos/lista_informacoes_portal_alunos',
      'dados' => array(
        'conteudosPagina' => '',
        'page' => "Cadastro de informações da Portal Alunos - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'paginaPortalAlunos' => $verificaExistePaginaPortalAlunos = isset($verificaExistePaginaPortalAlunos) ? $verificaExistePaginaPortalAlunos : '',
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_itens_portal_alunos($uriCampus = NULL, $pageId = null)
  {
    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();


    $queryItensSecretaria = "
    SELECT 
    page_contents.id,
    page_contents.title,
    page_contents.title_short,
    page_contents.status,
    page_contents.tipo,
    page_contents.order,
    page_contents.description,
    page_contents.link_redir,
    page_contents.created_at,
    page_contents.updated_at,
    page_contents.user_id
    FROM
        page_contents
        JOIN pages ON pages.id = page_contents.pages_id
        JOIN campus ON campus.id = pages.campusid
    WHERE
        page_contents.pages_id = $pagina->id AND 
        page_contents.tipo = 'informacoesPagina' AND
        page_contents.order NOT IN ('linkComutacao','comutacao')
    ORDER BY page_contents.title ASC
    ";

    $listaItensPaginaPortalAlunos = $this->painelbd->getQuery($queryItensSecretaria)->result();

    $data = array(
      'titulo' => 'Portal Alunos - Uniatenas',
      'conteudo' => 'paineladm/portalalunos/itens/lista_itens_portal_alunos',
      'dados' => array(
        'page' => "Informações da página PORTAL ALUNOS- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina' => $pagina,
        'listaItensPaginaPortalAlunos' => $listaItensPaginaPortalAlunos = isset($listaItensPaginaPortalAlunos) ? $listaItensPaginaPortalAlunos : '',
        'campus' => $campus,
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_itens_portal_alunos($uriCampus = NULL, $pageId = NULL)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadoPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadoPagina, 'pages', $joinPagina, $wherePagina)->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    $this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $path = "assets/images/portalalunos/$campus->id";
      is_way($path);

      $name_tmp = noAccentuation($this->input->post('title'));

      $upload = $this->painelbd->uploadFiles('capa', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', $name_tmp);

      $dados_form['capa'] = $path . '/' . $upload['file_name'];
      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['order'] = $this->input->post('order');
      $dados_form['tipo'] = 'informacoesPagina';
      $dados_form['pages_id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
        redirect(base_url("Painel_portal_alunos/lista_itens_portal_alunos/$campus->id/$pagina->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/portalalunos/itens/cadastrar_itens_portal_alunos',
      'dados' => array(
        'page' => "Cadastro de Links de Portais -  PORTAL ALUNOS- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'pagina' => $pagina,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_itens_portal_alunos($uriCampus = NULL, $pageId = null, $idInformacao = null)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadoPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadoPagina, 'pages', $joinPagina, $wherePagina)->row();

    $informacoesSecretaria = $this->painelbd->where("*", 'page_contents', null, array('page_contents.id' => $idInformacao))->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    //$this->form_validation->set_rules('title_short', 'Subtítulo', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    //$this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {
      if ($informacoesSecretaria->description !== $this->input->post('description')) {
        $dados_form['description'] = $this->input->post('description');
      }
      if ($informacoesSecretaria->title_short !== $this->input->post('title_short') and !empty($this->input->post('title_short'))) {
        $dados_form['title_short'] = $this->input->post('title_short');
      }
      if ($informacoesSecretaria->title !== $this->input->post('title') and !empty($this->input->post('title'))) {
        $dados_form['title'] = $this->input->post('title');
      }
      if ($informacoesSecretaria->status !== $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }

      if ($informacoesSecretaria->order !== $this->input->post('order')) {
        $dados_form['order'] = $this->input->post('order');
      }

      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['id'] = $informacoesSecretaria->id;
      $dados_form['updated_at'] = date('Y-m-d H:i:s');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Dados editados com sucesso.</p>', 'success');
        redirect(base_url("Painel_portal_alunos/lista_itens_portal_alunos/$campus->id/$pagina->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/portalalunos/itens/editar_itens_portal_alunos',
      'dados' => array(
        'informacoesSecretaria' => $informacoesSecretaria,
        'page' => "Edição de informações SECRETARIA ACADÊMICA- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'pagina' => $pagina,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_portal_alunos($uriCampus = NULL, $pagina = null, $id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*', 'page_contents', NULL, array('page_contents.id' => $id))->row();

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_portal_alunos/lista_itens_portal_alunos/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_portal_alunos/lista_itens_portal_alunos/$uriCampus/$pagina");
    }
  }


  public function cadastrar_pagina_portal_alunos($uriCampus = NULL)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $verificaExistePagina = $this->painelbd->where('*', 'pages', null, array('pages.title' => 'portalalunos', 'pages.campusid' => $campus->id))->row();

    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['title'] = 'portalalunos';
      $dados_form['status'] = $this->input->post('status');
      $dados_form['campusid'] = $campus->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if (isset($verificaExistePagina)) {
        $dados_form['id'] = $verificaExistePagina->id;
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (menu) Portal dos Alunos atualizados com sucesso.</p>', 'success');
          redirect(base_url("Painel_portal_alunos/cadastrar_pagina_portal_alunos/$campus->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      } else {
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (menu) Portal dos Alunos cadastrados com sucesso.</p>', 'success');
          redirect(base_url("Painel_portal_alunos/cadastrar_pagina_portal_alunos/$campus->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/portalalunos/pagina_menu_portal_alunos/cadastrar_pagina_portal_alunos',
      'dados' => array(
        'paginaPortalAlunos' => $verificaExistePagina = isset($verificaExistePagina) ? $verificaExistePagina : '',
        'page' => "Cadastro/Edição de pagina (menu do site) do Portal Alunos - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }



  /** Gerenciamento de links uteis */
  public function lista_links_uteis_portal_alunos($uriCampus = NULL, $pageId = null)
  {
    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadoPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadoPagina, 'pages', $joinPagina, $wherePagina)->row();

    $colunaResultadoLinksUteisPaginaPortalAlunos = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description',
      'page_contents.link_redir',
      'page_contents.created_at',
      'page_contents.updated_at',
      'page_contents.user_id',
    );
    $joinConteudoLinksUteisPaginaPortalAlunos = array(
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereLinksUteisPaginaPortalAlunos = array(
      'page_contents.pages_id' => $pagina->id,
      'page_contents.order' => 'linksUteis'
    );

    $listaLinksUteisPaginaPortalAlunos = $this->painelbd->where($colunaResultadoLinksUteisPaginaPortalAlunos, 'page_contents', $joinConteudoLinksUteisPaginaPortalAlunos, $whereLinksUteisPaginaPortalAlunos, array('campo' => 'title', 'ordem' => 'asc'))->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/portalalunos/links_uteis/lista_links_uteis_portal_alunos',
      'dados' => array(
        'page' => "Lista <u>Links Úteis</u> página Portal Alunos - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina' => $pagina,
        'listaLinksUteisPaginaPortalAlunos' => $listaLinksUteisPaginaPortalAlunos = isset($listaLinksUteisPaginaPortalAlunos) ? $listaLinksUteisPaginaPortalAlunos : '',
        'campus' => $campus,
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_links_uteis_portal_alunos($uriCampus = NULL, $pageId = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $this->form_validation->set_rules('link_redir', 'Por favor, insira o LINK ', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    $this->form_validation->set_rules('tipo', 'Tipo Link', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['tipo'] = $this->input->post('tipo');
      $dados_form['link_redir'] = $this->input->post('link_redir');
      $dados_form['order'] = 'linksUteis';
      $dados_form['pages_id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Link Útil cadastrado com sucesso.</p>', 'success');
        redirect(base_url("Painel_portal_alunos/lista_links_uteis_portal_alunos/$campus->id/$pagina->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/portalalunos/links_uteis/cadastrar_links_uteis_portal_alunos',
      'dados' => array(
        'page' => "Cadastro de Link Útil: Portal Alunos - <strong><i> $campus->name ($campus->city) </i></strong>",
        'pagina' => $pagina,
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_links_uteis_portal_alunos($uriCampus = NULL, $pageId = null, $idLink = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $colunaResultadoLinksUteisPaginaPortalAlunos = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.tipo',
      'page_contents.status',
      'page_contents.link_redir',
      'page_contents.order',
      'page_contents.created_at',
      'page_contents.updated_at',
      'page_contents.user_id',
    );
    $joinConteudoLinksUteisPaginaPortalAlunos = array(
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereLinksUteisPaginaPortalAlunos = array(
      'page_contents.pages_id' => $pagina->id,
      'page_contents.id' => $idLink,
      'page_contents.order' => 'linksUteis'
    );

    $listaLinksUteisPaginaPortalAlunos = $this->painelbd->where($colunaResultadoLinksUteisPaginaPortalAlunos, 'page_contents', $joinConteudoLinksUteisPaginaPortalAlunos, $whereLinksUteisPaginaPortalAlunos)->row();

    $this->form_validation->set_rules('link_redir', 'Por favor, insira o LINK ', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      if ($listaLinksUteisPaginaPortalAlunos->title !== $this->input->post('title')) {
        $dados_form['title'] = $this->input->post('title');
      }
      if ($listaLinksUteisPaginaPortalAlunos->status !== $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }
      if ($listaLinksUteisPaginaPortalAlunos->tipo !== $this->input->post('tipo')) {
        $dados_form['tipo'] = $this->input->post('tipo');
      }
      if ($listaLinksUteisPaginaPortalAlunos->link_redir !== $this->input->post('link_redir')) {
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }
      $dados_form['id'] = $listaLinksUteisPaginaPortalAlunos->id;
      $dados_form['order'] = 'linksUteis';
      $dados_form['updated_at'] = date('Y-m-d H:i:s');

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Link Útil atualizado com sucesso.</p>', 'success');
        redirect(base_url("Painel_portal_alunos/lista_links_uteis_portal_alunos/$campus->id/$pagina->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/portalalunos/links_uteis/editar_links_uteis_portal_alunos',
      'dados' => array(
        'tituloPagina' => "Edição de Link Útil: Portal Alunos - <strong><i> $campus->name ($campus->city) </i></strong>",
        'pagina' => $pagina,
        'listaLinksUteisPaginaPortalAlunos' => $listaLinksUteisPaginaPortalAlunos,
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_links_uteis_portal_alunos($uriCampus = NULL, $pagina = null, $id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*', 'page_contents', NULL, array('page_contents.id' => $id))->row();

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_portal_alunos/lista_links_uteis_portal_alunos/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_portal_alunos/lista_links_uteis_portal_alunos/$uriCampus/$pagina");
    }
  }
}
