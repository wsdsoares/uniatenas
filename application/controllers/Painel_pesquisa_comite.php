<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_pesquisa_comite extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('painel_model', 'painelbd');
    date_default_timezone_set('America/Sao_Paulo');
  }

  public function lista_campus_comite() {
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
        'conteudo' => 'paineladm/itens_iniciacao/lista_campus_comite',
        'dados' => array(
            'page' => "Informações Menu (PESQUISA >> Comitê de Ética em Pesquisa)",
            'tipoPagina' => 'INICIAÇÃO CIENTÍFICA',
            'campus'=> $listagemDosCampus,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }
    
  public function lista_informacoes_comite_etica($uriCampus=NULL) 
  {
    verificaLogin();

    $pagina = 'pesquisaComiteEticaPesquisa';
    $verificaExistePaginaComiteEticaPesquisa = $this->painelbd->where('*','pages',null,array('pages.campusid'=>$uriCampus,'pages.title'=> $pagina))->row();
    
  
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
      
     
      $whereContatosPagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id,'page_contents.order'=>'contatos');
      $contatosPaginaComiteEticaPesquisa = $this->painelbd->where($colunaResultadoContatoPagina,'page_contents',$joinContatoPagina, $whereContatosPagina,null)->result();
      
      $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/itens_iniciacao/comite_etica_pesquisa/lista_informacoes_comite_etica',
        'dados' => array(
         // 'conteudosPaginaComiteEticaPesquisa'=>$listaInformmacoesPaginaComiteEticaPesquisa,
          'page' => "Informações do Comitê de Ética em Pesquisa - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'contatosPaginaComiteEticaPesquisa'=>$contatosPaginaComiteEticaPesquisa,
          'campus'=>$campus,
          'paginaComiteEticaPesquisa'=> $verificaExistePaginaComiteEticaPesquisa = isset($verificaExistePaginaComiteEticaPesquisa) ? $verificaExistePaginaComiteEticaPesquisa : '',
          'tipo'=>''
        )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_pagina_comite_etica($uriCampus=NULL)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $verificaExistePagina = $this->painelbd->where('*','pages',null, array('pages.title'=>'pesquisaComiteEticaPesquisa','pages.campusid'=>$campus->id))->row();

    $this->form_validation->set_rules('status', 'Situação', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {
      
      $dados_form['title'] = 'pesquisaComiteEticaPesquisa';
      $dados_form['status'] = $this->input->post('status');
      $dados_form['campusid'] = $campus->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if(isset($verificaExistePagina)){
        $dados_form['id'] = $verificaExistePagina->id;
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE){
          setMsg('<p>Dados da página (menu) Comitê de Ética em Pesquisa (CEP) atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_comite/cadastrar_pagina_comite_etica/$campus->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }else{
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE){
          setMsg('<p>Dados da página (menu) Iniciacao Cientifica cadastra com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_comite/cadastrar_pagina_comite_etica/$campus->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/comite_etica_pesquisa/pagina_menu_comite_etica/cadastrar_pagina_comite_etica',
      'dados' => array(
        'paginaComiteEtica'=>$verificaExistePagina = isset($verificaExistePagina) ? $verificaExistePagina : '',
        'page' => "Cadastro de pagina (menu do site) do PESQUISA - Comitê de Ètica em Pesquisa - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }
    
  public function cadastrar_contato_pagina_comite_etica($uriCampus=NULL,$pageId = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId,);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadContatoPaginaComiteEtica = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description', 
      'page_contents.order', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoContatoPaginaComiteEtica = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereContatoPaginaComiteEtica = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.order'=>'contatos'
    );

    $contatoPaginaComiteEtica = $this->painelbd->where($colunaResultadContatoPaginaComiteEtica,'page_contents',$joinConteudoContatoPaginaComiteEtica, $whereContatoPaginaComiteEtica)->row();
    
    $this->form_validation->set_rules('description', 'Informações de contato', 'required'); 
    $this->form_validation->set_rules('status', 'Situação', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {
      
      $dados_form['title'] = "Contatos Comitê Etica";
      $dados_form['status'] = $this->input->post('status');
      $dados_form['description'] = $this->input->post('description');
      $dados_form['order'] = 'contatos';
      $dados_form['pages_id'] = $pagina->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if(isset($contatoPaginaComiteEtica)){
        $dados_form['id'] = $contatoPaginaComiteEtica->id;
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados da página (menu) Comitê Ética em Pesquisa atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_comite/cadastrar_contato_pagina_comite_etica/$campus->id/$pagina->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }else{
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados de contato cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_comite/cadastrar_contato_pagina_comite_etica/$campus->id/$pagina->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/comite_etica_pesquisa/contatos/cadastrar_contato_pagina_comite_etica',
      'dados' => array(
        'tituloPagina' => "Informações de contato página Comitê Ética Pesquisa - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'contatoPaginaComiteEtica' => $contatoPaginaComiteEtica = isset($contatoPaginaComiteEtica) ? $contatoPaginaComiteEtica : '',
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_atendimento_pagina_comite_etica($uriCampus=NULL,$pageId = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoAtendimentoPaginaComiteEtica = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description', 
      'page_contents.order', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoatendimentoPaginaComiteEtica = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereatendimentoPaginaIniciacaoCientifica = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.order'=>'atendimento'
    );

    $atendimentoPaginaComiteEtica = $this->painelbd->where($colunaResultadoAtendimentoPaginaComiteEtica,'page_contents',$joinConteudoatendimentoPaginaComiteEtica, $whereatendimentoPaginaIniciacaoCientifica)->row();
    
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

      if(isset($atendimentoPaginaComiteEtica)){
        $dados_form['id'] = $atendimentoPaginaComiteEtica->id;
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados de Atendimento atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_comite/cadastrar_atendimento_pagina_comite_etica/$campus->id/$pagina->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }else{
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados de Atendimento cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_comite/cadastrar_atendimento_pagina_comite_etica/$campus->id/$pagina->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/comite_etica_pesquisa/contatos/cadastrar_atendimento_pagina_comite_etica',
      'dados' => array(
        'tituloPagina' => "Informações de atendimento página Comitê de Ética em Pesquisa - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'atendimentoPaginaComiteEtica' => $atendimentoPaginaComiteEtica = isset($atendimentoPaginaComiteEtica) ? $atendimentoPaginaComiteEtica : '',
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_links_uteis_pagina_comite_etica($uriCampus=NULL,$pageId = null)
  {
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoLinksUteisPaginaComiteEtica = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description', 
      'page_contents.link_redir', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoLinksUteisPaginaComiteEtica = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereLinksUteisPaginaComiteEtica = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.order'=>'linksUteis'
    );

    $listaLinksUteisPaginaComiteEtica = $this->painelbd->where($colunaResultadoLinksUteisPaginaComiteEtica,'page_contents',$joinConteudoLinksUteisPaginaComiteEtica, $whereLinksUteisPaginaComiteEtica,array('campo' => 'title', 'ordem' => 'asc'))->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/comite_etica_pesquisa/links_uteis/lista_links_uteis_pagina_comite_etica',
      'dados' => array(
        'tituloPagina' => "Lista de Links Úteis página Iniciação Científica - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaLinksUteisPaginaComiteEtica' => $listaLinksUteisPaginaComiteEtica = isset($listaLinksUteisPaginaComiteEtica) ? $listaLinksUteisPaginaComiteEtica : '',
        'campus'=>$campus,
        'tipo'=>'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_links_uteis_pagina_comite_etica($uriCampus=NULL,$pageId = null)
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
        redirect(base_url("Painel_pesquisa_comite/lista_links_uteis_pagina_comite_etica/$campus->id/$pagina->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
     
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/comite_etica_pesquisa/links_uteis/cadastrar_links_uteis_pagina_comite_etica',
      'dados' => array(
        'tituloPagina' => "Cadastro de Link Útil: Comitê de Ética em Pesquisa - <strong><i> $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_links_uteis_pagina_comite_etica($uriCampus=NULL,$pageId = null,$idLink = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoLinksUteisPaginaComiteEtica = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.link_redir', 
      'page_contents.order', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoLinksUteisPaginaComiteEtica = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereLinksUteisPaginaComiteEtica = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.id'=>$idLink,
      'page_contents.order'=>'linksUteis'
    );

    $listaLinksUteisPaginaComiteEtica = $this->painelbd->where($colunaResultadoLinksUteisPaginaComiteEtica,'page_contents',$joinConteudoLinksUteisPaginaComiteEtica, $whereLinksUteisPaginaComiteEtica)->row();
    
    $this->form_validation->set_rules('link_redir', 'Por favor, insira o LINK ', 'required'); 
    $this->form_validation->set_rules('status', 'Situação', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {

      if($listaLinksUteisPaginaComiteEtica->title !== $this->input->post('title')){
        $dados_form['title'] = $this->input->post('title');
      }
      if($listaLinksUteisPaginaComiteEtica->status !== $this->input->post('status')){
        $dados_form['status'] = $this->input->post('status');
      }
      if($listaLinksUteisPaginaComiteEtica->link_redir !== $this->input->post('link_redir')){
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }
      $dados_form['id'] = $listaLinksUteisPaginaComiteEtica->id;
      $dados_form['order'] = 'linksUteis';
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
        setMsg('<p>Link Útil atualizado com sucesso.</p>', 'success');
        redirect(base_url("Painel_pesquisa_comite/lista_links_uteis_pagina_comite_etica/$campus->id/$pagina->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/comite_etica_pesquisa/links_uteis/editar_links_uteis_pagina_comite_etica',
      'dados' => array(
        'tituloPagina' => "Edição de Link Útil: Comitê de Ética em Pesquisa - <strong><i> $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaLinksUteisPaginaComiteEtica' => $listaLinksUteisPaginaComiteEtica,
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_links_uteis_comite($uriCampus=NULL, $pagina = null,$id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_pesquisa_comite/lista_links_uteis_pagina_comite_etica/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_pesquisa_comite/lista_links_uteis_pagina_comite_etica/$uriCampus/$pagina");
    }
  }

  public function lista_itens_comite_etica($uriCampus=NULL,$pageId = null)
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
      'conteudo' => 'paineladm/itens_iniciacao/comite_etica_pesquisa/informacoes_comite/lista_itens_comite_etica',
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
  
  public function cadastrar_itens_comite_etica($uriCampus=NULL, $pageId = null) {
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
          setMsg('<p>Dados do Comitê de Ética em Pesquisa cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_comite/lista_itens_comite_etica/$campus->id/$pagina->id"));
      }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/itens_iniciacao/comite_etica_pesquisa/informacoes_comite/cadastrar_itens_comite_etica',
        'dados' => array(
            'conteudosPagina'=>'',
            'page' => "Cadastro de informações COMITÊ ÉTICA EM PESQUISA - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'pagina'=>$pagina,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_itens_comite_pesquisa($uriCampus=NULL, $pageId = null, $idInformacao = null) {
    verificaLogin();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunaResultadPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    
    $informacoesComite = $this->painelbd->where("*",'page_contents',null, array('page_contents.id'=>$idInformacao))->row();

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
      $dados_form['id'] = $informacoesComite->id;
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      
      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados do COMITÊ DE ÉTICA EM PESQUISA editados com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_comite/lista_itens_comite_etica/$campus->id/$pagina->id"));
      }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/itens_iniciacao/comite_etica_pesquisa/informacoes_comite/editar_itens_comite_pesquisa',
        'dados' => array(
            'informacoesComite'=> $informacoesComite,
            'page' => "Edição de informações Comitê de Ètica em Pesquisa - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'pagina'=>$pagina,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_comite_etica($uriCampus=NULL, $pagina = null,$id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_pesquisa_comite/lista_itens_comite_etica/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_pesquisa_comite/lista_itens_comite_etica/$uriCampus/$pagina");
    }
  } 
  
}