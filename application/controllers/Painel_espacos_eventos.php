<?php

if (!defined("BASEPATH"))
  exit("No direct script access allowed");

class Painel_espacos_eventos extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('painel_model', 'painelbd');
    date_default_timezone_set('America/Sao_Paulo');
  }

  public function lista_campus_espacos_eventos()
  {
    verificaLogin();

    $listagemDosCampus = $this->painelbd->where('*', 'campus', NULL, array('visible' => 'SIM'))->result();
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/espacos_eventos/lista_campus_espacos_eventos',
      'dados' => array(
        'page' => "Lista Espaços para Eventos",
        'campus' => $listagemDosCampus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }


  public function lista_informacoes_espacos_eventos($uriCampus = NULL)
  {
    verificaLogin();

    $tituloPagina = 'espacoseventos';
    $pagina = $this->painelbd->where('*', 'pages', null, array('pages.campusid' => $uriCampus, 'pages.title' => $tituloPagina))->row();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $listaInformmacoesPaginaEspacosEventos =  $this->painelbd->getQuery(
      "SELECT 
          page_contents.id,
          page_contents.title,
          page_contents.img_destaque,
          page_contents.status,
          page_contents.link_redir,
          page_contents.description, 
          page_contents.created_at, 
          page_contents.updated_at, 
          page_contents.user_id
        FROM 
          page_contents
        INNER JOIN pages ON pages.id = page_contents.pages_id
        INNER JOIN campus ON campus.id= pages.campusid
        WHERE 
            pages.id = '$pagina->id' "
    )->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/espacos_eventos/lista_informacoes_espacos_eventos',
      'dados' => array(
        'conteudosPagina' => $listaInformmacoesPaginaEspacosEventos,
        'page' => "Cadastro de informações Espaços Eventos - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'pagina' => $pagina = isset($pagina) ? $pagina : '',
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }
  public function cadastrar_pagina_espacos_eventos($uriCampus = NULL)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $verificaExistePagina = $this->painelbd->where('*', 'pages', null, array('pages.title' => 'espacoseventos', 'pages.campusid' => $campus->id))->row();

    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()):
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['title'] = 'espacoseventos';
      $dados_form['status'] = $this->input->post('status');
      $dados_form['campusid'] = $campus->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if (isset($verificaExistePagina)) {
        $dados_form['id'] = $verificaExistePagina->id;
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (HOME - Espaço Eventos) atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_espacos_eventos/cadastrar_pagina_espacos_eventos/$campus->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      } else {
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (HOME - Espaço Eventos) atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_espacos_eventos/cadastrar_pagina_espacos_eventos/$campus->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/espacos_eventos/pagina_menu_espacos_eventos/cadastrar_pagina_espacos_eventos',
      'dados' => array(
        'pagina' => $verificaExistePagina = isset($verificaExistePagina) ? $verificaExistePagina : '',
        'page' => "Cadastro de pagina ( HOME site) Espaços Eventos - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_item_pagina_eventos($uriCampus = NULL, $idPagina = NULL)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $wherePagina = array('pages.id' => $idPagina, 'pages.campusid' => $campus->id);

    $colunasTabelaPages = array('pages.id', 'pages.title');

    $pagina = $this->painelbd->where($colunasTabelaPages, 'pages', null, $wherePagina, null)->row();

    $colunasConteudoPagina = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.description',
      'page_contents.status',
      'page_contents.img_destaque',
      'page_contents.pages_id',
      'page_contents.link_redir'
    );
    $joinConteudoPagina = array(
      'pages' => 'pages.id = page_contents.pages_id'
    );
    $whereConteudoPagina = array('page_contents.pages_id' => $pagina->id);

    $conteudoPagina = $this->painelbd->where($colunasConteudoPagina, 'page_contents', $joinConteudoPagina, $whereConteudoPagina)->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()):
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['description'] = $this->input->post('description');
      $dados_form['link_redir'] = $this->input->post('link_redir');
      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      // $dados_form['order'] = $this->input->post('order');
      $dados_form['pages_id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if (isset($conteudoPagina)) {
        $dados_form['id'] = $conteudoPagina->id;
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (HOME - Espaço Eventos) atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_espacos_eventos/lista_informacoes_espacos_eventos/$campus->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      } else {
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (HOME - Espaço Eventos) atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_espacos_eventos/lista_informacoes_espacos_eventos/$campus->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/espacos_eventos/cadastrar_item_pagina_eventos',
      'dados' => array(
        'pagina' => $pagina,
        'conteudosPagina' => $conteudoPagina,
        'page' => "Cadastro/Edição de informações página Espaço Eventos - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }


  public function lista_locais_espacos_eventos($uriCampus = NULL, $idPagina = NULL)
  {
    verificaLogin();

    $pagina = $this->painelbd->where('*', 'pages', null, array('pages.campusid' => $uriCampus, 'pages.id' => $idPagina))->row();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $coluncasLocaisEspacos = array(
      'event_space.id',
      'event_space.name',
      'event_space.photocape',
      'event_space.status',
      'event_space.description',
      'event_space.capacity',
      'event_space.created_at',
      'event_space.updated_at',
      'event_space.user_id'
    );
    $joinEspacoEventos = array(
      'page_contents' => 'page_contents.id = event_space.id_page_contents',
      'campus' => 'campus.id= event_space.campusid'
    );

    $listaLocaisEspcacoEventos = $this->painelbd->where($coluncasLocaisEspacos, 'event_space', $joinEspacoEventos, array());



    $listaLocaisEspcacoEventos =  $this->painelbd->getQuery(
      "SELECT 
          event_space.id,
          event_space.name,
          event_space.photocape,
          event_space.status,
          event_space.description, 
          event_space.capacity, 
          event_space.created_at, 
          event_space.updated_at, 
          event_space.user_id
        FROM 
          event_space
        INNER JOIN pages ON pages.id = event_space.id_page_contents
        INNER JOIN campus ON campus.id= event_space.campusid
        WHERE 
            pages.id = '$pagina->id' "
    )->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/espacos_eventos/lista_informacoes_espacos_eventos',
      'dados' => array(
        'conteudosPagina' => $listaLocaisEspcacoEventos,
        'page' => "Cadastro de informações Espaços Eventos - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'pagina' => $pagina = isset($pagina) ? $pagina : '',
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }


  public function deletar_item_espacos_eventos($uriCampus = NULL, $id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*', 'page_contents', NULL, array('page_contents.id' => $id))->row();

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_espacos_eventos/lista_informacoes_espacos_eventos/$uriCampus");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_espacos_eventos/lista_informacoes_espacos_eventos/$uriCampus");
    }
  }
}