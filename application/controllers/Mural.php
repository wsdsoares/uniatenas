<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Mural extends CI_Controller {

    public function __construct() {
        parent::__construct();
        verifica_login();
        init_painel_adm();
        //$this->load->model('ondeEstou_model', 'ondeEstou');
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('Cpainel_model', 'bd');
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function mural() {
        //carrega a view
        $dados['tela'] = 'mural';
        $dados['modulo'] = 'pagina';
        $dados['diretorio_view'] = 'painel';
        $dados['local'] = $this->uri->segment(3);
        set_tema('titulo', 'Painel - MURAL TV');
        set_tema('conteudo', load_modulo_tela($dados));
        load_template();
    }

    public function informacoesProvas($campusId=NULL)
    {

        $queryCursos = "SELECT
                        campus_has_courses.id idCourseCAmpus,
                        courses.id as courses_id,
                        courses.name as name,
                        campus.id as campusId,
                        courses.icone,
                        campus.city,
                        campus.name as campusName
                        
                    FROM
                      at_site.campus_has_courses
                      inner join campus on campus.id = campus_has_courses.campus_id
                      inner join courses on courses.id = campus_has_courses.courses_id
                    WHERE campus.id = $campusId
                    ORDER BY courses.name";

        $cursos = $this->painelbd->getQuery($queryCursos)->result();
        $data = array(
            'titulo' => 'Início',
            'conteudo' => 'paineladm/secretaria/informacoesProvas',
            'dados' => array(
                'campus'=>$this->painelbd->getWhere('campus', array('id'=>$campusId))->row(),
                'cursos' => $cursos,
                'tipo' => '',
                'page' => '')
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function calendariosProvasCurso($idCourseCampus=NULL)
    {
        $queryCurso = "SELECT
                        campus_has_courses.id idCourseCampus,
                        courses.id as courses_id,
                        courses.name as name,
                        campus.id as campusId,
                        courses.icone,
                        campus.city,
                        campus.name as campusName
                        
                    FROM
                      at_site.campus_has_courses
                      inner join campus on campus.id = campus_has_courses.campus_id
                      inner join courses on courses.id = campus_has_courses.courses_id
                    WHERE campus_has_courses.id = $idCourseCampus";

        $calendarsCourses = $this->painelbd->getQuery("SELECT * FROM courses_calendar_exams WHERE idCourseCampus=$idCourseCampus AND type <> 'salasprovas'")->result();
        $course = $this->painelbd->getQuery($queryCurso)->row();
        $data = array(
            'titulo' => 'Painel Administrativo',
            'conteudo' => 'paineladm/secretaria/calendarioProvas/calendario',
            'dados' => array(
                'course'=>$course,
                'calendarsCourse' => $calendarsCourses,
                'tipo' => '',
                'page' => '')
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrarCalendarioProvas($idCourseCampus = NULL)
    {

        if ($idCourseCampus == NULL) {
            redirect('painel');
        }
        $queryCurso = "SELECT
                        campus_has_courses.id idCourseCampus,
                        courses.id as courses_id,
                        courses.name as name,
                        campus.id as campusId,
                        courses.icone,
                        campus.city,
                        campus.name as campusName
                        
                    FROM
                      at_site.campus_has_courses
                      inner join campus on campus.id = campus_has_courses.campus_id
                      inner join courses on courses.id = campus_has_courses.courses_id
                    WHERE campus_has_courses.id = $idCourseCampus";
        $course = $this->painelbd->getQuery($queryCurso)->row();

        $this->load->helper('file');

        $this->form_validation->set_rules('type', 'Tipo de Prova', 'required');
        $this->form_validation->set_rules('cycle', 'Ciclo', 'required');

        if (empty($_FILES['file']['name'])) {
            $this->form_validation->set_rules('file', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            if (is_dir(FCPATH . "/assets/files/muralProvas/calendariosProva/$course->courses_id")) {
                $path = "assets/files/muralProvas/calendariosProva/$course->courses_id";
            } else {
                mkdir(FCPATH . "/assets/files/muralProvas/calendariosProva/$course->courses_id", 0777, true);
                $path = "assets/files/muralProvas/calendariosProva/$course->courses_id";
            }

            $upload = $this->painelbd->do_uploadFiles('file', $path, $types = 'pdf', NULL);

            if ($upload):
                $dados_form = elements(array('type','school_semester_id','cycle'), $this->input->post());
                $dados_form['file'] = $path . '/' . $upload['file_name'];
                $dados_form['usersid'] = $this->session->userdata('codusuario');
                $dados_form['status'] = '1';
                $dados_form['idCourseCampus'] = $course->idCourseCampus;

                if ($this->painelbd->salvar('courses_calendar_exams', $dados_form)):
                    setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Calendário de provas cadastrado com sucesso.</p>', 'success');
                    redirect("Mural/calendariosProvasCurso/$idCourseCampus");
                else:
                    setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Erro! O plano de ensino não pode ser cadastrado.</p>', 'error');
                    redirect("Mural/calendariosProvasCurso/$idCourseCampus");
                endif;

            else:
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            endif;
        }


        $data = array(
            'titulo' => 'Painel Administrativo - UniAtenas',
            'conteudo' => 'paineladm/secretaria/calendarioProvas/cadastrarCalendarioProva',
            'dados' => array(
                'course' => $course,
                'campus' => '',
                'tipo' => ''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);

    }

    public function editarCalendarioProvas($id = NULL)
    {

        if ($id == NULL) {
            redirect('painel');
        }
        $calendar = $this->painelbd->getQuery("SELECT * FROM courses_calendar_exams WHERE id=$id AND type <> 'salasprovas'" )->row();
        $queryCurso = "SELECT
                        campus_has_courses.id idCourseCampus,
                        courses.id as courses_id,
                        courses.name as name,
                        campus.id as campusId,
                        courses.icone,
                        campus.city,
                        campus.name as campusName
                        
                    FROM
                      at_site.campus_has_courses
                      inner join campus on campus.id = campus_has_courses.campus_id
                      inner join courses on courses.id = campus_has_courses.courses_id
                    WHERE campus_has_courses.id = $calendar->idCourseCampus";
        $course = $this->painelbd->getQuery($queryCurso)->row();

        $this->load->helper('file');

        $this->form_validation->set_rules('type', 'Tipo de Prova', 'required');
        $this->form_validation->set_rules('cycle', 'Ciclo', 'required');
        $fileAtual = $this->input->post('fileatual');
        $arquivo = $calendar->file;

        if (!file_exists($arquivo)) {
            $this->form_validation->set_rules('file', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }

        if (empty($_FILES['file']['name']) and empty($fileAtual)) {
            $this->form_validation->set_rules('file', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if (is_dir(FCPATH . "/assets/files/muralProvas/calendariosProva/$course->courses_id")) {
                $path = "assets/files/muralProvas/calendariosProva/$course->courses_id";
            } else {
                mkdir(FCPATH . "/assets/files/muralProvas/calendariosProva/$course->courses_id", 0777, true);
                $path = "assets/files/muralProvas/calendariosProva/$course->courses_id";
            }
            $dados_form = elements(array('type','school_semester_id','cycle'), $this->input->post());
            $dados_form['usersid'] = $this->session->userdata('codusuario');
            $dados_form['status'] = '1';
            $dados_form['idCourseCampus'] = $course->idCourseCampus;
            $dados_form['id']=$calendar->id;

            if (!empty($fileAtual) and empty($_FILES['file']['name'])) {

                if ($calendar->type == $dados_form['type'] and $calendar->cycle == $dados_form['cycle']) {
                    setMsg('<img src="' . base_url('assets/images/icons/wait.png') . '" alt=""><br><p>Atenção! <br>Você não modificou nehuma informação!.</p>', 'alert');
                    redirect(current_url());
                } else {

                    if ($this->painelbd->salvar('courses_calendar_exams', $dados_form)):
                        setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Calendário de provas cadastrado com sucesso.</p>', 'success');
                        redirect("Mural/calendariosProvasCurso/$course->idCourseCampus");
                    else:
                        setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Erro! O calendário não pode ser editado.</p>', 'error');
                        redirect("Mural/calendariosProvasCurso/$course->idCourseCampus");
                    endif;
                }
            } else {
                if (file_exists($arquivo)) {
                    unlink($arquivo);
                    $upload = $this->painelbd->do_uploadFiles('file', $path, $types = 'pdf', NULL);
                    if ($upload):
                        $dados_form['file'] = $path . '/' . $upload['file_name'];
                        if ($this->painelbd->salvar('courses_calendar_exams', $dados_form)):
                            setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Calendário de provas cadastrado com sucesso.</p>', 'success');
                            redirect("Mural/calendariosProvasCurso/$course->idCourseCampus");
                        else:
                            setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Erro! O calendário não pode ser editado.</p>', 'error');
                            redirect("Mural/calendariosProvasCurso/$course->idCourseCampus");
                        endif;
                    else:
                        //erro no upload
                        $msg = $this->upload->display_errors();
                        $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                        setMsg($msg, 'erro');
                    endif;
                } else {
                    setMsg('<img src="' . base_url('assets/images/icons/sorry.png') . '" alt=""><br><p>Atenção! O arquivo editado, não existe.</p>', 'alert');
                }
            }
        }

        $data = array(
            'titulo' => 'Painel Administrativo - UniAtenas',
            'conteudo' => 'paineladm/secretaria/calendarioProvas/editarCalendarioProvas',
            'dados' => array(
                'course' => $course,
                'calendar' => $calendar,

                'tipo' => ''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);

    }

    public function deletarCalendariosProva($id = NULL) {

        $table = 'courses_calendar_exams';
        $dados = $this->painelbd->getWhere($table, array('id' => $id))->row();
        $arquivo = $dados->file;

        if ($id != NULL && $dados) {
            if ($del = $this->painelbd->delete($table, array('id' => $id))) {

                if (!unlink($arquivo)) {
                    setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Não foi possível remover o arquivo de nome</p>', 'alert');
                    redirect('Mural/calendariosProvasCurso/' . $dados->idCourseCampus);
                } else {
                    setMsg('<p>.</p>', 'success');
                    setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Deleção realizada com sucesso.</p>', 'success');
                    redirect('Mural/calendariosProvasCurso/' . $dados->idCourseCampus);
                }
            } else {
                setMsg('<p>Erro! A publicação não pode ser deletada.</p>', 'error');
                redirect('Mural/calendariosProvasCurso/' . $dados->idCourseCampus);
            }
        } else {
            setMsg('<p>Erro! Não existe publicações para os dados informados.</p>', 'error');
            redirect('Mural/calendariosProvasCurso/' . $dados->idCourseCampus);
        }
    }

    public function listasSalasProvas($idCourseCampus=NULL)
    {

        $queryCurso = "SELECT
                        campus_has_courses.id idCourseCampus,
                        courses.id as courses_id,
                        courses.name as name,
                        campus.id as campusId,
                        courses.icone,
                        campus.city,
                        campus.name as campusName
                        
                    FROM
                      at_site.campus_has_courses
                      inner join campus on campus.id = campus_has_courses.campus_id
                      inner join courses on courses.id = campus_has_courses.courses_id
                    WHERE campus_has_courses.id = $idCourseCampus";

        $listaSalas = $this->painelbd->getQuery("SELECT * FROM courses_calendar_exams WHERE idCourseCampus=$idCourseCampus AND type ='salasprovas'" )->result();
        $course = $this->painelbd->getQuery($queryCurso)->row();
        $data = array(
            'titulo' => 'Painel Administrativo',
            'conteudo' => 'paineladm/secretaria/salasProvas/listasSalasProvas',
            'dados' => array(
                'course'=>$course,
                'listasSalas' => $listaSalas,
                'tipo' => '',
                'page' => '')
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrarListasSalasProvas($idCourseCampus = NULL)
    {

        if ($idCourseCampus == NULL) {
            redirect('painel');
        }
        $queryCurso = "SELECT
                        campus_has_courses.id idCourseCampus,
                        courses.id as courses_id,
                        courses.name as name,
                        campus.id as campusId,
                        courses.icone,
                        campus.city,
                        campus.name as campusName
                        
                    FROM
                      at_site.campus_has_courses
                      inner join campus on campus.id = campus_has_courses.campus_id
                      inner join courses on courses.id = campus_has_courses.courses_id
                    WHERE campus_has_courses.id = $idCourseCampus";
        $course = $this->painelbd->getQuery($queryCurso)->row();

        $this->load->helper('file');

        $this->form_validation->set_rules('cycle', 'Ciclo', 'required');

        if (empty($_FILES['file']['name'])) {
            $this->form_validation->set_rules('file', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            if (is_dir(FCPATH . "/assets/files/muralProvas/salasProvas/$course->courses_id")) {
                $path = "assets/files/muralProvas/salasProvas/$course->courses_id";
            } else {
                mkdir(FCPATH . "/assets/files/muralProvas/salasProvas/$course->courses_id", 0777, true);
                $path = "assets/files/muralProvas/salasProvas/$course->courses_id";
            }

            $upload = $this->painelbd->do_uploadFiles('file', $path, $types = 'pdf', NULL);

            if ($upload):
                $dados_form = elements(array('type','school_semester_id','cycle'), $this->input->post());
                $dados_form['file'] = $path . '/' . $upload['file_name'];
                $dados_form['usersid'] = $this->session->userdata('codusuario');
                $dados_form['status'] = '1';
                $dados_form['idCourseCampus'] = $course->idCourseCampus;

                if ($this->painelbd->salvar('courses_calendar_exams', $dados_form)):
                    setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Lista de salas de provas cadastrada com sucesso.</p>', 'success');
                    redirect("Mural/listasSalasProvas/$idCourseCampus");
                else:
                    setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Erro! Lista de salas de provas cadastrada não pode ser cadastrada.</p>', 'error');
                    redirect("Mural/listasSalasProvas/$idCourseCampus");
                endif;

            else:
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            endif;
        }
        $data = array(
            'titulo' => 'Painel Administrativo - UniAtenas',
            'conteudo' => 'paineladm/secretaria/salasProvas/cadastrarListasSalasProvas',
            'dados' => array(
                'course' => $course,
                'campus' => '',
                'tipo' => ''
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editarListasSalasProvas($id = NULL)
    {

        if ($id == NULL) {
            redirect('painel');
        }
        $calendar = $this->painelbd->getQuery("SELECT * FROM courses_calendar_exams WHERE id=$id AND type = 'salasprovas'" )->row();
        $queryCurso = "SELECT
                        campus_has_courses.id idCourseCampus,
                        courses.id as courses_id,
                        courses.name as name,
                        campus.id as campusId,
                        courses.icone,
                        campus.city,
                        campus.name as campusName
                        
                    FROM
                      at_site.campus_has_courses
                      inner join campus on campus.id = campus_has_courses.campus_id
                      inner join courses on courses.id = campus_has_courses.courses_id
                    WHERE campus_has_courses.id = $calendar->idCourseCampus";
        $course = $this->painelbd->getQuery($queryCurso)->row();

        $this->load->helper('file');

        $this->form_validation->set_rules('cycle', 'Ciclo', 'required');
        $fileAtual = $this->input->post('fileatual');
        $arquivo = $calendar->file;

        if (!file_exists($arquivo)) {
            $this->form_validation->set_rules('file', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }

        if (empty($_FILES['file']['name']) and empty($fileAtual)) {
            $this->form_validation->set_rules('file', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if (is_dir(FCPATH . "/assets/files/muralProvas/salasProvas/$course->courses_id")) {
                $path = "assets/files/muralProvas/salasProvas/$course->courses_id";
            } else {
                mkdir(FCPATH . "/assets/files/muralProvas/salasProvas/$course->courses_id", 0777, true);
                $path = "assets/files/muralProvas/salasProvas/$course->courses_id";
            }
            $dados_form = elements(array('type','school_semester_id','cycle'), $this->input->post());
            $dados_form['usersid'] = $this->session->userdata('codusuario');
            $dados_form['status'] = '1';
            $dados_form['idCourseCampus'] = $course->idCourseCampus;
            $dados_form['id']=$calendar->id;

            if (!empty($fileAtual) and empty($_FILES['file']['name'])) {

                if ($calendar->type == $dados_form['type'] and $calendar->cycle == $dados_form['cycle']) {
                    setMsg('<img src="' . base_url('assets/images/icons/wait.png') . '" alt=""><br><p>Atenção! <br>Você não modificou nehuma informação!.</p>', 'alert');
                    redirect(current_url());
                } else {
                    if ($this->painelbd->salvar('courses_calendar_exams', $dados_form)):
                        setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Lista de salas de provas editada com sucesso.</p>', 'success');
                        redirect("Mural/listasSalasProvas/$course->idCourseCampus");
                    else:
                        setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Erro! Lista de salas de provas editada não pode ser cadastrada.</p>', 'error');
                        redirect("Mural/listasSalasProvas/$course->idCourseCampus");
                    endif;
                }
            } else {
                if (file_exists($arquivo)) {
                    unlink($arquivo);
                    $upload = $this->painelbd->do_uploadFiles('file', $path, $types = 'pdf', NULL);
                    if ($upload):
                        $dados_form['file'] = $path . '/' . $upload['file_name'];
                        if ($this->painelbd->salvar('courses_calendar_exams', $dados_form)):
                            setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Calendário de provas cadastrado com sucesso.</p>', 'success');
                            redirect("Mural/calendariosProvasCurso/$course->idCourseCampus");
                        else:
                            setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Erro! O calendário não pode ser editado.</p>', 'error');
                            redirect("Mural/calendariosProvasCurso/$course->idCourseCampus");
                        endif;
                    else:
                        //erro no upload
                        $msg = $this->upload->display_errors();
                        $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                        setMsg($msg, 'erro');
                    endif;
                } else {
                    setMsg('<img src="' . base_url('assets/images/icons/sorry.png') . '" alt=""><br><p>Atenção! O arquivo editado, não existe.</p>', 'alert');
                }
            }
        }

        $data = array(
            'titulo' => 'Painel Administrativo - UniAtenas',
            'conteudo' => 'paineladm/secretaria/salasProvas/editarListasSalasProvas',
            'dados' => array(
                'course' => $course,
                'calendar' => $calendar,

                'tipo' => ''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);

    }

    public function deletarSalasProva($id = NULL) {

        $table = 'courses_calendar_exams';
        $dados = $this->painelbd->getWhere($table, array('id' => $id))->row();
        $arquivo = $dados->file;

        if ($id != NULL && $dados) {
            if ($del = $this->painelbd->delete($table, array('id' => $id))) {

                if (!unlink($arquivo)) {
                    setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Não foi possível remover o arquivo de nome</p>', 'alert');
                    redirect('Mural/listasSalasProvas/' . $dados->idCourseCampus);
                } else {
                    setMsg('<p>.</p>', 'success');
                    setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Deleção realizada com sucesso.</p>', 'success');
                    redirect('Mural/listasSalasProvas/' . $dados->idCourseCampus);
                }
            } else {
                setMsg('<p>Erro! A publicação não pode ser deletada.</p>', 'error');
                redirect('Mural/listasSalasProvas/' . $dados->idCourseCampus);
            }
        } else {
            setMsg('<p>Erro! Não existe publicações para os dados informados.</p>', 'error');
            redirect('Mural/listasSalasProvas/' . $dados->idCourseCampus);
        }
    }

    /** Modulo de mapa de vista de prova */
    public function mapaDeVista($id = null){

        $dataJoin = array(
            'campus_has_courses' => 'campus_has_courses.id = courses_calendar_exams.idCourseCampus',
            'courses' => 'courses.id = campus_has_courses.courses_id'
        );
        $whereBd = array('campus_has_courses.campus_id'=>'1','type' => 'mapaVista');
        $fieldsBd = array('courses_calendar_exams.id',
            'courses.name' , 'courses_calendar_exams.datecreated',
            'courses_calendar_exams.datemodified','courses_calendar_exams.file');

        //$listagem = $this->bd->getWhere('courses_calendar_exams',array('type' => 'mapaVista'))->result();
        $listagem = $this->bd->where($fieldsBd,'courses_calendar_exams',$dataJoin,$whereBd)->result();
        $data = array(
            'titulo' => 'Painel Administrativo - Vista de Provas',
            'conteudo' => 'paineladm/secretaria/mapaVista/lista',
            'dados' => array(
                'listagem' => $listagem,
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'id' =>$id,
                'tipo' => 'vistadeprova'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }
    public function mapaDeVista_cadastrar($id = null){
        $this->load->helper('file');
        $this->form_validation->set_rules('course','Curso','required');


        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG, PNG ou PDF.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            $path = 'assets/mapaDeVista';
            is_way($path);
            $name_tmp = noAccentuation($this->input->post('course'), 'MapVist');


            $upload = $this->bd->uploadFiles('files', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF', $name_tmp);
            if ($upload) {
                //upload efetuado
                $dados_form['idCourseCampus'] = $this->input->post('course');
                $dados_form['school_semester_id'] = 1;
                $dados_form['cycle'] = 3;
                $dados_form['type'] = 'mapaVista';
                $dados_form['status'] = 1;
                $dados_form['file'] = $path . '/' . $upload['file_name'];
                $dados_form['usersid'] = $this->session->userdata('codusuario');


                if ($this->bd->salvar('courses_calendar_exams', $dados_form) == TRUE) {
                    setMsg('<p>Mapa cadastrado com sucesso.</p>', 'success');
                    redirect("mural/mapaDeVista/$id");
                } else {
                    setMsg('<p>Erro! O mapa não foi cadastrada.</p>', 'error');
                    redirect("mural/mapaDeVista/$id");
                }
            } else {
                //erro no upload
                $msg = $this->upload->display_erros();
                $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }


        }


        $dataJoin = array('courses' => 'courses.id = campus_has_courses.courses_id');
        $whereBd = array('campus_has_courses.campus_id'=> $id);
        $fieldsBd = array('campus_has_courses.id', 'courses.name');
        $courses = $this->bd->Where($fieldsBd,'campus_has_courses',$dataJoin,$whereBd)->result();
        $data = array(
            'titulo' => 'Cadastrar Mapa de Vista de Prova',
            'conteudo' => 'paineladm/secretaria/mapaVista/cadastrar',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'courses' => $courses,
                'id'=> $id,
                'tipo' => 'vistadeprova'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }
    public function mapaDeVista_deletar($id= null,$idC = null){
       $arquivo = $this->bd->getwhere('courses_calendar_exams',array('id'=>$idC))->row();

        $origem = $arquivo->file;
        $nome = explode('/', $origem);
        $nome = end($nome);

        $destino = "assets/delete/mapaVista/";
        is_way($destino);
        $destino = "$destino$nome";
        if(copy($origem, $destino)) {
            if ($this->bd->deletar('courses_calendar_exams', $idC) == TRUE) {
                unlink($origem);
                setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
                redirect("mural/mapaDeVista/$id");;
            } else {
                setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
                redirect("mural/mapaDeVista/$id");;
            }
        }else{
            setMsg('<p>Erro! Problemas nos diretorios do arquivo! :(</p>', 'error');
            redirect("mural/mapaDeVista/$id");;
        }

        $dataJoin = array(
            'campus_has_courses' => 'campus_has_courses.id = courses_calendar_exams.idCourseCampus',
            'courses' => 'courses.id = campus_has_courses.courses_id'
        );
        $whereBd = array('campus_has_courses.campus_id'=>'1','type' => 'mapaVista');
        $fieldsBd = array('courses_calendar_exams.id',
            'courses.name' , 'courses_calendar_exams.datecreated',
            'courses_calendar_exams.datemodified','courses_calendar_exams.file');

        $listagem = $this->bd->where($fieldsBd,'courses_calendar_exams',$dataJoin,$whereBd)->result();
        $data = array(
            'titulo' => 'Deletar - Mapa de vista.',
            'conteudo' => 'paineladm/secretaria/mapaVista/lista',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $listagem,
                'id' => $id,
                'tipo' => 'mapVist'
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

}
