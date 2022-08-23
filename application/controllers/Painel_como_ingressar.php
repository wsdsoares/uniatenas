<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_como_ingressar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('painel_model', 'painelbd');
        date_default_timezone_set('America/Sao_Paulo');
    }
    
    public function lista_campus_como_ingressar() {
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
            'conteudo' => 'paineladm/comoIngressar/lista_campus_como_ingressar',
            'dados' => array(
                'page' => "Informações Formas de Ingresso - Como ingressar",
                'campus'=> $listagemDosCampus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_informacoes_como_ingressar($uriCampus=NULL) {
    verificaLogin();

      $pagina = 'comoingressar';
      $verificaExistePaginaComoIngressar = $this->painelbd->where('*','pages',null,array('pages.campusid'=>$uriCampus,'pages.title'=> $pagina))->row();
    
      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
          
      $colunaResultadoPaginaComoIngressar = array(
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
      $joinPaginaComoIngressar = array(
        'pages'=>'pages.id = page_contents.pages_id',
        'campus' => 'campus.id= pages.campusid'
      );

      $wherePaginaComoIngressar = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);
      
      $listaInformmacoesPaginaComoIngressar = $this->painelbd->where($colunaResultadoPaginaComoIngressar,'page_contents',$joinPaginaComoIngressar, $wherePaginaComoIngressar,array('campo' => 'page_contents.order', 'ordem' => 'asc'))->result();

      $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/comoIngressar/lista_informacoes_como_ingressar',
        'dados' => array(
          'conteudosPagina'=>$listaInformmacoesPaginaComoIngressar,
          'page' => "Cadastro de informações: Formas de ingresso - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'campus'=>$campus,
          'paginaComoIngressar'=> $verificaExistePaginaComoIngressar = isset($verificaExistePaginaComoIngressar) ? $verificaExistePaginaComoIngressar : '',
          'tipo'=>'tabelaDatatable'
        )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_pagina_como_ingressar($uriCampus=NULL)
    {
      verifica_login();
  
      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

      $verificaExistePagina = $this->painelbd->where('*','pages',null, array('pages.title'=>'comoingressar','pages.campusid'=>$campus->id))->row();

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
            setMsg('<p>Dados da página (menu) como_ingressar atualizado com sucesso.</p>', 'success');
            redirect(base_url("Painel_como_ingressar/cadastrar_pagina_como_ingressar/$campus->id"));
          }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }else{
          if ($this->painelbd->salvar('pages', $dados_form) == TRUE){
            setMsg('<p>Dados da página (menu) como_ingressar cadastra com sucesso.</p>', 'success');
            redirect(base_url("Painel_como_ingressar/cadastrar_pagina_como_ingressar/$campus->id"));
          }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }
      }

      $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/como_ingressar/pagina_menu_como_ingressar/cadastrar_pagina_como_ingressar',
        'dados' => array(
          'paginacomo_ingressar'=>$verificaExistePagina = isset($verificaExistePagina) ? $verificaExistePagina : '',
          'page' => "Cadastro de pagina (menu do site) do como_ingressar - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'campus'=>$campus,
          'tipo'=>''
        )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_informacoes_como_ingressar($uriCampus=NULL) {
        verificaLogin();

        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $pagina = 'comoingressar';
        $wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

        $colunasTabelaPages = array('pages.id','pages.title');
        $joinConteudoPagina = array('campus' => 'campus.id = pages.campusid');
        
        $listaItemPages = $this->painelbd->where($colunasTabelaPages,'pages',$joinConteudoPagina, $wherePagina,null)->row();

        if(!isset($listaItemPages)){
          redirect(base_url("Painel_como_ingressar/lista_informacoes_como_ingressar/$campus->id"));
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
          
          $path = "assets/images/howtojoin/$campus->id";
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
          $dados_form['title_short'] = noAccentuation(strtolower($dados_form['title']));

          if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
            setMsg('<p>Dados de "como ingressar" cadastrado com sucesso.</p>', 'success');
            redirect(base_url("Painel_como_ingressar/lista_informacoes_como_ingressar/$campus->id"));
          }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/comoIngressar/cadastrar_informacoes_como_ingressar',
            'dados' => array(
                'conteudosPagina'=>'',
                'page' => "Cadastro de informações do como ingressar - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_informacoes_como_ingressar($uriCampus=NULL,$itemId=null) {
      verificaLogin();

      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
      
      $pagina = 'comoingressar';
      //$wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

      $colunasTabelaPagescomo_ingressar = array('page_contents.id','page_contents.title','page_contents.description','page_contents.order','page_contents.img_destaque','page_contents.link_redir','page_contents.status');
      $joinConteudoPagina = array('pages' => 'pages.id = page_contents.pages_id');
      $wherePaginacomo_ingressar = array('page_contents.id'=>$itemId);

      $paginacomo_ingressar = $this->painelbd->where($colunasTabelaPagescomo_ingressar,'page_contents',$joinConteudoPagina, $wherePaginacomo_ingressar,null)->row();
      
      $this->form_validation->set_rules('title', 'Titulo', 'required');
      $this->form_validation->set_rules('description', 'Descrição', 'required');
      $this->form_validation->set_rules('status', 'Situação', 'required');
      $this->form_validation->set_rules('order', 'Ordem', 'required');

      if ($this->form_validation->run() == FALSE) {
         if (validation_errors()):
             setMsg(validation_errors(), 'error');
         endif;
      }else {
        
        if ($paginacomo_ingressar->description != $this->input->post('description')) {
          $dados_form['description'] = $this->input->post('description');
        }

        if ($paginacomo_ingressar->link_redir != $this->input->post('link_redir')) {
          $dados_form['link_redir'] = $this->input->post('link_redir');
        }

        if ($paginacomo_ingressar->title != $this->input->post('title')) {
          $dados_form['title'] = $this->input->post('title');
        }

        if ($paginacomo_ingressar->status != $this->input->post('status')) {
          $dados_form['status'] = $this->input->post('status');
        }
        
        if ($paginacomo_ingressar->order != $this->input->post('order')) {
          $dados_form['order'] = $this->input->post('order');
        }
        if ($paginacomo_ingressar->title_short != noAccentuation(strtolower($dados_form['title']))){
          $dados_form['title_short'] = noAccentuation(strtolower($dados_form['title']));
        }

        if (isset($_FILES['img_destaque']) && !empty($_FILES['img_destaque']['name'])) {

          if (file_exists($paginacomo_ingressar->img_destaque)) {
            unlink($paginacomo_ingressar->img_destaque);
          }

          $path = "assets/images/howtojoin/$campus->id";
          is_way($path);

          $upload = $this->painelbd->uploadFiles('img_destaque', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

          $dados_form['img_destaque'] = $path . '/' . $upload['file_name'];
        }
        
        $dados_form['id'] = $paginacomo_ingressar->id;
        $dados_form['user_id'] = $this->session->userdata('codusuario');

        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
            setMsg('<p>Dados do como_ingressar cadastrado com sucesso.</p>', 'success');
            redirect(base_url("Painel_como_ingressar/lista_informacoes_como_ingressar/$campus->id"));
        }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }

      $data = array(
          'titulo' => 'UniAtenas',
          'conteudo' => 'paineladm/comoIngressar/editar_informacoes_como_ingressar',
          'dados' => array(
              'paginacomo_ingressar'=>$paginacomo_ingressar,
              'page' => "Edição de informações do como_ingressar - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
              'campus'=>$campus,
              'tipo'=>''
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_item_como_ingressar($uriCampus=NULL,$id = NULL)
    {
        verifica_login();
    
        $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 
        if (file_exists($item->img_destaque)) {
          unlink($item->img_destaque);
        } 

        if ($this->painelbd->deletar('page_contents', $item->id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect("Painel_como_ingressar/lista_informacoes_como_ingressar/$uriCampus");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_como_ingressar/lista_informacoes_como_ingressar/$uriCampus");
        }
    }
}