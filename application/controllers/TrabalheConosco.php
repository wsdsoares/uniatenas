<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class trabalheConosco extends CI_Controller {

    public function __construct() {
        parent::__construct();
        verificaLogin();
        $this->load->model('painel_model', 'painelbd');
    }

    public function trabalheConosco() {
        $page = 'revistas';
        $aql = "SELECT 
                    revistas.id,
                    revistas.id as pagina_id,
                    revistas.titulo,
                    revistas.status, 
                    revistas.datacriacao
                FROM 
                    revistas
                WHERE
                    status =1
                ";
        $dados = $this->painelbd->getQuery($aql)->result();
        $data = array(
            'titulo' => 'Início',
            'conteudo' => 'paineladm/itens_iniciacao/publicacoes/revistas',
            'dados' => array(
                'revistas' => $dados,
                'tipo' => 'revistas')
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function conteudos() {
        $campus = '1'; //campus Paracatu 

        $page = 'sdf';
        $query = "SELECT 
            page_contents.id,
            page_contents.title as titulo,
            pages.title as 'pagina', 
            page_contents.description as 'descricao',
            page_contents.order as 'ordem',
            page_contents.data_modify as 'dataModificacao'

        FROM
            at_site.page_contents

            inner join pages on pages.id = page_contents.pages_id
         WHERE pages.title='trabalheconosco'";
        $pages_content = $this->painelbd->getQuery($query)->result();
        $itens = $this->painelbd->getWhere('midias')->result();
        $data = array(
            'titulo' => 'UniAtenas - Trabalhe Conosco',
            'conteudo' => 'paineladm/itens_paginas/trabalheConosco/conteudos',
            'dados' => array(
                'page' => $page,
                'tipo' => '',
                'slideshow' => $itens,
                'pages_content' => $pages_content
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function areasSetores() {
        $campus = '1'; //campus Paracatu 



        $pages_content = $this->painelbd->getWhere('resume_sector_area')->result();

        $data = array(
            'titulo' => 'UniAtenas - Trabalhe Conosco',
            'conteudo' => 'paineladm/itens_paginas/trabalheConosco/areasSetores',
            'dados' => array(
                'page' => '',
                'tipo' => 'trabalheConosco',
                'pages_content' => $pages_content
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function vagasTrabalho() {
        $campus = '1'; //campus Paracatu 

        $pages_content = $this->painelbd->getWhere('resume_job_vacancy')->result();

        $data = array(
            'titulo' => 'UniAtenas - Trabalhe Conosco',
            'conteudo' => 'paineladm/itensGestaoCuriculos/vagas/vagasTrabalho',
            'dados' => array(
                'page' => '',
                'tipo' => 'trabalheConosco',
                'pages_content' => $pages_content
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }
    
    public function curriculosRecebidos() {
        $campus = '1';


        
        $consulta = ('SELECT
                    resume.id,
                    resume.name, 
                    resume.email,
                    resume.files,
                    
                    resume.celphone +" / "+
                    resume.whatsapp as celphone,
                    resume_job_vacancy.name as vacancy,
                    resume_job_vacancy.datecreated
                FROM
                    at_site.resume
                    INNER JOIN resume_job_vacancy on resume_job_vacancy.id=resume.vacancyid
                    
                    ;'
                );
        $resumeRecived = $this->painelbd->getQuery($consulta)->result();

        $data = array(
            'titulo' => 'UniAtenas - Lista de Currículos',
            'conteudo' => 'paineladm/itensGestaoCuriculos/curriculos/listaCurriculos',
            'dados' => array(
                'page' => '',
                'tipo' => 'revistas',
                'resumeRecived' => $resumeRecived
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrarVagas() {
        $this->form_validation->set_rules('name', 'Título da Vaga', 'required');
        $this->form_validation->set_rules('datestart', 'Data Início', 'required');
        $this->form_validation->set_rules('dateend', 'Data Término', 'required');

        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }
        
        if ($this->input->post('campusid') == '0') {
            $this->form_validation->set_rules('campusid', 'Campus', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar ao menos um campus.');
        } else {
            $this->form_validation->set_rules('campusid', 'Curso');
        }

        if ($this->input->post('sectorareaid') == '0') {
            $this->form_validation->set_rules('sectorareaid', 'Area / Setor', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar ao menos uma área/ setor.');
        } else {
            $this->form_validation->set_rules('sectorareaid', 'Area / Setor');
        }
        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {
            
            $path = 'assets/files/trabalheConosco/editaisVagas';

            $upload = $this->painelbd->do_uploadFiles('files', $path, $types = 'pdf', $name_tmp = NULL);
            if ($upload):
                //upload efetuado
                setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
                date_default_timezone_set('America/Sao_Paulo');
                $data = date('Y-m-d H:i:s');
                
                $dados_form = elements(array('name', 'datestart', 'dateend','campusid','sectorareaid'), $this->input->post());
                $user = $this->painelbd->getWhere('users', array('user' => $this->input->post('usersid')))->row();
                $dados_form['files'] = $path . '/' . $upload['file_name'];
                
                $dados_form['usersid'] = $user->id;
                $dados_form['status'] = 1;
                $dados_form['datecreated'] = $data;

                if ($id = $this->painelbd->do_insert('resume_job_vacancy', $dados_form)):
                    setMsg('<p>Publicação da vaga realizada com sucesso.</p>', 'success');
                else:
                    setMsg('<p>Erro! A publicação não foi cadastrada. Tente novamente.</p>', 'error');
                endif;
            else:
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            endif;


            $dados = elements(array('nome', 'genero', 'codigoArea', 'telefone', 'whatsapp', 'email', 'uf', 'cidade', 'campus_id', 'tipoCurriculo', 'escolaridades_id', 'areasSetoresCurriculos_id'), $this->input->post());


            if ($this->bancosite->salvar('curriculos', $dados) == TRUE):
                setMsg('<p>Currículo registrado com sucesso.</p>', 'success');
                redirect('Site/envioCurriculo');
            else:
                setMsg('<p>Erro! A publicação não foi editada.</p>', 'error');
            endif;
        }


        $localidades = $this->painelbd->getAll('campus')->result();
        $pages_content = $this->painelbd->getWhere('resume_job_vacancy')->result();
        $resumeSectorArea = $this->painelbd->getWhere('resume_sector_area')->result();

        $data = array(
            'titulo' => 'UniAtenas - Trabalhe Conosco',
            'conteudo' => 'paineladm/itensGestaoCuriculos/vagas/cadastrarVagas',
            'dados' => array(
                'page' => '',
                'tipo' => 'trabalheConosco',
                'pages_content' => $pages_content,
                'resumeSectorArea' => $resumeSectorArea,
                'localidades' => $localidades
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }
    
    

}
