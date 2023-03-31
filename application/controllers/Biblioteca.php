<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Biblioteca extends CI_Controller {

    public function __construct() {
        parent::__construct();
        verifica_login();
        init_painel_adm();
        $this->load->model('painel_model', 'painelbd');
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function linksRevistasPeriodicos($campus = NULL) {
        // if($campus == null){
        //     redirect("");
        // }
        $areasLinks = $this->painelbd->getWhere('magazines_area', array('status' => 1))->result();
        $data = array(
            'head' => array(
                'title' => 'Biblioteca',
            ),
            'conteudo' => 'painelAdm/biblioteca/linksrevistasPeriodicos',
            'footer' => NULL,
            'menu' => '',
            'js' => 'headPainelMaster',
            'dados' => array(
                'areaslinks' => $areasLinks
            )
        );

        $this->load->view('templates/masterPainel', $data);
    }

    public function linksAreasCursos() {

        $areasLinks = $this->painelbd->getWhere('magazines_area', array('status' => 1))->result();

        $data = array(
            'head' => array(
                'title' => 'Biblioteca',
            ),
            'conteudo' => 'painelAdm/biblioteca/linksAreasCursos',
            'footer' => NULL,
            'menu' => '',
            'js' => 'headPainelMaster',
            'dados' => array(
                'areaslinks' => $areasLinks
            )
        );

        $this->load->view('templates/masterPainel', $data);
    }

    public function cadastrarAreasLinks() {

        $this->form_validation->set_rules('title', 'Título', 'required');
        //$this->form_validation->set_rules('users_id', '', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {
            $dados_form = elements(array('title'), $this->input->post());
            $user = $this->session->userdata('codusuario');

            $dados_form['usersid'] = $user;
            $dados_form['status'] = '1';

            if ($id = $this->painelbd->salvar('magazines_area', $dados_form)):
                setMsg('<p>Área de links de Revistas/ Periódicos cadastrada com sucesso.</p>', 'success');
            else:
                setMsg('<p>Erro! A Área de links de Revistas/ Periódicos não foi cadastrada.</p>', 'error');
            endif;
        }


        $areasLinks = $this->painelbd->getWhere('magazines_area', array('status' => 1))->result();
        $data = array(
            'head' => array(
                'title' => 'Biblioteca',
            ),
            'conteudo' => 'painelAdm/biblioteca/linksRevistas/cadastrarAreaLink',
            'footer' => NULL,
            'menu' => '',
            'js' => 'headPainelMaster',
            'dados' => array(
                'areaslinks' => $areasLinks
            )
        );

        $this->load->view('templates/masterPainel', $data);
    }

    public function deletarAreaLinks($id = NULL) {

        $table = 'magazines_area';
        $dados = $this->painelbd->getWhere($table, array('id' => $id))->row();
        $arquivo = $dados->files;

        if ($id != NULL && $dados) {
            if ($del = $this->painelbd->delete($table, array('id' => $id))) {


                setMsg('<p>Informação removida com sucesso.</p>', 'success');
                redirect('biblioteca/linksAreasCursos');
            } else {
                setMsg('<p>Erro! A Área não pode ser deletada.</p>', 'error');
                redirect('biblioteca/linksAreasCursos');
            }
        } else {
            setMsg('<p>Erro! Não existe publicações para os dados informados.</p>', 'error');
            redirect('biblioteca/linksAreasCursos');
        }
    }

    public function listaLinksRevistas($id = NULL) {
        if ($id == NULL) {
            redirect('biblioteca/linksRevistasPeriodicos');
        }

        $areasLinks = $this->painelbd->getWhere('magazines_links', array('status' => 1))->result();
        $areas = $this->painelbd->getWhere('magazines_area', array('id' => $id))->row();

        $data = array(
            'head' => array(
                'title' => 'Biblioteca',
            ),
            'conteudo' => 'painelAdm/biblioteca/linksRevistas/listaLinksRevistas',
            'footer' => NULL,
            'menu' => '',
            'js' => 'headPainelMaster',
            'dados' => array(
                'areaslinks' => $areasLinks,
                'idArea' => $id,
                'area' => $areas,
            )
        );

        $this->load->view('templates/masterPainel', $data);
    }

    public function cadastrarLinks($id = NULL) {
        if ($id == NULL) {
            redirect('biblioteca/linksRevistasPeriodicos');
        }
        $this->form_validation->set_rules('title', 'Título', 'required');
        $this->form_validation->set_rules('link', 'Link', 'required');


        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {
            $dados_form = elements(array('title', 'link', 'classification'), $this->input->post());
            $user = $this->session->userdata('codusuario');

            $dados_form['usersid'] = $user;
            $dados_form['magazines_areaid'] = $id;
            $dados_form['status'] = '1';

            if ($id = $this->painelbd->salvar('magazines_links', $dados_form)):
                setMsg('<p>Área de links de Revistas/ Periódicos cadastrada com sucesso.</p>', 'success');
            else:
                setMsg('<p>Erro! A Área de links de Revistas/ Periódicos não foi cadastrada.</p>', 'error');
            endif;
        }


        $areasLinks = $this->painelbd->getWhere('magazines_area', array('status' => 1))->result();
        $data = array(
            'head' => array(
                'title' => 'Biblioteca',
            ),
            'conteudo' => 'painelAdm/biblioteca/linksRevistas/cadastrarLinks',
            'footer' => NULL,
            'menu' => '',
            'js' => 'headPainelMaster',
            'dados' => array(
                'areaslinks' => $areasLinks,
                'idArea' => $id,
            )
        );

        $this->load->view('templates/masterPainel', $data);
    }

    public function editarAreasLinks($id=NULL) {
        if($id==NULL){
            redirect('painel');
        }

        $areasLinks = $this->painelbd->getWhere('magazines_area',array('id'=>$id,'status' => 1))->row();


        $this->form_validation->set_rules('title', 'Título', 'required');
        //$this->form_validation->set_rules('users_id', '', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {
            $dados_form = elements(array('title'), $this->input->post());
            $user = $this->session->userdata('codusuario');

            $dados_form['usersid'] = $user;
            $dados_form['status'] = '1';
            $dados_form['id'] = $areasLinks->id;

            if ($id = $this->painelbd->salvar('magazines_area', $dados_form)):
                setMsg('<p>Área de links de Revistas/ Periódicos editada com sucesso.</p>', 'success');
            else:
                setMsg('<p>Erro! A Área de links de Revistas/ Periódicos não foi editada.</p>', 'error');
            endif;
        }

        $data = array(
            'head' => array(
                'title' => 'Biblioteca',
            ),
            'conteudo' => 'painelAdm/biblioteca/linksRevistas/editarAreaLink',
            'footer' => NULL,
            'menu' => '',
            'js' => 'headPainelMaster',
            'dados' => array(
                'areaslinks' => $areasLinks
            )
        );

        $this->load->view('templates/masterPainel', $data);
    }

    public function deletarLinks($id = NULL) {

        $table = 'magazines_links';
        $dados = $this->painelbd->getWhere($table, array('id' => $id))->row();
        $idArea = $dados->magazines_areaid;
        

        if ($id != NULL && $dados) {
            if ($del = $this->painelbd->delete($table, array('id' => $id))) {


                setMsg('<p>Informação removida com sucesso.</p>', 'success');
                redirect('biblioteca/listaLinksRevistas/' . $idArea);
            } else {
                setMsg('<p>Erro! A Área não pode ser deletada.</p>', 'error');
                redirect('biblioteca/listaLinksRevistas/' . $idArea);
            }
        } else {
            setMsg('<p>Erro! Não existe publicações para os dados informados.</p>', 'error');
            redirect('biblioteca/listaLinksRevistas/' . $idArea);
        }
    }
    public function editarLinks($idLink = NULL, $idArea = NULL) {
        if ($idLink == NULL) {
            redirect('biblioteca/listaLinksRevistas');
        }
        $this->form_validation->set_rules('title', 'Título', 'required');
        $this->form_validation->set_rules('link', 'Link', 'required');


        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {
            $dados_form = elements(array('title', 'link', 'classification', 'magazines_areaid'), $this->input->post());
            $user = $this->session->userdata('codusuario');

            $dados_form['usersid'] = $user;
            //$dados_form['magazines_areaid'] = $id;
            $dados_form['status'] = '1';
            $dados_form['id'] = $idLink;

            if ($id = $this->painelbd->salvar('magazines_links', $dados_form)):
                setMsg('<p>Link de revistas editado com sucesso.</p>', 'success');
            else:
                setMsg('<p>Erro! Atenção, o link não foi editado.</p>', 'error');
            endif;
        }


        $areasLinks = $this->painelbd->getWhere('magazines_area', array('status' => 1))->result();
        $link = $this->painelbd->getWhere('magazines_links', array('id' => $idLink))->row();
        $data = array(
            'head' => array(
                'title' => 'Biblioteca',
            ),
            'conteudo' => 'painelAdm/biblioteca/linksRevistas/editarLinks',
            'footer' => NULL,
            'menu' => '',
            'js' => 'headPainelMaster',
            'dados' => array(
                'areaslinks' => $areasLinks,
                'link' => $link,
            )
        );

        $this->load->view('templates/masterPainel', $data);
    }

}