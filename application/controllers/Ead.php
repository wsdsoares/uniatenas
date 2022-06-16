<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ead extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
        $this->load->model('Site_model', 'bancosite');
        $this->load->model('Cpainel_model', 'Painelsite');
    }

    public function index()
    {
        $this->graduacao();
    }

    public function graduacao()
    {

        $queryCursos = "SELECT * FROM courses where modalidade = 'ead' and types = 'ead' order by areas_id, name";
        $cursos = $this->bancosite->getQuery($queryCursos)->result();
        $city = "Paracatu";

        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $city))->row();
        $data = array(
            'head' => array(
                'title' => 'EAD - UniAtenas',
                'css' => base_url('assets/css/css_course/style-course.css')),
            'conteudo' => "uniatenas/graduacaoEad/ead",
            'js' => NULL,
            'footer' => array(),
            'dados' => array(
                'campus' => $dataCampus,
                'cursos' => $cursos,
            )
        );
        $this->load->view('templates/masterEad', $data);
    }

    public function  uniatenas($idCourse = NULL){

            $city = "Paracatu";
        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $city))->row();

        if ($idCourse == '') {
            redirect('ead/graduacao');
        }
        $querySql = "SELECT 
	                    courses_pages.description,
                        courses_pages.actuation,
                        courses.duration
                            FROM courses_pages
                            INNER JOIN campus_has_courses ON campus_has_courses.id = courses_pages.campus_has_courses_id
                            INNER JOIN campus ON campus.id = campus_has_courses.campus_id
                            INNER JOIN courses On courses.id = campus_has_courses.courses_id
                                where modalidade='ead' 
                                and courses.id = $idCourse
                                and campus.id=$dataCampus->id ";
        $idCoursecampus = $this->bancosite->getwhere('campus_has_courses', array('courses_id' => $idCourse))->row();
        $idCoursecampus = $idCoursecampus->id;
        $query = "SELECT 
                    courses.id, 
                    courses.name, 
                    campus_has_courses.id as idCourseCampus,
                    courses_pages.video,
                    dirigentes.nome,
                    dirigentes.email,
                    courses_pages.description,
                    courses_pages.filesGrid,
                    courses_pages.actuation,
                    courses_pages.autorization,
                    courses_pages.recognition
                /*FROM
                    at_site.courses_pages
                inner join campus_has_courses on campus_has_courses.id = courses_pages.campus_has_courses_id
                inner join courses on courses.id = campus_has_courses.courses_id */
                FROM
                    at_site.courses_pages
                        INNER JOIN campus_has_courses ON campus_has_courses.id = courses_pages.campus_has_courses_id
                        INNER JOIN courses ON courses.id = campus_has_courses.courses_id
                        inner join courses_pages_has_dirigentes on courses_pages_has_dirigentes.courses_pagesid = courses_pages.id
                        inner join dirigentes on dirigentes.id = courses_pages_has_dirigentes.dirigentesid
                
                where campus_has_courses.id=$idCoursecampus";
        $queryGrid = "SELECT 
                           courses_curricular_grid.id, 
                           courses_curricular_grid.discipline,
                           courses_curricular_grid.period,
                           courses_curricular_grid.type, 
                           courses.name
                        FROM
                            at_site.courses_curricular_grid
                        inner join campus_has_courses on campus_has_courses.id =courses_curricular_grid.campus_has_courses_id
                        inner join courses on courses.id = campus_has_courses.courses_id
                        where campus_has_courses.id = $idCoursecampus";

        $queryPeriod = " SELECT 
                               period
                            FROM
                               at_site.courses_curricular_grid
                            inner join campus_has_courses on campus_has_courses.id =courses_curricular_grid.campus_has_courses_id
                            inner join courses on courses.id = campus_has_courses.courses_id
                            where campus_has_courses.id = $idCoursecampus  
                            group by 1";

        $queryDirigentes = "SELECT courses_pages.id,
                    dirigentes.nome,
                    dirigentes.cargo,
                    dirigentes.email
                     FROM courses_pages_has_dirigentes
                inner join dirigentes on dirigentes.id = courses_pages_has_dirigentes.dirigentesid
                inner join courses_pages on courses_pages.id = courses_pages_has_dirigentes.courses_pagesid
                 inner join campus_has_courses on campus_has_courses.id = courses_pages.campus_has_courses_id
                inner join courses on courses.id = campus_has_courses.courses_id 
               where campus_has_courses.id = $idCoursecampus ";


        $dirigetesCourse = $this->bancosite->getQuery($queryDirigentes)->result();


        $contends = $this->bancosite->getQuery($querySql)->row();

        $cursos = $this->bancosite->getWhere('courses', array('modalidade' => 'ead', 'types' => 'ead', 'id' => $idCourse))->row();
        $pageCourse = $this->bancosite->getQuery($query)->row();
        $coursePeriod = $this->bancosite->getQuery($queryPeriod)->result();
        $curricularGrid = $this->bancosite->getQuery($queryGrid)->result();
        //Logica da divição da area de atuação
        //$countAtu = substr_count($contends->actuation,'<p>');//aqui estou contato quantas tag <p> aparece, para saber quantas areas de atuação tem
        //$lista = preg_split("/(<[^>]*[^\/]>)/i", $conteudoPag->actuation);//aqui transforma o texto em uma matrix, sendo que na view sera passado até seis areas por coluna.
        $data = array(
            'head' => array(
                'title' => 'Graduação - EAD UniAtenas',
                'css' => base_url('assets/css/css_course/style-course.css')
            ),
            'conteudo' => "uniatenas/graduacaoEad/eadUniatenas",
            'js' => NULL,
            'footer' => '',

            'dados' => array(
                'curso' => $cursos,
                'campus' => $dataCampus,
                'conteudoPag' => $contends,
                'dirigentes' => $dirigetesCourse,
                'informacoesCurso' => $pageCourse,
                'gradeCurricular' => $curricularGrid,
                'cursoPeriodos' => $coursePeriod
            )
        );
        $this->load->view('templates/masterEad', $data);
    }
}
