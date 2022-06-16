<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_vestibular Extends CI_Controller
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

    /** MODULO DE INFORMAÇÕES DO VESTIBULAR  **/

    public function informacoesVestibular()
    {
        verificaLogin();

        $fieldsBd = array(
            'vestibular.id',
            'vestibular.usersid',
            'campus.id as idCampus',
            'campus.name as nameCampus',
            'campus.city as cityCampus',
            'vestibular.datecreated',
            'vestibular.datemodified',
            'vestibular_situation.name as vestibularSituation');
        $dataJoin = array(
            'vestibular' => 'vestibular.campusid = campus.id',
            'vestibular_situation' => 'vestibular_situation.id = vestibular.vestibular_situationid',
        );

        $vestibularSituation = $this->bd->where($fieldsBd, 'campus', $dataJoin, NULL)->result();

        $data = array(
            'titulo' => 'Informações do Vestibular',
            'conteudo' => 'paineladm/vestibular/informacoesVestibular/lista',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $vestibularSituation,
                'tipo' => 'provaGab'
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_informacoes_vestibular($idVestibular)
    {
        verificaLogin();

        $fieldsBd = array(
            'vestibular.id',
            'vestibular_files.files',
            'vestibular.name as nameVestibular',
            'vestibular.link',
            'campus.name as nameCampus',
            'campus.id as idCampus',
            'campus.city as cityCampus',
            'vestibular.datecreated',
            'vestibular.datemodified',
            'vestibular_situation.name as vestibularSituation', 'vestibular_situation.id as idSituation');
        $dataJoin = array(
            'vestibular' => 'vestibular.campusid = campus.id',
            'vestibular_situation' => 'vestibular_situation.id = vestibular.vestibular_situationid',
            'vestibular_files'=>'vestibular_files.vestibularid = vestibular.id'
        );
        $whereBd = array('vestibular.id'=>$idVestibular,'vestibular_files.typesid'=>1);

        $vestibularSituation = $this->bd->where($fieldsBd, 'campus', $dataJoin, $whereBd)->row();

        $this->form_validation->set_rules('name', 'Nome do Vestibular ', 'required');
        $this->form_validation->set_rules('vestibular_situationid', 'Situação do Vestibular ', 'required');


        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if ($vestibularSituation->nameVestibular != $this->input->post('name')) {
                $dados_form['name'] = $this->input->post('name');
            }
            if ($vestibularSituation->idCampus != $this->input->post('campusid')) {
                $dados_form['campusid'] = $this->input->post('campusid');
            }

            if ($vestibularSituation->idSituation != $this->input->post('vestibular_situationid')) {
                $dados_form['vestibular_situationid'] = $this->input->post('vestibular_situationid');
            }

            $link = $this->input->post('link');
            $dadosLink = $vestibularSituation->link;


            if ($link !='' and   $dadosLink != $link ) {
                $dados_form['link'] = $this->input->post('link');
            }

            if(isset($dados_form)){
                $dados_form['datemodified'] = date('Y-m-d H:i:s');
                $dados_form['id']=$vestibularSituation->id;
                $dados_form['usersid']=$this->session->userdata('codusuario');
                if ($this->bd->salvar('vestibular', $dados_form) == TRUE) {
                    setMsg('<p>Dados alterados com sucesso.</p>', 'success');
                    redirect('Painel_vestibular/informacoesVestibular');
                } else {
                    setMsg('<p>Erro! Os dados não foi alterado.</p>', 'error');
                    redirect('Painel_vestibular/informacoesVestibular');
                }
            }else{
                setMsg('<p>Atenção! Você não fez nenhuma alteração.</p>', 'alert');
            }


        }

        $data = array(
            'titulo' => 'Informações do Vestibular',
            'conteudo' => 'paineladm/vestibular/informacoesVestibular/editar',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $vestibularSituation,
                'tipo' => 'provaGab',
                'locaisCampus'=>$this->bd->where('*','campus',NULL,array('visible'=>'SIM'))->result(),
                'situation' => $this->bd->where('*','vestibular_situation',NULL,NULL)->result(),
                'campus'=>$this->bd->where('*','campus',NULL, array('id'=>$vestibularSituation->idCampus))->row()
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editarInformacoesVestibular($idVestibular)
    {
        verificaLogin();

        $fieldsBd = array(
            'vestibular.id',
            'vestibular_files.files',
            'vestibular.name as nameVestibular',
            'vestibular.link',
            'campus.name as nameCampus',
            'campus.id as idCampus',
            'campus.city as cityCampus',
            'vestibular.datecreated',
            'vestibular.datemodified',
            'vestibular_situation.name as vestibularSituation', 'vestibular_situation.id as idSituation');
        $dataJoin = array(
            'vestibular' => 'vestibular.campusid = campus.id',
            'vestibular_situation' => 'vestibular_situation.id = vestibular.vestibular_situationid',
            'vestibular_files'=>'vestibular_files.vestibularid = vestibular.id'
        );
        $whereBd = array('vestibular.id'=>$idVestibular,'vestibular_files.typesid'=>1);

        $vestibularSituation = $this->bd->where($fieldsBd, 'campus', $dataJoin, $whereBd)->row();

        $this->form_validation->set_rules('name', 'Nome do Vestibular ', 'required');
        $this->form_validation->set_rules('vestibular_situationid', 'Situação do Vestibular ', 'required');


        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if ($vestibularSituation->nameVestibular != $this->input->post('name')) {
                $dados_form['name'] = $this->input->post('name');
            }
            if ($vestibularSituation->idCampus != $this->input->post('campusid')) {
                $dados_form['campusid'] = $this->input->post('campusid');
            }

            if ($vestibularSituation->idSituation != $this->input->post('vestibular_situationid')) {
                $dados_form['vestibular_situationid'] = $this->input->post('vestibular_situationid');
            }

            $link = $this->input->post('link');
            $dadosLink = $vestibularSituation->link;


            if ($link !='' and   $dadosLink != $link ) {
                $dados_form['link'] = $this->input->post('link');
            }

            if(isset($dados_form)){
                $dados_form['datemodified'] = date('Y-m-d H:i:s');
                $dados_form['id']=$vestibularSituation->id;
                $dados_form['usersid']=$this->session->userdata('codusuario');
                if ($this->bd->salvar('vestibular', $dados_form) == TRUE) {
                    setMsg('<p>Dados alterados com sucesso.</p>', 'success');
                    redirect('Painel_vestibular/informacoesVestibular');
                } else {
                    setMsg('<p>Erro! Os dados não foi alterado.</p>', 'error');
                    redirect('Painel_vestibular/informacoesVestibular');
                }
            }else{
                setMsg('<p>Atenção! Você não fez nenhuma alteração.</p>', 'alert');
            }


        }

        $data = array(
            'titulo' => 'Informações do Vestibular',
            'conteudo' => 'paineladm/vestibular/informacoesVestibular/editar',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $vestibularSituation,
                'tipo' => 'provaGab',
                'locaisCampus'=>$this->bd->where('*','campus',NULL,array('visible'=>'SIM'))->result(),
                'situation' => $this->bd->where('*','vestibular_situation',NULL,NULL)->result(),
                'campus'=>$this->bd->where('*','campus',NULL, array('id'=>$vestibularSituation->idCampus))->row()
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }


    /** FIM DO MÓDULO - INFORMAÇÕES DO VESTIBULAR **/


    /**MODULO DE ARQUIVOS DO VESTIBULAR **/

    public function vestfiles($tipo = null)
    {
        verificaLogin();
        if ($tipo == null) {
            redirect('painel');
        }
        if ($tipo == 'provaGab') {
            //banco de dados
            $fieldsBd = array(" vestibular_exams.id", "vestibular_exams.title as name" ,"vestibular_exams.status",
                "vestibular_exams.files", "vestibular_exams.datacreated as datecreated","vestibular_exams.datemodified",
		"vestibular.name as vestname","vestibular_exams_types.title");
            $table = 'vestibular_exams';
            $dataJoin = array('vestibular'=>'vestibular_exams.vestibularid = vestibular.id ',
                'vestibular_exams_types' => 'vestibular_exams.typeid= vestibular_exams_types.id');
            if (!in_array("admTempsArgs", $_SESSION['permissionCampus']['campus-1'])) {
                $whereBD = "vestibular_exams.status = 1 ";
            }else{
                $whereBD = null;
            }
            $order['campo'] = 'vestibular_exams.id';
            $order['ordem'] = 'DESC';
            //view
            $titulo = "PROVAS E GABARITOS";
        }
        if ($tipo == 'files') {
            //banco de dados
            $dataJoin = array(
                'vestibular_exams_types' => 'vestibular_files.typesid = vestibular_exams_types.id',
                'vestibular' => 'vestibular_files.vestibularid = vestibular.id'
            );

            $fieldsBd = array('vestibular_files.id', ' vestibular_files.name', 'vestibular_files.datecreated','vestibular_files.status',
                'vestibular_files.datemodified', 'vestibular_exams_types.title', 'vestibular.name as vestname', 'vestibular_files.files');
            $whereBD = null;
            $order['campo'] = 'vestibular_files.id';
            $order['ordem'] = 'DESC';
            $table = 'vestibular_files';
            //view
            $titulo = "ARQUIVOS VESTIBULAR";
        }

        $listagem = $this->bd->where($fieldsBd, $table, $dataJoin, $whereBD, $order)->result();


        $data = array(
            'titulo' => $titulo,
            'conteudo' => 'paineladm/vestibular/vestfiles/lista',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $listagem,
                'tipo' => $tipo,
                'titulo' => $titulo
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_vestfiles($tipo = null)
    {
        $this->load->helper('file');
        verificaLogin();
        if ($tipo == null) {
            redirect('painel');
        }
        if ($tipo == 'provaGab') {
            //view
            $titulo = 'Provas e Gabaritos';
            //caminho de upload
            $path = 'assets/vestibularP/provaGabarito';
            //campos de banco de dados
            $userBD = 'userid';
            $typeBD = 'typeid';
            $nameBD = 'title';
            //tabela do banco de dados
            $table = 'vestibular_exams';
        }
        if($tipo == 'files'){
            //view
            $titulo = 'Arquivos do Vestibular';
            //caminho de upload
            $path = 'assets/vestibularP/files';
            //campos de banco de dados
            $userBD = 'usersid';
            $typeBD = 'typesid';
            $nameBD = 'name';
            //tabela do banco de dados
            $table = 'vestibular_files';

        }
        $this->form_validation->set_rules('title', 'Titulo', 'required');
        $this->form_validation->set_rules('nome', 'Tipo', 'required');
        $this->form_validation->set_rules('name', 'Vestibular', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'erro');
            endif;
        } else {
            is_way($path);
            if (unique_name_args(noAccentuation($this->input->post('title'), $tipo), $path)) {
                $name_tmp = null;
            } else {
                $name_tmp = noAccentuation($this->input->post('title'), $tipo);
            }

            $upload = $this->bd->uploadFiles('files', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF', $name_tmp);

            if ($upload) {
                //upload efetuado
                $dados_form['status'] = $this->input->post('status')-1;
                $dados_form [$nameBD] = $this->input->post('title');
                $dados_form['files'] = base_url($path . '/' . $upload['file_name']);
                $dados_form[$userBD] = $this->session->userdata('codusuario');
                $dados_form[$typeBD] = $this->input->post('nome');
                $dados_form['vestibularid'] = $this->input->post('name');


                if ($this->painelbd->salvar($table, $dados_form) == TRUE) {
                    setMsg('<p>Publicação cadastrada com sucesso.</p>', 'success');
                    redirect('Painel_vestibular/vestfiles/'.$tipo);
                } else {
                    setMsg('<p>Erro! A publicação não foi cadastrada.</p>', 'error');
                    redirect('Painel_vestibular/vestfiles/'.$tipo);
                }


            } else {
                //erro no upload
                $msg = $this->upload->display_erros();
                $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }


        }


        $dados = $this->painelbd->getWhere($table)->result();
        $tiposems = $this->painelbd->getWhere('vestibular_exams_types')->result();
        $vestibular = $this->painelbd->getWhere('vestibular')->result();
        $data = array(
            'titulo' => 'Cadastro -'.$titulo,
            'conteudo' => 'paineladm/vestibular/vestfiles/cadastrar',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'temps' => $dados,
                'tipos' => $tiposems,
                'vestibular' => $vestibular,
                'tipo' => $tipo,
                'titulo'=> $titulo)
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_vestfiles($id = NULL, $tipo =  null)
    {
        $this->load->helper('file');
        verificaLogin();
        if ($tipo == 'provaGab') {
            //view
            $titulo = 'Provas e Gabaritos';
            //caminho de upload
            $path = 'assets/vestibularP/provaGabarito';
            //campos de banco de dados
            $userBD = 'userid';
            $typeBD = 'typeid';
            $nameBD = 'title';
            //tabela do banco de dados
            $table = 'vestibular_exams';
        }
        if($tipo == 'files'){
            //view
            $titulo = 'Arquivos do Vestibular';
            //caminho de upload
            $path = 'assets/vestibularP/files';
            //campos de banco de dados
            $userBD = 'usersid';
            $typeBD = 'typesid';
            $nameBD = 'name';
            //tabela do banco de dados
            $table = 'vestibular_files';

        }

        $this->load->helper('file');
        $dados = $this->painelbd->getWhere($table, array('id' => $id))->row();
        $tiposems = $this->painelbd->getWhere('vestibular_exams_types')->result();
        $vestibular = $this->painelbd->getWhere('vestibular')->result();
        if($tipo == 'files'){
            $userDa  = $dados->name;
            $typeDa = $dados->typesid;
        }
        if($tipo == 'provaGab'){
            $userDa  = $dados->title;
            $typeDa = $dados->typeid;
        }
        date_default_timezone_set('America/Sao_Paulo');


        $this->form_validation->set_rules('title', 'Título', 'required');




       if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            $dados_form[$userBD] = $this->session->userdata('codusuario');
            $dados_form['datemodified'] = date('Y-m-d H:i:s');
            $dados_form['id'] = $id;
            if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['name'])) {
                is_way($path);

                if (unique_name_args(noAccentuation($this->input->post('title'), $tipo), $path)) {
                    $name_tmp = null;
                } else {
                    $name_tmp = noAccentuation($this->input->post('title'), $tipo);
                }
                $upload = $this->bd->uploadFiles('arquivo', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF|doc|DOC|docx|DOCX', $name_tmp);

            }


          if ($userDa != $this->input->post('title')) {
              $dados_form[$userBD] = $this->input->post('title');
          }
          if ($typeDa != $this->input->post('type')) {
              $dados_form[$typeBD] = $this->input->post('type');
          }
          if ($dados->vestibularid != $this->input->post('vestibularid')) {
              $dados_form['vestibularid'] = $this->input->post('vestibularid');
          }
          if($dados->status != $this->input->post('status')){
              $dados_form['status'] = $this->input->post('status');
          }

            if (isset($upload)) {
                if ($upload) {
                    $dados_form['files'] = base_url($path . '/' . $upload['file_name']);

                    if ($this->bd->salvar($table, $dados_form) == TRUE) {
                        setMsg('<p>Arquivo alterado com sucesso.</p>', 'success');
                        redirect('Painel_vestibular/vestfiles/'.$tipo);
                    } else {
                        setMsg('<p>Erro! O Arquivo não foi alterado.</p>', 'error');
                        redirect('Painel_vestibular/vestfiles/'.$tipo);
                    }
                } else {
                    //erro no upload
                    $msg = $this->upload->display_erros();
                    $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            } elseif (isset($dados_form[$userBD]) || isset($dados_form[$typeBD]) || isset($dados_form['vestibularid']) || isset($dados_form['status'])) {
                if ($this->bd->salvar($table, $dados_form) == TRUE) {
                    setMsg('<p>Dados alterados com sucesso.</p>', 'success');
                    redirect('Painel_vestibular/vestfiles/'.$tipo);
                } else {
                    setMsg('<p>Erro! Os dados não foi alterado.</p>', 'error');
                    redirect('Painel_vestibular/vestfiles/'.$tipo);
                }
            } else {
                setMsg('<p>Atenção!Não houve alteração.</p>', 'alert');
            }
        }

        $dados = $this->painelbd->getWhere($table, array('id' => $id))->row();
        $data = array(
            'titulo' => 'Editar -'.$titulo ,
            'conteudo' => 'paineladm/vestibular/vestfiles/editar',
            'dados' => array(
                'provaGab' => $dados,
                'item' => $id,
                'tipos' => $tiposems,
                'vestibular' => $vestibular,
                'tipo' => $tipo,
                'titulo' => $titulo
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function statusAlter($id = NULL, $status = null,$table = null,$redirec = null,$tipo = null)
    {
        verificaLogin();
        $dados_form['status'] = $status;
        if($tipo == null){
            $dados_form['usersid'] = $this->session->userdata('codusuario');
        }
        $redirec = str_replace('-','/',$redirec);
        if($tipo == 'provaGab') {
            $dados_form['userid'] = $this->session->userdata('codusuario');
            $redirec = $redirec.'/'.$tipo;
        }
        if($tipo == 'files'){
            $dados_form['usersid'] = $this->session->userdata('codusuario');
            $redirec = $redirec.'/'.$tipo;
        }
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


        if ($this->bd->salvar(base64_decode($table), $dados_form) == TRUE) {
            setMsg($messagem, 'success');
            redirect($redirec);
        } else {
            setMsg($messageNot, 'error');
            redirect($redirec);
        }
    }

    public function deletaR1($id = NULL,$table = null,$redirec = null,$tipo = null)
    {
        verificaLogin();
        $table = base64_decode($table);
        $redirec = str_replace('-','/',$redirec);
        $destino = "assets/delete/vestfiles/";
        if($tipo == 'files'|| $tipo == 'provaGab'){
            $redirec = $redirec.'/'.$tipo;
            $destino = "assets/delete/vestfiles/$tipo/";
        }
        $dtemps = $this->painelbd->getWhere($table, array('id' => $id))->row();
        $origem = $dtemps->files;
        $nome = explode('/', $origem);
        $nome = end($nome);


        is_way($destino);
        $destino = $destino . $nome;
        if (copy($origem, $destino) || $nome == '<') {
            if ($this->bd->deletar($table, $id) == TRUE) {
                unlink($origem);
                setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
                redirect($redirec);
            } else {
                setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
                redirect($redirec);
            }
        }else if ($this->bd->deletar($table, $id) == TRUE){
            unlink($origem);
            setMsg("<p>O arquivo foi deletado sem copia. ERROR-011</p> ",'success');
            redirect($redirec);
        }
        else{
            setMsg('<p>Erro! não foi possivel deletar o arquivo. ERROR-023</p>','error');
            redirect($redirec);
        }
    }

}