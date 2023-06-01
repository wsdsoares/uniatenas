<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_napp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('painel_model', 'painelbd');
        date_default_timezone_set('America/Sao_Paulo');
    }
    
    public function lista_campus_napp() {
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
            'conteudo' => 'paineladm/napp/lista_campus_napp',
            'dados' => array(
                'page' => "Informações NÚCLEO DE APOIO PSICOPEDAGÓGICO (NAPP) ",
                'campus'=> $listagemDosCampus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_informacoes_napp($uriCampus=NULL) {
    verificaLogin();

    $pagina = 'napp';
    $verificaExistePaginaNapp = $this->painelbd->where('*','pages',null,array('pages.campusid'=>$uriCampus,'pages.title'=> $pagina))->row();
  
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
      
      $listaInformmacoesPaginasNapp =  $this->painelbd->getQuery(
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
      $contatosPaginaNapp = $this->painelbd->where($colunaResultadoContatoPagina,'page_contents',$joinContatoPagina, $whereContatosPagina,null)->result();

      $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/napp/lista_informacoes_napp',
        'dados' => array(
          'conteudosPagina'=>$listaInformmacoesPaginasNapp,
          'contatosPaginaNapp'=>$contatosPaginaNapp,
          'page' => "Cadastro de informações do napp - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'campus'=>$campus,
          'paginaNapp'=> $verificaExistePaginaNapp = isset($verificaExistePaginaNapp) ? $verificaExistePaginaNapp : '',
          'tipo'=>''
        )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }
    
    public function cadastrar_contato_pagina_napp($uriCampus=NULL,$pageId = null)
    {
      verifica_login();
  
      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

      $colunaResultadPagina = array('pages.id','pages.title','pages.status',);
      $joinPagina = array('campus' => 'campus.id= pages.campusid');
      $wherePagina = array('pages.id'=>$pageId,);
      $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

      $colunaResultadContatoPaginaNapp = array(
        'page_contents.id',
        'page_contents.title',
        'page_contents.status',
        'page_contents.description', 
        'page_contents.order', 
        'page_contents.created_at', 
        'page_contents.updated_at', 
        'page_contents.user_id', 
      );
      $joinConteudoContatoPaginaNapp = array(
        'pages'=>'pages.id = page_contents.pages_id',
        'campus' => 'campus.id= pages.campusid'
      );
      $whereContatoPaginaNapp = array(
        'page_contents.pages_id'=>$pagina->id,
        'page_contents.order'=>'contatos'
      );

      $contatoPaginaNapp = $this->painelbd->where($colunaResultadContatoPaginaNapp,'page_contents',$joinConteudoContatoPaginaNapp, $whereContatoPaginaNapp)->row();
      
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

        if(isset($contatoPaginaNapp)){
          $dados_form['id'] = $contatoPaginaNapp->id;
          if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
            setMsg('<p>Dados da página (menu) napp atualizado com sucesso.</p>', 'success');
            redirect(base_url("Painel_napp/cadastrar_contato_pagina_napp/$campus->id/$pagina->id"));
          }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }else{
          if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
            setMsg('<p>Dados de contato cadastrado com sucesso.</p>', 'success');
            redirect(base_url("Painel_napp/cadastrar_contato_pagina_napp/$campus->id/$pagina->id"));
          }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }
      }

      $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/napp/contatos/cadastrar_contato_pagina_napp',
        'dados' => array(
          'tituloPagina' => "Informações de contato página napp - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'pagina'=>$pagina,
          'contatoPaginaNapp' => $contatoPaginaNapp = isset($contatoPaginaNapp) ? $contatoPaginaNapp : '',
          'campus'=>$campus,
          'tipo'=>''
        )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_pagina_napp($uriCampus=NULL)
    {
      verifica_login();
  
      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

      $verificaExistePagina = $this->painelbd->where('*','pages',null, array('pages.title'=>'napp','pages.campusid'=>$campus->id))->row();

      $this->form_validation->set_rules('status', 'Situação', 'required'); 

      if ($this->form_validation->run() == FALSE) {
          if (validation_errors()):
              setMsg(validation_errors(), 'error');
          endif;
      }else {
        
        $dados_form['title'] = 'napp';
        $dados_form['status'] = $this->input->post('status');
        $dados_form['campusid'] = $campus->id;

        $dados_form['user_id'] = $this->session->userdata('codusuario');

        if(isset($verificaExistePagina)){
          $dados_form['id'] = $verificaExistePagina->id;
          if ($this->painelbd->salvar('pages', $dados_form) == TRUE){
            setMsg('<p>Dados da página (menu) napp atualizado com sucesso.</p>', 'success');
            redirect(base_url("Painel_napp/cadastrar_pagina_napp/$campus->id"));
          }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }else{
          if ($this->painelbd->salvar('pages', $dados_form) == TRUE){
            setMsg('<p>Dados da página (menu) napp cadastrada com sucesso.</p>', 'success');
            redirect(base_url("Painel_napp/cadastrar_pagina_napp/$campus->id"));
          }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }
      }

      $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/napp/pagina_menu_napp/cadastrar_pagina_napp',
        'dados' => array(
          'paginaNapp'=>$verificaExistePagina = isset($verificaExistePagina) ? $verificaExistePagina : '',
          'page' => "Cadastro de pagina (menu do site) do napp - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'campus'=>$campus,
          'tipo'=>''
        )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_informacoes_napp($uriCampus=NULL) {
        verificaLogin();

        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $pagina = 'napp';
        $wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

        $colunasTabelaPages = array('pages.id','pages.title');
        $joinConteudoPagina = array('campus' => 'campus.id= pages.campusid');
        
        $listaItemPages = $this->painelbd->where($colunasTabelaPages,'pages',$joinConteudoPagina, $wherePagina,null)->row();

        if(!isset($listaItemPages)){
          redirect(base_url("Painel_napp/lista_informacoes_napp/$campus->id"));
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
          
          $path = "assets/images/napp/$campus->id";
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
              setMsg('<p>Dados do napp cadastrado com sucesso.</p>', 'success');
              redirect(base_url("Painel_napp/lista_informacoes_napp/$campus->id"));
          }else{
              setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/napp/cadastrar_informacoes_napp',
            'dados' => array(
                'conteudosPagina'=>'',
                'page' => "Cadastro de informações do napp - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_informacoes_napp($uriCampus=NULL,$itemId=null) {
      verificaLogin();

      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
      
      $pagina = 'napp';
      //$wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

      $colunasTabelaPagesnapp = array('page_contents.id','page_contents.title','page_contents.description','page_contents.order','page_contents.img_destaque','page_contents.link_redir','page_contents.status');
      $joinConteudoPagina = array('pages' => 'pages.id = page_contents.pages_id');
      
      $wherePaginaNapp = array('page_contents.id'=>$itemId);

      $paginaNapp = $this->painelbd->where($colunasTabelaPagesnapp,'page_contents',$joinConteudoPagina, $wherePaginaNapp,null)->row();
      
      $this->form_validation->set_rules('title', 'Titulo', 'required');
      $this->form_validation->set_rules('description', 'Descrição', 'required');
      $this->form_validation->set_rules('status', 'Situação', 'required');
      $this->form_validation->set_rules('order', 'Ordem', 'required');

      if ($this->form_validation->run() == FALSE) {
         if (validation_errors()):
             setMsg(validation_errors(), 'error');
         endif;
      }else {
        
        if ($paginaNapp->description != $this->input->post('description')) {
          $dados_form['description'] = $this->input->post('description');
        }

        if ($paginaNapp->link_redir != $this->input->post('link_redir')) {
          $dados_form['link_redir'] = $this->input->post('link_redir');
        }

        if ($paginaNapp->title != $this->input->post('title')) {
          $dados_form['title'] = $this->input->post('title');
        }

        if ($paginaNapp->status != $this->input->post('status')) {
          $dados_form['status'] = $this->input->post('status');
        }
        if ($paginaNapp->order != $this->input->post('order')) {
          $dados_form['order'] = $this->input->post('order');
        }


        if (isset($_FILES['img_destaque']) && !empty($_FILES['img_destaque']['name'])) {

          if (file_exists($paginaNapp->img_destaque)) {
            unlink($paginaNapp->img_destaque);
          }

          $path = "assets/images/napp/$campus->id";
          is_way($path);

          $upload = $this->painelbd->uploadFiles('img_destaque', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

          $dados_form['img_destaque'] = $path . '/' . $upload['file_name'];
        }
        
        $dados_form['id'] = $paginaNapp->id;
        $dados_form['user_id'] = $this->session->userdata('codusuario');

        if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
            setMsg('<p>Dados do napp cadastrado com sucesso.</p>', 'success');
            redirect(base_url("Painel_napp/lista_informacoes_napp/$campus->id"));
        }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }

      $data = array(
          'titulo' => 'UniAtenas',
          'conteudo' => 'paineladm/napp/editar_informacoes_napp',
          'dados' => array(
              'paginaNapp'=>$paginaNapp,
              'page' => "Edição de informações do napp - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
              'campus'=>$campus,
              'tipo'=>''
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_item_napp($uriCampus=NULL,$id = NULL)
    {
        verifica_login();
    
        $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

        if ($this->painelbd->deletar('page_contents', $item->id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect("Painel_napp/lista_informacoes_napp/$uriCampus");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_napp/lista_informacoes_napp/$uriCampus");
        }
    }
}