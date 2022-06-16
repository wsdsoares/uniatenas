<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_graduacao extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Sao_Paulo');
        $this->load->model('acesso_model', 'acesso');
        $this->load->model('inicio_model', 'inicio');
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('Cpainel_model', 'bd');

        date_default_timezone_set('America/Sao_Paulo');
    }
    public function todos_cursos() {
        $page = 'Lista de Campus';
        $uriModalidade = $this->uri->segment(3);
        $listagemDosCursos = $this->painelbd->where('*','courses',NULL,array('courses.modalidade'=>$uriModalidade))->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/todos_cursos',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' =>$page ,
                'cursos'=> $listagemDosCursos,
                'tipo'=> 'tabelaDatatable' 
            )
        );
        
        $this->load->view('templates/layoutPainelAdm', $data);
    }
    
    public function lista_campus_cursos() {
        verificaLogin();

        
        $colunasResultadoCursos = 
            array('campus.id',
            'campus.name',
            'campus.city',
            'campus.uf'
        );
    
        $listagemDosCampus = $this->painelbd->where('*','campus',NULL, array('visible' => 'SIM'))->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/lista_campus_cursos',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => 'Lista de Cursos - <strong>Gestão Por Campus</strong>',
                'campus'=> $listagemDosCampus,
                'tipo'=> '' 
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }
    
    public function lista_cursos($uriCampus,$uriModalidade) {
        verificaLogin();
        $uriCampus = $this->uri->segment(3);
        $uriModalidade = $this->uri->segment(4);

        $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

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
            'courses_pages'=>'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );
        $whereCursosPorCampus = array('campus.id'=>$campus->id,'courses.modalidade'=>$uriModalidade);
        $listaCampusPorCursos = $this->painelbd->where($colunasResultadoCursos,'campus_has_courses',$joinCampus, $whereCursosPorCampus,array('campo' => 'courses.name', 'ordem' => 'asc'), NULL)->result();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/lista_cursos',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => "Gestão de Cursos - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'cursos' => $listaCampusPorCursos,
                'campus'=> $campus,
                'tipo'=>'tabelaDatatable'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_informacoes_curso($courseCampusId=NULL){
        verificaLogin();
        $this->load->helper('file');

        // if (empty($courseCampusId)) {
        //     redirect('Paginas/editarSlideShow');
        // }

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
            'courses_pages.link_vestibular',
            'courses_pages.filesGrid',
            'courses_pages.actuation',
            'courses_pages.autorization',
            'courses_pages.recognition',
           
        );

        $joinCampus = array(
            'campus' => 'campus.id = campus_has_courses.campus_id',
            'courses' => 'courses.id = campus_has_courses.courses_id',
            'courses_pages'=>'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );
        
        $whereCursoPorCampus = array('campus_has_courses.id'=>$courseCampusId);
        $informacoesCurso = $this->painelbd->where($colunasBuscaDadosCurso,'campus_has_courses',$joinCampus, $whereCursoPorCampus,NULL, NULL,NULL)->row();

        $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$informacoesCurso->campusid))->row();


        //Validaçãoes via Form Validation
        $this->form_validation->set_rules('description', 'Descrição e informações do curso', 'required');


        /*if (!isset($arquivos) and isset($arquivoAtual)) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
        }*/


        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {

            $arquivoAutorizacao = $_FILES["autorization"];
            $arquivoReconhecimento = $_FILES["recognition"];
            $arquivoReconhecimentoAtual = $this->input->post('recognitionAtual');
            $arquivoCapa = $_FILES["capa"];
            // $arquivoAtual = $this->input->post('fileatual');

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
                
                $path = "assets/files/cursos//$campus->id/$informacoesCurso->idCourse/$informacoesCurso->coursePageId";
                is_way($path);
                $upload = $this->painelbd->uploadFiles('filesGrid', $path, $types = 'PDF|pdf', NULL);

                if ($upload){
                    //upload efetuado
                    $dados_form['filesGrid'] = $path . '/' . $upload['file_name'];
                }else{
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }
            
            if (isset($_FILES['capa']) && !empty($_FILES['capa']['name'])) {
                
                $path = 'assets/images/courses/capa/'.$campus->id;
                is_way($path);
                $upload = $this->painelbd->uploadFiles('capa', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

                if ($upload){
                    //upload efetuado
                    $dados_form['capa'] = $path . '/' . $upload['file_name'];
                }else{
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            if (isset($_FILES["autorization"]) && !empty($_FILES['autorization']['name'])) {
                
                $path = 'assets/files/cursos/'.$campus->id.'/autorization';
                is_way($path);
                $upload = $this->painelbd->uploadFiles('autorization', $path, $types = 'pdf|PDF', NULL);

                if ($upload){
                    //upload efetuado
                    $dados_form['autorization'] = $path . '/' . $upload['file_name'];
                    echo '<script>alert("'.$dados_form['autorization'].'")</script>';
                }else{
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            if (isset($_FILES["recognition"]) && !empty($_FILES['recognition']['name'])) {
                
                $path = 'assets/files/cursos/'.$campus->id.'/recognition';
                is_way($path);
                $upload = $this->painelbd->uploadFiles('recognition', $path, $types = 'pdf|PDF', NULL);

                if ($upload){
                    //upload efetuado
                    $dados_form['autorization'] = $path . '/' . $upload['file_name'];
                    
                }else{
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
            
            if ($this->painelbd->salvar('courses_pages', $dados_form) == TRUE){
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_graduacao/lista_cursos/$campus->id/presencial"));
            }else{
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/informacoes/cadastrar_informacoes',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => "Vínculo de Curso - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'informacoesCurso'=> $informacoesCurso,
                'campus'=> $campus,
                'tipo'=>''
            )
        );


        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function registro_dados_matriz($courseCampusId=NULL){
        verificaLogin();
        $this->load->helper('file');

        // if (empty($courseCampusId)) {
        //     redirect('Paginas/editarSlideShow');
        // }

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
            'courses_pages'=>'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );
        
        $whereCursoPorCampus = array('campus_has_courses.id'=>$courseCampusId);
        $informacoesCurso = $this->painelbd->where($colunasBuscaDadosCurso,'campus_has_courses',$joinCampus, $whereCursoPorCampus,NULL, NULL,NULL)->row();

        $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$informacoesCurso->campusid))->row();


        //Validaçãoes via Form Validation
        $this->form_validation->set_rules('description', 'Descrição e informações do curso', 'required');


        /*if (!isset($arquivos) and isset($arquivoAtual)) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
        }*/


        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {

            $arquivoAutorizacao = $_FILES["autorization"];
            $arquivoReconhecimento = $_FILES["recognition"];
            $arquivoReconhecimentoAtual = $this->input->post('recognitionAtual');
            $arquivoCapa = $_FILES["capa"];
            // $arquivoAtual = $this->input->post('fileatual');

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
                
                $path = 'assets/images/courses/capa/'.$campus->id;
                is_way($path);
                $upload = $this->painelbd->uploadFiles('capa', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

                if ($upload){
                    //upload efetuado
                    $dados_form['capa'] = $path . '/' . $upload['file_name'];
                }else{
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            if (isset($_FILES["autorization"]) && !empty($_FILES['autorization']['name'])) {
                
                $path = 'assets/files/cursos/'.$campus->id.'/autorization';
                is_way($path);
                $upload = $this->painelbd->uploadFiles('autorization', $path, $types = 'pdf|PDF', NULL);

                if ($upload){
                    //upload efetuado
                    $dados_form['autorization'] = $path . '/' . $upload['file_name'];
                    
                }else{
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            if (isset($_FILES["recognition"]) && !empty($_FILES['recognition']['name'])) {
                
                $path = 'assets/files/cursos/'.$campus->id.'/recognition';
                is_way($path);
                $upload = $this->painelbd->uploadFiles('recognition', $path, $types = 'pdf|PDF', NULL);

                if ($upload){
                    //upload efetuado
                    $dados_form['autorization'] = $path . '/' . $upload['file_name'];
                    
                }else{
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
            
            if ($this->painelbd->salvar('courses_pages', $dados_form) == TRUE){
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_graduacao/lista_cursos/$campus->id/presencial"));
            }else{
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/cursos/matriz/registro_dados_matriz',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => "Vínculo de Curso - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'informacoesCurso'=> $informacoesCurso,
                'campus'=> $campus,
                'tipo'=>''
            )
        );


        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_fotos_curso($courseCampusId=NULL,$uriCampus=NULL)
    {
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

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
            'courses_pages'=>'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus,'campus_has_courses',$joinCampus, array('campus_has_courses.id'=>$courseCampusId))->row();
        
        $whereCursoPorCampus = array('courses_photos.idCourseCampus'=>$cursoPorCampus->campus_coursesid);
        $fotosCurso = $this->painelbd->where('*','courses_photos',NULL, $whereCursoPorCampus)->result();
 
        $data = array(
            'conteudo' => 'paineladm/cursos/fotosCurso/lista_fotos_curso',
            'titulo' => 'Fotos do Curso - UniAtenas',
            'dados' => array(
                'page' => "Fotos do Curso - $cursoPorCampus->nameCourse <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'tipo' => 'tabelaDatatable',
                'fotosCurso' => $fotosCurso,
                'cursoPorCampus'=>$cursoPorCampus,
                'campus' => $campus,
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_fotos_curso($courseCampusId=NULL,$uriCampus=NULL)
    {
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

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
            'courses_pages'=>'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus,'campus_has_courses',$joinCampus, array('campus_has_courses.id'=>$courseCampusId))->row();
        
        $this->form_validation->set_rules('title', 'Título', 'required');

        if (empty($_FILES['files'])) {
            $_FILES['files']['size'][0] = 0;
        }

        if ($_FILES['files']['size'][0] <= 0) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPEG, PNG ou JPG.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
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
                'cursoPorCampus'=>$cursoPorCampus,
                'page'=> "<span>Cadastrar Fotos do Curso: <strong>$cursoPorCampus->nameCourse <i>$campus->name - $campus->city</i></strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_foto_curso($courseCampusId=NULL,$uriCampus=NULL,$id=NULL)
    {
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

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
            'courses_pages'=>'courses_pages.campus_has_courses_id = campus_has_courses.id',
        );

        $cursoPorCampus = $this->painelbd->where($colunasDadosCursoPorCampus,'campus_has_courses',$joinCampus, array('campus_has_courses.id'=>$courseCampusId))->row();

        $fotoCurso = $this->painelbd->where('*','courses_photos',NULL, array('courses_photos.id'=>$id))->row();
        
        $this->form_validation->set_rules('title', 'Título', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
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

                if ($upload){
                    //upload efetuado
                    $dados_form['files'] = $path . '/' . $upload['file_name'];
                }else{
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
           
            if ($this->painelbd->salvar('courses_photos', $dados_form) == TRUE){
                setMsg('<p>Fotos cadastrada com sucesso.</p>', 'success');
                redirect("Painel_graduacao/lista_fotos_curso/$cursoPorCampus->campus_coursesid/$campus->id");
            }else{
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
                'cursoPorCampus'=>$cursoPorCampus,
                'page'=> "<span>Cadastrar Fotos do Curso: <strong>$cursoPorCampus->nameCourse <i>$campus->name - $campus->city</i></strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_foto_curso($courseCampusId=NULL,$uriCampus=NULL,$id = NULL)
    {
        verifica_login();
    
        $uriCampus=$this->uri->segment(4);
        $id=$this->uri->segment(5);
        $item = $this->painelbd->where('*','courses_photos', NULL, array('courses_photos.id' => $id))->row(); 

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

}