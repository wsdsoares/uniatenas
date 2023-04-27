<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_pesquisa_revistas extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('painel_model', 'painelbd');
    date_default_timezone_set('America/Sao_Paulo');
  }

  public function lista_campus_revistas() {
    verificaLogin();

    $colunasCampus = 
      array('campus.id',
      'campus.name',
      'campus.city',
      'campus.uf'
    );

    $listagemDosCampus = $this->painelbd->where($colunasCampus,'campus',NULL, array('visible' => 'SIM'))->result();
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/lista_campus_revistas',
      'dados' => array(
        'page' => "Informações Menu (PESQUISA >> Revistas)",
        'campus'=> $listagemDosCampus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_informacoes_revistas($uriCampus=NULL) {
    verificaLogin();

    $pagina = 'revistas';
    $verificaExistePaginaRevistas = $this->painelbd->where('*','pages',null,array('pages.campusid'=>$uriCampus,'pages.title'=> $pagina))->row();
  
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

  
      
      $listaInformmacoesPaginasRevistas =  $this->painelbd->getQuery(
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

      $data = array(
        'titulo' => 'Gestão de Revistas - Uniatenas',
        'conteudo' => 'paineladm/itens_iniciacao/revistas/lista_revistas',
        //'conteudo' => 'paineladm/financeiro/lista_informacoes_financeiro',
        'dados' => array(
          'conteudosPagina'=>$listaInformmacoesPaginasRevistas,
          'page' => "Cadastro de informações Revistas - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'campus'=>$campus,
          'paginaRevistas'=> $verificaExistePaginaRevistas = isset($verificaExistePaginaRevistas) ? $verifverificaExistePaginaRevistasicaExistePaginaFinanceiro : '',
          'tipo'=>''
        )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }

  public function cadastrar_pagina_tcc($uriCampus=NULL)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $verificaExistePagina = $this->painelbd->where('*','pages',null, array('pages.title'=>'pesquisaTcc','pages.campusid'=>$campus->id))->row();

    $this->form_validation->set_rules('status', 'Situação', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {
      
      $dados_form['title'] = 'pesquisaTcc';
      $dados_form['status'] = $this->input->post('status');
      $dados_form['campusid'] = $campus->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if(isset($verificaExistePagina)){
        $dados_form['id'] = $verificaExistePagina->id;
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE){
          setMsg('<p>Dados da página (menu) Comitê de Ética em Pesquisa (CEP) atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_tcc/cadastrar_pagina_tcc/$campus->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }else{
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE){
          setMsg('<p>Dados da página (menu) Iniciacao Cientifica cadastra com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_tcc/cadastrar_pagina_tcc/$campus->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/tcc/trabalho/pagina_menu_tcc/cadastrar_pagina_tcc',
      'dados' => array(
        'paginaComiteEtica'=>$verificaExistePagina = isset($verificaExistePagina) ? $verificaExistePagina : '',
        'page' => "Cadastro de pagina (menu do site) do PESQUISA - Trabalho de Conclusão de Curso - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }
    
  public function cadastrar_contato_pagina_tcc($uriCampus=NULL,$pageId = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId,);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadContatoPaginaTcc = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description', 
      'page_contents.order', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoContatoPaginaTcc = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereContatoPaginaTcc = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.order'=>'contatos'
    );

    $contatoPaginaTcc = $this->painelbd->where($colunaResultadContatoPaginaTcc,'page_contents',$joinConteudoContatoPaginaTcc, $whereContatoPaginaTcc)->row();
    
    $this->form_validation->set_rules('description', 'Informações de contato', 'required'); 
    $this->form_validation->set_rules('status', 'Situação', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {
      
      $dados_form['title'] = "Contatos";
      $dados_form['status'] = $this->input->post('status');
      $dados_form['description'] = $this->input->post('description');
      $dados_form['order'] = 'contatos';
      $dados_form['pages_id'] = $pagina->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if(isset($contatoPaginaTcc)){
        $dados_form['id'] = $contatoPaginaTcc->id;
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados da página (menu) Trabalho de Conclusão de Curso atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_tcc/cadastrar_contato_pagina_tcc/$campus->id/$pagina->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }else{
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados de contato cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_tcc/cadastrar_contato_pagina_tcc/$campus->id/$pagina->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/tcc/trabalho/contatos/cadastrar_contato_pagina_tcc',
      'dados' => array(
        'tituloPagina' => "Informações de contato página Trabalho de Conclusão de Curso - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'contatoPaginaTcc' => $contatoPaginaTcc = isset($contatoPaginaTcc) ? $contatoPaginaTcc : '',
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_atendimento_pagina_tcc($uriCampus=NULL,$pageId = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoAtendimentoPaginaTcc = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description', 
      'page_contents.order', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoatendimentoPaginaTcc = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereatendimentoPaginaTcc = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.order'=>'atendimento'
    );

    $atendimentoPaginaTcc = $this->painelbd->where($colunaResultadoAtendimentoPaginaTcc,'page_contents',$joinConteudoatendimentoPaginaTcc, $whereatendimentoPaginaTcc)->row();
    
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

      if(isset($atendimentoPaginaTcc)){
        $dados_form['id'] = $atendimentoPaginaTcc->id;
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados de Atendimento atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_tcc/cadastrar_atendimento_pagina_tcc/$campus->id/$pagina->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }else{
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados de Atendimento cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_tcc/cadastrar_atendimento_pagina_tcc/$campus->id/$pagina->id"));
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/tcc/trabalho/contatos/cadastrar_atendimento_pagina_tcc',
      'dados' => array(
        'tituloPagina' => "Informações de atendimento página Trabalho de Conclusão de Curso - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'atendimentoPaginaTcc' => $atendimentoPaginaTcc = isset($atendimentoPaginaTcc) ? $atendimentoPaginaTcc : '',
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_links_uteis_pagina_tcc($uriCampus=NULL,$pageId = null)
  {
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoLinksUteisPaginaTcc = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description', 
      'page_contents.link_redir', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoLinksUteisPaginaTcc = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereLinksUteisPaginaTcc = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.order'=>'linksUteis'
    );

    $listaLinksUteisPaginaTcc = $this->painelbd->where($colunaResultadoLinksUteisPaginaTcc,'page_contents',$joinConteudoLinksUteisPaginaTcc, $whereLinksUteisPaginaTcc,array('campo' => 'title', 'ordem' => 'asc'))->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/tcc/trabalho/links_uteis/lista_links_uteis_pagina_tcc',
      'dados' => array(
        'tituloPagina' => "Lista <u>Links Úteis</u> página Trabalho de Conclusão de Curso- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaLinksUteisPaginaTcc' => $listaLinksUteisPaginaTcc = isset($listaLinksUteisPaginaTcc) ? $listaLinksUteisPaginaTcc : '',
        'campus'=>$campus,
        'tipo'=>'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_links_uteis_pagina_tcc($uriCampus=NULL,$pageId = null)
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
        redirect(base_url("Painel_pesquisa_tcc/lista_links_uteis_pagina_tcc/$campus->id/$pagina->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
     
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/tcc/trabalho/links_uteis/cadastrar_links_uteis_pagina_tcc',
      'dados' => array(
        'tituloPagina' => "Cadastro de Link Útil: Trabalho de Conclusão de Curso - <strong><i> $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_links_uteis_pagina_tcc($uriCampus=NULL,$pageId = null,$idLink = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoLinksUteisPaginaTcc = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.link_redir', 
      'page_contents.order', 
      'page_contents.created_at', 
      'page_contents.updated_at', 
      'page_contents.user_id', 
    );
    $joinConteudoLinksUteisPaginaTcc = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereLinksUteisPaginaTcc = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.id'=>$idLink,
      'page_contents.order'=>'linksUteis'
    );

    $listaLinksUteisPaginaTcc = $this->painelbd->where($colunaResultadoLinksUteisPaginaTcc,'page_contents',$joinConteudoLinksUteisPaginaTcc, $whereLinksUteisPaginaTcc)->row();
    
    $this->form_validation->set_rules('link_redir', 'Por favor, insira o LINK ', 'required'); 
    $this->form_validation->set_rules('status', 'Situação', 'required'); 

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {

      if($listaLinksUteisPaginaTcc->title !== $this->input->post('title')){
        $dados_form['title'] = $this->input->post('title');
      }
      if($listaLinksUteisPaginaTcc->status !== $this->input->post('status')){
        $dados_form['status'] = $this->input->post('status');
      }
      if($listaLinksUteisPaginaTcc->link_redir !== $this->input->post('link_redir')){
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }
      $dados_form['id'] = $listaLinksUteisPaginaTcc->id;
      $dados_form['order'] = 'linksUteis';
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
        setMsg('<p>Link Útil atualizado com sucesso.</p>', 'success');
        redirect(base_url("Painel_pesquisa_tcc/lista_links_uteis_pagina_tcc/$campus->id/$pagina->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/tcc/trabalho/links_uteis/editar_links_uteis_pagina_tcc',
      'dados' => array(
        'tituloPagina' => "Edição de Link Útil: Trabalho de Conclusão de Curso - <strong><i> $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaLinksUteisPaginaTcc' => $listaLinksUteisPaginaTcc,
        'campus'=>$campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_links_uteis_tcc($uriCampus=NULL, $pagina = null,$id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_pesquisa_tcc/lista_links_uteis_pagina_tcc/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_pesquisa_tcc/lista_links_uteis_pagina_tcc/$uriCampus/$pagina");
    }
  }

  public function lista_itens_tcc($uriCampus=NULL,$pageId = null)
  {
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoInformacoesPaginaTcc = array(
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
    $joinConteudoInformacoesPaginaTcc = array(
      'pages'=>'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereInformacoesPaginaTcc = array(
      'page_contents.pages_id'=>$pagina->id,
      'page_contents.tipo'=>'informacoesPagina'
    );

    $listaInformacoesPaginaTcc = $this->painelbd->where($colunaResultadoInformacoesPaginaTcc,'page_contents',$joinConteudoInformacoesPaginaTcc, $whereInformacoesPaginaTcc,array('campo' => 'title', 'ordem' => 'asc'))->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/itens_iniciacao/tcc/trabalho/informacoes_tcc/lista_itens_tcc',
      'dados' => array(
        'tituloPagina' => "Informações da página Trabalho de Conclusão de Curso - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaInformacoesPaginaTcc' => $listaInformacoesPaginaTcc = isset($listaInformacoesPaginaTcc) ? $listaInformacoesPaginaTcc : '',
        'campus'=>$campus,
        'tipo'=>'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }
  
  public function cadastrar_itens_tcc($uriCampus=NULL, $pageId = null) {
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
          setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_tcc/lista_itens_tcc/$campus->id/$pagina->id"));
      }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/itens_iniciacao/tcc/trabalho/informacoes_tcc/cadastrar_itens_tcc',
        'dados' => array(
            'conteudosPagina'=>'',
            'page' => "Cadastro de informações TRABALHO DE CONCLUSÃO DE CURSO - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'pagina'=>$pagina,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_itens_tcc($uriCampus=NULL, $pageId = null, $idInformacao = null) {
    verificaLogin();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunaResultadPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $informacoesTcc = $this->painelbd->where("*",'page_contents',null, array('page_contents.id'=>$idInformacao))->row();

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
      if( $informacoesTcc->description !== $this->input->post('description') and !empty ($this->input->post('description'))){
        $dados_form['description'] = $this->input->post('description');
      }
      if($informacoesTcc->description !== $this->input->post('description') and  !empty ($this->input->post('title_short'))){
        $dados_form['title_short'] = $this->input->post('title_short');
      }
      if($informacoesTcc->title !== $this->input->post('title') and !empty ($this->input->post('title'))){
        $dados_form['title'] = $this->input->post('title');
      }
      if($informacoesTcc->status !== $this->input->post('status')){
        $dados_form['status'] = $this->input->post('status');
      }
      if($informacoesTcc->order !== $this->input->post('order')){
        $dados_form['order'] = $this->input->post('order');
      }
            
      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['id'] = $informacoesTcc->id;
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      
      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
          setMsg('<p>Dados editados com sucesso.</p>', 'success');
          redirect(base_url("Painel_pesquisa_tcc/lista_itens_tcc/$campus->id/$pagina->id"));
      }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/itens_iniciacao/tcc/trabalho/informacoes_tcc/editar_itens_tcc',
        'dados' => array(
            'informacoesTcc'=> $informacoesTcc,
            'page' => "Edição de informações Trabalho de Conclusão de Curso - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'pagina'=>$pagina,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_tcc($uriCampus=NULL, $pagina = null,$id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_pesquisa_tcc/lista_itens_tcc/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_pesquisa_tcc/lista_itens_tcc/$uriCampus/$pagina");
    }
  } 
}