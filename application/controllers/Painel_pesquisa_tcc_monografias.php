<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_pesquisa_tcc_monografias extends CI_Controller {

  public function __construct() {
    parent::__construct();
    verificaLogin();
    $this->load->model('painel_model', 'painelbd');
    $this->load->model('site_model', 'bancosite');
    date_default_timezone_set('America/Sao_Paulo');
    $this->load->helper('file');
  }

  public function cursos_monografia($uriCampus = NULL,$pageId = NULL) {
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunasCursosCampus = array(
      'courses.id','campus_has_courses.id as idCursoCampus','courses.name','courses.modalidade'
    );
    $joinCursosCampus = array(
      'campus_has_courses'=>'campus_has_courses.courses_id = courses.id',
      'campus'=>'campus.id = campus_has_courses.campus_id'
    );
    $whereCursosCampus = array('campus.id'=>$uriCampus);
    $cursos = $this->painelbd->where($colunasCursosCampus,'courses',$joinCursosCampus,$whereCursosCampus)->result();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();


    $data = array(
      'titulo' => 'Gestão de monografias - Uniatenas',
      'conteudo' => 'paineladm/itens_iniciacao/tcc/publicacoes/cursos_monografia',
      'dados' => array(
        'page'=> "Lista Cursos/ Monografias <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'cursos' => $cursos,
        'campus'=>$campus,
        'pagina'=>$pagina,
        'tipo' => 'tabelaDatatable')
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }
  
  public function lista_monografias($uriCampus = NULL, $pageId = NULL, $idCurso = NULL) {
    
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunasCursosCampus = array(
      'campus_has_courses.id','courses.name'
    );
    $joinCursosCampus = array(
      'courses'=>'courses.id = campus_has_courses.courses_id',
      'campus'=>'campus.id = campus_has_courses.campus_id',
    );
    
    $whereCursosCampus = array('campus_has_courses.id'=>$idCurso);

    $curso = $this->painelbd->where($colunasCursosCampus,'campus_has_courses',$joinCursosCampus,$whereCursosCampus)->row();

    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoMonografia = array(
      'monography.id',
      'monography.campus_has_courses_id',
      'monography.coursesid',
      'monography.title',
      'monography.author',
      'monography.files',
      'monography.created_at',
      'monography.year',
      'monography.status',
      'monography.user_id',
    );
    $joinMonografia = array(
      'campus_has_courses'=>'campus_has_courses.id = monography.campus_has_courses_id',
    );
    $whereMonografia = array('monography.campus_has_courses_id'=>$curso->id);
    $listaMonografias = $this->painelbd->where($colunaResultadoMonografia,'monography',$joinMonografia, $whereMonografia, array('campo'=>'title','ordem'=>'ASC'))->result();
    
    $data = array(
      'titulo' => 'Gestão de monografias - Uniatenas',
      'conteudo' => 'paineladm/itens_iniciacao/tcc/publicacoes/monografias/lista_monografias',
      'dados' => array(
        'page'=> "Lista Monografias <u><i> $curso->name </i></u> <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'listaMonografias' => $listaMonografias,
        'curso' => $curso,
        'campus'=>$campus,
        'pagina'=>$pagina,
        'tipo' => 'tabelaDatatable')
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_monografia($uriCampus=NULL, $pageId=NULL, $idCurso = NULL) {
    $this->load->helper('file');
    
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunasCursosCampus = array(
      'courses.id','campus_has_courses.id as idCursoCampus','courses.name','courses.modalidade'
    );
    $joinCursosCampus = array(
      'courses'=>'courses.id = campus_has_courses.courses_id',
      'campus'=>'campus.id = campus_has_courses.campus_id',
    );
    $whereCursosCampus = array('campus_has_courses.id'=>$idCurso);

    $cursoCampus = $this->painelbd->where($colunasCursosCampus,'campus_has_courses',$joinCursosCampus,$whereCursosCampus)->row();

    $this->form_validation->set_rules('title', 'Título da monografia', 'required');
    $this->form_validation->set_rules('author', 'Autor do trabalho', 'required');
    $this->form_validation->set_rules('year', 'Ano', 'required');

    if (empty($_FILES['files']['name'])) {
        $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
        $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
    }

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()){
        setMsg(validation_errors(), 'error');
      }
    }else {
      $path = "assets/files/spic/monography/$campus->id/$cursoCampus->id";
      is_way($path);

      if (unique_name_args(noAccentuation($this->input->post('title').'-'.$this->input->post('year'), NULL), $path)) {
        $name_tmp = null;
      } else {
        $name_tmp = noAccentuation($this->input->post('title').'-'.$this->input->post('year'), NULL);
      }
      //$name_tmp = noAccentuation($this->input->post('title').'-'.$this->input->post('year').'-'.date('h:i:s d/m/Y'));
      $upload = $this->painelbd->uploadFiles('files', $path, $types = 'PDF|pdf', $name_tmp);

      if ($upload){
        //upload efetuado
        $dados_form = elements(array('title', 'year', 'author','status'), $this->input->post());
        $dados_form['campus_has_courses_id'] = $cursoCampus->idCursoCampus;      
        $dados_form['files'] = $path . '/' . $upload['file_name'];
        $dados_form['coursesid'] = $cursoCampus->id;      
        $dados_form['user_id'] = $this->session->userdata('codusuario');
        $dados_form['user_id'] = $this->session->userdata('codusuario');

        if ($this->painelbd->salvar('monography', $dados_form) == TRUE){
          setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
          redirect("Painel_pesquisa_tcc_monografias/lista_monografias/$campus->id/$pagina->id/$cursoCampus->idCursoCampus");
        }else{
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }   
    }
    $data = array(
      'titulo' => 'Gestão de monografias - Uniatenas',
      'conteudo' => 'paineladm/itens_iniciacao/tcc/publicacoes/monografias/cadastrar_monografia',
      'dados' => array(
        'page'=> "Cadastro de Monografia: Curso <u><i> $cursoCampus->name ($cursoCampus->modalidade)</i></u> <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'cursoCampus' => $cursoCampus,
        'campus'=>$campus,
        'pagina'=>$pagina,
        'tipo' => '')
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  
  public function editar_monografia($uriCampus = NULL, $pageId = NULL, $idItem = null) {
    $this->load->helper('file');
    
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunaResultadPagina = array('pages.id','pages.title','pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id'=>$pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina,'pages',$joinPagina, $wherePagina)->row();

    $colunaResultadoMonografia = array(
      'monography.id',
      'monography.campus_has_courses_id',
      'monography.coursesid',
      'monography.title',
      'monography.author',
      'monography.files',
      'monography.created_at',
      'monography.year',
      'monography.status',
      'monography.user_id',
    );
    $joinMonografia = array(
      'campus_has_courses'=>'campus_has_courses.id = monography.campus_has_courses_id',
    );
    $whereMonografia = array('monography.id'=>$idItem);
    $monografia = $this->painelbd->where($colunaResultadoMonografia,'monography',$joinMonografia, $whereMonografia)->row();
    
    $colunasCursosCampus = array(
      'courses.id','campus_has_courses.id as idCursoCampus','courses.name','courses.modalidade'
    );
    $joinCursosCampus = array(
      'courses'=>'courses.id = campus_has_courses.courses_id',
      'campus'=>'campus.id = campus_has_courses.campus_id',
    );
    $whereCursosCampus = array('campus_has_courses.id'=>$monografia->campus_has_courses_id);

    $cursoCampus = $this->painelbd->where($colunasCursosCampus,'campus_has_courses',$joinCursosCampus,$whereCursosCampus)->row();

    $this->form_validation->set_rules('title', 'Título da monografia', 'required');
    $this->form_validation->set_rules('author', 'Autor do trabalho', 'required');
    $this->form_validation->set_rules('year', 'Ano', 'required');

    // if (empty($_FILES['files']['name']) and ) {
    //     $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
    //     $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
    // }

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {

      if (isset($_FILES['files']) && !empty($_FILES['files']['name'])) {

        $verificaExistenciaArquivo= explode('.',$monografia->files );
        $finalArquivo =  end($verificaExistenciaArquivo);

        if($finalArquivo === 'pdf'){
          unlink($monografia->files);
        }
                
        $path = "assets/files/spic/monography/$campus->id/$monografia->campus_has_courses_id";
        is_way($path);
        
        $anoMonografia = $this->input->post('year');

        if (unique_name_args(noAccentuation($this->input->post('title').'-'.$anoMonografia, NULL), $path)) {
          $name_tmp = null;
        } else {
          $name_tmp = noAccentuation($this->input->post('title').'-'.$anoMonografia, NULL);
        }
        
        $upload = $this->painelbd->uploadFiles('files', $path, $types = 'PDF|pdf', $name_tmp);

        if ($upload){
          $dados_form['files'] = $path.'/'.$upload['file_name'];
        }
      }

      if ($monografia->title != $this->input->post('title')) {
        $dados_form['title'] = $this->input->post('title');
      }
      if ($monografia->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }
      if ($monografia->author != $this->input->post('author')) {
        $dados_form['author'] = $this->input->post('author');
      }
      if ($monografia->year != $this->input->post('year')) {
        $dados_form['year'] = $this->input->post('year');
      }
      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      $dados_form['id'] = $monografia->id;
      
      if ($this->painelbd->salvar('monography', $dados_form) == TRUE){
        setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
        redirect("Painel_pesquisa_tcc_monografias/lista_monografias/$campus->id/$pagina->id/$cursoCampus->idCursoCampus");
      }else{
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }
      
    $data = array(
      'titulo' => 'Gestão de monografias - Uniatenas',
      'conteudo' => 'paineladm/itens_iniciacao/tcc/publicacoes/monografias/editar_monografia',
      'dados' => array(
        // 'publicacoes' => '$dados',
        'page'=> "Edição dados monografia: Curso <u><i> $cursoCampus->name ($cursoCampus->modalidade)</i></u> <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus'=>$campus,
        'cursoCampus' => $cursoCampus,
        'monografia' => $monografia,
        'campus'=>$campus,
        'pagina'=>$pagina,
        'tipo' => ''
        )
    );
    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_monografia($uriCampus=NULL, $pagina=NULL, $idCurso = NULL, $id = null) {

    $item = $this->painelbd->where('*','monography', NULL, array('monography.id' => $id))->row();
 
    $arquivo = $item->files;

    if ($this->painelbd->deletar('monography', $item->id)) {
      unlink($item->files);
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_pesquisa_tcc_monografias/lista_monografias/$uriCampus/$pagina/$idCurso");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_pesquisa_tcc_monografias/lista_monografias/$uriCampus/$pagina/$idCurso");
    }
   
    
  }

}