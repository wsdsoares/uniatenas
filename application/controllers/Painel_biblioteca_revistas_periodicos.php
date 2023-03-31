<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_biblioteca_revistas_periodicos extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('painel_model', 'painelbd');
    date_default_timezone_set('America/Sao_Paulo');
  }
  
  public function lista_itens_revista_periodicos($uriCampus=NULL,$pageId = null){

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();
 
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/link_revistas_periodicos/lista_itens_revista_periodicos',
      'dados' => array(
        //'page' => "Informações Biblioteca",
        'page' => "Informações Menu (BIBLIOTECA >> Revistas Periódicos) <strong><i>Campus - $campus->name ($campus->city) </i>",
        'pagina'=>$pagina,
        'campus'=> $campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
    
  }
  
  public function links_revistas_periodicos($campus = NULL) {
    // if($campus == null){
    //     redirect("");
    // }
    $areasLinks = $this->painelbd->getWhere('magazines_area', array('status' => 1))->result();
    $data = array(
        'head' => array(
            'title' => 'Biblioteca',
        ),
        'conteudo' => '',
        'footer' => NULL,
        'menu' => '',
        'js' => 'headPainelMaster',
        'dados' => array(
            'areaslinks' => $areasLinks
        )
    );

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'painelAdm/biblioteca/link_revistas_periodicos',
      'dados' => array(
        'page' => "Informações da página BIBLIOTECA- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'listaItensPaginaBiblioteca' => $listaItensPaginaBiblioteca = isset($listaItensPaginaBiblioteca) ? $listaItensPaginaBiblioteca : '',
        'campus'=>$campus,
        'tipo'=>'tabelaDatatable'
      )
    );

    $this->load->view('templates/masterPainel', $data);
  }

  public function lista_areas_cursos($uriCampus=NULL, $pageId = NULL) {

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();
    
    $areasLinks = $this->painelbd->where('*','magazines_area', null, array('magazines_area.campus_id' => $campus->id),array('campo'=>'title','ordem'=>'ASC'))->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/link_revistas_periodicos/lista_areas_cursos',
      'dados' => array(
        'page' => "Informações Menu (BIBLIOTECA >> Revistas Periódicos >> Áreas) <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina'=>$pagina,
        'campus'=> $campus,
        'areasLinks'=> $areasLinks,
        'tipo'=>'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_area_curso_link($uriCampus=NULL, $pageId = NULL){

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();
    
    $this->form_validation->set_rules('title', 'Título da Área/Curso', 'required');
    //$this->form_validation->set_rules('users_id', '', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()){
        setMsg(validation_errors(), 'error');
      }
    }else{
      $dados_form = elements(array('title'), $this->input->post());
      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['campus_id'] = $campus->id;
      $dados_form['status'] = $this->input->post('status');

      if ($this->painelbd->salvar('magazines_area', $dados_form) == TRUE){  
        setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
        redirect(base_url("Painel_biblioteca_revistas_periodicos/lista_areas_cursos/$campus->id/$pagina->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }
    
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/link_revistas_periodicos/cadastrar_area_curso_link',
      'dados' => array(
        //'page' => "Informações Biblioteca",
        'page' => "Cadastro de informações: Menu -> BIBLIOTECA >> Revistas Periódicos >> Áreas) <strong><i>Campus - $campus->name ($campus->city) </i>",
        'pagina'=>$pagina,
        'campus'=> $campus,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_area_curso_link($uriCampus=NULL, $pageId = NULL, $idInformacao = null){

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $areaLink = $this->painelbd->where('*','magazines_area', null, array('magazines_area.id' => $idInformacao))->row();
    
    $this->form_validation->set_rules('title', 'Título da Área/Curso', 'required');
    //$this->form_validation->set_rules('users_id', '', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()){
        setMsg(validation_errors(), 'error');
      }
    }else{
      if($areaLink->title !== $this->input->post('title')){
        $dados_form['title'] = $this->input->post('title');
      }

      if($areaLink->status !== $this->input->post('status')){
        $dados_form['status'] = $this->input->post('status');
      }

      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['id'] = $areaLink->id;
      $dados_form['updated_at'] = date('Y-m-d H:i:s');

      if ($this->painelbd->salvar('magazines_area', $dados_form) == TRUE){  
        setMsg('<p>Dados editados com sucesso.</p>', 'success');
        redirect(base_url("Painel_biblioteca_revistas_periodicos/lista_areas_cursos/$campus->id/$pagina->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }
    
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/link_revistas_periodicos/editar_area_curso_link',
      'dados' => array(
        //'page' => "Informações Biblioteca",
        'page' => "Edição de informações: Menu -> BIBLIOTECA >> Revistas Periódicos >> Áreas) <strong><i>Campus - $campus->name ($campus->city) </i>",
        'pagina'=>$pagina,
        'campus'=> $campus,
        'areaLink'=> $areaLink,
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_area_curso_links($uriCampus=NULL, $pagina = null,$id = NULL){
    verifica_login();

    $item = $this->painelbd->where('*','magazines_area', NULL, array('magazines_area.id' => $id))->row(); 

    $verificaExisteLinksRevistaPeriodico = $this->painelbd->where('*','magazines_links', null, array('magazines_links.magazines_areaid' => $item->id))->result();

    
    if(count($verificaExisteLinksRevistaPeriodico) > 0){
      setMsg('<p>Atenção! Esse item não pode ser deletado, pois existem itens (links) associados a ele.</p>', 'error');
      redirect("Painel_biblioteca_revistas_periodicos/lista_areas_cursos/$uriCampus/$pagina");
    }else{
      if ($this->painelbd->deletar('magazines_area', $item->id)) {
        setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
        redirect("Painel_biblioteca_revistas_periodicos/lista_areas_cursos/$uriCampus/$pagina");
      } else {
        setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      }
    }
  } 

  public function lista_links_revistas_periodicos($uriCampus=NULL, $pageId = NULL,$idArea = NULL) {

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();
    $areaRevistaPeriodico = $this->painelbd->where(array('magazines_area.id'),'magazines_area',null, array('magazines_area.id'=>$idArea))->row();
    
    $colunaResultadoLinksRevistasPeriodicos = array(
      'magazines_links.id',
      'magazines_links.title',
      'magazines_links.status',
      'magazines_links.created_at',
      'magazines_links.updated_at',
      'magazines_links.user_id',
      'magazines_links.link',
      'magazines_links.classification',
    );
    $joinLinksRevistasPeriodicos = array(
      'magazines_area' => 'magazines_area.id = magazines_links.magazines_areaid',
    );
    $whereLinkRevistaPeriodicos = array(
      'magazines_links.campus_id' => $campus->id,
      'magazines_links.magazines_areaid' =>$idArea
    );
    $linksRevistasPeriodicos = $this->painelbd->where($colunaResultadoLinksRevistasPeriodicos,'magazines_links', $joinLinksRevistasPeriodicos, $whereLinkRevistaPeriodicos,array('campo'=>'title','ordem'=>'ASC'))->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/link_revistas_periodicos/lista_links_revistas_periodicos',
      'dados' => array(
        'page' => "Informações Menu (BIBLIOTECA >> Revistas Periódicos >> Áreas >> <strong>LINKS</strong>) <strong><i>Campus - $campus->name ($campus->city) </strong></i>",
        'pagina'=>$pagina,
        'campus'=> $campus,
        'areaRevistaPeriodico'=> $areaRevistaPeriodico = isset($areaRevistaPeriodico) ? $areaRevistaPeriodico : '',
        'linksRevistasPeriodicos' => $linksRevistasPeriodicos = isset($linksRevistasPeriodicos) ? $linksRevistasPeriodicos : '',
        'tipo'=>'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_link_revista_periodico($uriCampus=NULL, $pageId = NULL,$idArea = NULL) {

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $areaRevistaPeriodico = $this->painelbd->where(array('magazines_area.id'),'magazines_area',null, array('magazines_area.id'=>$idArea))->row();
      
    $this->form_validation->set_rules('title', 'Título', 'required');
    $this->form_validation->set_rules('link', 'Link', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()){
        setMsg(validation_errors(), 'error');
      }
    }else {
      $dados_form = elements(array('title', 'link', 'classification','status'), $this->input->post());

      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['magazines_areaid'] = $areaRevistaPeriodico->id;
      $dados_form['campus_id'] = $campus->id;

      if ($this->painelbd->salvar('magazines_links', $dados_form) == TRUE){ 
        setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
        redirect(base_url("Painel_biblioteca_revistas_periodicos/lista_links_revistas_periodicos/$campus->id/$pagina->id/$areaRevistaPeriodico->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }
    
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/link_revistas_periodicos/links/cadastrar_link_revista_periodico',
      'dados' => array(
        'page' => "Cadastro de informações: Menu -> BIBLIOTECA >> Revistas Periódicos >> Áreas >> Links <strong><i>Campus - - $campus->name ($campus->city) </strong></i>",
        'pagina'=>$pagina,
        'campus'=> $campus,
        'areaRevistaPeriodico' => $areaRevistaPeriodico = isset($areaRevistaPeriodico) ? $areaRevistaPeriodico : '',
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_link_revista_periodico($uriCampus=NULL, $pageId = NULL,$idArea = NULL, $idLinkRevistaPeriodico = NULL) 
  {

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $linkRevistaPeriodico = $this->painelbd->where('*','magazines_links',null, array('magazines_links.id'=>$idLinkRevistaPeriodico))->row();
    $areaRevistaPeriodico = $this->painelbd->where('*','magazines_area',null, array('magazines_area.id'=>$idArea))->row();
  
  
    $this->form_validation->set_rules('title', 'Título', 'required');
    $this->form_validation->set_rules('link', 'Link', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()){
        setMsg(validation_errors(), 'error');
      }
    }else {

      if($linkRevistaPeriodico->title !== $this->input->post('title')){
        $dados_form['title'] = $this->input->post('title');
      }
      
      if($linkRevistaPeriodico->status !== $this->input->post('status')){
        $dados_form['status'] = $this->input->post('status');
      }
      if($linkRevistaPeriodico->link !== $this->input->post('link')){
        $dados_form['link'] = $this->input->post('link');
      }
      if($linkRevistaPeriodico->classification !== $this->input->post('classification')){
        $dados_form['classification'] = $this->input->post('classification');
      }

      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['id'] = $linkRevistaPeriodico->id;
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('magazines_links', $dados_form) == TRUE){ 
        setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
        redirect(base_url("Painel_biblioteca_revistas_periodicos/lista_links_revistas_periodicos/$campus->id/$pagina->id/$areaRevistaPeriodico->id"));
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/biblioteca/link_revistas_periodicos/links/editar_link_revista_periodico',
      'dados' => array(
        'page' => "Edição de informações: Menu -> BIBLIOTECA >> Revistas Periódicos >> Áreas >> Links <strong><i>Campus - - $campus->name ($campus->city) </strong></i>",
        'pagina'=>$pagina,
        'campus'=> $campus,
        'linkRevistaPeriodico' => $linkRevistaPeriodico = isset($linkRevistaPeriodico) ? $linkRevistaPeriodico : '',
        'areaRevistaPeriodico' => $areaRevistaPeriodico = isset($areaRevistaPeriodico) ? $areaRevistaPeriodico : '',
        'tipo'=>''
      )
    );
    
    $this->load->view('templates/layoutPainelAdm', $data);
  }

  
  public function deletar_link_revista_periodico($uriCampus=NULL, $pagina = null,$idArea = NULL, $id = NULL){
    verifica_login();
    
    $item = $this->painelbd->where('*','magazines_links', NULL, array('magazines_links.id' => $id))->row(); 

    if ($this->painelbd->deletar('magazines_links', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_biblioteca_revistas_periodicos/lista_links_revistas_periodicos/$uriCampus/$pagina/$idArea");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
    }
    
  } 

}

  