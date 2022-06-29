<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_usuarios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('painel_model', 'painelbd');
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function lista_usuarios() {
        verificaLogin();

        $listaUsuarios = $this->painelbd->where('*','users',NULL)->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/gestao_usuarios/lista_usuarios',
            'dados' => array(
                'page' => "Lista - Usuários para gestão de dados/informaçoes - Site",
                'listaUsuarios'=> $listaUsuarios,
                'tipo'=>'tabelaDatatable'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_usuario() {
        verificaLogin();
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.visible'=>'SIM'))->result();

        $this->form_validation->set_rules('name', 'Nome', 'trim|required');
        $this->form_validation->set_rules('cod_user', 'Código Usuário', 'required|trim|is_unique[users.cod_user]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Senha', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {
            $dados_form = elements(array('name','cod_user','email','status'), $this->input->post());
            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['password'] = hash('sha256',$this->session->userdata('codusuario'));

            if ($this->painelbd->salvar('users', $dados_form) == TRUE){
                setMsg('<p>Usuário cadastrado com sucesso.</p>', 'success');
                redirect(base_url("Painel_usuarios/lista_usuarios/$campus->id"));
            }else{
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/gestao_usuarios/usuarios/cadastrar_usuario',
            'dados' => array(
                'page' => "Cadastro de Usuário - Gestão do site",
                'campus'=>$campus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }


    public function editar_usuario($userId=NULL) {
        verificaLogin();
        $listaUsuario = $this->painelbd->where('*','users',NULL,array('users.id'=>$userId))->row();
        if (!empty($this->input->post('name') and $listaUsuario->name != $this->input->post('name') )){
          $this->form_validation->set_rules('name', 'Nome', 'trim|required');
        }
        if (!empty($this->input->post('cod_user') and $listaUsuario->cod_user != $this->input->post('cod_user') )){
          $this->form_validation->set_rules('cod_user', 'Código Usuário', 'required|trim|is_unique[users.cod_user]');
        }
        if (!empty($this->input->post('email') and $listaUsuario->email != $this->input->post('email') )){
          $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        }

        if(empty($listaUsuario->password) or !empty($this->input->post('password'))){
            $this->form_validation->set_rules('password', 'Senha', 'required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        }
        $this->form_validation->set_rules('status', 'Status', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {
            $dados_form = elements(array('name','cod_user','email','password','status'), $this->input->post());
            if($listaUsuario->name != $this->input->post('name')){
                $dados_form['name'] = $this->input->post('name');
            }
            if($listaUsuario->cod_user != $this->input->post('cod_user')){
                $dados_form['cod_user'] = $this->input->post('cod_user');
            }
            if($listaUsuario->email != $this->input->post('email')){
                $dados_form['email'] = $this->input->post('email');
            }
            if($listaUsuario->password != $this->input->post('password')){
                $dados_form['password'] = $this->input->post('password');
            }

            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['id'] = $listaUsuario->id;

            echo '<pre>';
            print_r($dados_form);
            echo '</pre>';

            // if ($this->painelbd->salvar('users', $dados_form) == TRUE){
            //     setMsg('<p>Dados usuário editado com sucesso.</p>', 'success');
            //     redirect(base_url("Painel_usuarios/lista_usuarios"));
            // }else{
            //     setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            // }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/gestao_usuarios/usuarios/editar_usuario',
            'dados' => array(
                'page' => "Edição de daodos do usuário - Gestão do site",
                'listaUsuario'=>$listaUsuario,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_vinculo_campus_usuario($userId=NULL) {
      verificaLogin();
      $listaUsuario = $this->painelbd->where('*','users',NULL,array('users.id'=>$userId))->row();
      
      $colunaResultadoVinculo = array(
        'campus.id as idCampus',
        'campus.city',
        'campus.name',

        'users_has_campus.id',
        'users_has_campus.created_at',
        'users_has_campus.user_id'

      );
      $joinVinculo = array(
        'campus'=>'campus.id = users_has_campus.campus_id'
      );
      $vinculoUsuario = $this->painelbd->where($colunaResultadoVinculo,'users_has_campus',$joinVinculo,array('users_has_campus.users_id'=>$userId))->result();
      
      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.visible'=>'SIM'))->result();

      $data = array(
          'titulo' => 'UniAtenas',
          'conteudo' => 'paineladm/gestao_usuarios/usuarios/lista_vinculo_campus_usuario',
          'dados' => array(
              'page' => "Vínculos do usuário <strong><u>$listaUsuario->name</u></strong> - Gestão do site",
              'campus'=>$campus,
              'listaUsuario'=>$listaUsuario,
              'vinculoUsuario'=>$vinculoUsuario,
              'tipo'=>''
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function vincular_campus_usuario($userId=NULL) {
      verificaLogin();
      $listaUsuario = $this->painelbd->where('*','users',NULL,array('users.id'=>$userId))->row();

      $vinculoUsuario = $this->painelbd->where('*','users_has_campus',NULL,array('users_has_campus.users_id'=>$userId))->result();
      
      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.visible'=>'SIM'))->result();

      $this->form_validation->set_rules('checkbox_campus[]', 'Selecione um campus', 'trim|required');

      if ($this->form_validation->run() == FALSE) {
          if (validation_errors()):
              setMsg(validation_errors(), 'error');
          endif;
      }else {
        $campus = $this->input->post('checkbox_campus[]');
        foreach ($campus as $item=>$value) {
          $dados_form['users_id'] = $listaUsuario->id;
          $dados_form['campus_id'] = $value;
          $this->painelbd->salvar('users_has_campus', $dados_form);
        }
        setMsg('<p>Usuário cadastrado com sucesso.</p>', 'success');
        redirect(base_url("Painel_usuarios/lista_usuarios/$campus->id"));
      }

      $data = array(
          'titulo' => 'UniAtenas',
          'conteudo' => 'paineladm/gestao_usuarios/usuarios/vincular_campus_usuario',
          'dados' => array(
              'page' => "Cadastro de Usuário - Gestão do site",
              'campus'=>$campus,
              'listaUsuario'=>$listaUsuario,
              'vinculoUsuario'=>$vinculoUsuario,
              'tipo'=>''
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_vinculo_usuario($userId=NULL,$idvinculo = NULL)
    {
        verifica_login();
    
        $item = $this->painelbd->where('*','users_has_campus', NULL, array('users_has_campus.id' => $idvinculo))->row(); 
        if ($this->painelbd->deletar('users_has_campus', $item->id)) {
            setMsg('<p>O item foi deletado com sucesso.</p>', 'success');
            redirect(base_url("Painel_usuarios/lista_vinculo_campus_usuario/$userId"));
        } else {
            setMsg('<p>Erro! O item foi não deletado.</p>', 'error');
            redirect(base_url("Painel_usuarios/lista_vinculo_campus_usuario/$userId"));
        }
    }
  
  }