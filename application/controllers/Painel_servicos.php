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
        //'paginaFinanceiro'=> $verificaExistePaginaFinanceiro = isset($verificaExistePaginaFinanceiro) ? $verificaExistePaginaFinanceiro : '',
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function registro_item_pagina($uriCampus = NULL, $idPagina = NULL)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $this->form_validation->set_rules('title', 'Página', 'required');
    $this->form_validation->set_rules('tipo_pagina', 'Tipo Página', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['title'] = '' . lcfirst(str_replace("_", '', noAccentuation($this->input->post('title'))));
      $dados_form['tipo_pagina'] = 'item_geral';
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

  public function editar_informacoes_financeiro($uriCampus = NULL, $itemId = null)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $pagina = 'financeiro';
    //$wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

    $colunasTabelaPagesFinanceiro = array('page_contents.id', 'page_contents.title', 'page_contents.description', 'page_contents.order', 'page_contents.img_destaque', 'page_contents.link_redir', 'page_contents.status');
    $joinConteudoPagina = array('pages' => 'pages.id = page_contents.pages_id');
    $wherePaginaFinanceiro = array('page_contents.id' => $itemId);

    $paginaFinanceiro = $this->painelbd->where($colunasTabelaPagesFinanceiro, 'page_contents', $joinConteudoPagina, $wherePaginaFinanceiro, null)->row();

    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    $this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      if ($paginaFinanceiro->description != $this->input->post('description')) {
        $dados_form['description'] = $this->input->post('description');
      }

      if ($paginaFinanceiro->link_redir != $this->input->post('link_redir')) {
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }

      if ($paginaFinanceiro->title != $this->input->post('title')) {
        $dados_form['title'] = $this->input->post('title');
      }

      if ($paginaFinanceiro->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }
      if ($paginaFinanceiro->order != $this->input->post('order')) {
        $dados_form['order'] = $this->input->post('order');
      }


      if (isset($_FILES['img_destaque']) && !empty($_FILES['img_destaque']['name'])) {

        if (file_exists($paginaFinanceiro->img_destaque)) {
          unlink($paginaFinanceiro->img_destaque);
        }

        $path = "assets/images/financing/$campus->id";
        is_way($path);

        $upload = $this->painelbd->uploadFiles('img_destaque', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

        $dados_form['img_destaque'] = $path . '/' . $upload['file_name'];
      }

      $dados_form['id'] = $paginaFinanceiro->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Dados do financeiro cadastrado com sucesso.</p>', 'success');
        redirect(base_url("Painel_financeiro/lista_informacoes_financeiro/$campus->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/financeiro/editar_informacoes_financeiro',
      'dados' => array(
        'paginaFinanceiro' => $paginaFinanceiro,
        'page' => "Edição de informações do Financeiro - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
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
}
