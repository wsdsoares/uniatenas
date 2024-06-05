<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_graduacao extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('acesso_model', 'acesso');
        $this->load->model('inicio_model', 'inicio');
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('Cpainel_model', 'bd');

        date_default_timezone_set('America/Sao_Paulo');
    }
    public function todos_cursos()
    {

        $uriModalidade = $this->uri->segment(3);
        $array_where = null;
        if ($uriModalidade == 'ead') {
            $array_where = array('courses.modalidade' => $uriModalidade, 'types' => 'ead');
        }
        if ($uriModalidade == 'presencial') {
            $array_where = array('courses.modalidade' => $uriModalidade);
        }
        $listagemDosCursos = $this->painelbd->where('*', 'courses', NULL, $array_where)->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/todos_cursos',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => "Lista de Cursos da IES - <strong><i> (Grupo Atenas)</i></strong>",
                'cursos' => $listagemDosCursos,
                'modalidade' => $uriModalidade,
                'tipo' => 'tabelaDatatable'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_campus_cursos($modalidade = NULL)
    {
        verificaLogin();
        $colunasResultadoCursos =
            array(
                'campus.id',
                'campus.name',
                'campus.city',
                'campus.uf'
            );

        $listagemDosCampus = $this->painelbd->where('*', 'campus', NULL, array('visible' => 'SIM'))->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/lista_campus_cursos',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => 'Lista de Cursos - ' . $modalidade . ' <strong>Gestão Por Campus</strong>',
                'campus' => $listagemDosCampus,
                'modalidade' => $modalidade,
                'tipo' => ''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_cursos($uriCampus = null, $uriModalidade = null)
    {
        verificaLogin();

        $colunasCampus = array('campus.id', 'campus.name', 'campus.city', 'campus.uf');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $colunasResultadoCursos =
            array(
                'courses.id',
                'campus_has_courses.id as campus_coursesid',
                'courses.name',
                'courses.status as statusCourses',
                'courses.icone',
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'courses_pages.created_at',
                'courses_pages.updated_at',
                'courses_pages.userid',
                'courses_pages.filesGrid',

            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $whereCursosPorCampus = array('campus.id' => $campus->id, 'courses.modalidade' => $uriModalidade);
        $listaInformacoesPorCursos = $this->painelbd->where($colunasResultadoCursos, 'campus_has_courses', $joinCampus, $whereCursosPorCampus, array('campo' => 'courses.name', 'ordem' => 'asc'), NULL)->result();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/lista_cursos',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => "Gestão de Cursos $uriModalidade - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'cursos' => $listaInformacoesPorCursos,
                'campus' => $campus,
                'modalidade' => $uriModalidade,
                'tipo' => 'tabelaDatatable'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function vincular_curso_campus($uriCampus = NULL, $uriModalidade = NULL)
    {

        $colunasCampus = array('campus.id', 'campus.name', 'campus.city', 'campus.uf');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $courses = $this->painelbd->where('*', 'courses', null, array('courses.status' => 1, 'modalidade' => $uriModalidade))->result();

        $this->form_validation->set_rules('courses_id', 'Curso', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $dados_form['campus_id'] = $campus->id;
            $dados_form['courses_id'] = $this->input->post('courses_id');
            $status =  $dados_form['status'] = $this->input->post('status');
            $dados_form['user_id'] = $this->session->userdata('codusuario');

            if ($idCourseCampus = $this->painelbd->salvar('campus_has_courses', $dados_form, 'exibirIdInsert')) {

                $dados_form_course_page['campus_has_courses_id'] = $idCourseCampus;
                $dados_form_course_page['userid'] = $this->session->userdata('codusuario');
                $dados_form_course_page['status'] = $status;

                $this->painelbd->salvar('courses_pages', $dados_form_course_page);

                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_graduacao/lista_cursos/$campus->id/$uriModalidade"));
            } else {
                setMsg('<p>Erro! Algo de errado na inserção dos dados.</p>', 'error');
            }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/informacoes/vincular_curso_campus',
            'dados' => array(
                'page' => "Vínculo de Curso - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'courses' => $courses,
                'campus' => $campus,
                'modalidade' => $uriModalidade,
                'tipo' => ''
            )
        );


        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_vinculo_curso_campus($uriCampus = NULL, $idVinculo = NULL)
    {

        $colunasCampus = array('campus.id', 'campus.name', 'campus.city', 'campus.uf');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $courses = $this->painelbd->where('*', 'courses', null, array('courses.status' => 1, 'modalidade' => 'presencial'))->result();
        $vinculo_campus_has_courses = $this->painelbd->where('*', 'campus_has_courses', null, array('campus_has_courses.id' => $idVinculo))->row();

        $this->form_validation->set_rules('courses_id', 'Curso', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $dados_form['campus_id'] = $campus->id;
            $dados_form['courses_id'] = $this->input->post('courses_id');
            $status =  $dados_form['status'] = $this->input->post('status');
            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['id'] =  $vinculo_campus_has_courses->id;

            if ($idCourseCampus = $this->painelbd->salvar('campus_has_courses', $dados_form, 'exibirIdInsert')) {

                $dados_form_course_page['campus_has_courses_id'] = $idCourseCampus;
                $dados_form_course_page['userid'] = $this->session->userdata('codusuario');
                $dados_form_course_page['status'] = $status;

                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_graduacao/lista_cursos/$campus->id/presencial"));
            } else {
                setMsg('<p>Erro! Algo de errado na inserção dos dados.</p>', 'error');
            }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/informacoes/editar_vinculo_curso_campus',
            'dados' => array(
                'page' => "Vínculo de Curso - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'courses' => $courses,
                'campus_has_courses' => $vinculo_campus_has_courses,
                'campus' => $campus,
                'tipo' => ''
            )
        );


        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_vinculo_curso($uriCampus = null, $modalidade = null, $id = NULL)
    {
        verifica_login();

        $colunasCampus = array('campus.id', 'campus.name', 'campus.city', 'campus.uf');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $item = $this->painelbd->where('*', 'campus_has_courses', NULL, array('campus_has_courses.id' => $id))->row();

        if ($this->painelbd->deletar('campus_has_courses', $item->id)) {
            setMsg('<p>Vinculo de curso deletado com sucesso.</p>', 'success');
            redirect("Painel_graduacao/lista_cursos/$campus->id/$modalidade");
        } else {
            setMsg('<p>Erro! O vinículo de curso não pode ser deletado.</p>', 'error');
            redirect("Painel_graduacao/lista_cursos/$campus->id/$modalidade");
        }
    }

    public function cadastrar_informacoes_curso($courseCampusId = NULL, $modalidade = null)
    {
        verificaLogin();
        $this->load->helper('file');

        $colunasBuscaDadosCurso =
            array(
                'courses.id as idCourse',
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'campus_has_courses.id as campus_coursesid',
                'courses.name as nameCourse',
                'courses.status as statusCourse',

                'courses_pages.id as coursePageId',
                'courses_pages.status',
                'courses_pages.ppc',
                'courses_pages.description',
                'courses_pages.capa',
                'courses_pages.link_vestibular',
                'courses_pages.filesGrid',
                'courses_pages.matriz_visivel',
                'courses_pages.actuation',
                'courses_pages.autorization',
                'courses_pages.recognition',

            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $whereCursoPorCampus = array('campus_has_courses.id' => $courseCampusId);
        $informacoesCurso = $this->painelbd->where($colunasBuscaDadosCurso, 'campus_has_courses', $joinCampus, $whereCursoPorCampus, NULL, NULL, NULL)->row();

        $colunasCampus = array('campus.id', 'campus.name', 'campus.city', 'campus.uf');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $informacoesCurso->campusid))->row();

        //Validaçãoes via Form Validation
        $this->form_validation->set_rules('description', 'Descrição e informações do curso', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $arquivoAutorizacao = $_FILES["autorization"];
            $arquivoReconhecimento = $_FILES["recognition"];
            $arquivoReconhecimentoAtual = $this->input->post('recognitionAtual');
            $arquivoCapa = $_FILES["capa"];

            if ($informacoesCurso->description != $this->input->post('description')) {
                $dados_form['description'] = $this->input->post('description');
            }
            if ($informacoesCurso->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }
            if ($informacoesCurso->actuation != $this->input->post('actuation')) {
                $dados_form['actuation'] = $this->input->post('actuation');
            }

            if ($informacoesCurso->link_vestibular != $this->input->post('link_vestibular')) {
                $dados_form['link_vestibular'] = $this->input->post('link_vestibular');
            }

            if (isset($_FILES['filesGrid']) && !empty($_FILES['filesGrid']['name'])) {

                $path = "assets/files/cursos/$campus->id/$informacoesCurso->idCourse/$informacoesCurso->coursePageId";
                is_way($path);
                $upload = $this->painelbd->uploadFiles('filesGrid', $path, $types = 'PDF|pdf', NULL);

                if ($upload) {
                    //upload efetuado
                    $dados_form['filesGrid'] = $path . '/' . $upload['file_name'];
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            if (isset($_FILES['capa']) && !empty($_FILES['capa']['name'])) {

                $path = 'assets/images/courses/capa/' . $campus->id;
                is_way($path);
                $upload = $this->painelbd->uploadFiles('capa', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

                if ($upload) {
                    //upload efetuado
                    $dados_form['capa'] = $path . '/' . $upload['file_name'];
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            // if (isset($_FILES["autorization"]) && !empty($_FILES['autorization']['name'])) {
            if (!empty($_FILES['autorization']['name'])) {

                $path = "assets/files/cursos/$campus->id/autorization/$informacoesCurso->coursePageId";
                is_way($path);
                $upload = $this->painelbd->uploadFiles('autorization', $path, $types = 'pdf|PDF', NULL);

                if ($upload) {
                    //upload efetuado
                    $dados_form['autorization'] = $path . '/' . $upload['file_name'];
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            // if (isset($_FILES["recognition"]) && !empty($_FILES['recognition']['name'])) {
            if (!empty($_FILES['recognition']['name'])) {

                $path = "assets/files/cursos/$campus->id/recognition/$informacoesCurso->coursePageId";
                is_way($path);
                $upload = $this->painelbd->uploadFiles('recognition', $path, $types = 'pdf|PDF', NULL);

                if ($upload) {
                    //upload efetuado
                    $dados_form['recognition'] = $path . '/' . $upload['file_name'];
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }
            if (isset($_FILES["ppc"]) && !empty($_FILES['ppc']['name'])) {

                $path = "assets/files/cursos/$campus->id/ppc/$informacoesCurso->coursePageId";
                is_way($path);
                $upload = $this->painelbd->uploadFiles('ppc', $path, $types = 'pdf|PDF', NULL);

                if ($upload) {
                    //upload efetuado
                    $dados_form['ppc'] = $path . '/' . $upload['file_name'];
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }




            $dados_form['id'] = $informacoesCurso->coursePageId;
            $dados_form['userid'] = $this->session->userdata('codusuario');
            $dados_form['matriz_visivel'] = $this->input->post('matriz_visivel');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');

            // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
            if ($this->painelbd->salvar('courses_pages', $dados_form) == TRUE) {
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_graduacao/lista_cursos/$campus->id/$modalidade"));
            } else {
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/informacoes/cadastrar_informacoes',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => "Vínculo de Curso - <strong><i>Campus - $campus->name ($campus->city) $modalidade </i></strong>",
                'informacoesCurso' => $informacoesCurso,
                'campus' => $campus,
                'modalidade' => $modalidade,
                'tipo' => ''
            )
        );


        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function registro_dados_matriz($courseCampusId = NULL)
    {
        verificaLogin();
        $this->load->helper('file');


        $colunasBuscaDadosCurso =
            array(
                'courses.id as idCourse',
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'campus_has_courses.id as campus_coursesid',
                'courses.name as nameCourse',
                'courses.status as statusCourse',

                'courses_pages.id as coursePageId',
                'courses_pages.status',
                'courses_pages.description',
                'courses_pages.capa',
                'courses_pages.filesGrid',
                'courses_pages.link_vestibular',
                'courses_pages.actuation',
                'courses_pages.autorization',
                'courses_pages.recognition',

            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $whereCursoPorCampus = array('campus_has_courses.id' => $courseCampusId);
        $informacoesCurso = $this->painelbd->where($colunasBuscaDadosCurso, 'campus_has_courses', $joinCampus, $whereCursoPorCampus, NULL, NULL, NULL)->row();

        $colunasCampus = array('campus.id', 'campus.name', 'campus.city', 'campus.uf');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $informacoesCurso->campusid))->row();


        //Validaçãoes via Form Validation
        $this->form_validation->set_rules('description', 'Descrição e informações do curso', 'required');



        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $arquivoAutorizacao = $_FILES["autorization"];
            $arquivoReconhecimento = $_FILES["recognition"];
            $arquivoReconhecimentoAtual = $this->input->post('recognitionAtual');
            $arquivoCapa = $_FILES["capa"];

            if ($informacoesCurso->description != $this->input->post('description')) {
                $dados_form['description'] = $this->input->post('description');
            }
            if ($informacoesCurso->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }
            if ($informacoesCurso->actuation != $this->input->post('actuation')) {
                $dados_form['actuation'] = $this->input->post('actuation');
            }

            if ($informacoesCurso->link_vestibular != $this->input->post('link_vestibular')) {
                $dados_form['link_vestibular'] = $this->input->post('link_vestibular');
            }
            if (isset($_FILES['capa']) && !empty($_FILES['capa']['name'])) {

                $path = 'assets/images/courses/capa/' . $campus->id;
                is_way($path);
                $upload = $this->painelbd->uploadFiles('capa', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

                if ($upload) {
                    //upload efetuado
                    $dados_form['capa'] = $path . '/' . $upload['file_name'];
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            if (isset($_FILES["autorization"]) && !empty($_FILES['autorization']['name'])) {

                $path = 'assets/files/cursos/' . $campus->id . '/autorization';
                is_way($path);
                $upload = $this->painelbd->uploadFiles('autorization', $path, $types = 'pdf|PDF', NULL);

                if ($upload) {
                    //upload efetuado
                    $dados_form['autorization'] = $path . '/' . $upload['file_name'];
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            if (isset($_FILES["recognition"]) && !empty($_FILES['recognition']['name'])) {

                $path = 'assets/files/cursos/' . $campus->id . '/recognition';
                is_way($path);
                $upload = $this->painelbd->uploadFiles('recognition', $path, $types = 'pdf|PDF', NULL);

                if ($upload) {
                    //upload efetuado
                    $dados_form['autorization'] = $path . '/' . $upload['file_name'];
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            $dados_form['id'] = $informacoesCurso->coursePageId;
            $dados_form['userid'] = $this->session->userdata('codusuario');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem

            if ($this->painelbd->salvar('courses_pages', $dados_form) == TRUE) {
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_graduacao/lista_cursos/$campus->id/presencial"));
            } else {
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/matriz/registro_dados_matriz',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => "Vínculo de Curso - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'informacoesCurso' => $informacoesCurso,
                'campus' => $campus,
                'tipo' => ''
            )
        );


        $this->load->view('templates/layoutPainelAdm', $data);
    }

    /*************************************************************************
     * Dados do curso
     * Página: Página de gestão dos cursos
     *************************************************************************/

    public function cadastrar_curso($modalidade = null)
    {
        verificaLogin();
        $this->load->helper('file');

        //Validaçãoes via Form Validation
        $this->form_validation->set_rules('name', 'Nome do curso', 'required');

        $areasGraduacao = $this->painelbd->where('*', 'areas', NULL, array('status' => '1'))->result();

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $dados_form['duration'] = $this->input->post('duration');
            $dados_form['modalidade'] = $modalidade;
            $dados_form['status'] = $this->input->post('status');
            $dados_form['name'] = $this->input->post('name');
            $dados_form['types'] = $this->input->post('types');
            $dados_form['areas_id'] = $this->input->post('areas_id');

            if (isset($_FILES['icone']) && !empty($_FILES['icone']['name'])) {

                $path = 'assets/images/courses/icones';
                is_way($path);
                $upload = $this->painelbd->uploadFiles('icone', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

                if ($upload) {
                    //upload efetuado
                    $dados_form['icone'] = $path . '/' . $upload['file_name'];
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            $dados_form['user_id'] = $this->session->userdata('codusuario');

            if ($this->painelbd->salvar('courses', $dados_form) == TRUE) {
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_graduacao/todos_cursos/$modalidade"));
            } else {
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/dados_curso/cadastrar_curso',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => "Cadastro de Curso - <strong><i>IES</i> ($modalidade)</strong>",
                'tipo' => '',
                'modalidade' => $modalidade,
                'areasGraduacao' => $areasGraduacao,
            )
        );


        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_curso($idCurso = NULL, $modalidade = null)
    {
        verificaLogin();
        $this->load->helper('file');

        //Validaçãoes via Form Validation
        $this->form_validation->set_rules('name', 'Nome do curso', 'required');
        $curso = $this->painelbd->where('*', 'courses', NULL, array('courses.id' => $idCurso))->row();

        $areasGraduacao = $this->painelbd->where('*', 'areas', NULL, array('status' => '1'))->result();

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            if ($curso->name != $this->input->post('name')) {
                $dados_form['name'] = $this->input->post('name');
            }
            // if ($curso->modalidade != $this->input->post('modalidade')) {
            //     $dados_form['modalidade'] = $this->input->post('modalidade');
            // }
            if ($curso->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }
            if ($curso->types != $this->input->post('types')) {
                $dados_form['types'] = $this->input->post('types');
            }
            if ($curso->areas_id != $this->input->post('areas_id')) {
                $dados_form['areas_id'] = $this->input->post('areas_id');
            }

            if (isset($_FILES['icone']) && !empty($_FILES['icone']['name'])) {

                if (file_exists($curso->icone)) {
                    unlink($curso->icone);
                }

                $path = 'assets/images/courses/icones';

                is_way($path);
                $upload = $this->painelbd->uploadFiles('icone', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

                if ($upload) {
                    //upload efetuado
                    $dados_form['icone'] = $path . '/' . $upload['file_name'];
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['modalidade'] = $modalidade;
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            $dados_form['id'] = $curso->id;

            if ($this->painelbd->salvar('courses', $dados_form) == TRUE) {
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_graduacao/todos_cursos/$modalidade"));
            } else {
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/dados_curso/editar_curso',
            'dados' => array(
                'page' => "Edição de dados do curso - $curso->name <strong><i>IES</i></strong>",
                'tipo' => '',
                'modalidade' => $modalidade,
                'curso' => $curso,
                'areasGraduacao' => $areasGraduacao,
            )
        );


        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_curso($modalidade = null, $id = NULL)
    {
        verifica_login();

        $item = $this->painelbd->where('*', 'courses', NULL, array('courses.id' => $id))->row();

        if (file_exists($item->icone)) {
            unlink($item->icone);
        }

        if ($this->painelbd->deletar('courses', $item->id)) {
            setMsg('<p>Curso deletado com sucesso.</p>', 'success');
            redirect("Painel_graduacao/todos_cursos/$modalidade");
        } else {
            setMsg('<p>Erro! O curso não foi deletado.</p>', 'error');
            redirect("Painel_graduacao/todos_cursos/$modalidade");
        }
    }

    /*************************************************************************
     * Fotos do curso
     * Página: Página de fotos do curso que estão vinculado a um CAMPUS
     * Ex.: Administração em Sete Lagoas
     *************************************************************************/
    public function lista_fotos_curso($courseCampusId = NULL, $uriCampus = NULL)
    {
        $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $colunasDadosCursoPorCampus =
            array(
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'campus_has_courses.id as campus_coursesid',
                'courses.name as nameCourse',
                'courses.status as statusCourse'
            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus, 'campus_has_courses', $joinCampus, array('campus_has_courses.id' => $courseCampusId))->row();

        $whereCursoPorCampus = array('courses_photos.idCourseCampus' => $cursoPorCampus->campus_coursesid);
        $fotosCurso = $this->painelbd->where('*', 'courses_photos', NULL, $whereCursoPorCampus)->result();

        $data = array(
            'conteudo' => 'paineladm/cursos/fotosCurso/lista_fotos_curso',
            'titulo' => 'Fotos do Curso - UniAtenas',
            'dados' => array(
                'page' => "Fotos do Curso - $cursoPorCampus->nameCourse <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'tipo' => 'tabelaDatatable',
                'fotosCurso' => $fotosCurso,
                'cursoPorCampus' => $cursoPorCampus,
                'campus' => $campus,
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_fotos_curso($courseCampusId = NULL, $uriCampus = NULL)
    {
        $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $colunasDadosCursoPorCampus =
            array(
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'campus_has_courses.id as campus_coursesid',
                'courses.name as nameCourse',
            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus, 'campus_has_courses', $joinCampus, array('campus_has_courses.id' => $courseCampusId))->row();

        $this->form_validation->set_rules('title', 'Título', 'required');

        if (empty($_FILES['files'])) {
            $_FILES['files']['size'][0] = 0;
        }

        if ($_FILES['files']['size'][0] <= 0) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPEG, PNG ou JPG.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $path = "assets/images/courses/photos/$campus->id/$cursoPorCampus->campus_coursesid";
            is_way($path);
            $number_of_files = count($_FILES['files']['name']);
            $files = $_FILES;

            for ($i = 0; $i < $number_of_files; $i++) {
                $_FILES['files']['name'] = $files['files']['name'][$i];
                $_FILES['files']['type'] = $files['files']['type'][$i];
                $_FILES['files']['tmp_name'] = $files['files']['tmp_name'][$i];
                $_FILES['files']['error'] = $files['files']['error'][$i];
                $_FILES['files']['size'] = $files['files']['size'][$i];

                $dados_form['userid'] = $this->session->userdata('codusuario');

                $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|JPG|jpeg|JPEG|png|PNG', NULL);

                if ($upload) {
                    $dados_form['userid'] = $this->session->userdata('codusuario');
                    $dados_form['files'] = $path . '/' . $upload['file_name'];
                    $dados_form['title'] = $this->input->post('title');;
                    $dados_form['status'] = $this->input->post('status');
                    $dados_form['subtitle'] = $this->input->post('subtitle');
                    $dados_form['idCourseCampus'] = $cursoPorCampus->campus_coursesid;

                    if ($id = $this->painelbd->salvar('courses_photos', $dados_form)) {
                        if ($number_of_files == ($i + 1)) {
                            setMsg('<p>Fotos cadastrada com sucesso.</p>', 'success');
                            redirect("Painel_graduacao/lista_fotos_curso/$cursoPorCampus->campus_coursesid/$campus->id");
                        }
                    } else {
                        setMsg('<p>Erro! A foto não pode ser cadastrada.</p>', 'error');
                    }
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }
        }

        $data = array(
            'conteudo' => 'paineladm/cursos/fotosCurso/cadastrar_fotos_curso',
            'titulo' => "Fotos - $cursoPorCampus->nameCourse $campus->name - $campus->city",
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'cursoPorCampus' => $cursoPorCampus,
                'page' => "<span>Cadastrar Fotos do Curso: <strong>$cursoPorCampus->nameCourse <i>$campus->name - $campus->city</i></strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_foto_curso($courseCampusId = NULL, $uriCampus = NULL, $id = NULL)
    {
        $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $colunasDadosCursoPorCampus =
            array(
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'campus_has_courses.id as campus_coursesid',
                'courses.name as nameCourse',
            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus, 'campus_has_courses', $joinCampus, array('campus_has_courses.id' => $courseCampusId))->row();

        $fotoCurso = $this->painelbd->where('*', 'courses_photos', NULL, array('courses_photos.id' => $id))->row();

        $this->form_validation->set_rules('title', 'Título', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            if ($fotoCurso->title != $this->input->post('title')) {
                $dados_form['title'] = $this->input->post('title');
            }

            if ($fotoCurso->subtitle != $this->input->post('subtitle')) {
                $dados_form['subtitle'] = $this->input->post('subtitle');
            }

            if ($fotoCurso->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }


            if (isset($_FILES['files']) and !empty($_FILES['files']['name'])) {

                $path = "assets/images/courses/photos/$campus->id/$cursoPorCampus->campus_coursesid";

                is_way($path);

                if (file_exists($fotoCurso->files)) {
                    unlink($fotoCurso->files);
                }

                $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|JPG|jpeg|JPEG|png|PNG', NULL);

                if ($upload) {
                    //upload efetuado
                    $dados_form['files'] = $path . '/' . $upload['file_name'];
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            $dados_form['userid'] = $this->session->userdata('codusuario');

            $dados_form['id'] = $fotoCurso->id;
            $dados_form['userid'] = $this->session->userdata('codusuario');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');

            if ($this->painelbd->salvar('courses_photos', $dados_form) == TRUE) {
                setMsg('<p>Fotos cadastrada com sucesso.</p>', 'success');
                redirect("Painel_graduacao/lista_fotos_curso/$cursoPorCampus->campus_coursesid/$campus->id");
            } else {
                setMsg('<p>Erro! A foto não pode ser cadastrada.</p>', 'error');
            }
        }

        $data = array(
            'conteudo' => 'paineladm/cursos/fotosCurso/editar_foto_curso',
            'titulo' => "Edição de Dados Fotos do- $cursoPorCampus->nameCourse $campus->name - $campus->city",
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'fotoCurso' => $fotoCurso,
                'cursoPorCampus' => $cursoPorCampus,
                'page' => "<span>Cadastrar Fotos do Curso: <strong>$cursoPorCampus->nameCourse <i>$campus->name - $campus->city</i></strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_foto_curso($courseCampusId = NULL, $uriCampus = NULL, $id = NULL)
    {
        verifica_login();

        $uriCampus = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $item = $this->painelbd->where('*', 'courses_photos', NULL, array('courses_photos.id' => $id))->row();

        if (file_exists($item->files)) {
            unlink($item->files);
        }

        if ($this->painelbd->deletar('courses_photos', $item->id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect("Painel_graduacao/lista_fotos_curso/$courseCampusId/$uriCampus");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_graduacao/lista_fotos_curso/$courseCampusId/$uriCampus");
        }
    }

    /*************************************************************************
     * Coordenador do Curso
     * Página: Página do curso, onde mostra o coordenador que estão vinculado a um ou mais Cursos
     * Ex.: 
     * Administração EaD e Presencial - Cooordenadora Viviane 
     * Contabilidade EaD Cooordenadora Viviane
     *************************************************************************/

    public function cadastrar_coordenador_curso($courseCampusId = NULL, $uriCampus = NULL, $modalidade = null)
    {
        verificaLogin();
        $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $colunasDadosCursoPorCampus =
            array(
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'campus_has_courses.id as campus_coursesid',
                'courses.name as nameCourse',
            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus, 'campus_has_courses', $joinCampus, array('campus_has_courses.id' => $courseCampusId))->row();

        $coordenador = $this->painelbd->where('*', 'dirigentes', null, array('dirigentes.id_course_campus' => $cursoPorCampus->campus_coursesid))->row();

        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('cargo', 'Cargo', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                setMsg(validation_errors(), 'error');
            }
        } else {
            if (empty($coordenador)) {
                $dados_form = elements(array('nome', 'email', 'status', 'cargo', 'telefone'), $this->input->post());

                $dados_form['user_id'] = $this->session->userdata('codusuario');
                $dados_form['updated_at'] = date('Y-m-d H:i:s');
                $dados_form['perfil'] = 'coordenador';
                $dados_form['id_course_campus'] = $cursoPorCampus->campus_coursesid;

                if ($this->painelbd->salvar('dirigentes', $dados_form) == TRUE) {
                    setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                    redirect("Painel_graduacao/lista_cursos/$campus->id/$modalidade");
                } else {
                    setMsg('<p>Erro! Erro no cadastro.</p>', 'error');
                    redirect("Painel_graduacao/lista_cursos/$campus->id/$modalidade");
                }
            } else {

                if ($coordenador->nome != $this->input->post('nome')) {
                    $dados_form['nome'] = $this->input->post('nome');
                }
                if ($coordenador->email != $this->input->post('email')) {
                    $dados_form['email'] = $this->input->post('email');
                }
                if ($coordenador->telefone != $this->input->post('telefone')) {
                    $dados_form['telefone'] = $this->input->post('telefone');
                }
                if ($coordenador->cargo != $this->input->post('cargo')) {
                    $dados_form['cargo'] = $this->input->post('cargo');
                }

                $dados_form['user_id'] = $this->session->userdata('codusuario');
                $dados_form['updated_at'] = date('Y-m-d H:i:s');
                $dados_form['perfil'] = 'coordenador';
                $dados_form['id'] = $coordenador->id;

                if ($this->painelbd->salvar('dirigentes', $dados_form) == TRUE) {
                    setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                    redirect("Painel_graduacao/lista_cursos/$campus->id/$modalidade");
                } else {
                    setMsg('<p>Erro! Erro no cadastro.</p>', 'error');
                    redirect("Painel_graduacao/lista_cursos/$campus->id/$modalidade");
                }
            }
        }

        $data = array(
            'conteudo' => 'paineladm/cursos/coordenador/cadastrar_coordenador_curso',
            'titulo' => 'Coordenador do curso',
            'dados' => array(
                'tipo' => '',
                'coordenador' => $coordenador = !empty($coordenador) ? $coordenador : '',
                'campus' => $campus,
                'modalidade' => $modalidade,
                'cursoPorCampus' => $cursoPorCampus->campus_coursesid,
                'page' => "<span>Cadastro de coordenador(a) do curso de $cursoPorCampus->nameCourse $campus->city</span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_coordenador_curso($uriCampus = NULL, $modalidade = null, $id = NULL)
    {
        verifica_login();

        $item = $this->painelbd->where('*', 'dirigentes', NULL, array('dirigentes.id' => $id))->row();

        if ($this->painelbd->deletar('dirigentes', $item->id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect(base_url("Painel_graduacao/lista_cursos/$uriCampus/$modalidade"));
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect(base_url("Painel_graduacao/lista_cursos/$uriCampus/$modalidade"));
        }
    }
    /*************************************************************************
     * Grade/ Matriz Curricular
     * Página: Página da lista das disciplinas da matriz curricular dos cursos - Presenciais e EAD
     *  Períodos e Disciplinas
     * Exemplo: 1 º Periodo: (Pensamento cinetífico, TCC, etc..)
     *************************************************************************/

    public function lista_arquivos_autorizacao_reconhecimento($courseCampusId = NULL, $uriCampus = NULL, $modalidade = null)
    {
        verificaLogin();
        $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $colunasDadosCursoPorCampus =
            array(
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'campus_has_courses.id as campus_coursesid',
                'courses.name as nameCourse',
            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus, 'campus_has_courses', $joinCampus, array('campus_has_courses.id' => $courseCampusId))->row();

        $arquivosAutorizacaoReconhecimento = $this->painelbd->where('*', 'courses_autorizacao_reconhecimento', null, array('courses_autorizacao_reconhecimento.campus_has_courses_id' => $cursoPorCampus->campus_coursesid))->result();

        $data = array(
            'conteudo' => 'paineladm/cursos/autorizacaoReconhecimento/lista_arquivos_autorizacao_reconhecimento',
            'titulo' => 'Arquivos de Autorização e/ou reconhecimento',
            'dados' => array(
                'tipo' => 'tabelaDatatable',
                'arquivosAutorizacaoReconhecimento' => $arquivosAutorizacaoReconhecimento = !empty($arquivosAutorizacaoReconhecimento) ? $arquivosAutorizacaoReconhecimento : '',
                'campus' => $campus,
                'modalidade' => $modalidade,
                'cursoPorCampus' => $cursoPorCampus,
                'page' => "<span>Arquivos de Autorização/Reconhecimento <strong> $cursoPorCampus->nameCourse $campus->city</strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_arquivo_autorizacao_reconhecimento($courseCampusId = NULL, $uriCampus = NULL)
    {
        $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $colunasDadosCursoPorCampus =
            array(
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'campus_has_courses.id as campus_coursesid',
                'courses.name as nameCourse',
            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus, 'campus_has_courses', $joinCampus, array('campus_has_courses.id' => $courseCampusId))->row();

        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }
        $this->form_validation->set_rules('status', 'Situação', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $path = "assets/files/cursos/$campus->id/$cursoPorCampus->campus_coursesid";
            is_way($path);

            $upload = $this->painelbd->uploadFiles('files', $path, $types = 'PDF|pdf', NULL);

            if ($upload) {
                $dados_form['user_id'] = $this->session->userdata('codusuario');
                $dados_form['files'] = $path . '/' . $upload['file_name'];
                $dados_form['tipo_arquivo'] = $this->input->post('tipo_arquivo');;
                $dados_form['status'] = $this->input->post('status');
                $dados_form['campus_has_courses_id'] = $cursoPorCampus->campus_coursesid;

                if ($this->painelbd->salvar('courses_autorizacao_reconhecimento', $dados_form)) {
                    setMsg('<p>Arquivo cadastrado com sucesso.</p>', 'success');
                    redirect("Painel_graduacao/lista_arquivos_autorizacao_reconhecimento/$cursoPorCampus->campus_coursesid/$campus->id");
                } else {
                    setMsg('<p>Erro! A foto não pode ser cadastrada.</p>', 'error');
                }
            } else {
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }
        }
        $data = array(
            'conteudo' => 'paineladm/cursos/autorizacaoReconhecimento/cadastrar_arquivo_autorizacao_reconhecimento',
            'titulo' => "Arquivos - $cursoPorCampus->nameCourse $campus->name - $campus->city",
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'cursoPorCampus' => $cursoPorCampus,
                'page' => "<span>Cadastrar Autorização/Reconhecimento : <strong>$cursoPorCampus->nameCourse <i>$campus->name - $campus->city</i></strong></span>",
            )
        );


        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_arquivo_autorizacao_reconhecimento($courseCampusId = NULL, $uriCampus = NULL, $id = NULL)
    {
        $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $colunasDadosCursoPorCampus =
            array(
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'campus_has_courses.id as campus_coursesid',
                'courses.name as nameCourse',
            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus, 'campus_has_courses', $joinCampus, array('campus_has_courses.id' => $courseCampusId))->row();

        $arquivosAutorizacaoReconhecimento = $this->painelbd->where('*', 'courses_autorizacao_reconhecimento', null, array('courses_autorizacao_reconhecimento.id' => $id))->row();

        $this->form_validation->set_rules('status', 'Situação', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if ($arquivosAutorizacaoReconhecimento->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }
            if ($arquivosAutorizacaoReconhecimento->tipo_arquivo != $this->input->post('tipo_arquivo')) {
                $dados_form['tipo_arquivo'] = $this->input->post('tipo_arquivo');
            }

            if (isset($_FILES['files']) and !empty($_FILES['files']['name'])) {

                $path = "assets/files/cursos/$campus->id/$cursoPorCampus->campus_coursesid";

                is_way($path);

                if (file_exists($arquivosAutorizacaoReconhecimento->files)) {
                    unlink($arquivosAutorizacaoReconhecimento->files);
                }

                $upload = $this->painelbd->uploadFiles('files', $path, $types = 'PDF', NULL);

                if ($upload) {
                    //upload efetuado
                    $dados_form['files'] = $path . '/' . $upload['file_name'];
                } else {
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            $dados_form['id'] = $arquivosAutorizacaoReconhecimento->id;
            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['atualizado_em'] = date('Y-m-d H:i:s');

            if ($this->painelbd->salvar('courses_autorizacao_reconhecimento', $dados_form) == TRUE) {
                setMsg('<p>Arquivo cadastrado com sucesso.</p>', 'success');
                redirect("Painel_graduacao/lista_arquivos_autorizacao_reconhecimento/$cursoPorCampus->campus_coursesid/$campus->id");
            } else {
                setMsg('<p>Erro! O arquivo não pode ser cadastrada.</p>', 'error');
            }
        }

        $data = array(
            'conteudo' => 'paineladm/cursos/autorizacaoReconhecimento/editar_arquivo_autorizacao_reconhecimento',
            'titulo' => "Edição de Dados Autorização - Reconhecimento- $cursoPorCampus->nameCourse $campus->name - $campus->city",
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'arquivosAutorizacaoReconhecimento' => $arquivosAutorizacaoReconhecimento = !empty($arquivosAutorizacaoReconhecimento) ? $arquivosAutorizacaoReconhecimento : '',
                'cursoPorCampus' => $cursoPorCampus,
                'page' => "<span>Edição de informações: <strong>$cursoPorCampus->nameCourse <i>$campus->name - $campus->city</i></strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_arquivo_autorizacao_reconhecimento($courseCampusId = NULL, $uriCampus = NULL, $id = NULL)
    {
        verifica_login();

        $uriCampus = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $item = $this->painelbd->where('*', 'courses_autorizacao_reconhecimento', NULL, array('courses_autorizacao_reconhecimento.id' => $id))->row();

        if (file_exists($item->files)) {
            unlink($item->files);
        }

        if ($this->painelbd->deletar('courses_autorizacao_reconhecimento', $item->id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect("Painel_graduacao/lista_arquivos_autorizacao_reconhecimento/$courseCampusId/$uriCampus");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_graduacao/lista_arquivos_autorizacao_reconhecimento/$courseCampusId/$uriCampus");
        }
    }

    /*************************************************************************
     * Grade/ Matriz Curricular
     * Página: Página da lista das disciplinas da matriz curricular dos cursos - Presenciais e EAD
     *  Períodos e Disciplinas
     * Exemplo: 1 º Periodo: (Pensamento cinetífico, TCC, etc..)
     *************************************************************************/

    public function lista_dados_matriz($courseCampusId = NULL, $uriCampus = NULL, $modalidade = null)
    {
        verificaLogin();
        $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $colunasDadosCursoPorCampus =
            array(
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'campus_has_courses.id as campus_coursesid',
                'courses.name as nameCourse',
            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus, 'campus_has_courses', $joinCampus, array('campus_has_courses.id' => $courseCampusId))->row();

        $gradeCurricular = $this->painelbd->where('*', 'courses_curricular_grid', null, array('courses_curricular_grid.campus_has_courses_id' => $cursoPorCampus->campus_coursesid), array('campo' => 'period', 'ordem' => 'asc'))->result();

        $data = array(
            'conteudo' => 'paineladm/cursos/matriz/lista_dados_matriz',
            'titulo' => 'Matriz/Grade Curricular do curso',
            'dados' => array(
                'tipo' => 'tabelaDatatable',
                'gradeCurricular' => $gradeCurricular = !empty($gradeCurricular) ? $gradeCurricular : '',
                'campus' => $campus,
                'modalidade' => $modalidade,
                'cursoPorCampus' => $cursoPorCampus,
                'page' => "<span>de matriz/ grade curricular do curso de <strong> $cursoPorCampus->nameCourse $campus->city</strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_disciplina_por_periodo($courseCampusId = NULL, $uriCampus = NULL, $modalidade = null)
    {
        verificaLogin();
        $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $colunasDadosCursoPorCampus =
            array(
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'campus_has_courses.id as campus_coursesid',
                'courses.name as nameCourse',
            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus, 'campus_has_courses', $joinCampus, array('campus_has_courses.id' => $courseCampusId))->row();

        $this->form_validation->set_rules('discipline', 'Nome da Disciplina', 'required');
        $this->form_validation->set_rules('period', 'Periodo', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                setMsg(validation_errors(), 'error');
            }
        } else {
            $dados_form = elements(array('discipline', 'period', 'status'), $this->input->post());

            $dados_form['user_id'] = $this->session->userdata('codusuario');
            //$dados_form['updated_at'] = date('Y-m-d H:i:s');
            $dados_form['campus_has_courses_id'] = $cursoPorCampus->campus_coursesid;

            if ($this->painelbd->salvar('courses_curricular_grid', $dados_form) == TRUE) {
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect("Painel_graduacao/lista_dados_matriz/$cursoPorCampus->campus_coursesid/$cursoPorCampus->campusid/$modalidade");
            } else {
                setMsg('<p>Erro! Erro no cadastro.</p>', 'error');
                redirect("Painel_graduacao/lista_dados_matriz/$cursoPorCampus->campus_coursesid/$cursoPorCampus->campusid/$modalidade");
            }
        }

        $data = array(
            'conteudo' => 'paineladm/cursos/matriz/cadastrar_disciplina_por_periodo',
            'titulo' => 'Matriz/Grade Curricular do curso',
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'modalidade' => $modalidade,
                'cursoPorCampus' => $cursoPorCampus,
                'page' => "<span>Cadastro de disciplina do curso de <strong> $cursoPorCampus->nameCourse ($modalidade) $campus->city</strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_disciplina_por_periodo($idDisciplina = null, $courseCampusId = NULL, $uriCampus = NULL, $modalidade = null)
    {
        verificaLogin();
        $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
        $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

        $colunasDadosCursoPorCampus =
            array(
                'campus.id as campusid',
                'campus.name as campusName',
                'campus.city',

                'campus_has_courses.id as campus_coursesid',
                'courses.name as nameCourse',
            );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages' => 'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus, 'campus_has_courses', $joinCampus, array('campus_has_courses.id' => $courseCampusId))->row();
        $colunasDadosDisciplina = array('courses_curricular_grid.id', 'courses_curricular_grid.discipline', 'courses_curricular_grid.period', 'courses_curricular_grid.status');

        $disciplinaCurso = $this->painelbd->where($colunasDadosDisciplina, 'courses_curricular_grid', null, array('courses_curricular_grid.id' => $idDisciplina))->row();

        $this->form_validation->set_rules('discipline', 'Nome da Disciplina', 'required');
        $this->form_validation->set_rules('period', 'Periodo', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) {
                setMsg(validation_errors(), 'error');
            }
        } else {
            $dados_form = elements(array('discipline', 'period', 'status'), $this->input->post());

            $dados_form['user_id'] = $this->session->userdata('codusuario');
            //$dados_form['updated_at'] = date('Y-m-d H:i:s');
            $dados_form['campus_has_courses_id'] = $cursoPorCampus->campus_coursesid;
            $dados_form['id'] = $disciplinaCurso->id;

            if ($this->painelbd->salvar('courses_curricular_grid', $dados_form) == TRUE) {
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect("Painel_graduacao/lista_dados_matriz/$cursoPorCampus->campus_coursesid/$cursoPorCampus->campusid/$modalidade");
            } else {
                setMsg('<p>Erro! Erro no cadastro.</p>', 'error');
                redirect("Painel_graduacao/lista_dados_matriz/$cursoPorCampus->campus_coursesid/$cursoPorCampus->campusid/$modalidade");
            }
        }

        $data = array(
            'conteudo' => 'paineladm/cursos/matriz/editar_disciplina_por_periodo',
            'titulo' => 'Matriz/Grade Curricular do curso',
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'disciplinaCurso' => $disciplinaCurso,
                'modalidade' => $modalidade,
                'cursoPorCampus' => $cursoPorCampus,
                'page' => "<span>Edição de dados de disciplina do curso de <strong> $cursoPorCampus->nameCourse ($modalidade) $campus->city</strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_disciplina_por_periodo($courseCampusId = NULL, $uriCampus = NULL, $modalidade = null, $id = NULL)
    {
        verifica_login();

        $item = $this->painelbd->where('*', 'courses_curricular_grid', NULL, array('courses_curricular_grid.id' => $id))->row();

        if ($this->painelbd->deletar('courses_curricular_grid', $item->id)) {
            setMsg('<p>Disciplina deletada com sucesso.</p>', 'success');
            redirect("Painel_graduacao/lista_dados_matriz/$courseCampusId/$uriCampus/$modalidade");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_graduacao/lista_dados_matriz/$courseCampusId/$uriCampus/$modalidade");
        }
    }
}
