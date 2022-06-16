<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_mural_digital extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('acesso_model', 'acesso');
        $this->load->model('inicio_model', 'inicio');
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('Cpainel_model', 'bd');

        date_default_timezone_set('America/Sao_Paulo');
    }
    
    /** Modulo de arquivos e fotos normas institucionais */
    public function normas_institucionais()
    {
        verificaLogin();
        /*if (in_array("admTempsArgs", $_SESSION['permissionCampus']['campus-1'])) {
            $listagem = $this->painelbd->getWhere('files_temp')->result();
        } else {
            $listagem = $this->painelbd->getWhere('files_temp', array('status' => '1'))->result();
        }
         * 
         */
        $listagem = $this->painelbd->getWhere('mural_institutional_norms')->result();
        $typesArq =$this->painelbd->getWhere("mural_type_items")->result();
        $campus = $this->painelbd->getWhere("campus")->result();
        $data = array(
            'titulo' => 'Arquivos do Mural',
            'conteudo' => 'paineladm/mural/arquivos/lista',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $listagem,
                'type' => $typesArq,
                'campus' => $campus,
                'tipo' => 'temps'
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_norma_institucional()
    {
        verificaLogin();
        $this->load->helper('file');

        $this->form_validation->set_rules('name', 'Titulo', 'required');
        $this->form_validation->set_rules('campusid','campus','required');
        $this->form_validation->set_rules('status','status','required');
        $this->form_validation->set_rules('type','Tipo','required');
        $campus = $this->input->post('campusid');
        $status = $this->input->post('status');
        $status -= 1;

        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            $path = 'assets/mural';
            is_way($path);
            $name_tmp = noAccentuation($this->input->post('title'), 'temp');

            $upload = $this->bd->uploadFiles('files', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF', $name_tmp);
            if ($upload) {
                //upload efetuado

                $dados_form = elements(array('name'), $this->input->post());
                $dados_form['files'] = $path . '/' . $upload['file_name'];
                $dados_form['mural_typeid'] = $this->input->post('type');
                $dados_form['campusid'] = $campus;
                $dados_form['usersid'] = $this->session->userdata('codusuario');
                $dados_form['status'] = $status;

                if ($this->bd->salvar('mural_institutional_norms', $dados_form) == TRUE) {
                    setMsg('<p>Publicação cadastrada com sucesso.</p>', 'success');
                    redirect('Painel_mural_digital/normas_institucionais/');
                } else {
                    setMsg('<p>Erro! A publicação não foi cadastrada.</p>', 'error');
                    redirect('Painel_mural_digital/normas_institucionais/');
                }
            } else {
                //erro no upload
                $msg = $this->upload->display_erros();
                $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }


        }


        $dados = $this->painelbd->getWhere('mural_institutional_norms')->result();
        $campus = $this->painelbd->getWhere("campus")->result();
        $typesArq =$this->painelbd->getWhere("mural_type_items")->result();
        $data = array(
            'titulo' => 'Cadastrado de arquivos do mural',
            'conteudo' => 'paineladm/mural/arquivos/cadastrar',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'temps' => $dados,
                'campus' => $campus,
                'types' => $typesArq,
                'tipo' => 'temps')
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_norma_institucional($id = NULL)
    {
        verificaLogin();
        $campus = '1';

        $this->load->helper('file');
        $dados = $this->painelbd->getWhere('mural_institutional_norms', array('id' => $id))->row();


        date_default_timezone_set('America/Sao_Paulo');


        $this->form_validation->set_rules('name', 'Nome', 'required');

        $path = 'assets/mural';
        is_way($path);


        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            $dados_form['usersid'] = $this->session->userdata('codusuario');
            $dados_form['datemodified'] = date('Y-m-d H:i:s');
            $dados_form['id'] = $id;
            if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['name'])) {
                $name_tmp = noAccentuation($this->input->post('title'), 'temp');
                $upload = $this->bd->uploadFiles('arquivo', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF|doc|DOC|docx|DOCX', $name_tmp);

            }

            if ($dados->name != $this->input->post('name')) {
                $dados_form['name'] = $this->input->post('name');
            }

            if ($dados->campusid != $this->input->post('campusid')) {
                $dados_form['campusid'] = $this->input->post('campusid');
            }
            if ($dados->status+1 != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
                $dados_form['status'] -= 1;
            }
            if ($dados->mural_typeid != $this->input->post('type')) {
                $dados_form['mural_typeid'] = $this->input->post('type');
            }

            if (isset($upload)) {
                if ($upload) {
                    $dados_form['files'] = $path . '/' . $upload['file_name'];

                    if ($this->bd->salvar('mural_institutional_norms', $dados_form) == TRUE) {
                        setMsg('<p>Arquivo alterado com sucesso.</p>', 'success');
                        redirect('Painel_mural_digital/normas_institucionais');
                    } else {
                        setMsg('<p>Erro! O Arquivo não foi alterado.</p>', 'error');
                        redirect('Painel_mural_digital/normas_institucionais');
                    }
                } else {
                    //erro no upload
                    $msg = $this->upload->display_erros();
                    $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            } elseif (isset($dados_form['name']) || isset($dados_form['campusid']) ||isset($dados_form['status']) || isset($dados_form['mural_typeid'])) {
                if ($this->bd->salvar('mural_institutional_norms', $dados_form) == TRUE) {
                    setMsg("<p>Alterado com sucesso.</p>", 'success');
                    redirect('Painel_mural_digital/normas_institucionais');
                } else {
                    setMsg('<p>Erro! Não foi alterado.</p>', 'error');
                    redirect('Painel_mural_digital/normas_institucionais');
                }
            } else {
                setMsg('<p>Atenção!Não houve alteração.</p>', 'alert');
            }
        }

        $campus = $this->painelbd->getWhere("campus")->result();
        $dados = $this->painelbd->getWhere('mural_institutional_norms', array('id' => $id))->row();
        $typesArq =$this->painelbd->getWhere("mural_type_items")->result();
        $data = array(
            'titulo' => 'Editar - Arquivo do Mural',
            'conteudo' => 'paineladm/mural/arquivos/editar',
            'dados' => array(
                'norms' => $dados,
                'item' => $id,
                'campus' => $campus,
                'types' => $typesArq,
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'tipo' => 'normas'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function statusAlter_norma_institucional($id = NULL, $status = null)
    {
        verificaLogin();
        $dados_form['status'] = $status;
        $dados_form['usersid'] = $this->session->userdata('codusuario');
        $dados_form['datemodified'] = date('Y-m-d H:i:s');
        $dados_form['id'] = $id;
        $messagem = null;
        $messageNot = null;


        if ($status == 0) {
            $messagem = '<p>O Arquivo foi inativado com sucesso.</p>';
            $messageNot = '<p>Erro! O Arquivo foi não inativado.</p>';
        } else {
            $messagem = '<p>O Arquivo foi ativido com sucesso.</p>';
            $messageNot = '<p>Erro! O Arquivo foi não ativado.</p>';
        }

        if ($this->bd->salvar('mural_institutional_norms', $dados_form) == TRUE) {
            setMsg($messagem, 'success');
            redirect('Painel_mural_digital/normas_institucionais');
        } else {
            setMsg($messageNot, 'error');
            redirect('Painel_mural_digital/normas_institucionais');
        }

        $dados = $this->painelbd->getWhere('mural_institutional_norms')->result();
        $data = array(
            'titulo' => 'Arquivos do Mural.',
            'conteudo' => 'paineladm/mural/arquivos/lista',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $dados,
                'item' => $id,
                'tipo' => 'temps'
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function d1elete_norma_institucional($id = NULL)
    {
        verificaLogin();
        $dtemps = $this->painelbd->getWhere('mural_institutional_norms', array('id'=>$id))->row();

        $origem = $dtemps->files;
        $nome = explode('/', $origem);
        $nome = end($nome);

       $destino = "assets/delete/mural";
        is_way($destino);
        $destino = $destino+$nome;
        if(copy($origem, $destino)) {
            if ($this->bd->delete('files_temp', $id) == TRUE) {
                unlink($origem);
                setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
                redirect('Painel_home/tempArg');
            } else {
                setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
                redirect('Painel_home/tempArg');
            }
        }

        $dados = $this->painelbd->getWhere('files_temp')->result();
        $data = array(
            'titulo' => 'Editar - Arquivo Temp.',
            'conteudo' => 'paineladm/temps/lista',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $dados,
                'item' => $id,
                'tipo' => 'temps'
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }




}
