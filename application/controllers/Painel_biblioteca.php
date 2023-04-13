<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_biblioteca extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('painel_model', 'painelbd');
    date_default_timezone_set('America/Sao_Paulo');
  }
    
  public function lista_campus_biblioteca() {
    verificaLogin();

    $colunasResultadoCursos = 
      array('campus.id',
      'campus.name',
      'campus.city',
      'campus.uf'
    );

    $listagemDosCampus = $this->painelbd->where('*','campus',NULL, array('visible' => 'SIM'))->result();
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/lista_campus_biblioteca',
      'dados' => array(
        //'page' => "Informações Biblioteca",
        'page' => "Informações Menu (BIBLIOTECA)",
        'campus'=> $listagemDosCampus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_informacoes_biblioteca($uriCampus=NULL) {
    verificaLogin();

    $pagina = 'biblioteca';
    $verificaExistePaginaBiblioteca = $this->painelbd->where('*','pages',null,array('pages.campusid'=>$uriCampus,'pages.title'=> $pagina))->row();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/lista_informacoes_biblioteca',
      'dados' => array(
        'conteudosPagina'=>'',
        //'contatosPaginaBiblioteca'=>$contatosPaginaBiblioteca,
        'page' => "Cadastro de informações do Biblioteca - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus'=>$campus,
        'paginaBiblioteca'=> $verificaExistePaginaBiblioteca = isset($verificaExistePaginaBiblioteca) ? $verificaExistePaginaBiblioteca : '',
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_pagina_biblioteca($uriCampus=NULL)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $verificaExistePagina = $this->painelbd->where('*','pages',null, array('pages.title'=>'biblioteca','pages.campusid'=>$campus->id))->row();

    $this->form_validation->set_rules('status', 'Situação', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {
      
      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['campusid'] = $campus->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if(isset($verificaExistePagina)){
        $dados_form['id'] = $verificaExistePagina->id;
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE){
          setMsg('<p>Dados da página (menu) Biblioteca atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_biblioteca/cadastrar_pagina_biblioteca/$campus->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }else{
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE){
          setMsg('<p>Dados da página (menu) Biblioteca cadastrada com sucesso.</p>', 'success');
          redirect(base_url("Painel_biblioteca/cadastrar_pagina_biblioteca/$campus->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/pagina_menu_biblioteca/cadastrar_pagina_biblioteca',
      'dados' => array(
        'paginaBiblioteca'=>$verificaExistePagina = isset($verificaExistePagina) ? $verificaExistePagina : '',
        'page' => "Cadastro de pagina (menu do site) do Biblioteca - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_itens_biblioteca($uriCampus=NULL,$pageId = null)
  {
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();


    $queryItensBiblioteca = "
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

    $listaItensPaginaBiblioteca = $this->painelbd->getQuery($queryItensBiblioteca)->result();

    $data = array(
      'titulo' => 'Gestão de monografias - Uniatenas',
      'conteudo' => 'paineladm/biblioteca/itens/lista_itens_biblioteca',
      'dados' => array(
        'page' => "Informações da página BIBLIOTECA- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaItensPaginaBiblioteca' => $listaItensPaginaBiblioteca = isset($listaItensPaginaBiblioteca) ? $listaItensPaginaBiblioteca : '',
        'campus'=>$campus,
        'tipo'=>'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_itens_biblioteca($uriCampus=NULL, $pageId = NULL) {
    verificaLogin();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunaResultadoPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadoPagina,'pages',$joinPagina, $wherePagina)->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    // $this->form_validation->set_rules('title_short', 'Subtítulo', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    // $this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()):
        setMsg(validation_errors(), 'error');
      endif;
    }else {
      
      $dados_form['description'] = $this->input->post('description');
      
      if(!empty($this->input->post('title_short'))){
        $dados_form['title_short'] = $this->input->post('title_short');
      }
      
      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['order'] = $this->input->post('order');
      $dados_form['tipo'] = 'informacoesPagina';
      $dados_form['pages_id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
        setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
        redirect(base_url("Painel_biblioteca/lista_itens_biblioteca/$campus->id/$pagina->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/biblioteca/itens/cadastrar_itens_biblioteca',
        'dados' => array(
            'page' => "Cadastro de informações BIBLIOTECA - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'pagina'=>$pagina,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_itens_biblioteca($uriCampus=NULL, $pageId = null, $idInformacao = null) {
    verificaLogin();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunaResultadoPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadoPagina,'pages',$joinPagina, $wherePagina)->row();

    $informacoesBibliteca = $this->painelbd->where("*",'page_contents',null, array('page_contents.id'=>$idInformacao))->row();
    $informacoesTcc = $this->painelbd->where("*",'page_contents',null, array('page_contents.id'=>$idInformacao))->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    //$this->form_validation->set_rules('title_short', 'Subtítulo', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    //$this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()):
        setMsg(validation_errors(), 'error');
      endif;
    }else {
      if( $informacoesBibliteca->description !== $this->input->post('description')){
        $dados_form['description'] = $this->input->post('description');
      }
      if($informacoesBibliteca->title_short !== $this->input->post('title_short') and !empty ($this->input->post('title_short'))){
        $dados_form['title_short'] = $this->input->post('title_short');
      }
      if($informacoesBibliteca->title !== $this->input->post('title') and !empty ($this->input->post('title'))){
        $dados_form['title'] = $this->input->post('title');
      }
      if($informacoesBibliteca->status !== $this->input->post('status')){
        $dados_form['status'] = $this->input->post('status');
      }
      // if($informacoesBibliteca->link_redir !== $this->input->post('link_redir')){
      //   $dados_form['link_redir'] = $this->input->post('link_redir');
      // }
      if($informacoesBibliteca->order !== $this->input->post('order')){
        $dados_form['order'] = $this->input->post('order');
      }
            
      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['id'] = $informacoesBibliteca->id;
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      
      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados editados com sucesso.</p>', 'success');
          redirect(base_url("Painel_biblioteca/lista_itens_biblioteca/$campus->id/$pagina->id"));
      }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/biblioteca/itens/editar_itens_biblioteca',
        'dados' => array(
            'informacoesBibliteca'=> $informacoesBibliteca,
            'page' => "Edição de informações BIBLIOTECA- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'pagina'=>$pagina,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_biblioteca($uriCampus=NULL, $pagina = null,$id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_biblioteca/lista_itens_biblioteca/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_biblioteca/lista_itens_biblioteca/$uriCampus/$pagina");
    }
  } 


  public function lista_itens_comutacao_biblioteca($uriCampus=NULL,$pageId = null)
  {
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();


    $queryItensBiblioteca = "
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
        page_contents.order IN ('linkComutacao','comutacao')
    ORDER BY page_contents.title ASC
    ";

    $listaItensPaginaBiblioteca = $this->painelbd->getQuery($queryItensBiblioteca)->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/comutacao/lista_itens_comutacao_biblioteca',
      'dados' => array(
        'page' => "Informações da página BIBLIOTECA >> Comutação Bibliográfica- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaItensPaginaBiblioteca' => $listaItensPaginaBiblioteca = isset($listaItensPaginaBiblioteca) ? $listaItensPaginaBiblioteca : '',
        'campus'=>$campus,
        'tipo'=>'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_itens_comutacao_biblioteca($uriCampus=NULL, $pageId = NULL) {
    verificaLogin();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunaResultadoPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadoPagina,'pages',$joinPagina, $wherePagina)->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()):
        setMsg(validation_errors(), 'error');
      endif;
    }else {
      if(!empty($this->input->post('order'))){
        $dados_form['order'] = $this->input->post('order');
      }else{
        $dados_form['order'] = 'linkComutacao';
      }
      
      $dados_form['title'] = $this->input->post('title');
      $dados_form['link_redir'] = $this->input->post('link_redir');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['description'] = $this->input->post('description');
      $dados_form['tipo'] = 'informacoesPagina';
      $dados_form['pages_id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
          redirect(base_url("Painel_biblioteca/lista_itens_comutacao_biblioteca/$campus->id/$pagina->id"));
      }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/biblioteca/comutacao/cadastrar_itens_comutacao_biblioteca',
        'dados' => array(
            'page' => "Cadastro de informações: BIBLIOTECA >> Comutação Bibliográfica - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'pagina'=>$pagina,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_itens_comutacao_biblioteca($uriCampus=NULL, $pageId = null, $idInformacao = null) {
    verificaLogin();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunaResultadoPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadoPagina,'pages',$joinPagina, $wherePagina)->row();

    $informacoesBibliteca = $this->painelbd->where("*",'page_contents',null, array('page_contents.id'=>$idInformacao))->row();
    $informacoesTcc = $this->painelbd->where("*",'page_contents',null, array('page_contents.id'=>$idInformacao))->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()):
        setMsg(validation_errors(), 'error');
      endif;
    }else{
      if( $informacoesBibliteca->description !== $this->input->post('description')){
        $dados_form['description'] = $this->input->post('description');
      }
      if($informacoesBibliteca->title !== $this->input->post('title') and !empty ($this->input->post('title'))){
        $dados_form['title'] = $this->input->post('title');
      }
      if($informacoesBibliteca->status !== $this->input->post('status')){
        $dados_form['status'] = $this->input->post('status');
      }
      if($informacoesBibliteca->link_redir !== $this->input->post('link_redir')){
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }
      
      if(!empty($this->input->post('order')) and $informacoesBibliteca->order !== $this->input->post('order')){
        $dados_form['order'] = $this->input->post('order');
      }else{
        $dados_form['order'] = 'linkComutacao';
      }

      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['id'] = $informacoesBibliteca->id;
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      
      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados editados com sucesso.</p>', 'success');
          redirect(base_url("Painel_biblioteca/lista_itens_comutacao_biblioteca/$campus->id/$pagina->id"));
      }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/biblioteca/comutacao/editar_itens_comutacao_biblioteca',
        'dados' => array(
            'informacoesBibliteca'=> $informacoesBibliteca,
            'page' => "Edição de informações: BIBLIOTECA >> Comutação Bibliográfica- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'pagina'=>$pagina,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_comutacao_biblioteca($uriCampus=NULL, $pagina = null,$id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_biblioteca/lista_itens_comutacao_biblioteca/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_biblioteca/lista_itens_comutacao_biblioteca/$uriCampus/$pagina");
    }
  } 

  public function lista_fotos_slides_biblioteca($uriCampus=NULL,$pageId = NULL) {
    verificaLogin();

    
    $pagina = $this->painelbd->where('*','pages',null,array('pages.id'=>$pageId))->row();
  
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaFotosBiblioteca = array(
      'photos_gallery.id',
      'photos_gallery.id_page_contents',
      'photos_gallery.campusid',
      'photos_gallery.title',
      'photos_gallery.file',
      'photos_gallery.status', 
      'photos_gallery.created_at', 
      'photos_gallery.updated_at', 
      'photos_gallery.user_id', 
    );
    $joinFotosSlideBiblioteca  = array(
      'page_contents'=>'page_contents.id = photos_gallery.id_page_contents',
      'pages'=>'pages.id = page_contents.pages_id',
    );

    $whereFotosSlideBiblioteca = array(
      'page_contents.pages_id'=>$pagina->id,
    );
      
    $fotosSlideBiblioteca = $this->painelbd->where($colunaFotosBiblioteca,'photos_gallery',$joinFotosSlideBiblioteca,  $whereFotosSlideBiblioteca,NULL)->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/slide_fotos/lista_fotos_slides_biblioteca',
      'dados' => array(
        'conteudosPagina'=>'',
        //'contatosPaginaBiblioteca'=>$contatosPaginaBiblioteca,
        'page' => "Cadastro de informações do Biblioteca - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus'=> $campus,
        'pagina'=> $pagina,
        'fotosSlideBiblioteca'=> $fotosSlideBiblioteca = isset($fotosSlideBiblioteca) ? $fotosSlideBiblioteca : '',
        'tipo'=>''
      )
    );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_fotos_slides_biblioteca($uriCampus=NULL, $pageId=NULL)
  {
    $this->load->helper('file');
    
    $pagina = $this->painelbd->where('*','pages',null,array('pages.id'=>$pageId))->row();

    $conteudoPagina = $this->painelbd->where(array('page_contents.id'),'page_contents',null,array('page_contents.pages_id'=>$pageId))->row();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $this->form_validation->set_rules('title', 'Título da foto', 'required');
    $this->form_validation->set_rules('status', 'STATUS', 'required');

    if (empty($_FILES['file']['name'])) {
      $this->form_validation->set_rules('file', 'Arquivo', 'callback_file_check');
      $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
    }

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()){
        setMsg(validation_errors(), 'error');
      }
    } else {
      
      $path = "assets/images/gallery/$campus->id/biblioteca/slideshow";
      is_way($path);

      if (unique_name_args(noAccentuation($this->input->post('title'), NULL), $path)) {
        $name_tmp = null;
      } else {
        $name_tmp = noAccentuation($this->input->post('title'), NULL);
      }
      
      $upload = $this->painelbd->uploadFiles('file', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', $name_tmp);

      if ($upload){
        //upload efetuado
        $dados_form['status'] =$this->input->post('status');
        $dados_form['title'] = $this->input->post('title');
        $dados_form['file'] = $path . '/' . $upload['file_name'];
        $dados_form['campusid'] = $campus->id;
        $dados_form['id_page_contents'] = $conteudoPagina->id;
        $dados_form['user_id'] = $this->session->userdata('codusuario');

        if ($this->painelbd->salvar('photos_gallery', $dados_form) == TRUE) {
          setMsg('<p>Foto cadastrada com sucesso.</p>', 'success');
          redirect("Painel_biblioteca/lista_fotos_slides_biblioteca/$campus->id/$pagina->id");
        } else {
          setMsg('<p>Erro! A publicação não foi cadastrada.</p>', 'error');
        }
        
      }else{
        //erro no upload
        $msg = $this->upload->display_errors();
        $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
        setMsg($msg, 'erro');
      }        
    }
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/slide_fotos/cadastrar_fotos_slides_biblioteca',
      'dados' => array(
        'conteudosPagina'=>'',
        //'contatosPaginaBiblioteca'=>$contatosPaginaBiblioteca,
        'page' => "Cadastro de fotos slide show Biblioteca - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus'=>$campus,
        'pagina'=> $pagina,
        //'fotosSlideBiblioteca'=> $fotosSlideBiblioteca = isset($fotosSlideBiblioteca) ? $fotosSlideBiblioteca : '',
        'tipo'=>''
      )
    );
      
    $this->load->view('templates/layoutPainelAdm', $data);
  }
  
  public function editar_fotos_slides_biblioteca($uriCampus=NULL, $pageId=NULL,$idFoto=NULL)
  {
    $this->load->helper('file');
    
    $pagina = $this->painelbd->where('*','pages',null,array('pages.id'=>$pageId))->row();
    
    $conteudoPagina = $this->painelbd->where(array('page_contents.id'),'page_contents',null,array('page_contents.pages_id'=>$pageId))->row();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaFotosBiblioteca = array(
      'photos_gallery.id',
      'photos_gallery.id_page_contents',
      'photos_gallery.campusid',
      'photos_gallery.title',
      'photos_gallery.file',
      'photos_gallery.status', 
      'photos_gallery.created_at', 
      'photos_gallery.updated_at', 
      'photos_gallery.user_id', 
    );
    $joinFotosSlideBiblioteca  = array(
      'page_contents'=>'page_contents.id = photos_gallery.id_page_contents',
      'pages'=>'pages.id = page_contents.pages_id',
    );

    $whereFotosSlideBiblioteca = array(
      'page_contents.pages_id'=>$pagina->id,
      'photos_gallery.id'=>$idFoto,
    );
      
    $fotoSlideBiblioteca = $this->painelbd->where($colunaFotosBiblioteca,'photos_gallery',$joinFotosSlideBiblioteca,  $whereFotosSlideBiblioteca,NULL)->row();

    $this->form_validation->set_rules('title', 'Título da foto', 'required');
    $this->form_validation->set_rules('status', 'STATUS', 'required');

    if (empty($_FILES['file']['name'])) {
      $this->form_validation->set_rules('file', 'Arquivo', 'callback_file_check');
      $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
    }

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()){
        setMsg(validation_errors(), 'error');
      }
    } else {

      if ($fotoSlideBiblioteca->title != $this->input->post('title')) {
        $dados_form['title'] = $this->input->post('title');
      }
      if ($fotoSlideBiblioteca->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }
      if ($fotoSlideBiblioteca->user_id != $this->input->post('codusuario')) {
        $dados_form['user_id'] = $this->input->post('codusuario');
      }

      if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
        $path = dirname($fotoSlideBiblioteca->file);
        is_way($path);

        if (unique_name_args(noAccentuation($this->input->post('title'), NULL), $path)) {
          $name_tmp = null;
        } else {
          $name_tmp = noAccentuation($this->input->post('title'), NULL);
        }

        $upload = $this->painelbd->uploadFiles('file', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', $name_tmp);

        if(file_exists($fotoSlideBiblioteca->file)){
          unlink($fotoSlideBiblioteca->file);
        }
        
        $dados_form['file'] = $path . '/' . $upload['file_name'];
      }
      
      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['id'] = $fotoSlideBiblioteca->id;
      
      if ($this->painelbd->salvar('photos_gallery', $dados_form) == TRUE) {
        setMsg('<p>Dados atualizados com sucesso.</p>', 'success');
        redirect("Painel_biblioteca/lista_fotos_slides_biblioteca/$campus->id/$pagina->id");
      } else {
        setMsg('<p>Erro! A publicação não foi cadastrada.</p>', 'error');
      }
     

    }
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/slide_fotos/editar_fotos_slides_biblioteca',
      'dados' => array(
        'page' => "Editar foto slide show Biblioteca - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus'=>$campus,
        'pagina'=> $pagina,
        'fotoSlideBiblioteca'=> $fotoSlideBiblioteca = isset($fotoSlideBiblioteca) ? $fotoSlideBiblioteca : '',
        'tipo'=>''
      )
    );
      
    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_foto_slides_biblioteca($uriCampus=NULL, $pagina = null,$id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*','photos_gallery', NULL, array('photos_gallery.id' => $id))->row();
    
    if(file_exists($item->file)){
      unlink($item->file);
    }

    if ($this->painelbd->deletar('photos_gallery', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_biblioteca/lista_fotos_slides_biblioteca//$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_biblioteca/lista_fotos_slides_biblioteca/$uriCampus/$pagina");
    }
  } 
  
  public function lista_links_uteis_biblioteca($uriCampus=NULL,$pageId = null)
  {
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadoPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadoPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoLinksUteisPaginaBiblioteca = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description', 
      'page_contents.link_redir', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoLinksUteisPaginaBiblioteca = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereLinksUteisPaginaBiblioteca = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.order'=>'linksUteis'
    );

    $listaLinksUteisPaginaBiblioteca = $this->painelbd->where($colunaResultadoLinksUteisPaginaBiblioteca,'page_contents',$joinConteudoLinksUteisPaginaBiblioteca, $whereLinksUteisPaginaBiblioteca,array('campo' => 'title', 'ordem' => 'asc'))->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/links_uteis/lista_links_uteis_biblioteca',
      'dados' => array(
        'page' => "Lista <u>Links Úteis</u> página Biblioteca- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaLinksUteisPaginaBiblioteca' => $listaLinksUteisPaginaBiblioteca = isset($listaLinksUteisPaginaBiblioteca) ? $listaLinksUteisPaginaBiblioteca : '',
        'campus'=>$campus,
        'tipo'=>'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_links_uteis_biblioteca($uriCampus=NULL,$pageId = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();
    
    $this->form_validation->set_rules('link_redir', 'Por favor, insira o LINK ', 'required'); 
    $this->form_validation->set_rules('status', 'Situação', 'required'); 
    $this->form_validation->set_rules('tipo', 'Tipo Link', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {
      
      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['tipo'] = $this->input->post('tipo');
      $dados_form['link_redir'] = $this->input->post('link_redir');
      $dados_form['order'] = 'linksUteis';
      $dados_form['pages_id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');
      
      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
        setMsg('<p>Link Útil cadastrado com sucesso.</p>', 'success');
        redirect(base_url("Painel_biblioteca/lista_links_uteis_biblioteca/$campus->id/$pagina->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/links_uteis/cadastrar_links_uteis_biblioteca',
      'dados' => array(
        'page' => "Cadastro de Link Útil: Biblioteca - <strong><i> $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_links_uteis_biblioteca($uriCampus=NULL,$pageId = null,$idLink = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoLinksUteisPaginaBiblioteca = array(
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
    $joinConteudoLinksUteisPaginaBiblioteca = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereLinksUteisPaginaBiblioteca = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.id'=>$idLink,
      'page_contents.order'=>'linksUteis'
    );

    $listaLinksUteisPaginaBiblioteca = $this->painelbd->where($colunaResultadoLinksUteisPaginaBiblioteca,'page_contents',$joinConteudoLinksUteisPaginaBiblioteca, $whereLinksUteisPaginaBiblioteca)->row();
    
    $this->form_validation->set_rules('link_redir', 'Por favor, insira o LINK ', 'required'); 
    $this->form_validation->set_rules('status', 'Situação', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {

      if($listaLinksUteisPaginaBiblioteca->title !== $this->input->post('title')){
        $dados_form['title'] = $this->input->post('title');
      }
      if($listaLinksUteisPaginaBiblioteca->status !== $this->input->post('status')){
        $dados_form['status'] = $this->input->post('status');
      }
      if($listaLinksUteisPaginaBiblioteca->tipo !== $this->input->post('tipo')){
        $dados_form['tipo'] = $this->input->post('tipo');
      }
      if($listaLinksUteisPaginaBiblioteca->link_redir !== $this->input->post('link_redir')){
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }
      $dados_form['id'] = $listaLinksUteisPaginaBiblioteca->id;
      $dados_form['order'] = 'linksUteis';
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
        setMsg('<p>Link Útil atualizado com sucesso.</p>', 'success');
        redirect(base_url("Painel_biblioteca/lista_links_uteis_biblioteca/$campus->id/$pagina->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/links_uteis/editar_links_uteis_biblioteca',
      'dados' => array(
        'tituloPagina' => "Edição de Link Útil: Biblioteca - <strong><i> $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaLinksUteisPaginaBiblioteca' => $listaLinksUteisPaginaBiblioteca,
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_links_uteis_biblioteca($uriCampus=NULL, $pagina = null,$id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_biblioteca/lista_links_uteis_biblioteca/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_biblioteca/lista_links_uteis_biblioteca/$uriCampus/$pagina");
    }
  }  
}