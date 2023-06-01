<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Painel_secretaria Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('acesso_model', 'acesso');
        $this->load->model('inicio_model', 'inicio');
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('Cpainel_model', 'bd');
        date_default_timezone_set('America/Sao_Paulo');
        verificaLogin();
    }

     
  public function lista_campus_secretaria() {
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
        'conteudo' => 'paineladm/secretaria/lista_campus_secretaria',
        'dados' => array(
            'page' => "Lista informações calendário - Secretaria Acadêmica",
            'campus'=> $listagemDosCampus,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
}


    public function calendarios_semestre($uriCampus = null)
    {
       
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $field = array('campus_calendars.id', 'campus_calendars.name', 'campus_calendars.year', 'campus_calendars.status',
            'campus_calendars.semester', 'campus_calendars.files', 'campus_calendars.datacreated', 'campus_calendars.datemodified',
            'campus_calendars.usersid', 'campus_calendars.type', 'campus.city');
        $table = 'campus_calendars';
        $datajoin = array('campus' => 'campus_calendars.campusid = campus.id');
        $where = array('campusid' => $campus->id);
        $order = array('campo' => 'id','ordem' => 'DESC');

        $listagem = $this->bd->Where($field, $table, $datajoin, $where,$order)->result();
        $table = str_replace('=', '', base64_encode($table));
        $data = array(
            'titulo' => 'Lista de Calendários ',
            'conteudo' => 'paineladm/secretaria/calendariosSemestre/lista_calendarios',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                // 'namecity' => $namecity,
                'listagem' => $listagem,
                'campus' => $campus,
                'page'=>"Calendários Semestre - $campus->name $campus->city",
                'tipo' => 'tabelaDatatable',
                'table' => $table
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_calendarios_semestre($uriCampus = null)
    {
       
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $this->load->helper('file');
        verificaLogin();
        if ($uriCampus == null) {
            redirect('painel');
        }
        
        $this->form_validation->set_rules('title', 'Titulo', 'required');
        $this->form_validation->set_rules('semestre', 'Semestre', 'required');
        $this->form_validation->set_rules('year', 'Ano ', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo de curso', 'required');


        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'erro');
            endif;
        } else {
            $path = "assets/secretaria/calendariosSemestre/$campus->id/";
            is_way($path);
            if (unique_name_args(noAccentuation($this->input->post('title'), 'Calendar'), $path)) {
                $name_tmp = null;
            } else {
                $name_tmp = noAccentuation($this->input->post('title'), 'Calendar');
            }

            $upload = $this->bd->uploadFiles('files', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF', $name_tmp);

            if ($upload) {
                //upload efetuado
                if ($this->input->post('tipo') == 1) {
                    $curso = 'demais_cursos';
                } elseif ($this->input->post('tipo') == 2) {
                    $curso = 'medicina';
                } elseif ($this->input->post('tipo') == 3) {
                    $curso = 'medicina';
                }
                //coleta de dados
                $dados_form['campusid'] = $campus->id;
                $dados_form['name'] = $this->input->post('title');
                $dados_form['year'] = $this->input->post('year');
                $dados_form['semester'] = $this->input->post('semestre');
                $dados_form['status'] = $this->input->post('status') - 1;
                $dados_form['files'] = $path . $upload['file_name'];
                $dados_form['usersid'] = $this->session->userdata('codusuario');
                $dados_form['type'] = $curso;
                //salvando
                if ($this->painelbd->salvar('campus_calendars', $dados_form) == TRUE) {
                    setMsg('<p>Calendário  cadastrada com sucesso.</p>', 'success');
                    redirect("Painel_secretaria/calendarios_semestre/$campus->id");
                } else {
                    setMsg('<p>Erro! O calendário  não foi cadastrada.</p>', 'error');
                    redirect("Painel_secretaria/calendarios_semestre/$campus->id");
                }
            } else {
                //erro no upload
                $msg = $this->upload->display_erros();
                $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }
        }
        $sql = "SELECT max(school_semester.year_semester) as ano FROM at_site.school_semester";
        $ano = $this->painelbd->getQuery($sql)->row();
        //devolvendo o formulario
        $data = array(
            'titulo' => "Cadastro de Calendários - Semestre",
            'conteudo' => 'paineladm/secretaria/calendariosSemestre/cadastrar_calendarios_semestre',
            'dados' => array(
                //'permissionCampusArray' => $_SESSION['permissionCampus'],
                //'table' => $tableD,
                'ano' => $ano->ano,
                'campus' => $campus,
                //'namecity' => $namecity,
                'tipo' => 'calendario',
                'page'=>"Cadastro de calendários $campus->name $campus->city"
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_calendario_semestre($uriCampus = null, $id = NULL)
    {
        $this->load->helper('file');
        date_default_timezone_set('America/Sao_Paulo');
        verificaLogin();

        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $field = array('campus_calendars.id', 'campus_calendars.name', 'campus_calendars.year', 'campus_calendars.status',
            'campus_calendars.semester', 'campus_calendars.files', 'campus_calendars.datacreated', 'campus_calendars.datemodified',
            'campus_calendars.usersid', 'campus_calendars.type', 'campus.city');
        $table = 'campus_calendars';
        $datajoin = array('campus' => 'campus_calendars.campusid = campus.id ');
        $where = array('campusid' => $campus->id, 'campus_calendars.id' => $id);

        $listagem = $this->bd->Where($field, $table, $datajoin, $where)->row();
        $this->form_validation->set_rules('title', 'Título', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
          if ($this->input->post('tipo') == 1) {
              $curso = 'demais_cursos';
          } elseif ($this->input->post('tipo') == 2) {
              $curso = 'medicina';
          } elseif ($this->input->post('tipo') == 3) {
              $curso = 'medicina';
          }else{
              $curso = ' ';
          }

          if ($listagem->name != $this->input->post('title')) {
              $dados_form['name'] = $this->input->post('title');
          }
          if ($listagem->semester != $this->input->post('semestre')) {
              $dados_form['semester'] = $this->input->post('semestre');
          }
          if ($listagem->year != $this->input->post('year')) {
              $dados_form['year'] = $this->input->post('year');
          }
          if ($listagem->status != $this->input->post('status')) {
              $dados_form['status'] = $this->input->post('status');
          }
          if ($listagem->type != $curso) {
              $dados_form['type'] = $curso;
          }

          if (isset($_FILES['files']) && !empty($_FILES['files']['name'])) {
            $path = "assets/secretaria/calendariosSemestre/$campus->id";
            is_way($path);

            if (unique_name_args(noAccentuation($this->input->post('title'),'Calendar' ), $path)) {
              $name_tmp = null;
            } else {
              $name_tmp = noAccentuation($this->input->post('title'), 'Calendar');
            }
            $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF|doc|DOC|docx|DOCX', $name_tmp);

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

          $dados_form['usersid'] = $this->session->userdata('codusuario');
          $dados_form['datemodified'] = date('Y-m-d H:i:s');
          $dados_form['id'] = $id;
                  
          if ($this->painelbd->salvar($table, $dados_form) == TRUE) {
            setMsg('<p>Dados alterados com sucesso.</p>', 'success');
            redirect("Painel_secretaria/calendarios_semestre/$campus->id");
          } else {
            setMsg('<p>Erro! Os dados não foi alterado.</p>', 'error');
            redirect("Painel_secretaria/calendarios_semestre/$campus->id");
          }
        }

        $sql = "SELECT max(school_semester.year_semester) as ano FROM at_site.school_semester";
        $ano = $this->painelbd->getQuery($sql)->row();
        $tipo = $listagem->type;
        if ($tipo == 'demais_cursos') {
            $idtipo = 1;
        } elseif ($tipo == 'medicina') {
            $idtipo = 2;
        } elseif ($tipo == 'Medicina-Omega') {
            $idtipo = 3;
        }else{
            $idtipo = 4;
        }
        //devolvendo o formulario
        $data = array(
            'titulo' => "Editar Calendadario",
            'conteudo' => 'paineladm/secretaria/calendariosSemestre/editar_calendario_semestre',
            'dados' => array(
                //'permissionCampusArray' => $_SESSION['permissionCampus'],
                'id' => $id,
                'idtipo'=> $idtipo,
                'listagem' => $listagem,
                'ano' => $ano->ano,
                'campus' => $campus,
                'page'=>"Edição de informações Calendário Acadêmico",
                'tipo' => 'calendario',
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_calendario_semestre($campusId=NULL,$idCalendario = NULL){
      verifica_login();
      $item = $this->painelbd->where('*','campus_calendars', NULL, array('campus_calendars.id' => $idCalendario))->row(); 
      if ($this->painelbd->deletar('campus_calendars', $item->id)) {
        setMsg('<p>O item foi deletado com sucesso.</p>', 'success');
        redirect(base_url("Painel_secretaria/calendarios_semestre/$campusId"));
      } else {
        setMsg('<p>Erro! O item foi não deletado.</p>', 'error');
        redirect(base_url("Painel_secretaria/calendarios_semestre/$campusId"));
      }
    }
  
  }

    // public function statusAlter($id = NULL, $status = null, $table = null, $redirec = null, $campus = null)
    // {
    //     verificaLogin();
    //     $dados_form['status'] = $status;
    //     $redirec = str_replace('-', '/', $redirec);
    //     $dados_form['datemodified'] = date('Y-m-d H:i:s');
    //     $dados_form['id'] = $id;
    //     $messagem = null;
    //     $messageNot = null;


    //     if ($status == 0) {
    //         $messagem = '<p>O Arquivo foi inativado com sucesso.</p>';
    //         $messageNot = '<p>Erro! O Arquivo foi não inativado.</p>';
    //     } else {
    //         $messagem = '<p>O Arquivo foi ativido com sucesso.</p>';
    //         $messageNot = '<p>Erro! O Arquivo foi não ativado.</p>';
    //     }


    //     if ($this->bd->salvar(base64_decode($table), $dados_form) == TRUE) {
    //         setMsg($messagem, 'success');
    //         redirect($redirec.'/'.$campus);
    //     } else {
    //         setMsg($messageNot, 'error');
    //         redirect($redirec.'/'.$campus);
    //     }
    // }
    //Modulo PED
//     public function ped($campus = null){
//         $queryCursos = "SELECT
//                         campus_has_courses.id idCourseCAmpus,
//                         courses.id as courses_id,
//                         courses.name as name,
//                         campus.id as campusId,
//                         courses.icone,
//                         campus.city,
//                         campus.name as campusName
                        
//                     FROM
//                       at_site.campus_has_courses
//                       inner join campus on campus.id = campus_has_courses.campus_id
//                       inner join courses on courses.id = campus_has_courses.courses_id
//                     WHERE campus.id = $campus
//                     ORDER BY courses.name";

//         $cursos = $this->painelbd->getQuery($queryCursos)->result();
//         $data = array(
//             'titulo' => 'Ped Cursos',
//             'conteudo' => 'paineladm/secretaria/ped/informacoesPed',
//             'dados' => array(
//                 'campus'=>$this->painelbd->getWhere('campus', array('id'=>$campus))->row(),
//                 'cursos' => $cursos,
//                 'tipo' => '',
//                 'page' => '')
//         );
//         $this->load->view('templates/layoutPainelAdm', $data);
//     }
//     public function pedLista($idCourseCampus=NULL,$campus = null)
//     {

//         $field = array('*');
//         $table = 'courses_teaching_plan';
//         $datajoin = array();
//         $where = array('campus_has_courses_id' => $idCourseCampus);
//         $order = array('campo' => 'period','ordem' => 'ASC');

//         $listagem = $this->bd->Where($field, $table, $datajoin, $where,$order)->result();

//    
//         $data = array(
//             'titulo' => 'Lista de Calendários ',
//             'conteudo' => 'paineladm/secretaria/ped/lista',
//             'dados' => array(
//                 'permissionCampusArray' => $_SESSION['permissionCampus'],
//                 'listagem' => $listagem,
//                 'campus' => $this->painelbd->getWhere('campus', array('id'=>$campus))->row(),
//                 'tipo' => 'Calendarios',
//                 'curso' => $idCourseCampus
//             )
//         );
//         $this->load->view('templates/layoutPainelAdm', $data);
//     }
//     public function cadastrar_ped($campus = null, $table = null)
//     {
//         $this->load->helper('file');
//         verificaLogin();
//         if ($campus == null) {
//             redirect('painel');
//         }
//         switch ($campus) {
//             case 1:
//                 $namecity = 'Paracatu';
//                 break;
//             case 2:
//                 $namecity = 'Sete Lagoas';
//                 break;
//             case 3:
//                 $namecity = 'Passos';
//                 break;
//             case 6:
//                 $namecity = 'Valença';
//                 break;   
//         }
//         //devolvendo o banco criptografado
//         $tableD = $table;
//         //recebendo o banco des-criptografado para salvar
//         $table = base64_decode($table);
//         //validado o formulario
//         $this->form_validation->set_rules('title', 'Titulo', 'required');
//         $this->form_validation->set_rules('semestre', 'Semestre', 'required');
//         $this->form_validation->set_rules('year', 'Ano ', 'required');
//         $this->form_validation->set_rules('status', 'Status', 'required');
//         $this->form_validation->set_rules('tipo', 'Tipo de curso', 'required');


//         if (empty($_FILES['files']['name'])) {
//             $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
//             $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
//         }

//         if ($this->form_validation->run() == FALSE) {
//             if (validation_errors()):
//                 setMsg(validation_errors(), 'erro');
//             endif;
//         } else {
//             $path = 'assets/secretaria/calendariosSemestre/';
//             is_way($path);
//             if (unique_name_args(noAccentuation($this->input->post('title'), 'Calendar'), $path)) {
//                 $name_tmp = null;
//             } else {
//                 $name_tmp = noAccentuation($this->input->post('title'), 'Calendar');
//             }

//             $upload = $this->bd->uploadFiles('files', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF', $name_tmp);

//             if ($upload) {
//                 //upload efetuado
//                 if ($this->input->post('tipo') == 1) {
//                     $curso = 'demais_cursos';
//                 } elseif ($this->input->post('tipo') == 2) {
//                     $curso = 'medicina';
//                 } elseif ($this->input->post('tipo') == 3) {
//                     $curso = 'medicina';
//                 }
//                 //coleta de dados
//                 $dados_form['campusid'] = $campus;
//                 $dados_form['name'] = $this->input->post('title');
//                 $dados_form['year'] = $this->input->post('year');
//                 $dados_form['semester'] = $this->input->post('semestre');
//                 $dados_form['status'] = $this->input->post('status') - 1;
//                 $dados_form['files'] = $path . $upload['file_name'];
//                 $dados_form['usersid'] = $this->session->userdata('codusuario');
//                 $dados_form['type'] = $curso;
//                 //salvando
//                 if ($this->painelbd->salvar($table, $dados_form) == TRUE) {
//                     setMsg('<p>Calendário  cadastrada com sucesso.</p>', 'success');
//                     redirect("Painel_secretaria/calendarios_semestre/$campus");
//                 } else {
//                     setMsg('<p>Erro! O calendário  não foi cadastrada.</p>', 'error');
//                     redirect("Painel_secretaria/calendarios_semestre/$campus");
//                 }
//             } else {
//                 //erro no upload
//                 $msg = $this->upload->display_erros();
//                 $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
//                 setMsg($msg, 'erro');
//             }
//         }
//         $sql = "SELECT max(school_semester.year_semester) as ano FROM at_site.school_semester";
//         $ano = $this->painelbd->getQuery($sql)->row();
//         //devolvendo o formulario
//         $data = array(
//             'titulo' => "Cadastro - $namecity",
//             'conteudo' => 'paineladm/secretaria/calendariosSemestre/cadastrar',
//             'dados' => array(
//                 'permissionCampusArray' => $_SESSION['permissionCampus'],
//                 'table' => $tableD,
//                 'ano' => $ano->ano,
//                 'campus' => $campus,
//                 'namecity' => $namecity,
//                 'tipo' => 'calendario'
//             )
//         );
//         $this->load->view('templates/layoutPainelAdm', $data);
//     }

// }