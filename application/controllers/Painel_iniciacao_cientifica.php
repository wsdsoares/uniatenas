<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_iniciacao_cientifica extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('painel_model', 'painelbd');
    date_default_timezone_set('America/Sao_Paulo');
  }

  public function lista_campus_iniciacao() {
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
        'conteudo' => 'paineladm/itens_iniciacao/lista_campus_iniciacao',
        'dados' => array(
            'page' => "Informações Menu (PESQUISA >> Iniciação Científica)",
            'tipoPagina' => 'INICIAÇÃO CIENTÍFICA',
            'campus'=> $listagemDosCampus,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }
    
  public function lista_informacoes_iniciacao($uriCampus=NULL) 
  {
    verificaLogin();

    $pagina = 'pesquisaIniciacao';
    $verificaExistePaginaIniciacaoCientifica = $this->painelbd->where('*','pages',null,array('pages.campusid'=>$uriCampus,'pages.title'=> $pagina))->row();
    
  
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $joinContatoPagina = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );

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
      
      // $listaInformmacoesPaginaIniciacaoCientifica =  
      // $this->painelbd->getQuery(
      //   "SELECT 
      //     page_contents.id,
      //     page_contents.title,
      //     page_contents.img_destaque,
      //     page_contents.status,
      //     page_contents.title_short,
      //     page_contents.description, 
      //     page_contents.order, 
      //     page_contents.created_at, 
      //     page_contents.updated_at, 
      //     page_contents.user_id, 
      //     campus.city
      //   FROM 
      //     page_contents
      //   INNER JOIN pages ON pages.id = page_contents.pages_id
      //   INNER JOIN campus ON campus.id= pages.campusid
      //   WHERE 
      //       pages.title = '$pagina'AND 
      //       pages.campusid = $campus->id AND 
      //       page_contents.order <>'contatos' AND 
      //       page_contents.status=1 
      //   ORDER BY page_contents.order ASC")->result();
      
      $whereContatosPagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id,'page_contents.order'=>'contatos');
      $contatosPaginaIniciacaoCientifica = $this->painelbd->where($colunaResultadoContatoPagina,'page_contents',$joinContatoPagina, $whereContatosPagina,null)->result();
      
      $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/itens_iniciacao/iniciacao_cientifica/lista_informacoes_iniciacao',
        'dados' => array(
         // 'conteudosPaginaIniciacaoCientifica'=>$listaInformmacoesPaginaIniciacaoCientifica,
          'page' => "Informações da Iniciação Científica - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'contatosPaginaIniciacaoCientifica'=>$contatosPaginaIniciacaoCientifica,
          'campus'=>$campus,
          'paginaIniciacaoCientifica'=> $verificaExistePaginaIniciacaoCientifica = isset($verificaExistePaginaIniciacaoCientifica) ? $verificaExistePaginaIniciacaoCientifica : '',
          'tipo'=>''
        )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_itens_iniciacao_cientifica($uriCampus=NULL) 
  {
    verificaLogin();

    $pagina = 'pesquisaIniciacao';
    $verificaExistePaginaIniciacaoCientifica = $this->painelbd->where('*','pages',null,array('pages.campusid'=>$uriCampus,'pages.title'=> $pagina))->row();
  
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $joinContatoPagina = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );

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
      
      $listaInformmacoesPaginaIniciacaoCientifica =  
      $this->painelbd->getQuery(
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
        ORDER BY page_contents.order ASC")->result();
      
      $whereContatosPagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id,'page_contents.order'=>'contatos');
      $contatosPaginaIniciacaoCientifica = $this->painelbd->where($colunaResultadoContatoPagina,'page_contents',$joinContatoPagina, $whereContatosPagina,null)->result();
      
      $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/itens_iniciacao/iniciacao_cientifica/lista_informacoes_iniciacao',
        'dados' => array(
          'conteudosPaginaIniciacaoCientifica'=>$listaInformmacoesPaginaIniciacaoCientifica,
          'page' => "Informações da Iniciação Científica - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'contatosPaginaIniciacaoCientifica'=>$contatosPaginaIniciacaoCientifica,
          
          'campus'=>$campus,
          'paginaIniciacaoCientifica'=> $verificaExistePaginaIniciacaoCientifica = isset($verificaExistePaginaIniciacaoCientifica) ? $verificaExistePaginaIniciacaoCientifica : '',
          'tipo'=>''
        )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_pagina_iniciacao_cientifica($uriCampus=NULL)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $verificaExistePagina = $this->painelbd->where('*','pages',null, array('pages.title'=>'pesquisaIniciacao','pages.campusid'=>$campus->id))->row();

    $this->form_validation->set_rules('status', 'Situação', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {
      
      $dados_form['title'] = 'pesquisaIniciacao';
      $dados_form['status'] = $this->input->post('status');
      $dados_form['campusid'] = $campus->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if(isset($verificaExistePagina)){
        $dados_form['id'] = $verificaExistePagina->id;
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE){
          setMsg('<p>Dados da página (menu) Iniciação Cientifica atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_iniciacao_cientifica/cadastrar_pagina_iniciacao_cientifica/$campus->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }else{
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE){
          setMsg('<p>Dados da página (menu) Iniciacao Cientifica cadastra com sucesso.</p>', 'success');
          redirect(base_url("Painel_iniciacao_cientifica/cadastrar_pagina_iniciacao_cientifica/$campus->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/iniciacao_cientifica/pagina_menu_iniciacao/cadastrar_pagina_iniciacao_cientifica',
      'dados' => array(
        'paginaIniciacaoCientifica'=>$verificaExistePagina = isset($verificaExistePagina) ? $verificaExistePagina : '',
        'page' => "Cadastro de pagina (menu do site) do PESQUISA - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }
    
  public function cadastrar_contato_pagina_iniciacao_cientifica($uriCampus=NULL,$pageId = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId,);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadContatoPaginaIniciacaoCientifica = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description', 
      'page_contents.order', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoContatoPaginaIniciacaoCientifica = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereContatoPaginaIniciacaoCientifica = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.order'=>'contatos'
    );

    $contatoPaginaIniciacaoCientifica = $this->painelbd->where($colunaResultadContatoPaginaIniciacaoCientifica,'page_contents',$joinConteudoContatoPaginaIniciacaoCientifica, $whereContatoPaginaIniciacaoCientifica)->row();
    
    $this->form_validation->set_rules('description', 'Informações de contato', 'required'); 
    $this->form_validation->set_rules('status', 'Situação', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {
      
      $dados_form['title'] = "Contatos Iniciação Científica";
      $dados_form['status'] = $this->input->post('status');
      $dados_form['description'] = $this->input->post('description');
      $dados_form['order'] = 'contatos';
      $dados_form['pages_id'] = $pagina->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if(isset($contatoPaginaIniciacaoCientifica)){
        $dados_form['id'] = $contatoPaginaIniciacaoCientifica->id;
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados da página (menu) Iniciação Científica atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_iniciacao_cientifica/cadastrar_contato_pagina_iniciacao_cientifica/$campus->id/$pagina->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }else{
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados de contato cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_iniciacao_cientifica/cadastrar_contato_pagina_iniciacao_cientifica/$campus->id/$pagina->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/iniciacao_cientifica/contatos/cadastrar_contato_pagina_iniciacao_cientifica',
      'dados' => array(
        'tituloPagina' => "Informações de contato página Iniciação Científica - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'contatoPaginaIniciacaoCientifica' => $contatoPaginaIniciacaoCientifica = isset($contatoPaginaIniciacaoCientifica) ? $contatoPaginaIniciacaoCientifica : '',
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_atendimento_pagina_iniciacao_cientifica($uriCampus=NULL,$pageId = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadatendimentoPaginaIniciacaoCientifica = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description', 
      'page_contents.order', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoatendimentoPaginaIniciacaoCientifica = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereatendimentoPaginaIniciacaoCientifica = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.order'=>'atendimento'
    );

    $atendimentoPaginaIniciacaoCientifica = $this->painelbd->where($colunaResultadatendimentoPaginaIniciacaoCientifica,'page_contents',$joinConteudoatendimentoPaginaIniciacaoCientifica, $whereatendimentoPaginaIniciacaoCientifica)->row();
    
    $this->form_validation->set_rules('description', 'Informações de atendimento', 'required'); 
    $this->form_validation->set_rules('status', 'Situação', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {
      
      $dados_form['title'] = 'Atendimento';
      $dados_form['status'] = $this->input->post('status');
      $dados_form['description'] = $this->input->post('description');
      $dados_form['order'] = 'atendimento';
      $dados_form['pages_id'] = $pagina->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if(isset($atendimentoPaginaIniciacaoCientifica)){
        $dados_form['id'] = $atendimentoPaginaIniciacaoCientifica->id;
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados de Atendimento atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_iniciacao_cientifica/cadastrar_atendimento_pagina_iniciacao_cientifica/$campus->id/$pagina->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }else{
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados de Atendimento cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_iniciacao_cientifica/cadastrar_atendimento_pagina_iniciacao_cientifica/$campus->id/$pagina->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/iniciacao_cientifica/contatos/cadastrar_atendimento_pagina_iniciacao_cientifica',
      'dados' => array(
        'tituloPagina' => "Informações de atendimento página Iniciação Científica - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'atendimentoPaginaIniciacaoCientifica' => $atendimentoPaginaIniciacaoCientifica = isset($atendimentoPaginaIniciacaoCientifica) ? $atendimentoPaginaIniciacaoCientifica : '',
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_links_uteis_pagina_iniciacao_cientifica($uriCampus=NULL,$pageId = null)
  {
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoLinksUteisPaginaIniciacaoCientifica = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description', 
      'page_contents.link_redir', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoLinksUteisPaginaIniciacaoCientifica = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereLinksUteisPaginaIniciacaoCientifica = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.order'=>'linksUteis'
    );

    $listaLinksUteisPaginaIniciacaoCientifica = $this->painelbd->where($colunaResultadoLinksUteisPaginaIniciacaoCientifica,'page_contents',$joinConteudoLinksUteisPaginaIniciacaoCientifica, $whereLinksUteisPaginaIniciacaoCientifica,array('campo' => 'title', 'ordem' => 'asc'))->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/iniciacao_cientifica/links_uteis/lista_links_uteis_pagina_iniciacao_cientifica',
      'dados' => array(
        'tituloPagina' => "Lista de Links Úteis página Iniciação Científica - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaLinksUteisPaginaIniciacaoCientifica' => $listaLinksUteisPaginaIniciacaoCientifica = isset($listaLinksUteisPaginaIniciacaoCientifica) ? $listaLinksUteisPaginaIniciacaoCientifica : '',
        'campus'=>$campus,
        'tipo'=>'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_links_uteis_pagina_iniciacao_cientifica($uriCampus=NULL,$pageId = null)
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

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {
      
      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['link_redir'] = $this->input->post('link_redir');
      $dados_form['order'] = 'linksUteis';
      $dados_form['pages_id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');
      
      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
        setMsg('<p>Link Útil cadastrado com sucesso.</p>', 'success');
        redirect(base_url("Painel_iniciacao_cientifica/lista_links_uteis_pagina_iniciacao_cientifica/$campus->id/$pagina->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
     
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/iniciacao_cientifica/links_uteis/cadastrar_links_uteis_pagina_iniciacao_cientifica',
      'dados' => array(
        'tituloPagina' => "Cadastro de Link Útil página Iniciação Científica - <strong><i> $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_links_uteis_pagina_iniciacao_cientifica($uriCampus=NULL,$pageId = null,$idLink = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoLinksUteisPaginaIniciacaoCientifica = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.link_redir', 
      'page_contents.order', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoLinksUteisPaginaIniciacaoCientifica = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereLinksUteisPaginaIniciacaoCientifica = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.id'=>$idLink,
      'page_contents.order'=>'linksUteis'
    );

    $listaLinksUteisPaginaIniciacaoCientifica = $this->painelbd->where($colunaResultadoLinksUteisPaginaIniciacaoCientifica,'page_contents',$joinConteudoLinksUteisPaginaIniciacaoCientifica, $whereLinksUteisPaginaIniciacaoCientifica)->row();
    
    $this->form_validation->set_rules('link_redir', 'Por favor, insira o LINK ', 'required'); 
    $this->form_validation->set_rules('status', 'Situação', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {

      if($listaLinksUteisPaginaIniciacaoCientifica->title !== $this->input->post('title')){
        $dados_form['title'] = $this->input->post('title');
      }
      if($listaLinksUteisPaginaIniciacaoCientifica->status !== $this->input->post('status')){
        $dados_form['status'] = $this->input->post('status');
      }
      if($listaLinksUteisPaginaIniciacaoCientifica->link_redir !== $this->input->post('link_redir')){
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }
      $dados_form['id'] = $listaLinksUteisPaginaIniciacaoCientifica->id;
      $dados_form['order'] = 'linksUteis';
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
        setMsg('<p>Link Útil atualizado com sucesso.</p>', 'success');
        redirect(base_url("Painel_iniciacao_cientifica/lista_links_uteis_pagina_iniciacao_cientifica/$campus->id/$pagina->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/iniciacao_cientifica/links_uteis/editar_links_uteis_pagina_iniciacao_cientifica',
      'dados' => array(
        'tituloPagina' => "Edição de Link Útil página Iniciação Científica - <strong><i> $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaLinksUteisPaginaIniciacaoCientifica' => $listaLinksUteisPaginaIniciacaoCientifica,
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_links_uteis($uriCampus=NULL, $pagina = null,$id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_iniciacao_cientifica/lista_links_uteis_pagina_iniciacao_cientifica/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_iniciacao_cientifica/lista_links_uteis_pagina_iniciacao_cientifica/$uriCampus/$pagina");
    }
  }

  public function lista_informacoes_iniciacao_cientifica($uriCampus=NULL,$pageId = null)
  {
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoInformacoesPaginaIniciacaoCientifica = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.title_short',
      'page_contents.status',
      'page_contents.order',
      'page_contents.description', 
      'page_contents.link_redir', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoInformacoesPaginaIniciacaoCientifica = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereInformacoesPaginaIniciacaoCientifica = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.tipo'=>'informacoesPagina'
    );

    $listaInformacoesPaginaIniciacaoCientifica = $this->painelbd->where($colunaResultadoInformacoesPaginaIniciacaoCientifica,'page_contents',$joinConteudoInformacoesPaginaIniciacaoCientifica, $whereInformacoesPaginaIniciacaoCientifica,array('campo' => 'title', 'ordem' => 'asc'))->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/iniciacao_cientifica/informacoes_iniciacao/lista_informacoes_iniciacao_cientifica',
      'dados' => array(
        'tituloPagina' => "Informações da página da Iniciação Científica - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaInformacoesPaginaIniciacaoCientifica' => $listaInformacoesPaginaIniciacaoCientifica = isset($listaInformacoesPaginaIniciacaoCientifica) ? $listaInformacoesPaginaIniciacaoCientifica : '',
        'campus'=>$campus,
        'tipo'=>'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }
  
  public function cadastrar_informacoes_iniciacao_cientifica($uriCampus=NULL, $pageId = null) {
    verificaLogin();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunaResultadPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('title_short', 'Subtítulo', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    $this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()):
        setMsg(validation_errors(), 'error');
      endif;
    }else {
      
      $dados_form['description'] = $this->input->post('description');
      $dados_form['title_short'] = $this->input->post('title_short');
      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['tipo'] = 'informacoesPagina';
      $dados_form['order'] = $this->input->post('order');
      $dados_form['pages_id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados da Iniciação Científica cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_iniciacao_cientifica/lista_informacoes_iniciacao_cientifica/$campus->id/$pagina->id"));
      }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/itens_iniciacao/iniciacao_cientifica/informacoes_iniciacao/cadastrar_informacoes_iniciacao_cientifica',
        'dados' => array(
            'conteudosPagina'=>'',
            'page' => "Cadastro de informações da Iniciação Científica - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'pagina'=>$pagina,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_informacoes_iniciacao_cientifica($uriCampus=NULL, $pageId = null, $idInformacao = null) {
    verificaLogin();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunaResultadPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    
    $informacoesIniciacao = $this->painelbd->where("*",'page_contents',null, array('page_contents.id'=>$idInformacao))->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('title_short', 'Subtítulo', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    $this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()):
        setMsg(validation_errors(), 'error');
      endif;
    }else {
      if(!empty ($this->input->post('description'))){
        $dados_form['description'] = $this->input->post('description');
      }
      if(!empty ($this->input->post('title_short'))){
        $dados_form['title_short'] = $this->input->post('title_short');
      }
      if(!empty ($this->input->post('title'))){
        $dados_form['title'] = $this->input->post('title');
      }
      if(!empty ($this->input->post('status'))){
        $dados_form['status'] = $this->input->post('status');
      }
      if(!empty ($this->input->post('order'))){
        $dados_form['order'] = $this->input->post('order');
      }
            
      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['id'] = $informacoesIniciacao->id;
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      
      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados da Iniciação Científica editada com sucesso.</p>', 'success');
          redirect(base_url("Painel_iniciacao_cientifica/lista_informacoes_iniciacao_cientifica/$campus->id/$pagina->id"));
      }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/itens_iniciacao/iniciacao_cientifica/informacoes_iniciacao/editar_informacoes_iniciacao_cientifica',
        'dados' => array(
            'informacoesIniciacao'=> $informacoesIniciacao,
            'page' => "Edição de informações da Iniciação Científica - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'pagina'=>$pagina,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_iniciacao($uriCampus=NULL, $pagina = null,$id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_iniciacao_cientifica/lista_informacoes_iniciacao_cientifica/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_iniciacao_cientifica/lista_informacoes_iniciacao_cientifica/$uriCampus/$pagina");
    }
  } 
  
}