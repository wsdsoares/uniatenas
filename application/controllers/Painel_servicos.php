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

    $this->form_validation->set_rules('title', 'Página', 'required');
    $this->form_validation->set_rules('tipo_pagina', 'Tipo Página', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {
      $dados_form['title'] = '' . lcfirst(str_replace("_", '', noAccentuation($this->input->post('title'))));
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

    $this->form_validation->set_rules('title', 'Página', 'required');
    $this->form_validation->set_rules('tipo_pagina', 'Tipo Página', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {
      if ($pagina->title != $this->input->post('title')) {
        $dados_form['title'] = '' . lcfirst(str_replace("_", '', noAccentuation($this->input->post('title'))));
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
      'pages.id', 'pages.title'
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
}
