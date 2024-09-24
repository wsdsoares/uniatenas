<?php

if (!defined("BASEPATH"))
  exit("No direct script access allowed");

class Painel_posgraduacao extends CI_Controller
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
  public function lista_campus_posgraduacao()
  {
    verificaLogin();

    $listagemDosCampus = $this->painelbd->where('*', 'campus', NULL, array('visible' => 'SIM'))->result();
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/cursos_posgraduacao/lista_campus_posgraduacao',
      'dados' => array(
        'page' => "Lista informações Campus - <b>Pós Graduação</b>",
        'campus' => $listagemDosCampus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_cursos_posgraduacao($uriCampus = null, $uriModalidade = 'ead')
  {
    $colunasPosGraduacao =
      array(
        'courses.id',
        'courses.name',
        'campus_has_courses.id',
        'campus_has_courses.status',
        'courses.icone',
        'courses.created_at',
        'courses.user_id'
      );

    $joinCoursesCampusHasCourses = array(
      'campus' => 'campus.id = campus_has_courses.campus_id',
      'courses' => 'courses.id = campus_has_courses.courses_id'
    );

    $whereCursosPos = array('courses.modalidade' => $uriModalidade, 'types' => 'PosGraduacao', 'campus_id' => $uriCampus);

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();


    $listagemDosCursos = $this->painelbd->where($colunasPosGraduacao, 'campus_has_courses', $joinCoursesCampusHasCourses, $whereCursosPos)->result();
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/cursos_posgraduacao/lista_cursos_posgraduacao',
      'dados' => array(
        // 'permissionCampusArray' => $_SESSION['permissionCampus'],
        'page' => "Lista de Cursos de Pós Graduação - <strong><i> $campus->city</i></strong>",
        'cursos' => $listagemDosCursos,
        'modalidade' => $uriModalidade,
        'campus' => $campus,
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_curso_posgraduacao($modalidade = null)
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
      'conteudo' => 'paineladm/cursos_posgraduacao/dados_curso/cadastrar_curso_posgraduacao',
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
}
