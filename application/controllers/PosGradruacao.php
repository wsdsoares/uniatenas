<?php defined('BASEPATH') or exit('No direct script access allowed');

class PosGraduacao extends CI_Controller
{
  public function __construct()
  {
    header('Access-Control-Allow-Origin: *');
    parent::__construct();
    $this->load->model('Site_model', 'bancosite');
    // $this->load->model('Cpainel_model', 'Painelsite');
  }

  public function cursos($campus = NULL)
  {
    if ($campus == null) {
      redirect("");
    }
    $ColunasTabelaCampus = array('campus.name', 'campus.id', 'campus.city', 'campus.shurtName');
    $dataCampus = $this->bancosite->where($ColunasTabelaCampus, 'campus', NULL, array('shurtName' => $campus))->row();

    $sql = "SELECT 
                courses.id as id,
                courses.name as name, 
                courses.areas_id, 
                courses.status,
                courses.capa,
                courses.types,
                courses.icone,
                courses.imagem, 
                courses.links,
                courses.modalidade,
                campus.id as idCampus, 
                campus.name as nameCampus,
                campus.city, 
                courses_pages.link_vestibular
            FROM
                at_site.campus_has_courses
            inner join campus on campus.id = campus_has_courses.campus_id
            inner join courses on courses.id = campus_has_courses.courses_id
            INNER JOIN courses_pages on courses_pages.campus_has_courses_id = campus_has_courses.id
            
            where campus.id =" . $dataCampus->id . "
            and modalidade='presencial'
            order by courses.name";

    $cursos = $this->bancosite->getQuery($sql)->result();
    $campusCursos = array();
    count($cursos);
    for ($i = 0; $i < count($cursos); $i++) {
      $sqlCampus = '
                        SELECT
                            campus.id, 
                            campus.name,
                            campus.city,
                            campus_has_courses.id as idCourseCampus,
                            courses.id as courseId                            
                        FROM
                            at_site.campus
                        inner join campus_has_courses on campus_has_courses.campus_id = campus.id
                        inner join courses on courses.id = campus_has_courses.courses_id
                        INNER JOIN courses_pages on courses_pages.campus_has_courses_id = campus_has_courses.id
                        
                        WHERE courses.id =' . $cursos[$i]->id . " 
                        order by campus.city";

      $campusCursos[$i]['id'] = $cursos[$i]->id;
      $campusCursos[$i]['areas_id'] = $cursos[$i]->areas_id;
      $campusCursos[$i]['name'] = $cursos[$i]->name;
      $campusCursos[$i]['status'] = $cursos[$i]->status;
      $campusCursos[$i]['modalidade'] = $cursos[$i]->modalidade;
      $campusCursos[$i]['types'] = $cursos[$i]->types;
      $campusCursos[$i]['icone'] = $cursos[$i]->icone;
      $campusCursos[$i]['imagem'] = $cursos[$i]->imagem;
      $campusCursos[$i]['imagem'] = $cursos[$i]->imagem;
      $campusCursos[$i]['link_vestibular'] = $cursos[$i]->link_vestibular;
      $campusCursos[$i]['capa'] = $cursos[$i]->capa;
      $campusCursos[$i]['campus'] = $this->bancosite->getQuery($sqlCampus)->result();
    }


    $data = array(
      'head' => array(
        'title' => 'Graduação - UniAtenas',
        'css' => base_url('assets/css/css_course/style-course.css')
      ),
      'conteudo' => "uni_graduacao/principal",
      'js' => NULL,
      'footer' => array(
        //'specific_JS' => 'assets/plugins/lightbox/dist/js/lightbox-plus-jquery.js',
      ),

      'dados' => array(
        'cursos' => $cursos,
        'campus' => $dataCampus,
        'campusCursos' => $campusCursos
      )
    );
    $this->output->cache(14.400);
    $this->load->view('templates/master', $data);
  }
}
