<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_arquivos_temporarios extends CI_Controller
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

    /************************************
     *  Modulo de arquivos e fotos temporarios  
     * ***********************************/
    public function lista_campus_temps(){
        verificaLogin();

        $page = 'Lista de Campus';
        $colunasResultadoCursos = 
            array('campus.id',
            'campus.name',
            'campus.city',
            'campus.uf'
        );
    
        $listagemDosCampus = $this->painelbd->where('*','campus',NULL, array('visible' => 'SIM'))->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/temps/lista_campus_temps',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => 'Listagem de Arquivos temporários - Por Campus',
                'campus'=> $listagemDosCampus,
                'tipo'=>'tabelaDatatable'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }
    
    public function tempArg()
    {
        verificaLogin();
        $uriCampus = $this->uri->segment(3);
        $campus = $this->painelbd->where(array('campus.id','campus.name'),'campus',NULL, array('visible' => 'SIM','campus.id'=>$uriCampus))->row();
        
        $listagem = $this->painelbd->where('*', 'files_temp', NULL, array('status' => '1','campusid'=>$campus->id), array('campo' => 'id', 'ordem' => 'DESC'))->result();
        
        $data = array(
            'titulo' => 'Arquivos -temporarios',
            'conteudo' => 'paineladm/temps/lista',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $listagem,
                'campus' => $campus,
                'tipo'=>'tabelaDatatable'
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_tempArg()
    {
        verificaLogin();
        $this->load->helper('file');
        $uriCampus = $this->uri->segment(3);
        $campus = $this->painelbd->where(array('campus.id','campus.name','campus.city'),'campus',NULL, array('visible' => 'SIM','campus.id'=>$uriCampus))->row();

        $this->form_validation->set_rules('title', 'Titulo', 'required');

        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            

            $path = "assets/temps";
            is_way($path);

            $name_tmp = noAccentuation($this->input->post('title'), 'temp');

            if (unique_name_args($name_tmp, $path)) {
                $name_tmp = null;
            }

            $upload = $this->bd->uploadFiles('files', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF', $name_tmp);

            if ($upload) {
                //upload efetuado          
                $campusId =  $this->input->post('campusid');   
                $dados_form = elements(array('title'), $this->input->post());
                $dados_form['files'] = $path . '/' . $upload['file_name'];
                $dados_form['link'] = base_url($dados_form['files']);
                $dados_form['campusid'] = $campusId;
                $dados_form['userid'] = $this->session->userdata('codusuario');
                $dados_form['status'] = '1';

                if ($this->painelbd->salvar('files_temp', $dados_form)) {
                    setMsg('<p>Publicação cadastrada com sucesso.</p>', 'success');
                    redirect('Painel_arquivos_temporarios/tempArg/'.$campusId);
                } else {
                    setMsg('<p>Erro! A publicação não foi cadastrada.</p>', 'error');
                    redirect('Painel_arquivos_temporarios/tempArg/'.$campusId);
                }
            } else {
                //erro no upload
                $msg = $this->upload->display_erros();
                $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }
        }


        $dados = $this->painelbd->getWhere('files_temp')->result();
        $data = array(
            'titulo' => 'Arquivos - Temporarios',
            'conteudo' => 'paineladm/temps/cadastrar',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'temps' => $dados,
                'campus' => $campus,
                'tipo' => '')
            );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_tempArg($campusId = NULL,$id = NULL)
    {
        verificaLogin();
        $this->load->helper('file');
        date_default_timezone_set('America/Sao_Paulo');

        $uriCampus = $campusId;

        $campus = $this->painelbd->where(array('campus.id','campus.name','campus.city'),'campus',NULL, array('visible' => 'SIM','campus.id'=>$uriCampus))->row();
        $dados = $this->painelbd->getWhere('files_temp', array('id' => $id))->row();

        $this->form_validation->set_rules('title', 'Título', 'required');

        $path = 'assets/temps';

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            

            $dados_form['userid'] = $this->session->userdata('codusuario');
            $dados_form['dateupdate'] = date('Y-m-d H:i:s');
            $dados_form['id'] = $id;
            if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['name'])) {
                $path = 'assets/temps';
                $name_tmp = noAccentuation($this->input->post('title'), 'temp');
                $upload = $this->bd->uploadFiles('arquivo', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF|doc|DOC|docx|DOCX', $name_tmp);
            }

            if ($dados->title != $this->input->post('title')) {
                $dados_form['title'] = $this->input->post('title');
            }

            if (isset($upload)) {
                if ($upload) {
                    $dados_form['files'] = $path . '/' . $upload['file_name'];
                    $dados_form['link'] = base_url($dados_form['files']);

                    if ($this->painelbd->salvar('files_temp', $dados_form)) {
                        setMsg('<p>Arquivo alterado com sucesso.</p>', 'success');
                        redirect('Painel_arquivos_temporarios/tempArg/'.$campus->id);
                    } else {
                        setMsg('<p>Erro! O Arquivo não foi alterado.</p>', 'error');
                        redirect('Painel_arquivos_temporarios/tempArg/'.$campus->id);
                    }
                } else {
                    //erro no upload
                    $msg = $this->upload->display_erros();
                    $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            } elseif (isset($dados_form['title'])) {
                echo "<script>alert($id)</script>";
                if ($this->painelbd->salvar('files_temp', $dados_form)) {
                    setMsg('<p>Apenas o título alterado com sucesso.</p>', 'success');
                    redirect("Painel_arquivos_temporarios/tempArg/$campusId/$id");
                } else {
                    setMsg('<p>Erro! O título não foi alterado.</p>', 'error');
                    redirect("Painel_arquivos_temporarios/tempArg/$campusId/$id");
                }
            } else {
                setMsg('<p>Atenção!Não houve alteração.</p>', 'alert');
            }
        }

        $dados = $this->painelbd->getWhere('files_temp', array('id' => $id))->row();
        $data = array(
            'titulo' => 'Editar - Arquivo Temp.',
            'conteudo' => 'paineladm/temps/editar',
            'dados' => array(
                'tempsarg' => $dados,
                'item' => $id,
                'campus' => $campus,
                'tipo' => ''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function statusAlter_tempArg($id = NULL, $status = null)
    {
        verificaLogin();
        $dados_form['status'] = $status;
        $dados_form['userid'] = $this->session->userdata('codusuario');
        $dados_form['dateupdate'] = date('Y-m-d H:i:s');
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

        if ($this->bd->salvar('files_temp', $dados_form)) {
            setMsg($messagem, 'success');
            redirect('Painel_home/tempArg');
        } else {
            setMsg($messageNot, 'error');
            redirect('Painel_home/tempArg');
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

    public function d1elete_tempArg($id = NULL,$campusId = NULL)
    {
        verificaLogin();
        $dtemps = $this->painelbd->getWhere('files_temp', array('id' => $id))->row();

        $origem = $dtemps->files;
        $nome = explode('/', $origem);
        $nome = end($nome);

        $destino = "assets/delete/temps/";
        is_way($destino);
        $destino = $destino . $nome;
        if (copy($origem, $destino) || $nome == '<') {
            if ($this->bd->deletar('files_temp', $id)) {
                unlink($origem);
                setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
                redirect("Painel_home/tempArg/$campusId");
            } else {
                setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
                redirect("Painel_home/tempArg/$campusId");
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