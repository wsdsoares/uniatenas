<?php

if (!defined("BASEPATH"))
  exit("No direct script access allowed");

class Painel_servicos extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('painel_model', 'painelbd');
    date_default_timezone_set('America/Sao_Paulo');
  }

  public function lista_campus_servicos()
  {
    verificaLogin();
    $tipoPagina = 'SERVIÇOS >>> Itens Gerais';

    $listagemDosCampus = $this->painelbd->where('*', 'campus', NULL, array('visible' => 'SIM'))->result();
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/servicos/lista_campus_servicos',
      'dados' => array(
        'page' => "Informações Menu Serviços >> SUBMENU - Itens Gerais",
        'tipoPagina' => $tipoPagina,
        'campus' => $listagemDosCampus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_itens_servicos($uriCampus = NULL)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/servicos/lista_itens_servicos',
      'dados' => array(
        'page' => "Lista de Itens - Menu Serviços >> Campus - <b>$campus->name ($campus->city)</b>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_informacoes_servicos($uriCampus = NULL)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $listaInformmacoesPaginaServicos =  $this->painelbd->where('*', 'pages', null, array('pages.campusid' => $uriCampus, 'pages.pagina' => 'servicos'))->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/servicos/lista_informacoes_servicos',
      'dados' => array(
        'conteudosPaginaServicos' => $listaInformmacoesPaginaServicos,
        'page' => "Informações: Menu SERVIÇOS <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function registro_item_pagina($uriCampus = NULL)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $this->form_validation->set_rules('titulo_descritivo', 'Título Menu Página', 'required');
    $this->form_validation->set_rules('tipo_pagina', 'Tipo Página', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {
      $dados_form['titulo_descritivo'] = $this->input->post('titulo_descritivo');
      $dados_form['title'] = '' . lcfirst(str_replace("_", '', noAccentuation(strtolower($this->input->post('titulo_descritivo')))));
      $dados_form['tipo_pagina'] = $this->input->post('tipo_pagina');
      $dados_form['pagina'] = 'servicos';
      $dados_form['status'] = $this->input->post('status');
      $dados_form['campusid'] = $campus->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('pages', $dados_form) == TRUE) {
        setMsg('<p>Dados da página registrado com sucesso.</p>', 'success');
        redirect(base_url("Painel_servicos/lista_informacoes_servicos/$campus->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/servicos/pagina/registro_item_pagina',
      'dados' => array(
        'page' => "Cadastro de Página Serviços >> (SUBMENU) Item Geral <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_registro_item_pagina($uriCampus = NULL, $idPagina = NULL)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();
    $pagina = $this->painelbd->where('*', 'pages', NULL, array('pages.id' => $idPagina))->row();

    $this->form_validation->set_rules('titulo_descritivo', 'Título Menu Página', 'required');
    $this->form_validation->set_rules('tipo_pagina', 'Tipo Página', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {
      if ($pagina->titulo_descritivo != $this->input->post('titulo_descritivo')) {
        $dados_form['titulo_descritivo'] = $this->input->post('titulo_descritivo');
      }
      if ($pagina->tipo_pagina != $this->input->post('tipo_pagina')) {
        $dados_form['tipo_pagina'] = $this->input->post('tipo_pagina');
      }
      if ($pagina->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }

      $dados_form['pagina'] = 'servicos';
      $dados_form['campusid'] = $campus->id;
      $dados_form['id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('pages', $dados_form) == TRUE) {
        setMsg('<p>Dados da página atualizados com sucesso.</p>', 'success');
        redirect(base_url("Painel_servicos/lista_informacoes_servicos/$campus->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/servicos/pagina/editar_registro_item_pagina',
      'dados' => array(
        'page' => "Cadastro de Página Serviços >> (SUBMENU) Item Geral <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'informacoesPagina' => $pagina,
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_registro_item_pagina($uriCampus = NULL, $id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*', 'pages', NULL, array('pages.id' => $id))->row();

    if ($this->painelbd->deletar('pages', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_servicos/lista_informacoes_servicos/$uriCampus");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_servicos/lista_informacoes_servicos/$uriCampus");
    }
  }

  public function lista_itens_paginas_servicos($uriCampus = NULL)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunasItensSubmneu = array(
      'pages.id', 'pages.title', 'pages.tipo_pagina', 'pages.titulo_descritivo'
    );
    $listaItensSubmenuPaginaServicos =  $this->painelbd->where($colunasItensSubmneu, 'pages', null, array('pages.campusid' => $uriCampus, 'pages.pagina' => 'servicos'))->result();

    $data = array(
      'titulo' => 'UniAtenas - Submenu Serviços',
      'conteudo' => 'paineladm/servicos/pagina/lista_itens_paginas_servicos',
      'dados' => array(
        'itensSubmenuPaginaServicos' => $listaItensSubmenuPaginaServicos,
        'page' => "Lista dos Itens que compõe o menu Servicos -<strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }


  public function lista_item_pagina_especifica($uriCampus = NULL, $idPagina = NuLL)
  {

    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunasPagina = array(
      'pages.id', 'pages.title'
    );
    $pagina =  $this->painelbd->where($colunasPagina, 'pages', null, array('pages.id' => $idPagina))->row();

    $colunasConteudoPagina = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.img_destaque',
      'page_contents.description',
      'page_contents.order',
      'page_contents.created_at',
      'page_contents.updated_at',
      'page_contents.user_id',
      'campus.city'
    );
    $joinConteudoPagina = array(
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereConteudoPagina = array(
      'page_contents.pages_id' => $pagina->id,
      'page_contents.tipo' => 'informacoesPagina'
    );

    $conteudosPagina = $this->painelbd->where($colunasConteudoPagina, 'page_contents', $joinConteudoPagina, $whereConteudoPagina)->result();

    $data = array(
      'titulo' => 'UniAtenas - Submenu Serviços',
      'conteudo' => 'paineladm/servicos/pagina/itens_pagina/lista_item_pagina_especifica',
      'dados' => array(
        'conteudosPagina' => $conteudosPagina,
        'page' => "Lista itens específicos do Menu >> (<b>$pagina->title</b>) << -<strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'pagina' => $pagina,
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_item_pagina_especifica($uriCampus = NULL, $idPagina)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $pagina = $this->painelbd->where('*', 'pages', null, array('pages.id' => $idPagina, 'pages.campusid' => $campus->id))->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    $this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      if (isset($_FILES['img_destaque']) && !empty($_FILES['img_destaque']['name'])) {
        $path = "assets/images/servicos/$campus->id/$pagina->title";
        is_way($path);
        $upload = $this->painelbd->uploadFiles('img_destaque', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);
        $dados_form['img_destaque'] = $path . '/' . $upload['file_name'];
      }

      if (!empty($this->input->post('description')) and $this->input->post('description') != '') {
        $dados_form['description'] = $this->input->post('description');
      }
      if (!empty($this->input->post('link_redir')) and $this->input->post('link_redir') != '') {
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }
      if (!empty($this->input->post('title_short')) and $this->input->post('title_short') != '') {
        $dados_form['title_short'] = $this->input->post('title_short');
      }
      if (!empty($this->input->post('link_redir')) and $this->input->post('link_redir') != '') {
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }

      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['order'] = $this->input->post('order');
      $dados_form['tipo'] = 'informacoesPagina';
      $dados_form['pages_id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Dados da página cadastrados com sucesso.</p>', 'success');
        redirect(base_url("Painel_servicos/lista_item_pagina_especifica/$campus->id/$pagina->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas - Submenu - Serviços',
      'conteudo' => 'paineladm/servicos/pagina/itens_pagina/cadastrar_item_pagina_especifica',
      'dados' => array(
        'pagina' => $pagina = isset($pagina) ? $pagina : '',
        'page' => "Cadastro de dados da página (Menu) >> (<b>$pagina->title</b>) << -<strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_item_pagina_especifica($uriCampus = NULL, $idPagina = NULL, $itemId = null)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $pagina = $this->painelbd->where(array('pages.id', 'pages.title'), 'pages', null, array('pages.id' => $idPagina, 'pages.campusid' => $campus->id))->row();

    $colunasTabelaConteudoPagina = array('page_contents.id', 'page_contents.title', 'page_contents.title_short', 'page_contents.description', 'page_contents.order', 'page_contents.img_destaque', 'page_contents.link_redir', 'page_contents.status');
    $joinConteudoPagina = array('pages' => 'pages.id = page_contents.pages_id');

    $wherePaginaEspecifica = array('page_contents.id' => $itemId);

    $paginaEspecifica = $this->painelbd->where($colunasTabelaConteudoPagina, 'page_contents', $joinConteudoPagina, $wherePaginaEspecifica, null)->row();

    // $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    $this->form_validation->set_rules('order', 'Ordem', 'required');
    $dados_form['updated_at'] = date('Y-m-d H:i:s');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      if ($paginaEspecifica->description != $this->input->post('description')) {
        $dados_form['description'] = $this->input->post('description');
      }

      if ($paginaEspecifica->link_redir != $this->input->post('link_redir')) {
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }

      if ($paginaEspecifica->title != $this->input->post('title')) {
        $dados_form['title'] = $this->input->post('title');
      }
      if ($paginaEspecifica->title_short != $this->input->post('title_short')) {
        $dados_form['title_short'] = $this->input->post('title_short');
      }

      if ($paginaEspecifica->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }
      if ($paginaEspecifica->order != $this->input->post('order')) {
        $dados_form['order'] = $this->input->post('order');
      }

      if (isset($_FILES['img_destaque']) && !empty($_FILES['img_destaque']['name'])) {

        if (file_exists($paginaEspecifica->img_destaque)) {
          unlink($paginaEspecifica->img_destaque);
        }

        $path = "assets/images/servicos/$campus->id/$pagina->title";
        is_way($path);

        $upload = $this->painelbd->uploadFiles('img_destaque', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

        $dados_form['img_destaque'] = $path . '/' . $upload['file_name'];
      }

      $dados_form['id'] = $paginaEspecifica->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Dados do napp cadastrado com sucesso.</p>', 'success');
        redirect(base_url("Painel_servicos/lista_item_pagina_especifica/$campus->id/$pagina->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas - Submenu - Serviços',
      'conteudo' => 'paineladm/servicos/pagina/itens_pagina/editar_item_pagina_especifica',
      'dados' => array(
        'pagina' => $pagina = isset($pagina) ? $pagina : '',
        'paginaEspecifica' => $paginaEspecifica = isset($paginaEspecifica) ? $paginaEspecifica : '',
        'page' => "Edição de dados da página (Menu) >> (<b>$pagina->title</b>) << -<strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_pagina_especifica($uriCampus = NULL, $idPagina = NULL, $id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*', 'page_contents', NULL, array('page_contents.id' => $id))->row();
    if (file_exists($item->img_destaque)) {
      unlink($item->img_destaque);
    }

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>Informações deletadas com sucesso.</p>', 'success');
      redirect("Painel_servicos/lista_item_pagina_especifica/$uriCampus/$idPagina");
    } else {
      setMsg('<p>Erro! Os dados não deletado.</p>', 'error');
      redirect("Painel_servicos/lista_item_pagina_especifica/$uriCampus/$idPagina");
    }
  }

  public function cadastrar_contato_pagina_especifica($uriCampus = NULL, $pageId = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId,);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $colunaResultadContatoPaginaEspecifica = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description',
      'page_contents.order',
      'page_contents.created_at',
      'page_contents.updated_at',
      'page_contents.user_id',
    );
    $joinConteudoContatoPaginaEspecifica = array(
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereContatoPaginaEspecifica = array(
      'page_contents.pages_id' => $pagina->id,
      'page_contents.order' => 'contatos'
    );

    $contatoPaginaEspecifica = $this->painelbd->where($colunaResultadContatoPaginaEspecifica, 'page_contents', $joinConteudoContatoPaginaEspecifica, $whereContatoPaginaEspecifica)->row();

    $this->form_validation->set_rules('description', 'Informações de contato', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['title'] = "Contatos";
      $dados_form['status'] = $this->input->post('status');
      $dados_form['description'] = $this->input->post('description');
      $dados_form['order'] = 'contatos';
      $dados_form['pages_id'] = $pagina->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if (isset($contatoPaginaEspecifica)) {
        $dados_form['id'] = $contatoPaginaEspecifica->id;
        $dados_form['updated_at'] = date('Y-m-d H:i:s');
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (menu)' . strtoupper($pagina->title) . 'atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_servicos/lista_item_pagina_especifica/$campus->id/$pagina->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      } else {
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
          setMsg('<p>Dados de contato cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_servicos/lista_item_pagina_especifica/$campus->id/$pagina->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas - Submenu - Serviços',
      'conteudo' => 'paineladm/servicos/pagina/itens_pagina/contatos/cadastrar_contato_pagina_especifica',
      'dados' => array(
        'pagina' => $pagina = isset($pagina) ? $pagina : '',
        'page' => "Cadastro de Contatos da página (Menu) >> (<b>$pagina->title</b>) << -<strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'contatoPaginaEspecifica' => $contatoPaginaEspecifica = isset($contatoPaginaEspecifica) ? $contatoPaginaEspecifica : '',
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_atendimento_pagina_especifica($uriCampus = NULL, $pageId = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $colunaResultadoAtendimentoPaginaEspecifica = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description',
      'page_contents.order',
      'page_contents.user_id',
    );
    $joinConteudoatendimentoPaginaEspecifica = array(
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereatendimentoPaginaEspecifica = array(
      'page_contents.pages_id' => $pagina->id,
      'page_contents.order' => 'atendimento'
    );

    $atendimentoPaginaEspecifica = $this->painelbd->where($colunaResultadoAtendimentoPaginaEspecifica, 'page_contents', $joinConteudoatendimentoPaginaEspecifica, $whereatendimentoPaginaEspecifica)->row();

    $this->form_validation->set_rules('description', 'Informações de atendimento', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['title'] = 'Atendimento';
      $dados_form['status'] = $this->input->post('status');
      $dados_form['description'] = $this->input->post('description');
      $dados_form['order'] = 'atendimento';
      $dados_form['pages_id'] = $pagina->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if (isset($atendimentoPaginaEspecifica)) {
        $dados_form['id'] = $atendimentoPaginaEspecifica->id;
        $dados_form['updated_at'] = date('Y-m-d H:i:s');
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
          setMsg('<p>Dados de Atendimento atualizados com sucesso.</p>', 'success');
          redirect(base_url("Painel_servicos/lista_item_pagina_especifica/$campus->id/$pagina->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      } else {
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
          setMsg('<p>Dados de Atendimento cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_servicos/lista_item_pagina_especifica/$campus->id/$pagina->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas - Submenu - Serviços',
      'conteudo' => 'paineladm/servicos/pagina/itens_pagina/contatos/cadastrar_atendimento_pagina_especifica',
      'dados' => array(
        'pagina' => $pagina = isset($pagina) ? $pagina : '',
        'page' => "Informações de atendimento da página (Menu) >> (<b>$pagina->title</b>) << -<strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'atendimentoPaginaEspecifica' => $atendimentoPaginaEspecifica = isset($atendimentoPaginaEspecifica) ? $atendimentoPaginaEspecifica : '',
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }
}
