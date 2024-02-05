<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Secretaria extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        verifica_login();
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('site_model', 'bancosite');
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function index()
    {
        $this->listaCartilhas();
    }

    public function taxaservicos($local=NULL)
    {
        if($local=='1'){
            $campus=$this->painelbd->getWhere('campus',array('id'=>1))->row();
        }elseif ($local=='2'){
            $campus=$this->painelbd->getWhere('campus',array('id'=>2))->row();
        }elseif ($local=='3'){
            $campus=$this->painelbd->getWhere('campus',array('id'=>3))->row();
        }
        $taxas = $this->painelbd->getWhere("rates",array('campusid'=>$campus->id))->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/itens_secretaria/taxaservicos/taxas',
            'dados' => array(
                'taxas' => $taxas,
                'tipo' => ''
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrarTaxa($local=NULL)
    {
        if($local=='1'){
            $campus=$this->painelbd->getWhere('campus',array('id'=>1))->row();
        }elseif ($local=='2'){
            $campus=$this->painelbd->getWhere('campus',array('id'=>2))->row();
        }elseif ($local=='3'){
            $campus=$this->painelbd->getWhere('campus',array('id'=>3))->row();
        }

        $this->form_validation->set_rules('name', 'Nome da Taxa', 'required');
        $this->form_validation->set_rules('value', 'Valor da taxa', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            //upload efetuado
            $dados_form = elements(array('name', 'value'), $this->input->post());
            $dados_form['userid'] = $this->session->userdata('codusuario');
            $dados_form['status'] = 1;
            $dados_form['campusid'] = $campus->id;
            $dados_form['firstfree'] = !empty($this->input->post('firstfree')) ? $this->input->post('firstfree') : NULL;

            if ($id = $this->painelbd->salvar('rates', $dados_form)) {
                setMsg('<p>Item cadastrado com sucesso.</p>', 'success');
                redirect('Secretaria/taxaservicos/'.$local);
            } else {
                setMsg('<p>Erro! O item não pode ser cadastrado.</p>', 'error');

                redirect('Secretaria/cadastrarTaxa/'.$local);
            }
        }

        $data = array(
            'titulo' => 'UniAtenas - Taxas e serviços',
            'conteudo' => 'paineladm/itens_secretaria/taxaservicos/cadastrarTaxa',
            'dados' => array(
                'tipo' => '',
                'titulo' => 'Taxas e serviços')
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editarTaxa($idTaxa=NULL)
    {

        if($idTaxa==NULL) {
            redirect('Secretaria/taxaservicos');
        }

        $campus = $this->painelbd->getWhere('campus')->result();

        $taxas = $this->painelbd->getWhere('rates',array('id'=>$idTaxa))->row();

        $queryCampos = "select 
                            rates_has_campus.id ,
                            rates_has_campus.campusid  as campusid,
                            rates_has_campus.ratesid,
                            campus.id, 
                            campus.city
                            from rates_has_campus
                            inner join campus on campus.id = rates_has_campus.campusid
                            where rates_has_campus.ratesid=$idTaxa
                            order by rates_has_campus.id
                            ";
        $campustax = $this->painelbd->getQuery($queryCampos)->result();

        $this->form_validation->set_rules('name', 'Nome da Taxa', 'required');
        $this->form_validation->set_rules('value', 'Valor da taxa', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            //upload efetuado
            $dados_form = elements(array('name', 'value'), $this->input->post());
            $dados_form['userid'] = $this->session->userdata('codusuario');
            $dados_form['status'] = 1;
            $dados_form['firstfree'] = !empty($this->input->post('firstfree')) ? $this->input->post('firstfree') : NULL;
            $dados_form['id'] = $idTaxa;

            if ($id = $this->painelbd->salvar('rates', $dados_form)) {
                setMsg('<p>Taxas e serviços editado com sucesso.</p>', 'success');
                redirect('Secretaria/taxaservicos');
            } else {
                setMsg('<p>Erro! A taxa,  não pode ser editada.</p>', 'error');
                //redirect('Secretaria/taxaservicos');
            }

        }

        $data = array(
            'titulo' => 'UniAtenas - Taxas e serviços',
            'conteudo' => 'paineladm/itens_secretaria/taxaservicos/editarTaxa',
            'dados' => array(
                'tipo' => '',
                'titulo' => 'Taxas e serviços',
                'taxas'=>$taxas,
                'campustax'=>$campustax,
                'campus' => $campus)
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }




    public function listaCartilhas($campus = NULL)
    {

        $sql = "SELECT 
                files.id,
                files.name,
                campus.city,
                files.files,
                (case
                    WHEN files.datemodifIed='0000-00-00'  THEN datecreated
                    ELSE files.datemodifIed
                    END) as 'datemodifIed'
                FROM
                    files
                INNER JOIN campus on campus.id = files.campusid  
                
                ";
        $data = array(
            'titulo' => 'Gestão - Arquivo Horas Complementares',
            'conteudo' => 'paineladm/itens_paginas/secretaria/cartilha/listaCartilhas',
            'dados' => array(
                'files' => $this->painelbd->getQuery($sql)->result(),
                'tipo' => 'horasComplementares',
                'cursos' => '$this->painelbd->getCourses($campus)->result()',
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrarCartilha()
    {
        $this->load->helper('file');
        $page = $this->uri->segment(3);
s
        $this->form_validation->set_rules('name', 'Título', 'required');

        if ($this->input->post('campusid') == '0') {
            $this->form_validation->set_rules('campusid', 'Campus', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar ao menos um campus.');
        } else {
            $this->form_validation->set_rules('campusid', 'Campus');
        }

        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato XLS ou XLSX.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            $campusName = $this->painelbd->getWhere('campus', array('id' => $this->input->post('campusid')))->row();
            $nameTmp = str_replace(' ', '', $campusName->city);
            //Upload da imagem e sua respectiva pasta - Path
            $path = 'assets/files/cartilhas';
            //Não esquecer que a pasta já deve existir, caso contrário gerará um erro
            $upload = $this->painelbd->uploadFiles('files', $path, $types = 'xls|xlsx', 'cartilha_' . $nameTmp);
            if ($upload) {
                //upload efetuado


                $dados_form = elements(array('name', 'campusid', 'files'), $this->input->post());
                $user = $this->painelbd->getWhere('users', array('user' => $this->session->userdata('user')))->row();
                $dados_form['files'] = $path . '/' . $upload['file_name'];
                $dados_form['usersid'] = $user->id;

                if ($id = $this->painelbd->salvar('files', $dados_form)) {
                    setMsg('<p>Arquivo cadastrado com sucesso.</p>', 'success');
                    redirect('Secretaria/listaCartilhas');
                } else {
                    setMsg('<p>Erro! O Arquivo o não foi cadastrado.</p>', 'error');
                    redirect('Secretaria/listaCartilhas');
                }
            } else {
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }
        }

        $data = array(
            'conteudo' => 'paineladm/itens_paginas/secretaria/cartilha/cadastrarCartilha',
            'dados' => array(
                'tipo' => '',
                'titulo' => 'Cadastrar Cartilhas',
                'publicacoes' => '$dados',
                'campus' => $this->painelbd->getWhere('campus', array('id' => 1))->result(),
                'page' => $page)
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editarCartilha($id = NULL)
    {

        if (empty($id)) {
            redirect('Secretaria/listaCartilhas');
        }
        $this->load->helper('file');

        $sql = "SELECT 
                    files.id,
                    campus.name as 'nameCampus',
                    campus.city,
                    files.campusid,
                    files.name,
                    files.files,
                    files.status,
                    (CASE
                        WHEN files.datemodifIed = '0000-00-00' THEN datecreated
                        ELSE files.datemodifIed
                    END) AS 'datemodifIed'
                FROM
                    files
                        INNER JOIN
                    campus ON campus.id = files.campusid
                WHERE 
                     files.id =$id";

        $files = $this->painelbd->getQuery($sql)->row();
        $this->form_validation->set_rules('name', 'Título', 'required');

        if ($this->input->post('campusid') == '0') {
            $this->form_validation->set_rules('campusid', 'Campus', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar ao menos um campus.');
        } else {
            $this->form_validation->set_rules('campusid', 'Campus');
        }

        /* if (empty($_FILES['files']['name']) and ($files->files)) {
          $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
          $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato XLS ou XLSX.');
          } */

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {


            if (isset($_FILES['files']) and !empty($this->input->post('files'))) {

                $campusName = $this->painelbd->getWhere('campus', array('id' => $this->input->post('campusid')))->row();
                $nameTmp = str_replace(' ', '', $campusName->city);

                //Upload da imagem e sua respectiva pasta - Path
                $path = 'assets/files/cartilhas';
                $file_antigo = $files->files;

                $upload = $this->painelbd->uploadFiles('files', $path, $types = 'xls|xlsx', 'cartilha_' . $nameTmp);

                if ($upload):
                    //upload efetuado
                    unlink($file_antigo);
                    $dados_form = elements(array('name', 'campusid', 'files'), $this->input->post());
                    $user = $this->painelbd->getWhere('users', array('user' => $this->session->userdata('user')))->row();
                    $dados_form['files'] = $path . '/' . $upload['file_name'];
                    $dados_form['usersid'] = $user->id;
                    $dados_form['id'] = $files->id;
                    $dados_form['status'] = '1';

                    if ($this->painelbd->salvar('files', $dados_form) == TRUE) {
                        setMsg('<p>Informações editadas com sucesso.</p>', 'success');
                        redirect('Secretaria/listaCartilhas');
                    } else {
                        setMsg('<p>Erro! As informações não foram editadas.</p>', 'error');
                    }
                else:
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                endif;

                //opção de quando não é enviado um novo arquivo para upload.
            } else {

                $dados_form = elements(array('name', 'campusid'), $this->input->post());
                $user = $this->painelbd->getWhere('users', array('id' => $this->session->userdata('id')))->row();
                $dados_form['usersid'] = $user->id;
                $dados_form['status'] = '1';
                $dados_form['id'] = $files->id;

                if ($this->painelbd->salvar('files', $dados_form) == TRUE):
                    setMsg('<p>Informações eidtadas com sucesso.</p>', 'success');
                    redirect('Secretaria/listaCartilhas');
                else:
                    setMsg('<p>Erro! As informações não foram editadas.</p>', 'error');
                endif;
            }
        }


        $data = array(
            'conteudo' => 'paineladm/itens_paginas/secretaria/cartilha/editarCartilha',
            'dados' => array(
                'tipo' => '',
                'files' => $files,
                'campus' => $this->painelbd->getWhere('campus', array('id' => 1))->result(),
                'page' => '$page')
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar1($table = NULL, $pagina = NULL, $id = NULL)
    {

        $dados = $this->painelbd->getWhere($table, array('id' => $id))->row();

        $arquivo = isset($dados->files) ? $dados->files : '';
        $pagina = str_replace('pag', '', $pagina);
        if ($id != NULL && $dados) {
            if ($del = $this->painelbd->delete($table, array('id' => $id))) {
                if (!unlink($arquivo)) {
                    setMsg('Não foi possível remover o arquivo de nome ' . $arquivo . '', 'alert');
                    redirect(current_url());
                } else {
                    setMsg('<p>Item deletado com sucesso.</p>', 'success');
                    redirect($pagina);
                }
            } else {
                setMsg('<p>Erro! O item não pode ser deletado.</p>', 'error');
                redirect($pagina);
            }
        } else {

            //$this->session->set_flashdata('error_msg', 'Não existe disciplina com esse ID.');
            //redirect(base_url('disciplinas'));
        }
    }

    public function calendarios_semestre($campus)
    {
        $data = array(
            'titulo' => 'Início',
            'conteudo' => 'paineladm/secretaria/calendariosSemestre/listaCalendarios',
            'dados' => array(
                'calendarios' => '',
                'tipo' =>'',
                'campus' => $this->painelbd->getWhere('campus',array('id'=>$campus))->row(),
                'page' => '')
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrarCalendario($id)
    {
        $this->load->helper('file');
        $page = $this->uri->segment(3);

        $this->form_validation->set_rules('name', 'Título', 'required');

        if ($this->input->post('status') == '0') {
            $this->form_validation->set_rules('status', 'Campus', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar uma situação (Ativo ou Inativo).');
        } else {
            $this->form_validation->set_rules('status', 'Campus');
        }

        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato XLS ou XLSX.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            //Upload da imagem e sua respectiva pasta - Path
            $path = 'assets/files/muralProvas/salasProva';
            //Não esquecer que a pasta já deve existir, caso contrário gerará um erro
            $upload = $this->painelbd->uploadFiles('files', $path, $types = 'pdf', NULL);

            if (is_dir(FCPATH . "/assets/images/courses/photos/$campus->id/$courses->courses_id")) {
                $path = "assets/images/courses/photos/$campus->id/$courses->courses_id";
            } else {
                mkdir(FCPATH . "/assets/images/courses/photos/$campus->id/$courses->courses_id", 0777, true);
                $path = "assets/images/courses/photos/$campus->id/$courses->courses_id";
            }

            if ($upload) {
                //upload efetuado
                $dados_form_file = elements(array('name', 'campusid', 'coursesid', 'files'), $this->input->post());
                $dados_form = elements(array('name', 'cycle', 'typelist', 'datestart', 'dateend', 'coursesid'), $this->input->post());

                $user = $this->painelbd->getWhere('users', array('user' => $this->session->userdata('user')))->row();
                $dados_form_file['files'] = $path . '/' . $upload['file_name'];
                $dados_form_file['usersid'] = $user->id;
                $dados_form_file['status'] = 1;

                if (($id = $this->painelbd->salvarId('files', $dados_form_file)) == TRUE) {

                    $dados_form['schoolsemesterid'] = 2; //recebendo o id do semestre ativo - MAUANLMENTE, mudar depois para automático
                    $dados_form['filesid'] = $id;
                    $dados_form['usersid'] = $user->id;

                    if ($this->painelbd->salvar('courses_exams_lists', $dados_form) == TRUE) {
                        setMsg('<p>Arquivo cadastrado com sucesso.</p>', 'success');
                        redirect('secretaria/listaProvas/' . $dados_form['coursesid'] . '/' . $dados_form['campusid']);
                    }

                } else {
                    setMsg('<p>Erro! O Arquivo o não foi cadastrado.</p>', 'error');
                    redirect('secretaria/listaProvas/' . $dados_form['coursesid'] . '/' . $dados_form['campusid']);
                }

            } else {
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }
        }

        $data = array(
            'titulo' => 'Gestão - Calendários Semestre',
            'conteudo' => 'paineladm/secretaria/calendariosSemestre/cadastrarCalendario',
            'dados' => array(
                'tipo' => '',
                'campus' => $this->painelbd->getWhere('campus', array('id' => $id))->row())
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editarCalendario($id = NULL)
    {

        if (empty($id)) {
            redirect('Secretaria/listaCartilhas');
        }
        $this->load->helper('file');

        $sql = "SELECT 
                    files.id,
                    campus.name as 'nameCampus',
                    campus.city,
                    files.campusid,
                    files.name,
                    files.files,
                    files.status,
                    (CASE
                        WHEN files.datemodifIed = '0000-00-00' THEN datecreated
                        ELSE files.datemodifIed
                    END) AS 'datemodifIed'
                FROM
                    files
                        INNER JOIN
                    campus ON campus.id = files.campusid
                WHERE 
                     files.id =$id";

        $files = $this->painelbd->getQuery($sql)->row();
        $this->form_validation->set_rules('name', 'Título', 'required');

        if ($this->input->post('campusid') == '0') {
            $this->form_validation->set_rules('campusid', 'Campus', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar ao menos um campus.');
        } else {
            $this->form_validation->set_rules('campusid', 'Campus');
        }

        /* if (empty($_FILES['files']['name']) and ($files->files)) {
          $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
          $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato XLS ou XLSX.');
          } */

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {


            if (isset($_FILES['files']) and !empty($this->input->post('files'))) {

                $campusName = $this->painelbd->getWhere('campus', array('id' => $this->input->post('campusid')))->row();
                $nameTmp = str_replace(' ', '', $campusName->city);

                //Upload da imagem e sua respectiva pasta - Path
                $path = 'assets/files/cartilhas';
                $file_antigo = $files->files;

                $upload = $this->painelbd->uploadFiles('files', $path, $types = 'xls|xlsx', 'cartilha_' . $nameTmp);

                if ($upload):
                    //upload efetuado
                    unlink($file_antigo);
                    $dados_form = elements(array('name', 'campusid', 'files'), $this->input->post());
                    $user = $this->painelbd->getWhere('users', array('user' => $this->session->userdata('user')))->row();
                    $dados_form['files'] = $path . '/' . $upload['file_name'];
                    $dados_form['usersid'] = $user->id;
                    $dados_form['id'] = $files->id;
                    $dados_form['status'] = '1';

                    if ($this->painelbd->salvar('files', $dados_form) == TRUE) {
                        setMsg('<p>Informações editadas com sucesso.</p>', 'success');
                        redirect('Secretaria/listaCartilhas');
                    } else {
                        setMsg('<p>Erro! As informações não foram editadas.</p>', 'error');
                    }
                else:
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                endif;

                //opção de quando não é enviado um novo arquivo para upload.
            } else {

                $dados_form = elements(array('name', 'campusid'), $this->input->post());
                $user = $this->painelbd->getWhere('users', array('id' => $this->session->userdata('id')))->row();
                $dados_form['usersid'] = $user->id;
                $dados_form['status'] = '1';
                $dados_form['id'] = $files->id;

                if ($this->painelbd->salvar('files', $dados_form) == TRUE):
                    setMsg('<p>Informações eidtadas com sucesso.</p>', 'success');
                    redirect('Secretaria/listaCartilhas');
                else:
                    setMsg('<p>Erro! As informações não foram editadas.</p>', 'error');
                endif;
            }
        }


        $data = array(
            'conteudo' => 'paineladm/itens_paginas/secretaria/cartilha/editarCartilha',
            'dados' => array(
                'tipo' => '',
                'files' => $files,
                'campus' => $this->painelbd->getWhere('campus', array('id' => 1))->result(),
                'page' => '$page')
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }


    public function salasProvas($idcampus = 1, $cursos = NULL)
    {

        $sql = "SELECT 
                    campus.name as nameCampus,
                    campus.id as idCampus, 
                    courses.name as nameCourse,
                    courses.id as idCourses,
                    courses.icone   
                 FROM
                     campus_has_courses as camps
                 JOIN campus on campus.id = camps.campus_id
                 JOIN courses on courses.id = camps.courses_id  
                 WHERE camps.campus_id = $idcampus
                ";
        $data = array(
            'titulo' => 'Gestão - Arquivo Horas Complementares',
            'conteudo' => 'paineladm/itens_paginas/secretaria/salas_provas/cursosProvas',
            'dados' => array(
                'files' => '',
                'tipo' => '',
                'cursos' => $this->painelbd->getQuery($sql)->result(),
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function listaProvas($idCourses = NULL, $idCampus = NULL)
    {

        $sql = "SELECT 
                    files.id, 
                    files.files, 
                    courses_exams_lists.typelist as tipoalunos,
                    courses_exams_lists.name as name,
                    courses.id as coursesid,
                    courses.name as coursesname,
                    campus.id as campusid, 
                    campus.name as campusname,
                    campus.city, 
                    courses_exams_lists.datestart,
                    courses_exams_lists.dateend,
                    courses_exams_lists.datemodifIed
                FROM
                    at_site.courses_exams_lists
                inner JOIN 
                    files on files.id = courses_exams_lists.filesid
                inner join 
                    courses on courses.id = courses_exams_lists.coursesid
                inner join 
                    campus on campus.id = files.campusid

                    where courses.id = $idCourses
                    and courses.id <> 3
                    and campus.id = $idCampus";


        $data = array(
            'titulo' => 'Gestão - Lista de Salas de Provas',
            'conteudo' => 'paineladm/itens_paginas/secretaria/salas_provas/listaProvas',
            'dados' => array(
                'files' => $this->painelbd->getQuery($sql)->result(),
                'tipo' => 'inputMask',
                'curso' => $this->painelbd->getWhere('courses', array('id' => $idCourses))->row(),
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrarLista($idCourses = NULL)
    {
        $this->load->helper('file');

        $this->form_validation->set_rules('name', 'Título', 'required');

        if ($this->input->post('cycle') == '0') {
            $this->form_validation->set_rules('cycle', 'Ciclo', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar o ciclo.');
        } else {
            $this->form_validation->set_rules('typesfile', 'Ciclo');
        }

        $this->form_validation->set_rules('typelist', 'Tipo Alunos', 'required');
        $this->form_validation->set_rules('datestart', 'Data início', 'required');
        $this->form_validation->set_rules('dateend', 'Data fim', 'required');

        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            //Upload da imagem e sua respectiva pasta - Path
            $path = 'assets/files/muralProvas/salasProva';
            //Não esquecer que a pasta já deve existir, caso contrário gerará um erro
            $upload = $this->painelbd->uploadFiles('files', $path, $types = 'pdf', NULL);

            if ($upload) {
                //upload efetuado
                $dados_form_file = elements(array('name', 'campusid', 'coursesid', 'files'), $this->input->post());
                $dados_form = elements(array('name', 'cycle', 'typelist', 'datestart', 'dateend', 'coursesid'), $this->input->post());

                $user = $this->painelbd->getWhere('users', array('user' => $this->session->userdata('user')))->row();
                $dados_form_file['files'] = $path . '/' . $upload['file_name'];
                $dados_form_file['usersid'] = $user->id;
                $dados_form_file['status'] = 1;

                if (($id = $this->painelbd->salvarId('files', $dados_form_file)) == TRUE) {

                    $dados_form['schoolsemesterid'] = 2; //recebendo o id do semestre ativo - MAUANLMENTE, mudar depois para automático
                    $dados_form['filesid'] = $id;
                    $dados_form['usersid'] = $user->id;

                    if ($this->painelbd->salvar('courses_exams_lists', $dados_form) == TRUE) {
                        setMsg('<p>Arquivo cadastrado com sucesso.</p>', 'success');
                        redirect('secretaria/listaProvas/' . $dados_form['coursesid'] . '/' . $dados_form['campusid']);
                    }

                } else {
                    setMsg('<p>Erro! O Arquivo o não foi cadastrado.</p>', 'error');
                    redirect('secretaria/listaProvas/' . $dados_form['coursesid'] . '/' . $dados_form['campusid']);
                }

            } else {
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }
        }

        $data = array(
            'titulo' => 'Gestão - Cadastro de Salas de Provas',
            'conteudo' => 'paineladm/itens_paginas/secretaria/salas_provas/cadastrarLista',
            'dados' => array(
                'tipo' => '',
                'curso' => $this->painelbd->getWhere('courses', array('id' => $idCourses))->row(),
                'campus' => $this->painelbd->getWhere('campus', array('id' => 1))->row(),
                'page' => '$page')
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

}
