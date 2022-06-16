<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Paginas extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('acesso_model', 'acesso');
        $this->load->model('inicio_model', 'inicio');
        $this->load->model('painel_model', 'painelbd');

        date_default_timezone_set('America/Sao_Paulo');
    }

    public function index() {
        verificaLogin();
        $dados = '';

        $campus = '1'; //campus Paracatu 
        $page = $this->uri->segment(2);
        //$page = 'sdf';
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/itens',
            'dados' => array(
                'page' => $page,
                'pagina_id' => '',
                'tipo' => ''
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function home() {
        $campus = '1'; //campus Paracatu 
        $page = $this->uri->segment(2);
        $itens = $this->acesso->getWhere('midias')->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/itens_paginas/home/principal',
            'dados' => array(
                'page' => $page,
                'slideshow' => $itens
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    /*     * *****************************************************
      Slideshow
     * **************************************************** */

    public function slideshow() {
        $campus = '1'; //campus Paracatu 
        $page = $this->uri->segment(2);
        //$page = 'sdf';
        $itens = $this->painelbd->getWhere('midias')->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/itens_paginas/home/slideshow',
            'dados' => array(
                'page' => $page,
                'tipo' => '',
                'slideshow' => $itens
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrarSlideShow() {
        $this->load->helper('file');
        $campus = '1'; //campus Paracatu 


        $this->form_validation->set_rules('titulo', 'Título', 'required');
        $this->form_validation->set_rules('textoBreve', 'Texto Breve', 'required');


        $this->form_validation->set_rules('dataInicio', 'Data de Início', 'required');
        $this->form_validation->set_rules('dataFim', 'Data Fim', 'required');
        if (empty($_FILES['arquivo']['name'])) {
            $this->form_validation->set_rules('arquivo', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {
            $path = 'assets/images/slider';
            $name_tmp = preg_replace(array(
                "/(á|à|ã|â|ä)/",
                "/(Á|À|Ã|Â|Ä)/",
                "/(é|è|ê|ë)/",
                "/(É|È|Ê|Ë)/",
                "/(í|ì|î|ï)/",
                "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post('title'));
            $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', "’");

            // matriz de saída
            $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');

            // devolver a string
            $name_tmp = str_replace($what, $by, $name_tmp);

            $name_tmp = NULL;
            $upload = $this->painelbd->uploadFiles('arquivo', $path, $types = 'jpg|JPG|png|jpeg|JPEG');

            if ($upload):
                //upload efetuado

                $dados_form = elements(array('titulo', 'textoBreve', 'dataInicio', 'dataFim', 'linkRedir'), $this->input->post());

                $dados_form['arquivo'] = $path . '/' . $upload['file_name'];
                $dados_form['campus_id'] = $campus;
                $dados_form['tipo'] = 'slideshow';
                $dados_form['users_id'] = $this->session->userdata('codusuario');
                $dados_form['status'] = '1';

                if ($id = $this->painelbd->salvar('midias', $dados_form)):
                    setMsg('<p>Publicação cadastrada com sucesso.</p>', 'success');
                    redirect('Paginas/slideshow');
                else:
                    setMsg('<p>Erro! A publicação não foi cadastrada.</p>', 'error');
                    redirect('Paginas/slideshow');
                endif;
            else:
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            endif;
        }


        $condition = array('status' => 1, 'campus_id' => $campus);
        $dados = $this->painelbd->getWhere('midias', $condition)->result();

        $data = array(
            'titulo' => 'Início - Slides',
            'conteudo' => 'paineladm/itens_paginas/home/slideshow/salvar',
            'dados' => array('slideshow' => $dados,
                'cursos' => '',
                'page' => '',
                'revistas_id' => '',
                'tipo' => 'slideshow')
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editarSlideShow($id = NULL, $idPage = NULL) {
        $campus = '1'; //campus Paracatu 
        date_default_timezone_set('America/Sao_Paulo');


        if (empty($id)) {
            redirect('Paginas/editarSlideShow');
        }

        $idPage = $this->uri->segment(3);

        $this->form_validation->set_rules('titulo', 'Título', 'required');
        $this->form_validation->set_rules('textoBreve', 'Texto Breve', 'required');

        //$this->form_validation->set_rules('dataInicio', 'Data de Início', 'required');
        //$this->form_validation->set_rules('dataFim', 'Data Fim', 'required');

        if (!empty($_FILES["arquivo"]) and empty($this->input->post('fileatual'))) {
            $this->form_validation->set_rules('arquivo', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
        }

        $this->form_validation->set_rules('users_id', '', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {
            if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['name'])) {
                $path = 'assets/images/slider';
                $name_tmp = preg_replace(array(
                    "/(á|à|ã|â|ä)/",
                    "/(Á|À|Ã|Â|Ä)/",
                    "/(é|è|ê|ë)/",
                    "/(É|È|Ê|Ë)/",
                    "/(í|ì|î|ï)/",
                    "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post('title'));
                $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', "’");

                // matriz de saída
                $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');

                // devolver a string
                $name_tmp = str_replace($what, $by, $name_tmp);

                $name_tmp = NULL;
                $upload = $this->painelbd->uploadFiles('arquivo', $path, $types = 'jpg|JPG|png|jpeg|JPEG', $name_tmp);

                if ($upload):
                    //upload efetuado

                    //$dados_form = elements(array('titulo', 'textoBreve', 'dataInicio', 'dataFim', 'linkRedir'), $this->input->post());
                    $dados_form = elements(array('titulo', 'textoBreve', 'linkRedir', 'id'), $this->input->post());
                    $user = $this->painelbd->getWhere('users', array('user' => $this->input->post('users_id')))->row();
                    $dados_form['arquivo'] = $path . '/' . $upload['file_name'];
                    $dados_form['campus_id'] = $campus;
                    $dados_form['tipo'] = 'slideshow';
                    $dados_form['users_id'] = $user->id;
                    $dados_form['status'] = '1';


                    if ($this->painelbd->salvar('midias', $dados_form) == TRUE):
                        setMsg('<p>Publicação cadastrada com sucesso.</p>', 'success');
                        redirect('Paginas/slideshow');
                    else:
                        setMsg('<p>Erro! A publicação não foi cadastrada.</p>', 'error');
                        redirect('Paginas/slideshow');
                    endif;
                
                else:
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                endif;
            } else {

                $dados_form = elements(array('titulo', 'textoBreve', 'linkRedir', 'id'), $this->input->post());
                $user = $this->painelbd->getWhere('users', array('user' => $this->input->post('users_id')))->row();
                $dados_form['campus_id'] = $campus;
                $dados_form['tipo'] = 'slideshow';
                $dados_form['users_id'] = $user->id;
                $dados_form['status'] = '1';


                if ($this->painelbd->salvar('midias', $dados_form) == TRUE):
                    setMsg('<p>Publicação editada com sucesso.</p>', 'success');
                //redirect('Paginas/slideshow');
                else:
                    setMsg('<p>Erro! A publicação não foi editada.</p>', 'error');
                //redirect('Paginas/slideshow');
                endif;
            }
        }
        $condition = array('status' => 1, 'campus_id' => $campus, 'tipo' => 'slideshow', 'id' => $id);
        $dados = $this->painelbd->getWhere('midias', $condition)->row();

        $data = array(
            'titulo' => 'Início - Editar Slides',
            'conteudo' => 'paineladm/itens_paginas/home/slideshow/editar',
            'dados' => array(
                'slideshow' => $dados,
                'tipo' => 'slideshow',
                'idSlid' => $id)
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    function deletarSlideShow($id = NULL) {

        $table = 'midias';
        $dados = $this->painelbd->getWhere($table, array('id' => $id))->row();
        $arquivo = isset($dados->arquivo) ? $dados->arquivo : '';

        if ($id != NULL && $dados) {

            if ($this->painelbd->delete($table, array('id' => $id)) == TRUE) {

                $path = 'assets/images/old/slider';
                $files = realpath($dados->arquivo);
                $fileDeleted = current(array_reverse(explode('/', $dados->arquivo)));

                if (copy($files, $path . '/' . date('d-m-y') . $fileDeleted)) {
                    $msg = "";
                } else {
                    $msg = "não foi possível fazer a cópia de segurança para '$path'.";
                }

                if (!unlink($arquivo)) {
                    setMsg('Não foi possível remover o arquivo de nome ' . $arquivo . " e  $msg", 'alert');
                    redirect('Paginas/slideshow');
                } else {
                    setMsg('<p>Item deletado com sucesso.</p>', 'success');
                    redirect('Paginas/slideshow');
                }
            } else {
                setMsg('<p>Erro! O item não pode ser deletado.</p>', 'error');
                redirect('Paginas/slideshow');
            }
        } else {
            setMsg('<p>Erro! O item não pode ser deletado.</p>', 'error');
            redirect('Paginas/slideshow');
        }
    }

}
