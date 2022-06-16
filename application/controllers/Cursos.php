<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Cursos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //verifica_login();
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('site_model', 'bancosite');
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function cursosPlanosEnsino($campus = NULL)
    {
    if($campus == null){
    redirect("");
    }

        $sqlCourses = "SELECT 
                        campus.id as campusid,
                        campus_has_courses.id as id,
                        courses.id as courses_id, 
                        courses.name  as name,
                        courses.icone,
                        courses.modalidade,
                        courses.types,
                        campus.name as campusname,
                        campus.city as city
                    FROM
                        at_site.campus_has_courses
                    inner join campus on campus.id = campus_has_courses.campus_id
                    inner join courses on courses.id = campus_has_courses.courses_id
                    where campus.id =$campus;";

        $courses = $this->painelbd->getQuery($sqlCourses)->result();
        $campus = $this->painelbd->getWhere('campus', array('id' => $campus))->row();


        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/planosensino/cursosPlanosEnsino',
            'dados' => array(
                'courses' => $courses,
                'campus' => $campus,
                'tipo' => ''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);

    }

    public function informacoesCurso($campus = NULL)
    {
        if($campus == null){
            redirect("");
        }

        $queryCursos = "SELECT
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
                    WHERE campus.id = $campus
                    ORDER BY courses.name";

        $courses = $this->painelbd->getQuery($queryCursos)->result();
        $campus = $this->painelbd->getWhere('campus',array('id'=>$campus))->row();

        
       
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/informacoesCurso',
            'dados' => array(
                'courses' => $courses,
                'campus' => $campus,
                'tipo' => ''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);

    }



    public function verFotos($idCourseCampus){

        if($idCourseCampus == null){
            redirect("");
        }
        $queryCursos = "SELECT
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


        $courses = $this->painelbd->getQuery($queryCursos)->row();

        $fotos = $this->painelbd->getWhere('courses_photos', array('idCourseCampus' =>$idCourseCampus), array('campo'=>'datecreated', 'ordem'=>'desc'))->result();
        $campus = $this->painelbd->getWhere('campus',array('id'=>$courses->campusId))->row();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/fotosCurso/verFotos',
            'dados' => array(
                'courses' => $courses,
                'campus' => $campus,
                'fotos' => $fotos,

                'tipo' => ''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrarFotos($id)
    {
        if (empty($id)) {
            redirect('cursos/informacoesCurso/1');
        }

        $queryCursos = "SELECT
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
                    WHERE campus_has_courses.id = $id
                    ORDER BY courses.name";

        $courses = $this->painelbd->getQuery($queryCursos)->row();
        $campus = $this->painelbd->getWhere('campus',array('id'=>$courses->campusId))->row();

        $this->form_validation->set_rules('title', 'Título', 'required');


        if (empty($_FILES['files'])) {
            $_FILES['files']['size'][0] = 0;
        }

        if ($_FILES['files']['size'][0] == 0) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPEG, PNG ou JPG.');
        }elseif ($_FILES['files']['name'][0] != '' and $_FILES['files']['size'][0]==0) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'A sua imagem está no formato incorreto ou o tamanho dela está muito grande. <br> Por favor, tente a compactação ou procure outra imagem.');
        }

        $this->form_validation->set_rules('usersid', 'Usuários', 'required');


        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $number_of_files = count($_FILES['files']['name']);
            $files = $_FILES;

            if (is_dir(FCPATH . "/assets/images/courses/photos/$campus->id/$courses->courses_id")) {
                $path = "assets/images/courses/photos/$campus->id/$courses->courses_id";
            } else {
                mkdir(FCPATH . "/assets/images/courses/photos/$campus->id/$courses->courses_id", 0777, true);
                $path = "assets/images/courses/photos/$campus->id/$courses->courses_id";
            }
            echo $number_of_files;
            for ($i = 0; $i < $number_of_files; $i++) {
                $_FILES['files']['name'] = $files['files']['name'][$i];
                $_FILES['files']['type'] = $files['files']['type'][$i];
                $_FILES['files']['tmp_name'] = $files['files']['tmp_name'][$i];
                $_FILES['files']['error'] = $files['files']['error'][$i];
                $_FILES['files']['size'] = $files['files']['size'][$i];

                $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|jpeg|png|JPG|JPEG|PNG', NULL);

                if ($upload) {
                    $user = $this->session->userdata('codusuario');
                    $dados_form['usersid'] = $user;
                    $dados_form['title'] = $this->input->post('title');

                    $dados_form['files'] = $path . '/' . $upload['file_name'];
                    $dados_form['datecreated'] = date('Y-m-d H:i:s');
                    $dados_form['idCourseCampus'] = $courses->idCourseCampus;
                    $dados_form['status'] = 1;

                    if ($id = $this->painelbd->salvar('courses_photos', $dados_form)) {
                        if ($number_of_files == ($i + 1)) {
                            setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Fotos cadastrada com sucesso.</p>', 'success');
                            redirect('cursos/verFotos/'.$courses->idCourseCampus);
                        }
                    } else {
                        setMsg('<img src="' . base_url('assets/images/icons/sorry.png') . '" alt=""><br><p>Erro! As fotos não podem ser cadastradas.</p>', 'error');
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
            'conteudo' => 'paineladm/cursos/fotosCurso/cadastrarFotos',
            'titulo' => 'Fotos - Cadastro - UniAtenas',
            'dados' => array(
                'tipo' => '',
                'courses' => $courses,
                'campus' => $campus
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);

    }

    function deletarFoto($id = NULL)
    {
        $table = 'courses_photos';
        $explodeId = explode('-', $id);
        $dados = $this->painelbd->getWhere($table, array('id' => $explodeId[1]))->row();
        $arquivo = isset($dados->files) ? $dados->files : '';
        if ($explodeId[1] != NULL && $dados) {

            if ($this->painelbd->delete($table, array('id' => $explodeId[1])) == TRUE) {


                $files = realpath($dados->file);
                $fileDeleted = current(array_reverse(explode('/', $dados->files)));

                if (is_dir(FCPATH . "/assets/images/old/courses/$explodeId[0]")) {
                    $path = "assets/assets/images/old/courses/$explodeId[0]";
                } else {
                    mkdir(FCPATH . "/assets/images/old/courses/$explodeId[0]", 0777, true);
                    $path = "assets/images/old/courses/$explodeId[0]";
                }


                if (copy($files, $path . '/' . date('d-m-y') . $fileDeleted)) {
                    $msg = "";
                } else {
                    $msg = "não foi possível fazer a cópia de segurança para '$path'.";
                }

                if (!unlink($arquivo)) {
                    setMsg('Não foi possível remover o arquivo de nome ' . $arquivo . " e  $msg", 'alert');
                    redirect(current_url());
                } else {
                    setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Foto deletada com sucesso.</p>', 'success');
                    redirect('Cursos/verFotos/' . $explodeId[0]);
                }
            } else {

                setMsg('<img src="' . base_url('assets/images/icons/sorry.png') . '" alt=""><br><p>Erro! A foto não podem ser deletada.</p>', 'error');
                redirect('Cursos/verFotos/' . $explodeId[0]);
            }
        } else {
            setMsg('<img src="' . base_url('assets/images/icons/sorry.png') . '" alt=""><br><p>Erro! A foto não podem ser deletada.</p>', 'error');
            redirect('Cursos/verFotos/' . $explodeId[0]);
        }
    }

    public function verInfraestrutura($idCourseCampus){

        $queryCursos = "SELECT
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


        $courses = $this->painelbd->getQuery($queryCursos)->row();

        $laboratorios = $this->painelbd->getWhere('courses_infrastructure', array('idCourseCampus'=>$idCourseCampus))->result();
        $campus = $this->painelbd->getWhere('campus',array('id'=>$courses->campusId))->row();


        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/infraLabCurso/verInfraestura',
            'dados' => array(
                'courses' => $courses,
                'campus' => $campus,
                'laboratorios' => $laboratorios,

                'tipo' => ''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrarInfraestrutura($id)
    {
        if (empty($id)) {
            edirect('cursos/informacoesCurso/1');
        }

        $queryCursos = "SELECT
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
                    WHERE campus_has_courses.id = $id
                    ORDER BY courses.name";

        $courses = $this->painelbd->getQuery($queryCursos)->row();
        $campus = $this->painelbd->getWhere('campus',array('id'=>$courses->campusId))->row();

        $this->form_validation->set_rules('title', 'Título', 'required');


        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('file', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPEG, PNG ou JPG.');
        }

        $this->form_validation->set_rules('title', 'Título do laboratório', 'required');
        $this->form_validation->set_rules('subtitle', 'Descrição breve do laboratório', 'required');
        $this->form_validation->set_rules('description', 'Descrição do laboratório', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if (is_dir(FCPATH . "/assets/images/courses/photosLabs/$campus->id/$courses->courses_id")) {
                $path = "assets/images/courses/photosLabs/$campus->id/$courses->courses_id";
            } else {
                mkdir(FCPATH . "/assets/images/courses/photosLabs/$campus->id/$courses->courses_id", 0777, true);
                $path = "assets/images/courses/photosLabs/$campus->id/$courses->courses_id";
            }

            $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|jpeg|png|JPG|JPEG|PNG', NULL);

            if ($upload) {
                $user = $this->session->userdata('codusuario');
                $dados_form = elements(array('title', 'subtitle','description'), $this->input->post());
                $dados_form['usersid'] = $user;
                $dados_form['files'] = $path . '/' . $upload['file_name'];
                $dados_form['datecreated'] = date('Y-m-d H:i:s');
                $dados_form['idCourseCampus'] = $courses->idCourseCampus;

                if ($id = $this->painelbd->salvar('courses_infrastructure', $dados_form)) {
                    setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p> Informações de laboratórios cadastrado com sucesso.</p>', 'success');
                    redirect('cursos/verInfraestrutura/'.$courses->idCourseCampus);
                } else {
                    setMsg('<img src="' . base_url('assets/images/icons/sorry.png') . '" alt=""><br><p>Erro! As informações não foram cadastradas.</p>', 'error');
                }
            } else {
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }
        }

        $data = array(
            'conteudo' => 'paineladm/cursos/infraLabCurso/cadastrarInfraLab',
            'titulo' => 'Infraestrutura Laboratórios - UniAtenas',
            'dados' => array(
                'tipo' => '',
                'courses' => $courses,
                'campus' => $campus
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);

    }

    function deletarFotoInfra($id = NULL)
    {
        $table = 'courses_photos';
        $explodeId = explode('-', $id);
        $dados = $this->painelbd->getWhere($table, array('id' => $explodeId[1]))->row();
        $arquivo = isset($dados->files) ? $dados->files : '';
        if ($explodeId[1] != NULL && $dados) {

            if ($this->painelbd->delete($table, array('id' => $explodeId[1])) == TRUE) {


                $files = realpath($dados->file);
                $fileDeleted = current(array_reverse(explode('/', $dados->files)));

                if (is_dir(FCPATH . "/assets/images/old/courses/$explodeId[0]")) {
                    $path = "assets/assets/images/old/courses/$explodeId[0]";
                } else {
                    mkdir(FCPATH . "/assets/images/old/courses/$explodeId[0]", 0777, true);
                    $path = "assets/images/old/courses/$explodeId[0]";
                }


                if (copy($files, $path . '/' . date('d-m-y') . $fileDeleted)) {
                    $msg = "";
                } else {
                    $msg = "não foi possível fazer a cópia de segurança para '$path'.";
                }

                if (!unlink($arquivo)) {
                    setMsg('Não foi possível remover o arquivo de nome ' . $arquivo . " e  $msg", 'alert');
                    redirect(current_url());
                } else {
                    setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Foto deletada com sucesso.</p>', 'success');
                    redirect('Cursos/verFotos/' . $explodeId[0]);
                }
            } else {

                setMsg('<img src="' . base_url('assets/images/icons/sorry.png') . '" alt=""><br><p>Erro! A foto não podem ser deletada.</p>', 'error');
                redirect('Cursos/verFotos/' . $explodeId[0]);
            }
        } else {
            setMsg('<img src="' . base_url('assets/images/icons/sorry.png') . '" alt=""><br><p>Erro! A foto não podem ser deletada.</p>', 'error');
            redirect('Cursos/verFotos/' . $explodeId[0]);
        }
    }



    public function planosEnsinoCurso($campus = NULL, $course = NULL, $idCourseCampus = NULL)
    {

        if ($course == NULL) {
            redirect('painel');
        }
        $sql = "SELECT * FROM at_site.courses_teaching_plan
            where campus_has_courses_id =$course
            order by period desc";

        $sqlPeriod = "SELECT 
                        period  
                    FROM
                        at_site.courses_teaching_plan
                    inner join campus_has_courses on campus_has_courses.id = courses_teaching_plan.campus_has_courses_id
                    WHERE
                        campus_has_courses_id = $idCourseCampus
                    GROUP BY (period)";

        $planos = $this->bancosite->getQuery($sql)->result();
        $periods = $this->bancosite->getQuery($sqlPeriod)->result();
        $course = $this->painelbd->getWhere('courses', array('id' => $course))->row();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/planosensino/planosEnsinoCurso',
            'dados' => array(
                'planos' => $planos,
                'periods' => $periods,
                'course' => $course,
                'tipo' => ''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);

    }

    public function cadastrarPlanoEnsino($campus = NULL, $course = NULL, $idCourseCampus = NULL)
    {

        if ($course == NULL) {
            redirect('painel');
        }

        $course = $this->painelbd->getWhere('courses', array('id' => $course))->row();
        $campus = $this->painelbd->getWhere('campus', array('id' => $campus))->row();

        $this->load->helper('file');

        $this->form_validation->set_rules('discipline', 'Disciplina', 'required');
        $this->form_validation->set_rules('period', 'Período', 'required');

        if (empty($_FILES['file']['name'])) {
            $this->form_validation->set_rules('file', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            $name_tmp = preg_replace(array(
                "/(á|à|ã|â|ä)/",
                "/(Á|À|Ã|Â|Ä)/",
                "/(é|è|ê|ë)/",
                "/(É|È|Ê|Ë)/",
                "/(í|ì|î|ï)/",
                "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post('discipline'));
            $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', "’");

            // matriz de saída
            $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');

            // devolver a string
            $period = $this->input->post('period');
            $name_tmp = str_replace($what, $by, $name_tmp);
            if (is_dir(FCPATH . "/assets/files/cursos/courses_teaching_plan/$campus->id/$course->id/$period")) {
                $path = "assets/files/cursos/courses_teaching_plan/$campus->id/$course->id/$period";
            } else {
                mkdir(FCPATH . "/assets/files/cursos/courses_teaching_plan/$campus->id/$course->id/$period", 0777, true);
                $path = "assets/files/cursos/courses_teaching_plan/$campus->id/$course->id/$period";
            }

            $upload = $this->painelbd->do_uploadFiles('file', $path, $types = 'pdf', $name_tmp);

            if ($upload):
                $dados_form = elements(array('discipline', 'period'), $this->input->post());
                $dados_form['file'] = $path . '/' . $upload['file_name'];
                $dados_form['usersid'] = $this->session->userdata('codusuario');
                $dados_form['status'] = '1';
                $dados_form['campus_has_courses_id'] = $idCourseCampus;

                if ($id = $this->painelbd->salvar('courses_teaching_plan', $dados_form)):
                    setMsg('<p>Plano de Esnino cadastrado com sucesso.</p>', 'success');
                    redirect("Cursos/planosEnsinoCurso/$campus->id/$course->id/$idCourseCampus");
                else:
                    setMsg('<img src="' . base_url('assets/images/icons/sorry.png') . '" alt=""><br><p>Erro! O plano de ensino não pode ser cadastrado.</p>', 'error');
                    redirect("Cursos/cadastrarPlanoEnsino/$campus->id/$course->id/$idCourseCampus");
                endif;

            else:
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            endif;
        }


        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/planosensino/cadastrarPlanoEnsino',
            'dados' => array(
                'course' => $course,
                'campus' => $campus,
                'tipo' => ''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);

    }

    public function editarPlanoEnsino($id = NULL)
    {

        if ($id == NULL) {
            //redirect('painel');
        }

        $queryPeriods = "SELECT
                            courses_teaching_plan.id,
                            courses_teaching_plan.discipline,
                            courses_teaching_plan.file,
                            courses_teaching_plan.period,
                            campus.id AS campusid,
                            campus_has_courses.id AS idCourseCampus,
                            courses.id AS courses_id,
                            courses.name AS course,
                            campus.city AS city
                        FROM
                            courses_teaching_plan
                                INNER JOIN
                            campus_has_courses ON campus_has_courses.id = courses_teaching_plan.campus_has_courses_id
                                INNER JOIN
                            campus ON campus.id = campus_has_courses.campus_id
                                INNER JOIN
                            courses ON courses.id = campus_has_courses.courses_id
                        WHERE
                            courses_teaching_plan.id=$id";
        $teachingPlan = $this->painelbd->getQuery($queryPeriods)->row();


        $this->load->helper('file');

        $this->form_validation->set_rules('discipline', 'Disciplina', 'required');
        $this->form_validation->set_rules('period', 'Período', 'required');

        if (empty($_FILES['file']['name']) and empty($this->input->post('fileatual'))) {
            $this->form_validation->set_rules('file', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            $dados_form = elements(array('discipline', 'period'), $this->input->post());
            $fileAtual = $this->input->post('fileatual');
            $dados_form['id'] = $id;

            $dados_form['usersid'] = $this->session->userdata('codusuario');
            $dados_form['status'] = '1';
            $dados_form['campus_has_courses_id'] = $teachingPlan->idCourseCampus;

            $name_tmp = preg_replace(array(
                "/(á|à|ã|â|ä)/",
                "/(Á|À|Ã|Â|Ä)/",
                "/(é|è|ê|ë)/",
                "/(É|È|Ê|Ë)/",
                "/(í|ì|î|ï)/",
                "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post('discipline'));
            $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', "’");

            // matriz de saída
            $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');

            // devolver a string

            $period = $this->input->post('period');

            if (is_dir(FCPATH . "/assets/files/cursos/courses_teaching_plan/$teachingPlan->campusid/$teachingPlan->courses_id/$period")) {
                $path = "assets/files/cursos/courses_teaching_plan/$teachingPlan->campusid/$teachingPlan->courses_id/$period";
            } else {
                mkdir(FCPATH . "/assets/files/cursos/courses_teaching_plan/$teachingPlan->campusid/$teachingPlan->courses_id/$period", 0777, true);
                $path = "assets/files/cursos/courses_teaching_plan/$teachingPlan->campusid/$teachingPlan->courses_id/$period";
            }

            $name_tmp = str_replace($what, $by, $name_tmp);
            $arquivo = $teachingPlan->file;

            if (!empty($fileAtual) and empty($_FILES['file']['name'])) {
                if ($teachingPlan->discipline == $dados_form['discipline']) {
                    setMsg('<img src="' . base_url('assets/images/icons/wait.png') . '" alt=""><br><p>Atenção! <br>Você não modificou nehuma informação!.</p>', 'alert');
                    redirect(current_url());
                } else {

                    $ext = pathinfo($path . '/' . $teachingPlan->file, PATHINFO_EXTENSION);
                    rename("$teachingPlan->file", "$path/$name_tmp.$ext");
                    $dados_form['file'] = "$path/$name_tmp.$ext";
                    if ($id = $this->painelbd->salvar('courses_teaching_plan', $dados_form)):
                        setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Plano de Ensino editado com sucesso.</p>', 'success');
                        redirect("cursos/visualizarPlanosEnsino/$teachingPlan->campusid/$teachingPlan->courses_id/$teachingPlan->idCourseCampus/$teachingPlan->period");
                    else:
                        setMsg('<img src="' . base_url('assets/images/icons/sorry.png') . '" alt=""><br><p>Erro! O plano de ensino não pode ser editado.</p>', 'error');
                        redirect("cursos/visualizarPlanosEnsino/$teachingPlan->campusid/$teachingPlan->courses_id/$teachingPlan->idCourseCampus/$teachingPlan->period");
                    endif;
                }
            } else {
                if (file_exists($arquivo)) {
                    unlink($arquivo);
                    $upload = $this->painelbd->do_uploadFiles('file', $path, $types = 'pdf', $name_tmp);
                    if ($upload):
                        $dados_form['file'] = $path . '/' . $upload['file_name'];
                        if ($id = $this->painelbd->salvar('courses_teaching_plan', $dados_form)):
                            setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Plano de Ensino editado com sucesso.</p>', 'success');
                            redirect("cursos/visualizarPlanosEnsino/$teachingPlan->campusid/$teachingPlan->courses_id/$teachingPlan->idCourseCampus/$teachingPlan->period");
                        else:
                            setMsg('<img src="' . base_url('assets/images/icons/sorry.png') . '" alt=""><br><p>Erro! O plano de ensino não pode ser editado.</p>', 'error');
                            redirect("cursos/visualizarPlanosEnsino/$teachingPlan->campusid/$teachingPlan->courses_id/$teachingPlan->idCourseCampus/$teachingPlan->period");
                        endif;
                    else:
                        //erro no upload
                        $msg = $this->upload->display_errors();
                        $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                        setMsg($msg, 'erro');
                    endif;
                } else {
                    echo '<script>alert("File not exists")</script>';
                }
            }
        }


        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/planosensino/editarPlanoEnsino',
            'dados' => array(
                'teachingPlan' => $teachingPlan,
                'tipo' => ''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);

    }


    public function visualizarPlanosEnsino($campus = NULL, $course = NULL, $idCourseCampus = NULL, $period = NULL)
    {

        $queryPeriods = "Select 
                            *
                            from 
                            courses_teaching_plan
                            where courses_teaching_plan.period=$period
                            and courses_teaching_plan.campus_has_courses_id=$idCourseCampus
                                    ";
        $teachingPlan = $this->painelbd->getQuery($queryPeriods)->result();

        $course = $this->painelbd->getWhere('courses', array('id' => $course))->row();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/planosensino/visualizarPlanosEnsino',
            'dados' => array(
                'course' => $course,
                'campus' => $campus,
                'teachingPlan' => $teachingPlan,
                'period' => $period,
                'tipo' => ''
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }


    public function deletarPlanoEnsino($id = NULL)
    {
        $daddosForm = explode('-', $id);
        $table = 'courses_teaching_plan';
        $dados = $this->painelbd->getWhere($table, array('id' => $daddosForm[0]))->row();
        $arquivo = $dados->file;

        if ($id != NULL && $dados) {
            if ($del = $this->painelbd->delete($table, array('id' => $id))) {

                if (!unlink($arquivo)) {
                    setMsg('Não foi possível remover o arquivo de nome ' . $arquivo . '', 'alert');
                    redirect('Cursos/visualizarPlanosEnsino/' . $daddosForm[1] . '/' . $daddosForm[2] . '/' . $daddosForm[3] . '/' . $dados->period);
                } else {
                    setMsg('<p>Informação removida com sucesso.</p>', 'success');
                    redirect('Cursos/visualizarPlanosEnsino/' . $daddosForm[1] . '/' . $daddosForm[2] . '/' . $daddosForm[3] . '/' . $dados->period);
                }
            } else {
                setMsg('<p>Erro! A publicação não pode ser deletada.</p>', 'error');
                redirect('Cursos/visualizarPlanosEnsino/' . $daddosForm[1] . '/' . $daddosForm[2] . '/' . $daddosForm[3] . '/' . $dados->period);
            }
        } else {
            setMsg('<p>Erro! Não existe publicações para os dados informados.</p>', 'error');
            redirect('Cursos/visualizarPlanosEnsino/' . $daddosForm[1] . '/' . $daddosForm[2] . '/' . $daddosForm[3] . '/' . $dados->period);
        }
    }


}
