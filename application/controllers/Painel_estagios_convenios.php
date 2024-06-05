<?php

if (!defined("BASEPATH"))
  exit("No direct script access allowed");

class Painel_estagios_convenios extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('painel_model', 'painelbd');
    date_default_timezone_set('America/Sao_Paulo');
  }

  public function lista_campus_estagios_convenios()
  {
    verificaLogin();

    $colunasCampus =
      array(
        'campus.id',
        'campus.name',
        'campus.city',
        'campus.uf'
      );

    $listagemDosCampus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('visible' => 'SIM'))->result();
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/servicos/estagios_convenios/lista_campus_estagios_convenios',
      'dados' => array(
        'page' => "Estágios e Convênios",
        'campus' => $listagemDosCampus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_informacoes_estagios_convenios($uriCampus = NULL)
  {
    verificaLogin();

    $pagina = 'estagiosConvenios';
    $verificaExistePaginaEstagiosConvenios = $this->painelbd->where('*', 'pages', null, array('pages.campusid' => $uriCampus, 'pages.title' => $pagina))->row();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $listaInformmacoesPaginasEstagiosConvenios =  $this->painelbd->getQuery(
      "SELECT 
          page_contents.id,
          page_contents.title,
          page_contents.img_destaque,
          page_contents.status,
          page_contents.title_short,
          page_contents.description, 
          page_contents.order, 
          page_contents.created_at, 
          page_contents.updated_at, 
          page_contents.user_id, 
          campus.city
        FROM 
          page_contents
        INNER JOIN pages ON pages.id = page_contents.pages_id
        INNER JOIN campus ON campus.id= pages.campusid
        WHERE 
            pages.title = '$pagina'AND 
            pages.campusid = $campus->id AND 
            page_contents.order <>'contatos' AND 
            page_contents.status=1 
        ORDER BY page_contents.order ASC"
    )->result();

    $colunaResultadoContatoPagina = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description',
      'page_contents.order',
      'page_contents.created_at',
      'page_contents.updated_at',
      'page_contents.user_id',
      'campus.city'
    );
    $whereContatosPagina = array('pages.title' => $pagina, 'pages.campusid' => $campus->id, 'page_contents.order' => 'contatos');
    $joinContatoPagina = array(
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $contatosPaginaEstagiosConvenios = $this->painelbd->where($colunaResultadoContatoPagina, 'page_contents', $joinContatoPagina, $whereContatosPagina, null)->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/servicos/estagios_convenios/lista_informacoes_estagios_convenios',
      'dados' => array(
        'conteudosPagina' => $listaInformmacoesPaginasEstagiosConvenios,
        'contatosPaginaEstagiosConvenios' => $contatosPaginaEstagiosConvenios,
        'page' => "Informações - Estágios e Convênios - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'paginaEstagiosConvenios' => $verificaExistePaginaEstagiosConvenios = isset($verificaExistePaginaEstagiosConvenios) ? $verificaExistePaginaEstagiosConvenios : '',
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_itens_estagios_convenios($uriCampus = NULL, $pagina = NULL)
  {
    verificaLogin();
    $verificaExistePaginaEstagiosConvenios = $this->painelbd->where('*', 'pages', null, array('pages.campusid' => $uriCampus, 'pages.id' => $pagina))->row();
    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');

    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $listaInformmacoesPaginasEstagiosConvenios =  $this->painelbd->getQuery(
      "SELECT 
          page_contents.id,
          page_contents.title,
          page_contents.status,
          page_contents.title_short,
          page_contents.description, 
          page_contents.order, 
          page_contents.created_at, 
          page_contents.updated_at, 
          page_contents.user_id, 
          campus.city
        FROM 
          page_contents
        INNER JOIN pages ON pages.id = page_contents.pages_id
        INNER JOIN campus ON campus.id= pages.campusid
        WHERE 
            pages.id = '$pagina'AND 
            pages.campusid = $campus->id AND 
            page_contents.order <>'contatos' AND 
            page_contents.status=1 
        ORDER BY page_contents.order ASC"
    )->result();

    $colunaResultadoContatoPagina = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description',
      'page_contents.order',
      'page_contents.created_at',
      'page_contents.updated_at',
      'page_contents.user_id',
      'campus.city'
    );
    $whereContatosPagina = array('pages.title' => $pagina, 'pages.campusid' => $campus->id, 'page_contents.order' => 'contatos');
    $joinContatoPagina = array(
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $contatosPaginaEstagiosConvenios = $this->painelbd->where($colunaResultadoContatoPagina, 'page_contents', $joinContatoPagina, $whereContatosPagina)->result();

    $data = array(
      'titulo' => 'Estágios e Convênios - ITENS',
      'conteudo' => 'paineladm/servicos/estagios_convenios/informacoes/lista_itens_estagios_convenios',
      'dados' => array(
        'conteudosPagina' => $listaInformmacoesPaginasEstagiosConvenios,
        'contatosPaginaEstagiosConvenios' => $contatosPaginaEstagiosConvenios,
        'page' => "Informações - Estágios e Convênios - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'paginaEstagiosConvenios' => $verificaExistePaginaEstagiosConvenios = isset($verificaExistePaginaEstagiosConvenios) ? $verificaExistePaginaEstagiosConvenios : '',
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_contato_pagina_estagios_convenios($uriCampus = NULL, $pageId = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status',);
    $joinPagina = array('campus' => 'campus.id= pages.campusid');
    $wherePagina = array('pages.id' => $pageId,);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $colunaResultadContatoPaginaEstagiosConvenios = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description',
      'page_contents.order',
      'page_contents.created_at',
      'page_contents.updated_at',
      'page_contents.user_id',
    );
    $joinConteudoContatoPaginaEstagiosConvenios = array(
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereContatoPaginaEstagiosConvenios = array(
      'page_contents.pages_id' => $pagina->id,
      'page_contents.order' => 'contatos'
    );

    $contatoPaginaEstagiosConvenios = $this->painelbd->where($colunaResultadContatoPaginaEstagiosConvenios, 'page_contents', $joinConteudoContatoPaginaEstagiosConvenios, $whereContatoPaginaEstagiosConvenios)->row();

    $this->form_validation->set_rules('description', 'Informações de contato', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['title'] = "Contatos " . $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['description'] = $this->input->post('description');
      $dados_form['order'] = 'contatos';
      $dados_form['pages_id'] = $pagina->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if (isset($contatoPaginaEstagiosConvenios)) {
        $dados_form['id'] = $contatoPaginaEstagiosConvenios->id;
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (menu) estágios e convênios atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_estagios_convenios/cadastrar_contato_pagina_estagios_convenios/$campus->id/$pagina->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      } else {
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
          setMsg('<p>Dados de contato cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_estagios_convenios/cadastrar_contato_pagina_estagios_convenios/$campus->id/$pagina->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/servicos/estagios_convenios/contatos/cadastrar_contato_pagina_estagios_convenios',
      'dados' => array(
        'tituloPagina' => "Informações de contato página Estágios e Convênios - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina' => $pagina,
        'contatoPaginaEstagiosConvenios' => $contatoPaginaEstagiosConvenios = isset($contatoPaginaEstagiosConvenios) ? $contatoPaginaEstagiosConvenios : '',
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_pagina_estagios_convenios($uriCampus = NULL)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $verificaExistePagina = $this->painelbd->where('*', 'pages', null, array('pages.title' => 'estagiosConvenios', 'pages.campusid' => $campus->id))->row();

    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['title'] = 'estagiosConvenios';
      $dados_form['status'] = $this->input->post('status');
      $dados_form['campusid'] = $campus->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if (isset($verificaExistePagina)) {
        $dados_form['id'] = $verificaExistePagina->id;
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (menu) estágios e convênios atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_estagios_convenios/cadastrar_pagina_estagios_convenios/$campus->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      } else {
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (menu) estágios e convênios cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_estagios_convenios/cadastrar_pagina_estagios_convenios/$campus->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/servicos/estagios_convenios/pagina_menu_estagios_convenios/cadastrar_pagina_estagios_convenios',
      'dados' => array(
        'paginaEstagiosConvenios' => $verificaExistePagina = isset($verificaExistePagina) ? $verificaExistePagina : '',
        'page' => "Cadastro de pagina (menu do site) do Estágios e Convênios - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_itens_estagios_convenios($uriCampus = NULL)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $pagina = 'estagiosConvenios';
    $wherePagina = array('pages.title' => $pagina, 'pages.campusid' => $campus->id);

    $colunasTabelaPages = array('pages.id', 'pages.title');
    $joinConteudoPagina = array('campus' => 'campus.id= pages.campusid');

    $listaItemPages = $this->painelbd->where($colunasTabelaPages, 'pages', $joinConteudoPagina, $wherePagina, null)->row();

    if (!isset($listaItemPages)) {
      redirect(base_url("Painel_estagios_convenios/lista_informacoes_estagios_convenios/$campus->id"));
    }

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    $this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['description'] = $this->input->post('description');
      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['order'] = $this->input->post('order');
      $dados_form['pages_id'] = $listaItemPages->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Dados do financeiro cadastrado com sucesso.</p>', 'success');
        redirect(base_url("Painel_estagios_convenios/lista_itens_estagios_convenios/$campus->id/$listaItemPages->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas - Estágios e Convênios Cadastro',
      'conteudo' => 'paineladm/servicos/estagios_convenios/informacoes/cadastrar_itens_estagios_convenios',
      'dados' => array(
        'conteudosPagina' => '',
        'page' => "Cadastro de informações - Estágios e Convênios - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_informacoes_estagios_convenios($uriCampus = NULL, $paginaId = NULL, $itemId = NULL)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $wherePagina = array('pages.id' => $paginaId, 'pages.campusid' => $campus->id);
    $colunasTabelaPages = array('pages.id', 'pages.title');
    $joinConteudoPagina = array('campus' => 'campus.id = pages.campusid');

    $listaItemPages = $this->painelbd->where($colunasTabelaPages, 'pages', $joinConteudoPagina, $wherePagina, null)->row();

    if (!isset($listaItemPages)) {
      redirect(base_url("Painel_estagios_convenios/lista_informacoes_estagios_convenios/$campus->id"));
    }

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    $this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['description'] = $this->input->post('description');
      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['order'] = $this->input->post('order');
      $dados_form['pages_id'] = $listaItemPages->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Dados do financeiro cadastrado com sucesso.</p>', 'success');
        redirect(base_url("Painel_estagios_convenios/lista_itens_estagios_convenios/$campus->id/$listaItemPages->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas - Estágios e Convênios Cadastro',
      'conteudo' => 'paineladm/servicos/estagios_convenios/informacoes/cadastrar_itens_estagios_convenios',
      'dados' => array(
        'conteudosPagina' => '',
        'page' => "Cadastro de informações - Estágios e Convênios - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_informacoes_estagios_convenios_2($uriCampus = NULL, $itemId = null)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $pagina = 'financeiro';
    //$wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

    $colunasTabelaPagesFinanceiro = array('page_contents.id', 'page_contents.title', 'page_contents.description', 'page_contents.order', 'page_contents.img_destaque', 'page_contents.link_redir', 'page_contents.status');
    $joinConteudoPagina = array('pages' => 'pages.id = page_contents.pages_id');
    $wherePaginaEstagiosConvenios = array('page_contents.id' => $itemId);

    $paginaEstagiosConvenios = $this->painelbd->where($colunasTabelaPagesFinanceiro, 'page_contents', $joinConteudoPagina, $wherePaginaEstagiosConvenios, null)->row();

    $this->form_validation->set_rules('title', 'Titulo', 'required');

    $this->form_validation->set_rules('status', 'Situação', 'required');
    $this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      if ($paginaEstagiosConvenios->description != $this->input->post('description')) {
        $dados_form['description'] = $this->input->post('description');
      }

      if ($paginaEstagiosConvenios->link_redir != $this->input->post('link_redir')) {
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }

      if ($paginaEstagiosConvenios->title != $this->input->post('title')) {
        $dados_form['title'] = $this->input->post('title');
      }

      if ($paginaEstagiosConvenios->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }
      if ($paginaEstagiosConvenios->order != $this->input->post('order')) {
        $dados_form['order'] = $this->input->post('order');
      }


      if (isset($_FILES['img_destaque']) && !empty($_FILES['img_destaque']['name'])) {

        if (file_exists($paginaEstagiosConvenios->img_destaque)) {
          unlink($paginaEstagiosConvenios->img_destaque);
        }

        $path = "assets/images/financing/$campus->id";
        is_way($path);

        $upload = $this->painelbd->uploadFiles('img_destaque', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

        $dados_form['img_destaque'] = $path . '/' . $upload['file_name'];
      }

      $dados_form['id'] = $paginaEstagiosConvenios->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Dados do financeiro cadastrado com sucesso.</p>', 'success');
        redirect(base_url("Painel_estagios_convenios/lista_informacoes_estagios_convenios/$campus->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/servicos/estagios_convenios/editar_informacoes_estagios_convenios',
      'dados' => array(
        'paginaEstagiosConvenios' => $paginaEstagiosConvenios,
        'page' => "Edição de informações do Financeiro - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_estagios_convenios($uriCampus = NULL, $id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*', 'page_contents', NULL, array('page_contents.id' => $id))->row();

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_estagios_convenios/lista_informacoes_estagios_convenios/$uriCampus");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_estagios_convenios/lista_informacoes_estagios_convenios/$uriCampus");
    }
  }



  /** Parte de Documentos */
  public function lista_documentos_estagios_convenios($uriCampus = NULL, $idConteudoPagina = NULL)
  {

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $idConteudoPagina);

    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $coluntaResultadoConteudoItemEstagiosConvenios = array(
      'page_contents.title', 'page_contents.id', 'page_contents.pages_id'
    );

    $whereConteudoItemEstagiosConvenios = array('page_contents.pages_id' => $pagina->id);

    $conteudoItemEstagiosConvenios = $this->painelbd->where($coluntaResultadoConteudoItemEstagiosConvenios, 'page_contents', NULL, $whereConteudoItemEstagiosConvenios)->row();

    $colunaResultadoArquivosItensEstagiosConvenios = array(
      'page_contents_files.id',
      'page_contents_files.title',
      'page_contents_files.id_page_contents',
      'page_contents_files.status',
      'page_contents_files.files',
      'page_contents_files.order',
      'page_contents_files.created_at',
      'page_contents_files.updated_at',
      'page_contents_files.user_id',
    );

    $joinArquivosConteudosCpa = array(
      'page_contents' => 'page_contents.id = page_contents_files.id_page_contents',
    );
    $whereArquivosConteudosCpa = array('page_contents_files.id_page_contents' => $conteudoItemEstagiosConvenios->id);
    $listaArquivosConteudosCpa = $this->painelbd->where($colunaResultadoArquivosItensEstagiosConvenios, 'page_contents_files', $joinArquivosConteudosCpa, $whereArquivosConteudosCpa,)->result();

    $data = array(
      'titulo' => 'Estágios e Convênios - Documentos',
      'conteudo' => 'paineladm/servicos/estagios_convenios/documentos/lista_documentos_estagios_convenios',
      'dados' => array(
        'page' => "Lista documentos <u><i> $conteudoItemEstagiosConvenios->title </i></u> <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'listaArquivosConteudosCpa' => $listaArquivosConteudosCpa,
        'conteudoItemEstagiosConvenios' => $conteudoItemEstagiosConvenios,
        'campus' => $campus,
        'pagina' => $pagina,
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_documentos_estagios_convenios($uriCampus = NULL, $idConteudoPagina = NULL)
  {
    $this->load->helper('file');

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $coluntaResultadoConteudoItemEstagiosConvenios = array(
      'page_contents.title', 'page_contents.id', 'page_contents.pages_id'
    );
    $whereConteudoItemEstagiosConvenios = array('page_contents.id' => $idConteudoPagina);
    $conteudoItemEstagiosConvenios = $this->painelbd->where($coluntaResultadoConteudoItemEstagiosConvenios, 'page_contents', NULL, $whereConteudoItemEstagiosConvenios)->row();

    // $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    // $joinPagina = array('campus' => 'campus.id = pages.campusid');
    // $wherePagina = array('pages.id'=>$conteudoItemEstagiosConvenios->pages_id);
    // $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $this->form_validation->set_rules('title', 'Título arquivo', 'required');
    $this->form_validation->set_rules('order', 'Ordem', 'required');

    if (empty($_FILES['files']['name'])) {
      $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
      $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
    }

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) {
        setMsg(validation_errors(), 'error');
      }
    } else {
      $path = "assets/files/CPA/$campus->id";
      is_way($path);

      if (unique_name_args(noAccentuation($this->input->post('title'), NULL), $path)) {
        $name_tmp = null;
      } else {
        $name_tmp = noAccentuation($this->input->post('title'), NULL);
      }
      //$name_tmp = noAccentuation($this->input->post('title').'-'.$this->input->post('year').'-'.date('h:i:s d/m/Y'));
      $upload = $this->painelbd->uploadFiles('files', $path, $types = 'PDF|pdf', $name_tmp);

      if ($upload) {
        //upload efetuado
        $dados_form = elements(array('title', 'order', 'status'), $this->input->post());
        $dados_form['id_page_contents'] = $conteudoItemEstagiosConvenios->id;
        $dados_form['files'] = $path . '/' . $upload['file_name'];
        $dados_form['user_id'] = $this->session->userdata('codusuario');

        if ($this->painelbd->salvar('page_contents_files', $dados_form) == TRUE) {
          setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
          redirect("Painel_cpa/lista_documentos_estagios_convenios/$campus->id/$conteudoItemEstagiosConvenios->id");
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }
    $data = array(
      'titulo' => 'Arquivos CPA - Painel ADM',
      'conteudo' => 'paineladm/campus/cpa/arquivos/cadastrar_documentos_estagios_convenios',
      'dados' => array(
        'page' => "Cadastro de Arquivos CPA >> ITEM <u><i> $conteudoItemEstagiosConvenios->title</i></u> <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'conteudoItemEstagiosConvenios' => $conteudoItemEstagiosConvenios,
        'campus' => $campus,
        //'pagina'=>$pagina,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_documentos_estagios_convenios($uriCampus = NULL, $idConteudoPagina = NULL, $idArquivo = NULL)
  {
    $this->load->helper('file');

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadoArquivo = array(
      'page_contents_files.id',
      'page_contents_files.id_page_contents',
      'page_contents_files.title',
      'page_contents_files.files',
      'page_contents_files.order',
      'page_contents_files.status',
      'page_contents_files.user_id',
    );
    $joinArquivo = array(
      'page_contents' => 'page_contents.id = page_contents_files.id_page_contents',
    );
    $whereArquivo = array('page_contents_files.id' => $idArquivo);

    $arquivoCpa = $this->painelbd->where($colunaResultadoArquivo, 'page_contents_files', $joinArquivo, $whereArquivo)->row();

    $coluntaResultadoConteudoItemEstagiosConvenios = array(
      'page_contents.title', 'page_contents.id', 'page_contents.pages_id'
    );
    $whereConteudoItemEstagiosConvenios = array('page_contents.id' => $arquivoCpa->id_page_contents);
    $conteudoItemEstagiosConvenios = $this->painelbd->where($coluntaResultadoConteudoItemEstagiosConvenios, 'page_contents', NULL, $whereConteudoItemEstagiosConvenios)->row();

    // $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    // $joinPagina = array('campus' => 'campus.id = pages.campusid');
    // $wherePagina = array('pages.id'=>$conteudoItemEstagiosConvenios->pages_id);
    // $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $this->form_validation->set_rules('title', 'Título do arquivo', 'required');
    $this->form_validation->set_rules('order', 'Ordem', 'required');

    // if (empty($_FILES['files']['name'])) {
    //     $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
    //     $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
    // }

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) {
        setMsg(validation_errors(), 'error');
      }
    } else {
      if (isset($_FILES['files']) && !empty($_FILES['files']['name'])) {

        $verificaExistenciaArquivo = explode('.', $arquivoCpa->files);
        $finalArquivo =  end($verificaExistenciaArquivo);

        if ($finalArquivo === 'pdf') {
          unlink($arquivoCpa->files);
        }

        $path = "assets/files/CPA/$campus->id";
        is_way($path);

        if (unique_name_args(noAccentuation($this->input->post('title'), NULL), $path)) {
          $name_tmp = null;
        } else {
          $name_tmp = noAccentuation($this->input->post('title'), NULL);
        }

        $upload = $this->painelbd->uploadFiles('files', $path, $types = 'PDF|pdf', $name_tmp);

        if ($upload) {
          $dados_form['files'] = $path . '/' . $upload['file_name'];
        }
      }

      if ($arquivoCpa->title != $this->input->post('title')) {
        $dados_form['title'] = $this->input->post('title');
      }
      if ($arquivoCpa->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }
      if ($arquivoCpa->order != $this->input->post('order')) {
        $dados_form['order'] = $this->input->post('order');
      }

      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      $dados_form['id'] = $arquivoCpa->id;

      if ($this->painelbd->salvar('page_contents_files', $dados_form) == TRUE) {
        setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
        redirect("Painel_cpa/lista_documentos_estagios_convenios/$campus->id/$arquivoCpa->id_page_contents");
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }
    $data = array(
      'titulo' => 'Arquivos CPA - Painel ADM',
      'conteudo' => 'paineladm/campus/cpa/arquivos/editar_documentos_estagios_convenios',
      'dados' => array(
        'page' => "Edição de Arquivos CPA >> ITEM <u><i> $conteudoItemEstagiosConvenios->title</i></u> <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'conteudoItemEstagiosConvenios' => $conteudoItemEstagiosConvenios,
        'arquivoCpa' => $arquivoCpa,
        'campus' => $campus,
        //'pagina'=>$pagina,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }


  public function deletar_arquivo_cpa($uriCampus = NULL, $idConteudoItemEstagiosConvenios = NULL, $id = null)
  {

    $item = $this->painelbd->where('*', 'page_contents_files', NULL, array('page_contents_files.id' => $id))->row();

    $arquivo = $item->files;

    if ($this->painelbd->deletar('page_contents_files', $item->id)) {
      unlink($item->files);
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_cpa/lista_documentos_estagios_convenios/$uriCampus/$idConteudoItemEstagiosConvenios");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_cpa/lista_documentos_estagios_convenios/$uriCampus/$idConteudoItemEstagiosConvenios");
    }
  }
}
