<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_Instituicao extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('acesso_model', 'acesso');
        $this->load->model('inicio_model', 'inicio');
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('Cpainel_model', 'bd');

        date_default_timezone_set('America/Sao_Paulo');
    }

    public function dirigentes() {
        verificaLogin();

        $page = $this->uri->segment(2);

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/instituicao/dirigentes/lista_dirigentes',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => $page,
                'listagem'=> $this->bd->getWhere('dirigentes')->result(),
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_dirigentes(){
        verificaLogin();

        //Validaçãoes via Form Validation
        $this->form_validation->set_rules('nome', 'Nome do Dirigente', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('cargo', 'Título', 'required');


        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {

            //aqui pega os dados dos formulários por meio do input
            //os nomes - names dos inputs devem ser iguais aos do BD.
            $dados_form = elements(array('nome','email','cargo'), $this->input->post());


            $dados_form['status'] = '1';

            //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
            if ($this->bd->salvar('dirigentes', $dados_form) == TRUE):
                setMsg('<p>Dirigentes incluído com sucesso.</p>', 'success');
            else:
                setMsg('<p>Erro! Algo de errado não está certo.</p>', 'error');
            endif;
        }



        $page = $this->uri->segment(2);

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/instituicao/dirigentes/cadastrar_dirigentes',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => $page,
                'listagem'=> $this->bd->getWhere('dirigentes')->result(),
                'tipo'=>''
            )
        );


        $this->load->view('templates/layoutPainelAdm', $data);
    }



}
