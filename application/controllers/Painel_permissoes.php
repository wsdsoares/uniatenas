<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_permissoes extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->model('painel_model', 'painelbd');
      date_default_timezone_set('America/Sao_Paulo');
  }
  
  public function index() {
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
      'conteudo' => 'paineladm/permissoes/index',
      'dados' => array(
          'page' => "perfis para usuários",
          'campus'=> $listagemDosCampus,
          'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_perfis() {
    verificaLogin();

    $colunasResultadoPerfis = array('campus.city','profile.name','profile.id','profile.status','profile.created_at','profile.updated_at','profile.user_id');
    $joinPerfisCampus = array(
      'campus'=>'campus.id = profile.campusid'
    );
    $perfis = $this->painelbd->where($colunasResultadoPerfis,'profile',$joinPerfisCampus, null,null)->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/permissoes/lista_informacoes_perfis',
      'dados' => array(
        'page' => "Perfis - <strong><i> registrados no sistema </i></strong>",
        'perfis'=> $perfis = isset($perfis) ? $perfis : '',
        'tipo'=>''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_permissoes_perfis($idPerfil=null) {
    verificaLogin();

    $colunasResultadoPerfil = array('campus.city','profile.name','profile.id','profile.status','profile.created_at','profile.updated_at','profile.user_id');
    $joinPerfilCampus = array(
      'campus'=>'campus.id = profile.campusid'
    );
    $perfil = $this->painelbd->where($colunasResultadoPerfil,'profile',$joinPerfilCampus, array('profile.id'=>$idPerfil),null)->row();

    $colunasResultadoPermissoes = array(
      'permission.id', 'permission.titulo','permission.titulo_curto','permission.status','permission.inserir',
      'permission.visualizar','permission.atualizar','permission.deletar'
    );
    $permissoes = $this->painelbd->where($colunasResultadoPermissoes,'permission',null, null,null)->result();

    $countPermissoes = count($permissoes);

    $this->form_validation->set_rules('perfil', 'Perfil', 'required'); 

      if ($this->form_validation->run() == FALSE) {
          if (validation_errors()):
              setMsg(validation_errors(), 'error');
          endif;
      }else {
        $dados_form = elements(array('perfil'), $this->input->post());
        $array_permissoes= $this->input->post('permissoes[]');

        //$newArray = [];
        foreach($array_permissoes as $permissao){
          $parts = explode("-", $permissao);
          $newArray[$parts[0]][] = $permissao;
      }
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<br>';
        echo '<pre>';
        print_r($newArray);
        print_r($dados_form);
        echo '</pre>';
        // $dados_form['title'] = $this->input->post('title');
        // $dados_form['status'] = $this->input->post('status');
        // $dados_form['campusid'] = $campus->id;
      }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/permissoes/lista_permissoes_perfis',
      'dados' => array(
        'page' => "Opções de permissão para o perfil <strong><i>  </i></strong>",
        'perfil'=> $perfil = isset($perfil) ? $perfil : '',
        'permissoes'=>$permissoes,
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