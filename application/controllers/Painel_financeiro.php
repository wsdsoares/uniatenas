<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_financeiro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('painel_model', 'painelbd');
        date_default_timezone_set('America/Sao_Paulo');
    }
    
    public function lista_campus_financeiro() {
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
            'conteudo' => 'paineladm/financeiro/lista_campus_financeiro',
            'dados' => array(
                'page' => "Informações Financeiro",
                'campus'=> $listagemDosCampus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_informacoes_financeiro($uriCampus=NULL) {
    verificaLogin();

      $pagina = 'financeiro';
      $verificaExistePaginaFinanceiro = $this->painelbd->where('*','pages',null,array('pages.campusid'=>$uriCampus,'pages.title'=> $pagina))->row();
    
      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
      
      // $wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

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
      
      //$listaInformmacoesPaginasFinanceiro = $this->painelbd->where($colunaResultadPagina,'page_contents',$joinContatoPagina, $wherePagina,null)->result();

      $listaInformmacoesPaginasFinanceiro =  $this->painelbd->getQuery(
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
      $contatosPaginaFinanceiro = $this->painelbd->where($colunaResultadoContatoPagina,'page_contents',$joinContatoPagina, $whereContatosPagina,null)->result();

      $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/financeiro/lista_informacoes_financeiro',
        'dados' => array(
          'conteudosPagina'=>$listaInformmacoesPaginasFinanceiro,
          'contatosPaginaFinanceiro'=>$contatosPaginaFinanceiro,
          'page' => "Cadastro de informações do Financeiro - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'campus'=>$campus,
          'paginaFinanceiro'=> $verificaExistePaginaFinanceiro = isset($verificaExistePaginaFinanceiro) ? $verificaExistePaginaFinanceiro : '',
          'tipo'=>''
        )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }
    public function cadastrar_contato_pagina_financeiro($uriCampus=NULL,$pageId = null)
    {
      verifica_login();
  
      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

      $colunaResultadPagina = array('pages.id','pages.title','pages.status',);
      $joinPagina = array('campus' => 'campus.id= pages.campusid');
      $wherePagina = array('pages.id'=>$pageId,);
      $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

      $colunaResultadContatoPaginaFinanceiro = array(
        'page_contents.id',
        'page_contents.title',
        'page_contents.status',
        'page_contents.description', 
        'page_contents.order', 
        'page_contents.created_at', 
        'page_contents.updated_at', 
        'page_contents.user_id', 
      );
      $joinConteudoContatoPaginaFinanceiro = array(
        'pages'=>'pages.id = page_contents.pages_id',
        'campus' => 'campus.id= pages.campusid'
      );
      $whereContatoPaginaFinanceiro = array(
        'page_contents.pages_id'=>$pagina->id,
        'page_contents.order'=>'contatos'
      );

      $contatoPaginaFinanceiro = $this->painelbd->where($colunaResultadContatoPaginaFinanceiro,'page_contents',$joinConteudoContatoPaginaFinanceiro, $whereContatoPaginaFinanceiro)->row();
      
      $this->form_validation->set_rules('description', 'Informações de contato', 'required'); 
      $this->form_validation->set_rules('status', 'Situação', 'required'); 

      if ($this->form_validation->run() == FALSE) {
          if (validation_errors()):
              setMsg(validation_errors(), 'error');
          endif;
      }else {
        
        $dados_form['title'] = "Contatos ".$this->input->post('title');
        $dados_form['status'] = $this->input->post('status');
        $dados_form['description'] = $this->input->post('description');
        $dados_form['order'] = 'contatos';
        $dados_form['pages_id'] = $pagina->id;

        $dados_form['user_id'] = $this->session->userdata('codusuario');

        if(isset($contatoPaginaFinanceiro)){
          $dados_form['id'] = $contatoPaginaFinanceiro->id;
          if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
            setMsg('<p>Dados da página (menu) financeiro atualizado com sucesso.</p>', 'success');
            redirect(base_url("Painel_financeiro/cadastrar_contato_pagina_financeiro/$campus->id/$pagina->id"));
          }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }else{
          if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
            setMsg('<p>Dados de contato cadastrado com sucesso.</p>', 'success');
            redirect(base_url("Painel_financeiro/cadastrar_contato_pagina_financeiro/$campus->id/$pagina->id"));
          }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }
      }

      $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/financeiro/contatos/cadastrar_contato_pagina_financeiro',
        'dados' => array(
          'tituloPagina' => "Informações de contato página Financeiro - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'pagina'=>$pagina,
          'contatoPaginaFinanceiro' => $contatoPaginaFinanceiro = isset($contatoPaginaFinanceiro) ? $contatoPaginaFinanceiro : '',
          'campus'=>$campus,
          'tipo'=>''
        )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_pagina_financeiro($uriCampus=NULL)
    {
      verifica_login();
  
      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

      $verificaExistePagina = $this->painelbd->where('*','pages',null, array('pages.title'=>'financeiro','pages.campusid'=>$campus->id))->row();

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
            setMsg('<p>Dados da página (menu) financeiro atualizado com sucesso.</p>', 'success');
            redirect(base_url("Painel_financeiro/cadastrar_pagina_financeiro/$campus->id"));
          }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }else{
          if ($this->painelbd->salvar('pages', $dados_form) == TRUE){
            setMsg('<p>Dados da página (menu) financeiro cadastra com sucesso.</p>', 'success');
            redirect(base_url("Painel_financeiro/cadastrar_pagina_financeiro/$campus->id"));
          }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }
      }

      $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/financeiro/pagina_menu_financeiro/cadastrar_pagina_financeiro',
        'dados' => array(
          'paginaFinanceiro'=>$verificaExistePagina = isset($verificaExistePagina) ? $verificaExistePagina : '',
          'page' => "Cadastro de pagina (menu do site) do Financeiro - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'campus'=>$campus,
          'tipo'=>''
        )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_informacoes_financeiro($uriCampus=NULL) {
        verificaLogin();

        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $pagina = 'financeiro';
        $wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

        $colunasTabelaPages = array('pages.id','pages.title');
        $joinConteudoPagina = array('campus' => 'campus.id= pages.campusid');
        
        $listaItemPages = $this->painelbd->where($colunasTabelaPages,'pages',$joinConteudoPagina, $wherePagina,null)->row();

        if(!isset($listaItemPages)){
          redirect(base_url("Painel_financeiro/lista_informacoes_financeiro/$campus->id"));
        }

        //Validaçãoes via Form Validation
        $this->form_validation->set_rules('title', 'Titulo', 'required');
        $this->form_validation->set_rules('description', 'Descrição', 'required');
        $this->form_validation->set_rules('status', 'Situação', 'required');
        $this->form_validation->set_rules('order', 'Ordem', 'required');

        if ($this->form_validation->run() == FALSE) {
           if (validation_errors()):
               setMsg(validation_errors(), 'error');
           endif;
        }else {
          
          $path = "assets/images/financing/$campus->id";
          is_way($path);

          $upload = $this->painelbd->uploadFiles('img_destaque', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

          $dados_form['img_destaque'] = $path . '/' . $upload['file_name'];
          $dados_form['description'] = $this->input->post('description');
          $dados_form['link_redir'] = $this->input->post('link_redir');
          $dados_form['title'] = $this->input->post('title');
          $dados_form['status'] = $this->input->post('status');
          $dados_form['order'] = $this->input->post('order');
          $dados_form['pages_id'] = $listaItemPages->id;
          $dados_form['user_id'] = $this->session->userdata('codusuario');
  
          if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
              setMsg('<p>Dados do financeiro cadastrado com sucesso.</p>', 'success');
              redirect(base_url("Painel_financeiro/lista_informacoes_financeiro/$campus->id"));
          }else{
              setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/financeiro/cadastrar_informacoes_financeiro',
            'dados' => array(
                'conteudosPagina'=>'',
                'page' => "Cadastro de informações do Financeiro - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_informacoes_financeiro($uriCampus=NULL,$itemId=null) {
      verificaLogin();

      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
      
      $pagina = 'financeiro';
      //$wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

      $colunasTabelaPagesFinanceiro = array('page_contents.id','page_contents.title','page_contents.description','page_contents.order','page_contents.img_destaque','page_contents.link_redir','page_contents.status');
      $joinConteudoPagina = array('pages' => 'pages.id = page_contents.pages_id');
      $wherePaginaFinanceiro = array('page_contents.id'=>$itemId);

      $paginaFinanceiro = $this->painelbd->where($colunasTabelaPagesFinanceiro,'page_contents',$joinConteudoPagina, $wherePaginaFinanceiro,null)->row();
      
      $this->form_validation->set_rules('title', 'Titulo', 'required');
      $this->form_validation->set_rules('description', 'Descrição', 'required');
      $this->form_validation->set_rules('status', 'Situação', 'required');
      $this->form_validation->set_rules('order', 'Ordem', 'required');

      if ($this->form_validation->run() == FALSE) {
         if (validation_errors()):
             setMsg(validation_errors(), 'error');
         endif;
      }else {
        
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



        echo '<br>';
      
        echo '</br>';
        echo '<pre>';
        print_r($dados_form);
        echo '</pre>';
        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
            setMsg('<p>Dados do financeiro cadastrado com sucesso.</p>', 'success');
            redirect(base_url("Painel_financeiro/lista_informacoes_financeiro/$campus->id"));
        }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }

      $data = array(
          'titulo' => 'UniAtenas',
          'conteudo' => 'paineladm/financeiro/editar_informacoes_financeiro',
          'dados' => array(
              'paginaFinanceiro'=>$paginaFinanceiro,
              'page' => "Edição de informações do Financeiro - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
              'campus'=>$campus,
              'tipo'=>''
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_item_financeiro($uriCampus=NULL,$id = NULL)
    {
        verifica_login();
    
        $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

        if ($this->painelbd->deletar('page_contents', $item->id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect("Painel_financeiro/lista_informacoes_financeiro/$uriCampus");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_financeiro/lista_informacoes_financeiro/$uriCampus");
        }
    }
}