<?php defined('BASEPATH') or exit('No direct script access allowed');

class Graduacao extends CI_Controller
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
        redirect('site');
    }

    public function como_ingressar($uricampus = NULL, $modalidadeIngresso = NULL)
    {

      if ($uricampus == null) {
          redirect("");
      }
      $dataCampus = $this->bancosite->where('*','campus',NULL, array('shurtName' => $uricampus))->row();

      $pages_content = $this->bancosite->where(array('pages.id','pages.title'),'pages', null,array('title' => 'comoingressar', 'campusid' => $dataCampus->id))->row();
      
      $colunaItenResultadPagina = array('page_contents.id','page_contents.title','page_contents.title_short');
      $wherePagina = array('campus.id'=>$dataCampus->id, 'page_contents.pages_id'=>$pages_content->id,'page_contents.status'=>1);
      $joinConteudoPagina = array('pages'=>'pages.id = page_contents.pages_id','campus' => 'campus.id= pages.campusid');
      $listaItensMenuComoIngressar = $this->bancosite->where($colunaItenResultadPagina,'page_contents',$joinConteudoPagina, $wherePagina,null)->result();
    
      $whereModalidadeIngresso = array('page_contents.title_short'=>$modalidadeIngresso,'pages_id' => $pages_content->id);
      $conteudoPrincipal = $this->bancosite->where("*",'page_contents',null,$whereModalidadeIngresso)->row();

      $data = array(
          'head' => array(
            'title' => 'Como Ingressar - ' . $dataCampus->name,
            'css' => base_url('assets/wizzard/css/styleWizzard.css')
          ),
          'conteudo' => "uni_graduacao/comoIngressar/formasIngresso",
          'js' => NULL,
          'footer' => array(//'specific_JS' => 'assets/plugins/lightbox/dist/js/lightbox-plus-jquery.js',
          ),

          'dados' => array(
            'campus' => $dataCampus,
            'conteudoPag' => $conteudoPrincipal,
            'menuComoIngressar'=> isset($listaItensMenuComoIngressar) ? $listaItensMenuComoIngressar : ''
          )
      );
      $this->output->cache(14.400);
      $this->load->view('templates/master', $data);
    }

    public function cursos($campus = NULL)
    {
        if ($campus == null) {
            redirect("");
        }
        $ColunasTabelaCampus = array('campus.name', 'campus.id','campus.city', 'campus.shurtName');
        $dataCampus = $this->bancosite->where($ColunasTabelaCampus,'campus', NULL,array('shurtName' => $campus))->row();


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
    campus.city
FROM
    at_site.campus_has_courses
inner join campus on campus.id = campus_has_courses.campus_id
inner join courses on courses.id = campus_has_courses.courses_id
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
                            courses.id as courseId,
                            courses_pages.link_vestibular
                            
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
            $campusCursos[$i]['links'] = $cursos[$i]->links;
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
            'footer' => array(//'specific_JS' => 'assets/plugins/lightbox/dist/js/lightbox-plus-jquery.js',
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

    public function presencial($uricampus, $idCourse = NULL)
    {
        if ($idCourse == NULL) {
            redirect('graduacao/cursos');
        }

        $dataCampus = $this->bancosite->getWhere('campus', array('shurtName' => $uricampus))->row();

        $query = "SELECT 
                    courses.id, 
                    courses.name, 
                    campus_has_courses.id as idCourseCampus,
                    
                    courses_pages.capa,
                    courses_pages.link_vestibular,
                   
                    courses_pages.description,
                    courses_pages.filesGrid,
                    courses_pages.matriz_visivel,
                    courses_pages.actuation,
                    courses_pages.autorization,
                    courses_pages.recognition
                FROM
                    at_site.courses_pages
                inner join campus_has_courses on campus_has_courses.id = courses_pages.campus_has_courses_id
                inner join courses on courses.id = campus_has_courses.courses_id 
                 
                where campus_has_courses.id=$idCourse";

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
                        where campus_has_courses.id = $idCourse";

        $queryPeriod = " SELECT 
                               period
                            FROM
                               at_site.courses_curricular_grid
                            inner join campus_has_courses on campus_has_courses.id =courses_curricular_grid.campus_has_courses_id
                            inner join courses on courses.id = campus_has_courses.courses_id
                            where campus_has_courses.id = $idCourse  
                            group by 1";


        $categoryPhotos = "
                       SELECT 
                                 photos_gallery.file as photoCategory,
                                photos_category.id as idCategory,
                                photos_category.title as titleCategory
                        FROM
                                at_site.course_photos_infrastructure
                        inner join campus_has_courses on campus_has_courses.id =course_photos_infrastructure.idCourseCampus
                        inner join courses on courses.id = campus_has_courses.courses_id
                        inner join photos_category on photos_category.id = course_photos_infrastructure.idphotosCategory
                        inner join photos_gallery on photos_gallery.photoscategoryid = photos_category.id 
                        where campus_has_courses.id = $idCourse
                        group by (photos_category.id)
                        order by photos_category.title";

        $queryCourseCampus = "SELECT 
                                   campus_has_courses.id as idCourseCampus,
                                    campus.id as idCampus,
                                    campus.name as nameCampus,
                                    campus.city as cityCampus,
                                    courses.name as nameCourse, 
                                    courses.id as idCourse,
                                    courses.icone,
                                    courses.capa
                                FROM
                                    at_site.campus_has_courses
                                INNER JOIN courses ON courses.id = campus_has_courses.courses_id
                                INNER JOIN campus ON campus.id = campus_has_courses.campus_id
                                WHERE
                                    campus_has_courses.id = $idCourse";

        $queryDirigentes = "SELECT courses_pages.id,
                    dirigentes.nome,
                    dirigentes.cargo,
                    dirigentes.email,
                    dirigentes.camsetorid
                     FROM courses_pages_has_dirigentes
                inner join dirigentes on dirigentes.id = courses_pages_has_dirigentes.dirigentesid
                inner join courses_pages on courses_pages.id = courses_pages_has_dirigentes.courses_pagesid
                 inner join campus_has_courses on campus_has_courses.id = courses_pages.campus_has_courses_id
                inner join courses on courses.id = campus_has_courses.courses_id 
               where campus_has_courses.id = $idCourse ";

        $colunasDirigentes = array(
          'dirigentes.nome','dirigentes.cargo','dirigentes.email','dirigentes.telefone','dirigentes.id_course_campus'
        );

       

        $pageCourse = $this->bancosite->getQuery($query)->row();
        $whereCoordenador = array('dirigentes.id_course_campus'=>$pageCourse->idCourseCampus);

        $coordenadorCurso = $this->bancosite->where($colunasDirigentes,'dirigentes',null,$whereCoordenador)->result();
        
        $courseCampus = $this->bancosite->getQuery($queryCourseCampus)->row();
        //$dirigetesCourse = $this->bancosite->getQuery($queryDirigentes)->result();
        $categoria = $this->bancosite->getQuery($categoryPhotos)->result();
        $curricularGrid = $this->bancosite->getQuery($queryGrid)->result();
        $coursePeriod = $this->bancosite->getQuery($queryPeriod)->result();


        $filedCont = array("contatos_setores.phone", "contatos_setores.ramal", "contatos_setores.visiblepage", "dirigentes.email", "contatos_setores.phonesetor");
        $tableCont = "campus_has_setores";
        $dataJoinCont = array("dirigentes" => "dirigentes.camsetorid = campus_has_setores.id",
            "contatos_setores" => "contatos_setores.setoresidcamp = campus_has_setores.id");

        if(!empty($dirigetesCourse)){
        $whereCont = array("campus_has_setores.id"=>$dirigetesCourse[0]->camsetorid,"contatos_setores.visiblepage" => 1);
        $contatos = $this->Painelsite->where($filedCont,$tableCont,$dataJoinCont,$whereCont)->row();
        }else{
        $contatos = "null";
        }

        $fotos = $this->bancosite->getWhere('courses_photos', array('idCourseCampus' => $pageCourse->idCourseCampus, 'status' => '1'), array('campo' => 'created_at', 'ordem' => 'desc'), 8)->result();

        if ($courseCampus->idCampus != 1) {
            $tema = "Você entre os melhores";
        } else {
            $tema = "Aqui Começa Uma Nova História";
        }
        
        $data = array(
            'head' => array(
                'title' => 'Graduação - UniAtenas',

                'css' => base_url('assets/css/css_course/style-course.css')
            ),
            'conteudo' => "uni_graduacao/courses/course",
            'js' => NULL,
            'footer' => array(//'specific_JS' => 'assets/plugins/lightbox/dist/js/lightbox-plus-jquery.js',
            ),

            'dados' => array(
                'dadosCurso' => array(
                    'curso' => $courseCampus,
                    'dirigentes' => $coordenadorCurso,
                    'informacoesCurso' => $pageCourse,
                    'gradeCurricular' => $curricularGrid,
                    'cursoPeriodos' => $coursePeriod,
                    'fotosCurso' => $fotos,
                    'contatos' => $contatos,
                    'categoriaFotos' => $categoria,
                    'tema' => $tema
                ),
                'campus' => $dataCampus
            )
        );
        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }

    public function galeria_fotos($uricampus = NULL, $idCourse = NULL, $idCategory = NULL)
    {
        if ($uricampus == null) {
            redirect("");
        }
        if ($uricampus == 'paracatu') {
            $city = "Paracatu";
        } elseif ($uricampus == 'passos') {
            $city = "Passos";
        } elseif ($uricampus == 'setelagoas') {
            $city = "Sete Lagoas";
        } elseif ($uricampus == 'valenca') {
            $city = "Valenca";
        }

        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $city))->row();

        $queryCourses = "SELECT 
                    courses.id, 
                    courses.name, 
                    campus_has_courses.id as idCourseCampus
                   
                FROM
                    at_site.courses_pages
                inner join campus_has_courses on campus_has_courses.id = courses_pages.campus_has_courses_id
                inner join courses on courses.id = campus_has_courses.courses_id 
                
                where campus_has_courses.id=$idCourse";

        $curso = $this->bancosite->getQuery($queryCourses)->row();

        $courses_infrastructure = " SELECT 
                                                campus_has_courses.id as idCourseCampus,
                                                photos_gallery.id as idPhoto,
                                                    photos_gallery.file,
                                                photos_gallery.title, 
                                                photos_category.id as idCategory,
                                                 photos_category.title as titleCategory
    
                                        FROM
                                                at_site.course_photos_infrastructure
                                        inner join campus_has_courses on campus_has_courses.id =course_photos_infrastructure.idCourseCampus
                                        inner join courses on courses.id = campus_has_courses.courses_id
                                        inner join photos_category on photos_category.id = course_photos_infrastructure.idphotosCategory
                                        inner join photos_gallery on photos_gallery.photoscategoryid = photos_category.id 
                                        where campus_has_courses.id = $idCourse
                                          and photos_category.id = $idCategory
                                        order by photos_category.title";

        $infrastructure = $this->bancosite->getQuery($courses_infrastructure)->result();
        $category = $this->bancosite->getWhere('photos_category', array('id' => $idCategory))->row();
        $data = array(
            'head' => array(
                'title' => 'Graduação - UniAtenas',
                'css' => base_url('assets/css/css_course/style-course.css')
            ),
            'conteudo' => "uni_graduacao/courses/courseGallery",

            'js' => NULL,
            'footer' => '',
            'dados' => array(
                'photosInfra' => $infrastructure,
                'cursos' => $curso,
                'cathegory' => $category,
                'campus' => $dataCampus
            )
        );
        $this->load->view('templates/master', $data);
    }

    public function galeria_fotos_curso($uricampus = NULL, $idCourseCampus = NULL)
    {
        if ($uricampus == null) {
            redirect("");
        }
        if ($uricampus == 'paracatu') {
            $city = "Paracatu";
        } elseif ($uricampus == 'passos') {
            $city = "Passos";
        } elseif ($uricampus == 'setelagoas') {
            $city = "Sete Lagoas";
        }
        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $city))->row();

        $queryCourses = "SELECT 
                    courses.id, 
                    courses.name, 
                    campus_has_courses.id as idCourseCampus
                   
                FROM
                    at_site.courses_pages
                inner join campus_has_courses on campus_has_courses.id = courses_pages.campus_has_courses_id
                inner join courses on courses.id = campus_has_courses.courses_id 
                where campus_has_courses.id=$idCourseCampus";

        $curso = $this->bancosite->getQuery($queryCourses)->row();

        $photos = $this->bancosite->getWhere('courses_photos', array('idCourseCampus' => $idCourseCampus, 'status' => '1'), array('campo' => 'created_at', 'ordem' => 'desc'))->result();


        $data = array(
            'head' => array(
                'title' => 'Graduação - UniAtenas',
                'css' => base_url('assets/css/css_course/style-course.css')
            ),
            'conteudo' => "uni_graduacao/courses/photos_course_geral",

            'js' => NULL,
            'footer' => '',
            'dados' => array(
                'cursos' => $curso,
                'photos' => $photos,
                'campus' => $dataCampus
            )
        );
        $this->load->view('templates/master', $data);
    }

    public function ead($uricampus = NULL)
    {
        if ($uricampus == null) {
            redirect("");
        }

        $colunasTabelaCampus = array('campus.name', 'campus.id','campus.city', 'campus.shurtName');
        $dataCampus = $this->bancosite->where($colunasTabelaCampus,'campus', NULL,array('shurtName' => $uricampus))->row();

        $queryCursos = "SELECT * FROM courses where modalidade = 'ead' and types = 'ead' order by areas_id, name";

        $cursos = $this->bancosite->getQuery($queryCursos)->result();
        $polosEad = $this->bancosite->getWhere('polos')->result();
         
        $colunasInformacoesCurso = array(
          'courses.id',
          'courses.name',
          'courses.areas_id',
          'courses_pages.capa',

          'courses_pages.link_vestibular',

          'campus_has_courses.id as id_campus_has_course'  
        );

        $joinInformacoesCursos = array(
          'campus_has_courses' => 'campus_has_courses.id = courses_pages.campus_has_courses_id',
          'campus'=> 'campus.id = campus_has_courses.campus_id',
          'courses' => 'courses.id = campus_has_courses.courses_id'
        );

        $whereInformacoesCurso = array(
          'modalidade'=>'ead',
          'campus.id'=>$dataCampus->id
        );
        
        $campusCursos = $this->bancosite->where($colunasInformacoesCurso,'courses_pages',$joinInformacoesCursos,$whereInformacoesCurso,array('campo' => 'courses.name', 'ordem' => 'asc'))->result();

        $data = array(
            'head' => array(
                'title' => 'Graduação - EAD UniAtenas',
                'css' => base_url('assets/css/css_course/style-course.css')
            ),
            'conteudo' => "uniatenas/graduacaoEad/ead",
            'js' => NULL,
            'footer' => '',
            'dados' => array(
                'campusCursos' => $campusCursos,
                'campus' => $dataCampus,
                'polos' => $polosEad
            )
        );
        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }

    public function eadUniatenas($uricampus = NULL, $idCourse = NULL)
    {
        if ($uricampus == null) {
            redirect("");
        }
        $colunasTabelaCampus = array('campus.name', 'campus.id','campus.city', 'campus.shurtName','campus.phone');
        $dataCampus = $this->bancosite->where($colunasTabelaCampus,'campus', NULL,array('shurtName' => $uricampus))->row();


        if ($idCourse == '') {
            redirect('graduacao/ead');
        }
        
        $colunasInformacoesCurso = array(
          'courses.id',
          'courses.name',
          
          'courses_pages.description',
          'courses_pages.actuation',
          'courses.duration',
          'courses_pages.capa',

          'courses_pages.link_vestibular',
          'courses_pages.filesGrid',
          'courses_pages.actuation',
          'courses_pages.autorization',
          'courses_pages.recognition',

          'campus_has_courses.id as id_campus_has_course'  
        );

        $joinInformacoesCurso = array(
          'campus_has_courses' => 'campus_has_courses.id = courses_pages.campus_has_courses_id',
          'campus'=> 'campus.id = campus_has_courses.campus_id',
          'courses' => 'courses.id = campus_has_courses.courses_id'
        );

        $whereInformacoesCurso = array(
          'modalidade'=>'ead',
          'courses.id' => $idCourse,
          'campus.id'=>$dataCampus->id
        );

        $informacoesCurso = $this->bancosite->where($colunasInformacoesCurso,'courses_pages',$joinInformacoesCurso,$whereInformacoesCurso)->row();


        $idCoursecampus = $this->bancosite->getwhere('campus_has_courses', array('courses_id' => $idCourse))->row();
        $idCourse = $idCoursecampus->id;
        
        
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
                        where campus_has_courses.id = $idCourse";

        $queryPeriod = " SELECT 
                               period
                            FROM
                               at_site.courses_curricular_grid
                            inner join campus_has_courses on campus_has_courses.id =courses_curricular_grid.campus_has_courses_id
                            inner join courses on courses.id = campus_has_courses.courses_id
                            where campus_has_courses.id = $idCourse  
                            group by 1";


        $colunasDirigentes = array(
            'dirigentes.nome','dirigentes.cargo','dirigentes.email','dirigentes.telefone','dirigentes.id_course_campus'
        );

        $whereCoordenador = array('dirigentes.id_course_campus'=>$informacoesCurso->id_campus_has_course);
        $coordenadorCurso = $this->bancosite->where($colunasDirigentes,'dirigentes',null,$whereCoordenador)->result();
        
        $colunasDadosCurso = array(
            'courses.name',
            'courses.id'
          );
  
        $curso = $this->bancosite->where($colunasDadosCurso,'courses', null,array('modalidade' => 'ead', 'types' => 'ead', 'id' => $idCourse))->row();
        
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
                // 'curso' => $curso,
                'campus' => $dataCampus,
                'informacoesCurso' => $informacoesCurso,
                'coordenadorCurso' => $coordenadorCurso,
                'gradeCurricular' => $curricularGrid,
                'cursoPeriodos' => $coursePeriod
            )
        );

        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }
}