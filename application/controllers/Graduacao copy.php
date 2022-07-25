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

    public function como_ingressar($uricampus = NULL, $type = NULL)
    {

        if ($uricampus == null) {
            redirect("");
        }
        $dataCampus = $this->bancosite->where('*','campus',NULL, array('shurtName' => $uricampus))->row();

        $pages_content = $this->bancosite->where(array('pages.idpages','pages.title'),'pages', null,array('title' => 'comoingressar', 'campusid' => $dataCampus->id))->row();
        
        // $pages_content = $this->bancosite->getWhere('pages', array('title' => 'comoingressar', 'campusid' => $dataCampus->id))->row();

        $joinConteudoPagina = array(
            'pages'=>'pages.idpages = page_contents.pages_id',
            'campus' => 'campus.id= pages.campusid'
            
        );

        $colunaResultadPagina = array(
            'page_contents.id',
            'page_contents.title',
            'page_contents.title_short',
        );

        $wherePagina = array(
            'campus.id'=>$dataCampus->id, 
            'page_contents.pages_id'=>$pages_content->idpages,
            'page_contents.status'=>1);
        
        $listaItensMenuComoIngressar = $this->bancosite->where($colunaResultadPagina,'page_contents',$joinConteudoPagina, $wherePagina,null)->result();

        // echo '<pre>';
        // echo '<br>';
        // echo '<br>';
        // echo '<br>';
        // echo '<br>';
        // echo '<br>';
        // echo '<br>';
        // print_r($pages_content);
        //print_r($listaItensMenuComoIngressar);
        
        echo '</pre>';
        if ($type == 'vestibulartradicional') {
            $vestibular = "Vestibular Tradicional";
        } elseif ($type == 'vestibularagendado') {
            $vestibular = "Agendado";
        } elseif ($type == 'notaenem') {
            $vestibular = "ENEM";
        } elseif ($type == 'segundagraduacao') {
            $vestibular = "SEGUNDA";
        } elseif ($type == 'transferencia') {
            $vestibular = "TRANSF";
        } elseif ($type == 'reingresso') {
            $vestibular = "REING";
        } elseif ($type == 'reopcaodecurso') {
            $vestibular = "REOPC";
        }

        $queryHowToJoin = "SELECT 
            *
        FROM
            page_contents
        where page_contents.title like '%$vestibular%'
        and pages_id =  $pages_content->idpages
        ";

        $conteudoPrincipal = $this->bancosite->getQuery($queryHowToJoin)->row();

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

    // public function como_ingressar($uricampus = NULL, $type = NULL)
    // {

    //     if ($uricampus == null) {
    //         redirect("");
    //     }
    //     $dataCampus = $this->bancosite->where('*','campus',NULL, array('shurtName' => $uricampus))->row();
        
    //     $pages_content = $this->bancosite->getWhere('pages', array('title' => 'comoingressar', 'campusid' => $dataCampus->id))->row();

    //     if ($type == 'vestibulartradicional') {
    //         $vestibular = "Vestibular Tradicional";
    //     } elseif ($type == 'vestibularagendado') {
    //         $vestibular = "Agendado";
    //     } elseif ($type == 'notaenem') {
    //         $vestibular = "ENEM";
    //     } elseif ($type == 'segundagraduacao') {
    //         $vestibular = "SEGUNDA";
    //     } elseif ($type == 'transferencia') {
    //         $vestibular = "TRANSF";
    //     } elseif ($type == 'reingresso') {
    //         $vestibular = "REING";
    //     } elseif ($type == 'reopcaodecurso') {
    //         $vestibular = "REOPC";
    //     }

    //     $queryHowToJoin = "SELECT 
    //         *
    //     FROM
    //         page_contents
    //     where page_contents.title like '%$vestibular%'
    //     and pages_id =  $pages_content->idpages
    //     ";

    //     $conteudoPrincipal = $this->bancosite->getQuery($queryHowToJoin)->row();

    //     $data = array(
    //         'head' => array(
    //             'title' => 'Como Ingressar - ' . $dataCampus->name,
    //             'css' => base_url('assets/wizzard/css/styleWizzard.css')
    //         ),
    //         'conteudo' => "uni_graduacao/comoIngressar/formasIngresso",
    //         'js' => NULL,
    //         'footer' => array(//'specific_JS' => 'assets/plugins/lightbox/dist/js/lightbox-plus-jquery.js',
    //         ),

    //         'dados' => array(
    //             'campus' => $dataCampus,
    //             'conteudoPag' => $conteudoPrincipal,
    //         )
    //     );
    //     $this->output->cache(14.400);
    //     $this->load->view('templates/master', $data);
    // }

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


        $courseCampus = $this->bancosite->getQuery($queryCourseCampus)->row();
        $dirigetesCourse = $this->bancosite->getQuery($queryDirigentes)->result();
        $pageCourse = $this->bancosite->getQuery($query)->row();
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
                    'dirigentes' => $dirigetesCourse,
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

        $data = array(
            'head' => array(
                'title' => 'Graduação - EAD UniAtenas',
                'css' => base_url('assets/css/css_course/style-course.css')
            ),
            'conteudo' => "uniatenas/graduacaoEad/ead",
            'js' => NULL,
            'footer' => '',
            'dados' => array(
                'cursos' => $cursos,
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
                          and campus.id=$dataCampus->id";

        $idCoursecampus = $this->bancosite->getwhere('campus_has_courses', array('courses_id' => $idCourse))->row();
        $idCoursecampus = $idCoursecampus->id;
        $queryInformacoesCurso = 
          "SELECT 
                    courses.id, 
                    courses.name, 
                    campus_has_courses.id as idCourseCampus,
                    courses_pages.capa,
                    dirigentes.nome,
                    dirigentes.email,
                    courses_pages.description,
                    courses_pages.link_vestibular,
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
        
        $informacoesCurso = $this->bancosite->getQuery($queryInformacoesCurso)->row();

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
                //'informacoesCurso' => $informacoesCurso,
                'gradeCurricular' => $curricularGrid,
                'cursoPeriodos' => $coursePeriod
            )
        );

        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }

   /* public function inscricao($campus = NULL, $courseId = NULL)
    {

        $this->form_validation->set_rules('user', 'Nome', 'required|ucfirst');
        $this->form_validation->set_rules('emailUser', 'E-mail', 'valid_email|required');
        $this->form_validation->set_rules('phone', 'Telefone', 'required');


        if ($this->input->post('courses_id') == '0') {
            $this->form_validation->set_rules('courses_id', 'Curso', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar ao menos um curso.');
        } else {
            $this->form_validation->set_rules('courses_id', 'Curso');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if ($this->input->post('description') != '') {
                $outhersInformation = $this->input->post('description');
            } else {
                $outhersInformation = '';
            }

            $data = elements(array('user', 'emailUser', 'phone', 'courses_id'), $this->input->post());
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');

            $date = date('Y-m-d H:i:s');

            $data['description'] = $outhersInformation;

            $courseGraduation = "
                select 
                    courses.id as idCourse,
                    courses.name as nameCourse,
                    campus.name as nameCampus,
                    campus.city as cityCampus
                    from courses
                    inner join campus_has_courses on campus_has_courses.courses_id = courses.id
                    inner join campus on campus.id = campus_has_courses.campus_id
                    where courses.name like '%" . $this->input->post('courses_id') . "%'
            ";

            $courseRegistration = $this->bancosite->getQuery($courseGraduation)->row();

            $data['courses_id'] = $courseRegistration->idCourse;
            $data['type'] = 'PRESENCIAL';

            $mensagem = "<p>O(A) candidato(a) " .
                "<b>" . $data['user'] . "</b> fez conato pelo site, interessado em matricular em um de nossos cursos" . "<br/>" .
                "Email: " . $data['emailUser'] . "<br/>" .
                "Celular: " . $data['phone'] . "<br/>" .

                "Curso: " . $courseRegistration->nameCourse . "<br/>" . "<br/>" .
                "O contato foi realizado no dia " . date('d/m/Y H:i:s', strtotime($date));

            $messageUser = "
            <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
                'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html style='width:100%;font-family:arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;'>
<head>
    <meta charset='UTF-8'>
    <meta content='width=device-width, initial-scale=1' name='viewport'>
    <meta name='x-apple-disable-message-reformatting'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta content='telephone=no' name='format-detection'>
    <title>UniAtenas - Inscrição</title>

    <style type='text/css'>
                @media only screen and (max-width: 600px) {
                p, ul li, ol li, a {
                    font-size: 16px !important;
                line-height: 150% !important
            }

            h1 {
                    font-size: 30px !important;
                text-align: center;
                line-height: 120% !important
            }

            h2 {
                    font-size: 26px !important;
                text-align: center;
                line-height: 120% !important
            }

            h3 {
                    font-size: 20px !important;
                text-align: center;
                line-height: 120% !important
            }

            h1 a {
                    font-size: 30px !important
            }

            h2 a {
                    font-size: 26px !important
            }

            h3 a {
                    font-size: 20px !important
            }

            .es-menu td a {
                    font-size: 16px !important
            }

            .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a {
                    font-size: 16px !important
            }

            .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a {
                    font-size: 16px !important
            }

            .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a {
                    font-size: 12px !important
            }

            *[class='gmail-fix'] {
                    display: none !important
            }

            .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 {
                    text-align: center !important
            }

            .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 {
                    text-align: right !important
            }

            .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 {
                    text-align: left !important
            }

            .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img {
                    display: inline !important
            }

            .es-button-border {
                    display: block !important
            }

            a.es-button {
                    font-size: 20px !important;
                display: block !important;
                border-width: 10px 0px 10px 0px !important
            }

            .es-btn-fw {
                    border-width: 10px 0px !important;
                text-align: center !important
            }

            .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right {
                    width: 100% !important
            }

            .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header {
                    width: 100% !important;
                    max-width: 600px !important
            }

            .es-adapt-td {
                    display: block !important;
                width: 100% !important
            }

            .adapt-img {
                    width: 100% !important;
                    height: auto !important
            }

            .es-m-p0 {
                    padding: 0px !important
            }

            .es-m-p0r {
                    padding-right: 0px !important
            }

            .es-m-p0l {
                    padding-left: 0px !important
            }

            .es-m-p0t {
                    padding-top: 0px !important
            }

            .es-m-p0b {
                    padding-bottom: 0 !important
            }

            .es-m-p20b {
                    padding-bottom: 20px !important
            }

            .es-mobile-hidden, .es-hidden {
                    display: none !important
            }

            .es-desk-hidden {
                    display: table-row !important;
                width: auto !important;
                overflow: visible !important;
                float: none !important;
                max-height: inherit !important;
                line-height: inherit !important
            }

            .es-desk-menu-hidden {
                    display: table-cell !important
            }

            table.es-table-not-adapt, .esd-block-html table {
                    width: auto !important
            }

            table.es-social {
                    display: inline-block !important
            }

            table.es-social td {
                    display: inline-block !important
            }
        }

        #outlook a {
            padding: 0;
        }

        .ExternalClass {
        width: 100%;
    }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
        line-height: 100%;
        }

        .es-button {
        mso-style-priority: 100 !important;
            text-decoration: none !important;
        }

        a[x-apple-data-detectors] {
        color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        .es-desk-hidden {
        display: none;
        float: left;
        overflow: hidden;
        width: 0;
        max-height: 0;
            line-height: 0;
            mso-hide: all;
        }
    </style>
</head>
<body style='width:100%;font-family:arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;'>
<div class='es-wrapper-color' style='background-color:#F6F6F6;'>
    
    <table class='es-wrapper' width='100%' cellspacing='0' cellpadding='0'
           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;'>
        <tr style='border-collapse:collapse;'>
            <td valign='top' style='padding:0;Margin:0;'>
                <table class='es-content' cellspacing='0' cellpadding='0' align='center'
                       style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                    <tr style='border-collapse:collapse;'>
                        <td align='center' style='padding:0;Margin:0;'>
                            <table class='es-content-body'
                                   style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;'
                                   width='600' cellspacing='0' cellpadding='0' align='center'>
                                <tr style='border-collapse:collapse;'>
                                    <td align='left'
                                        style='Margin:0;padding-top:15px;padding-bottom:15px;padding-left:20px;padding-right:20px;'>
                                        <!--[if mso]>
                                        <table width='560' cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td width='270' valign='top'><![endif]-->
                                        <table class='es-left' cellspacing='0' cellpadding='0' align='left'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='270' align='left' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>

                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                       
                                        <table class='es-right' cellspacing='0' cellpadding='0' align='right'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='270' align='left' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>

                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class='es-content' cellspacing='0' cellpadding='0' align='center'
                       style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                    <tr style='border-collapse:collapse;'>
                        <td align='center' style='padding:0;Margin:0;'>
                            <table class='es-content-body'
                                   style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#9AAEA6;'
                                   width='600' cellspacing='0' cellpadding='0' bgcolor='#9aaea6' align='center'>
                                <tr style='border-collapse:collapse;'>
                                    <td align='left' style='padding:0;Margin:0;'>
                                        <table width='100%' cellspacing='0' cellpadding='0'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td style='padding:0;Margin:0;position:relative;'
                                                                align='center'><a target='_blank'
                                                                                  href='http://www.atenas.edu.br/uniatenas'
                                                                                  style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#9AAEA6;'><img
                                                                    class='adapt-img'
                                                                    src='http://www.atenas.edu.br/uniatenas/assets/images/logoUniatenas.png' width='100%' 
                                                                    style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;'></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class='es-content' cellspacing='0' cellpadding='0' align='center'
                       style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                    <tr style='border-collapse:collapse;'>
                        <td align='center' style='padding:0;Margin:0;'>
                            <table class='es-content-body' width='600' cellspacing='0' cellpadding='0' bgcolor='#ffffff'
                                   align='center'
                                   style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;'>
                                <tr style='border-collapse:collapse;'>
                                    <td align='left'
                                        style='Margin:0;padding-bottom:10px;padding-top:30px;padding-left:40px;padding-right:40px;'>
                                        <table width='100%' cellspacing='0' cellpadding='0'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='520' valign='top' align='center' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td align='left' style='padding:0;Margin:0;'><h3
                                                                    style='Margin:0;line-height:20px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666;'>
    Parabéns, você está bem mais próximo de fazer um
                                                                curso superior.<br><br>Você realizou sua inscrição com
                                                                as seguintes informações:<br><br></h3>
                                                                <h3 style='Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666;'>
    Nome:" . $data['user'] . "</h3>
                                                                <h3 style='Margin:0;line-height:20px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666;'>
    Email:" . $data['emailUser'] . "<br></h3>
                                                                <h3 style='Margin:0;line-height:20px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666;'>
    Telefone:" . $data['phone'] . "<br></h3>
                                                                <h3 style='Margin:0;line-height:20px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666;'>
                                                                    <br></h3>
                                                                <h3 style='Margin:0;line-height:20px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666;'>
    Para o curso de " . $courseRegistration->nameCourse . ". O contato foi realizado no dia " . date('d/m/Y H:i:s', strtotime($date)) . "<br><br></h3></td>
          
                                                        </tr>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td align='center'
                                                                style='padding:0;Margin:0;padding-top:15px;padding-bottom:15px;'>
                                                                <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#999999;'>
                                                                    <span style='font-size:16px;'><i>Em breve um colaborador de nossa equipe entrará em contato com você, para que possamos agendar a data e hora do seu vestibular.<br><br>Agradecemos a confiança.</i></span><br>
                                                                </p></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class='es-content' cellspacing='0' cellpadding='0' align='center'
                       style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                    <tr style='border-collapse:collapse;'></tr>
                    <tr style='border-collapse:collapse;'>
                        <td align='center' style='padding:0;Margin:0;'>
                            <table class='es-footer-body'
                                   style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#9AAEA6;'
                                   width='600' cellspacing='0' cellpadding='0' bgcolor='#9aaea6' align='center'>
                                <tr style='border-collapse:collapse;'>
                                    <td align='left' style='padding:20px;Margin:0;'>
                                        <!--[if mso]>
                                        <table width='560' cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td width='270' valign='top'><![endif]-->
                                        <table class='es-left' cellspacing='0' cellpadding='0' align='left'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td class='es-m-p20b' width='270' align='left'
                                                    style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td class='es-m-txt-с' align='center'
                                                                style='padding:0;Margin:0;padding-bottom:10px;'><h3
                                                                    style='Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#FFFFFF;'>
    Siga-nos</h3></td>
                                                        </tr>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td align='center' style='padding:0;Margin:0;'>
                                                                <table class='es-table-not-adapt es-social'
                                                                       cellspacing='0' cellpadding='0'
                                                                       style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                                    <tr style='border-collapse:collapse;'>
                                                                        <td valign='top' align='center'
                                                                            style='padding:0;Margin:0;padding-right:10px;'>
                                                                            <a href='https://www.facebook.com/uniatenasoficial'
                                                                               style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666;'><img
                                                                                    title='Facebook'
                                                                                    src='http://www.atenas.edu.br/uniatenas/assets/images/aprincipal/images/email-facebook.png'
                                                                                    alt='Fb' width='32' height='32'
                                                                                    style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;'></a>
                                                                        </td>
                                                                        <td valign='top' align='center'
                                                                            style='padding:0;Margin:0;padding-right:10px;'>
                                                                            <a href='https://www.youtube.com/user/tvatenas'
                                                                               style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666;'><img
                                                                                    title='Youtube'
                                                                                    src='http://www.atenas.edu.br/uniatenas/assets/images/aprincipal/images/email-youtube.png'
                                                                                    alt='Yt' width='32' height='32'
                                                                                    style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;'></a>
                                                                        </td>
                                                                        <td valign='top' align='center'
                                                                            style='padding:0;Margin:0;'>
                                                                            <a href='instagram.com/uniatenasoficial/'
                                                                                style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666;'>
                                                                                
                                                                                <img
                                                                                title='Linkedin'
                                                                                src='http://www.atenas.edu.br/uniatenas/assets/images/aprincipal/images/email-instagram.png'
                                                                                alt='In' width='32' height='32'
                                                                                style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;'>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width='20'></td>
                                    <td width='270' valign='top'><![endif]-->
                                        <table class='es-right' cellspacing='0' cellpadding='0' align='right'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='270' align='left' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                        <tr style='border-collapse:collapse;'>
                                                            
                                                        </tr>
                                                        <tr style='border-collapse:collapse;'>
                                                          
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!--[if mso]></td></tr></table><![endif]--></td>
                                </tr>
                                <tr style='border-collapse:collapse;'>
                                    <td style='padding:0;Margin:0;background-color:#FFFFFF;' bgcolor='#ffffff'
                                        align='left'>
                                        <table width='100%' cellspacing='0' cellpadding='0'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td class='es-m-txt-с' esdev-links-color='#666666'
                                                                align='center'
                                                                style='padding:0;Margin:0;padding-top:10px;padding-bottom:20px;'>
                                                                <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;color:#666666;'>
                                                                    <br></p><font color='#666666'><span
                                                                    style='font-size:12px;'>Para ter acesso a mais informações acesse o nosso site:<br>www.uniatenas.edu.br</span></font><br>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class='es-content' cellspacing='0' cellpadding='0' align='center'
                       style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                    <tr style='border-collapse:collapse;'>
                        <td align='center' style='padding:0;Margin:0;'>
                            <table class='es-content-body'
                                   style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;'
                                   width='600' cellspacing='0' cellpadding='0' align='center'>
                                <tr style='border-collapse:collapse;'>
                                    <td align='left'
                                        style='Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;'>
                                        <table width='100%' cellspacing='0' cellpadding='0'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='560' valign='top' align='center' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td class='es-infoblock' align='center'
                                                                style='padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC;'>
                                                                <a target='_blank'
                                                                   href='http://www.uniatenas.edu.br'
                                                                   style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#CCCCCC;'><img src='http://localhost/uniatenas/assets/images/logoUniatenas.png'
                                                                        alt width='125'
                                                                        style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;'></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
    ";

            $this->load->library('email');

            //Inicia o processo de configuração para o envio do email
            $config['protocol'] = 'mail'; // define o protocolo utilizado
            $config['wordwrap'] = TRUE; // define se haverá quebra de palavra no texto
            $config['validate'] = TRUE; // define se haverá validação dos endereços de email
            $config['mailtype'] = 'html';
            $config['newline'] = '\r\n';
            $config['charset'] = 'utf-8';

            //$email = 'ponire@8i7.net';
            $email = 'copeve@atenas.edu.br';
            $this->email->initialize($config);

            $assunto = 'Insrição Processo Seletivo - Site NOVO';
            $this->email->from('copeve@atenas.edu.br', 'Contato Site - UniAtenas'); //quem mandou
            $this->email->to($email); // Destinatário
            //$this->email->cc('comuni@atenas.edu.br');
            //$this->email->bcc('comunicacao@atenas.edu.br');
            $this->email->cc($data['emailUser']);
            $this->email->subject($assunto);
            $this->email->message($mensagem);
            $this->email->message($messageUser);

            if ($this->email->send()) {
                $this->bancosite->salvar('course_registration', $data);
                setMsg('<p>Pré-Inscrição Realizada com sucesso. Qualquer dúvida, entre em contato por um de nossos canais de atendimento. <br> 
Enviamos um email, em sua caixa postal, com as informações a respeito de sua inscrição.</p>', 'success');

                echo "<script>alert('Email enviado com sucesso!');location.href='" . base_url() . "graduacao/inscricao/$campus;</script>";
                //echo "<script>alert('Email enviado com sucesso!');</script>";
            } else {
                setMsg('<p>Erro! Infelismente, houve um erro. Você pode tentar novamente mais tarde, ou nos enviar uma mensagem pelo nosso Whatsapp (38)9.9805-9502 </p>', 'error');
                //echo "<script>alert('Algto de errado não está certo.!');</script>";
                echo "<script>alert('Algto de errado não está certo.!');location.href='" . base_url() . "graduacao/inscricao/$campus';</script>";
            }
        }

        $cursos = $this->bancosite->getWhere('courses', array('modalidade' => "presencial"), array('campo' => 'name', 'ordem' => 'ASC'))->result();

        if ($courseId != NULL) {
            $courseEspecific = $this->bancosite->getWhere('courses', array('modalidade' => "presencial", 'id' => $courseId))->row();
        } else {
            $courseEspecific = '';
        }

        $data = array(
            'head' => array(
                'title' => 'Inscrição Processo Seletivo Presencial - UniAtenas',
                'css' => base_url('assets/wizzard/css/styleWizzard.css')
            ),

            'js' => NULL,
            'footer' => array(//'specific_JS' => 'assets/plugins/lightbox/dist/js/lightbox-plus-jquery.js',
            ),

            'dados' => array(
                'cursos' => $cursos,
                'campus' => $campus,
                'courseEspecific' => $courseEspecific
            )
        );

        $this->load->view('templates/masterRegistration', $data);
    }*/


    /*public function inscricaoEad($campus = NULL, $courseId = NULL)
    {

        if ($campus == 'paracatu') {
            $city = "Paracatu";
        } elseif ($campus == 'passos') {
            $city = "Passos";
        } elseif ($campus == 'setelagoas') {
            $city = "Sete Lagoas";
        }
        $this->form_validation->set_rules('user', 'Nome', 'required|ucfirst');
        $this->form_validation->set_rules('emailUser', 'E-mail', 'valid_email|required');
        $this->form_validation->set_rules('phone', 'Telefone', 'required');

        if ($this->input->post('courses_id') == '0') {
            $this->form_validation->set_rules('courses_id', 'Curso', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar ao menos um curso.');
        } else {
            $this->form_validation->set_rules('courses_id', 'Curso');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if ($this->input->post('description') != '') {
                $outhersInformation = $this->input->post('description');
            } else {
                $outhersInformation = '';
            }

            $data = elements(array('user', 'emailUser', 'phone', 'courses_id'), $this->input->post());

            $localPolo = $this->input->post('polo_id');
            $fielsBD = array('polos_has_campus.id as poloCampusId',
                'campus.name as campusName',
                'campus.id as idCampus',
                'polos.email',
                'polos.id as idPolo',
                'polos.city',
                'polos.responsible',
                'polos.email as emailPolo');
            $dataJoinPolo = array('polos_has_campus' => 'polos_has_campus.poloscampusid=polos.id', 'campus' => 'campus.id = polos_has_campus.campusid');
            $wherePolo = array('polos.city' => $localPolo);

            $poloEspecifico = $this->Painelsite->where($fielsBD, 'polos', $dataJoinPolo, $wherePolo)->row();

            setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');

            $date = date('Y-m-d H:i:s');

            $data['description'] = $outhersInformation;

            $courseGraduation = "
                select 
                    courses.id as idCourse,
                    courses.name as nameCourse,
                    campus.name as nameCampus,
                    campus.city as cityCampus
                    from courses
                    inner join campus_has_courses on campus_has_courses.courses_id = courses.id
                    inner join campus on campus.id = campus_has_courses.campus_id
                    where courses.name like '%" . $this->input->post('courses_id') . "%'
            ";

            $courseRegistration = $this->bancosite->getQuery($courseGraduation)->row();

            $data['courses_id'] = $courseRegistration->idCourse;
            $data['type'] = 'EAD';

            $mensagemPolo = "<p>O(A) candidato(a) " .
                "<b>" . $data['user'] . "</b> fez conato pelo site, interessado em matricular em um de nossos cursos" . "<br/>" .
                "Email: " . $data['emailUser'] . "<br/>" .
                "Celular: " . $data['phone'] . "<br/>" .

                "Curso: " . $courseRegistration->nameCourse . "<br/>" .
                "Polo: " . $poloEspecifico->city . "<br/>" .
                "O contato foi realizado no dia " . date('d/m/Y H:i:s', strtotime($date));

            $messageUser = "
            <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
                'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html style='width:100%;font-family:arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;'>
<head>
    <meta charset='UTF-8'>
    <meta content='width=device-width, initial-scale=1' name='viewport'>
    <meta name='x-apple-disable-message-reformatting'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta content='telephone=no' name='format-detection'>
    <title>UniAtenas - Inscrição</title>

    <style type='text/css'>
                @media only screen and (max-width: 600px) {
                p, ul li, ol li, a {
                    font-size: 16px !important;
                line-height: 150% !important
            }

            h1 {
                    font-size: 30px !important;
                text-align: center;
                line-height: 120% !important
            }

            h2 {
                    font-size: 26px !important;
                text-align: center;
                line-height: 120% !important
            }

            h3 {
                    font-size: 20px !important;
                text-align: center;
                line-height: 120% !important
            }

            h1 a {
                    font-size: 30px !important
            }

            h2 a {
                    font-size: 26px !important
            }

            h3 a {
                    font-size: 20px !important
            }

            .es-menu td a {
                    font-size: 16px !important
            }

            .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a {
                    font-size: 16px !important
            }

            .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a {
                    font-size: 16px !important
            }

            .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a {
                    font-size: 12px !important
            }

            *[class='gmail-fix'] {
                    display: none !important
            }

            .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 {
                    text-align: center !important
            }

            .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 {
                    text-align: right !important
            }

            .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 {
                    text-align: left !important
            }

            .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img {
                    display: inline !important
            }

            .es-button-border {
                    display: block !important
            }

            a.es-button {
                    font-size: 20px !important;
                display: block !important;
                border-width: 10px 0px 10px 0px !important
            }

            .es-btn-fw {
                    border-width: 10px 0px !important;
                text-align: center !important
            }

            .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right {
                    width: 100% !important
            }

            .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header {
                    width: 100% !important;
                    max-width: 600px !important
            }

            .es-adapt-td {
                    display: block !important;
                width: 100% !important
            }

            .adapt-img {
                    width: 100% !important;
                    height: auto !important
            }

            .es-m-p0 {
                    padding: 0px !important
            }

            .es-m-p0r {
                    padding-right: 0px !important
            }

            .es-m-p0l {
                    padding-left: 0px !important
            }

            .es-m-p0t {
                    padding-top: 0px !important
            }

            .es-m-p0b {
                    padding-bottom: 0 !important
            }

            .es-m-p20b {
                    padding-bottom: 20px !important
            }

            .es-mobile-hidden, .es-hidden {
                    display: none !important
            }

            .es-desk-hidden {
                    display: table-row !important;
                width: auto !important;
                overflow: visible !important;
                float: none !important;
                max-height: inherit !important;
                line-height: inherit !important
            }

            .es-desk-menu-hidden {
                    display: table-cell !important
            }

            table.es-table-not-adapt, .esd-block-html table {
                    width: auto !important
            }

            table.es-social {
                    display: inline-block !important
            }

            table.es-social td {
                    display: inline-block !important
            }
        }

        #outlook a {
            padding: 0;
        }

        .ExternalClass {
        width: 100%;
    }

        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
        line-height: 100%;
        }

        .es-button {
        mso-style-priority: 100 !important;
            text-decoration: none !important;
        }

        a[x-apple-data-detectors] {
        color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        .es-desk-hidden {
        display: none;
        float: left;
        overflow: hidden;
        width: 0;
        max-height: 0;
            line-height: 0;
            mso-hide: all;
        }
    </style>
</head>
<body style='width:100%;font-family:arial, 'helvetica neue', helvetica, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;'>
<div class='es-wrapper-color' style='background-color:#F6F6F6;'>
    <!--[if gte mso 9]>
    <v:background xmlns:v='urn:schemas-microsoft-com:vml' fill='t'>
        <v:fill type='tile' color='#f6f6f6'></v:fill>
    </v:background>
    <![endif]-->
    <table class='es-wrapper' width='100%' cellspacing='0' cellpadding='0'
           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;'>
        <tr style='border-collapse:collapse;'>
            <td valign='top' style='padding:0;Margin:0;'>
                <table class='es-content' cellspacing='0' cellpadding='0' align='center'
                       style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                    <tr style='border-collapse:collapse;'>
                        <td align='center' style='padding:0;Margin:0;'>
                            <table class='es-content-body'
                                   style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;'
                                   width='600' cellspacing='0' cellpadding='0' align='center'>
                                <tr style='border-collapse:collapse;'>
                                    <td align='left'
                                        style='Margin:0;padding-top:15px;padding-bottom:15px;padding-left:20px;padding-right:20px;'>
                                        <!--[if mso]>
                                        <table width='560' cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td width='270' valign='top'><![endif]-->
                                        <table class='es-left' cellspacing='0' cellpadding='0' align='left'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='270' align='left' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>

                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!--[if mso]></td>
                                    <td width='20'></td>
                                    <td width='270' valign='top'><![endif]-->
                                        <table class='es-right' cellspacing='0' cellpadding='0' align='right'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='270' align='left' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>

                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!--[if mso]></td></tr></table><![endif]--></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class='es-content' cellspacing='0' cellpadding='0' align='center'
                       style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                    <tr style='border-collapse:collapse;'>
                        <td align='center' style='padding:0;Margin:0;'>
                            <table class='es-content-body'
                                   style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#9AAEA6;'
                                   width='600' cellspacing='0' cellpadding='0' bgcolor='#9aaea6' align='center'>
                                <tr style='border-collapse:collapse;'>
                                    <td align='left' style='padding:0;Margin:0;'>
                                        <table width='100%' cellspacing='0' cellpadding='0'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td style='padding:0;Margin:0;position:relative;'
                                                                align='center'><a target='_blank'
                                                                                  href='http://www.atenas.edu.br/uniatenas'
                                                                                  style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:14px;text-decoration:underline;color:#9AAEA6;'><img
                                                                    class='adapt-img'
                                                                    src='http://www.atenas.edu.br/uniatenas/assets/images/logoUniatenas.png' width='100%' 
                                                                    style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;'></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class='es-content' cellspacing='0' cellpadding='0' align='center'
                       style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                    <tr style='border-collapse:collapse;'>
                        <td align='center' style='padding:0;Margin:0;'>
                            <table class='es-content-body' width='600' cellspacing='0' cellpadding='0' bgcolor='#ffffff'
                                   align='center'
                                   style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;'>
                                <tr style='border-collapse:collapse;'>
                                    <td align='left'
                                        style='Margin:0;padding-bottom:10px;padding-top:30px;padding-left:40px;padding-right:40px;'>
                                        <table width='100%' cellspacing='0' cellpadding='0'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='520' valign='top' align='center' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td align='left' style='padding:0;Margin:0;'><h3
                                                                    style='Margin:0;line-height:20px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666;'>
    Parabéns, você está bem mais próximo de fazer um  curso superior.<br><br>Você realizou sua inscrição, para um curso EaD,  com as seguintes informações:<br><br></h3>
                                                                <h3 style='Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666;'>
    Nome:" . $data['user'] . "</h3>
                                                                <h3 style='Margin:0;line-height:20px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666;'>
    Email:" . $data['emailUser'] . "<br></h3>
                                                                <h3 style='Margin:0;line-height:20px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666;'>
    Telefone:" . $data['phone'] . "<br></h3>
                                                                <h3 style='Margin:0;line-height:20px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666;'>
                                                                    <br></h3>
                                                                <h3 style='Margin:0;line-height:20px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#666666;'>
    Para o curso EaD em " . $courseRegistration->nameCourse . ", interessado no polo" . $poloEspecifico->city . ". O contato foi realizado no dia " . date('d/m/Y H:i:s', strtotime($date)) . "<br><br></h3></td>
          
                                                        </tr>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td align='center'
                                                                style='padding:0;Margin:0;padding-top:15px;padding-bottom:15px;'>
                                                                <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#999999;'>
                                                                    <span style='font-size:16px;'><i>Em breve um colaborador de nossa equipe entrará em contato com você, para que possamos agendar a data e hora do seu vestibular.<br><br>Agradecemos a confiança.</i></span><br>
                                                                </p></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class='es-content' cellspacing='0' cellpadding='0' align='center'
                       style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                    <tr style='border-collapse:collapse;'></tr>
                    <tr style='border-collapse:collapse;'>
                        <td align='center' style='padding:0;Margin:0;'>
                            <table class='es-footer-body'
                                   style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#9AAEA6;'
                                   width='600' cellspacing='0' cellpadding='0' bgcolor='#9aaea6' align='center'>
                                <tr style='border-collapse:collapse;'>
                                    <td align='left' style='padding:20px;Margin:0;'>
                                        <!--[if mso]>
                                        <table width='560' cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td width='270' valign='top'><![endif]-->
                                        <table class='es-left' cellspacing='0' cellpadding='0' align='left'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td class='es-m-p20b' width='270' align='left'
                                                    style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td class='es-m-txt-с' align='center'
                                                                style='padding:0;Margin:0;padding-bottom:10px;'><h3
                                                                    style='Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#FFFFFF;'>
    Siga-nos</h3></td>
                                                        </tr>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td align='center' style='padding:0;Margin:0;'>
                                                                <table class='es-table-not-adapt es-social'
                                                                       cellspacing='0' cellpadding='0'
                                                                       style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                                    <tr style='border-collapse:collapse;'>
                                                                        <td valign='top' align='center'
                                                                            style='padding:0;Margin:0;padding-right:10px;'>
                                                                            <a href='https://www.facebook.com/uniatenasoficial'
                                                                               style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666;'><img
                                                                                    title='Facebook'
                                                                                    src='http://www.atenas.edu.br/uniatenas/assets/images/aprincipal/images/email-facebook.png'
                                                                                    alt='Fb' width='32' height='32'
                                                                                    style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;'></a>
                                                                        </td>
                                                                        <td valign='top' align='center'
                                                                            style='padding:0;Margin:0;padding-right:10px;'>
                                                                            <a href='https://www.youtube.com/user/tvatenas'
                                                                               style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666;'><img
                                                                                    title='Youtube'
                                                                                    src='http://www.atenas.edu.br/uniatenas/assets/images/aprincipal/images/email-youtube.png'
                                                                                    alt='Yt' width='32' height='32'
                                                                                    style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;'></a>
                                                                        </td>
                                                                        <td valign='top' align='center'
                                                                            style='padding:0;Margin:0;'>
                                                                            <a href='instagram.com/uniatenasoficial/'
                                                                                style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#666666;'>
                                                                                
                                                                                <img
                                                                                title='Linkedin'
                                                                                src='http://www.atenas.edu.br/uniatenas/assets/images/aprincipal/images/email-instagram.png'
                                                                                alt='In' width='32' height='32'
                                                                                style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;'>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width='20'></td>
                                    <td width='270' valign='top'><![endif]-->
                                        <table class='es-right' cellspacing='0' cellpadding='0' align='right'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='270' align='left' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                        <tr style='border-collapse:collapse;'>
                                                            
                                                        </tr>
                                                        <tr style='border-collapse:collapse;'>
                                                            
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!--[if mso]></td></tr></table><![endif]--></td>
                                </tr>
                                <tr style='border-collapse:collapse;'>
                                    <td style='padding:0;Margin:0;background-color:#FFFFFF;' bgcolor='#ffffff'
                                        align='left'>
                                        <table width='100%' cellspacing='0' cellpadding='0'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='600' valign='top' align='center' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td class='es-m-txt-с' esdev-links-color='#666666'
                                                                align='center'
                                                                style='padding:0;Margin:0;padding-top:10px;padding-bottom:20px;'>
                                                                <p style='Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:18px;color:#666666;'>
                                                                    <br></p><font color='#666666'><span
                                                                    style='font-size:12px;'>Para ter acesso a mais informações acesse o nosso site:<br>www.uniatenas.edu.br</span></font><br>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class='es-content' cellspacing='0' cellpadding='0' align='center'
                       style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;'>
                    <tr style='border-collapse:collapse;'>
                        <td align='center' style='padding:0;Margin:0;'>
                            <table class='es-content-body'
                                   style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;'
                                   width='600' cellspacing='0' cellpadding='0' align='center'>
                                <tr style='border-collapse:collapse;'>
                                    <td align='left'
                                        style='Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;'>
                                        <table width='100%' cellspacing='0' cellpadding='0'
                                               style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                            <tr style='border-collapse:collapse;'>
                                                <td width='560' valign='top' align='center' style='padding:0;Margin:0;'>
                                                    <table width='100%' cellspacing='0' cellpadding='0'
                                                           style='mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;'>
                                                        <tr style='border-collapse:collapse;'>
                                                            <td class='es-infoblock' align='center'
                                                                style='padding:0;Margin:0;line-height:14px;font-size:12px;color:#CCCCCC;'>
                                                                <a target='_blank'
                                                                   href='http://www.uniatenas.edu.br'
                                                                   style='-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-size:12px;text-decoration:underline;color:#CCCCCC;'><img src='http://localhost/uniatenas/assets/images/logoUniatenas.png'
                                                                        alt width='125'
                                                                        style='display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;'></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
    ";
            $data['polos_has_campus_id'] = $poloEspecifico->poloCampusId;
            $this->load->library('email');

            //Inicia o processo de configuração para o envio do email
            $config['protocol'] = 'mail'; // define o protocolo utilizado
            $config['wordwrap'] = TRUE; // define se haverá quebra de palavra no texto
            $config['validate'] = TRUE; // define se haverá validação dos endereços de email
            $config['mailtype'] = 'html';
            $config['newline'] = '\r\n';
            $config['charset'] = 'utf-8';

            $this->email->initialize($config);

            $assunto = 'Insrição Processo Seletivo EAD - Site';
            $this->email->from('copeve@atenas.edu.br', 'EAD - Uniatenas'); //quem mandou

            $this->email->to($data['emailUser']); // Destinatário

            $this->email->subject($assunto);
            $this->email->message($messageUser);

            if ($this->email->send()) {
                $this->email->clear();

                $this->email->from('copeve@atenas.edu.br', 'EAD - Uniatenas'); //quem mandou
                //$this->email->cc('comunicacao@atenas.edu.br');
                $this->email->subject($assunto);
                $this->email->message($mensagemPolo);

                $this->email->to($poloEspecifico->email); // Destinatário
                $this->email->send();
                $this->email->clear();

                $this->bancosite->salvar('course_registration_ead', $data);

                setMsg('<p>Pré-Inscrição Realizada com sucesso. Qualquer dúvida, entre em contato por um de nossos canais de atendimento. <br>  Enviamos um email, em sua caixa postal, com as informações a respeito de sua inscrição.</p>', 'success');
                echo "<script>alert('Email enviado com sucesso!');location.href='" . base_url() . "graduacao/inscricaoEad/$campus;</script>";

            } else {
                setMsg('<p>Erro! Infelismente, houve um erro. Você pode tentar novamente mais tarde, ou nos enviar uma mensagem pelo nosso Whatsapp (38)9.9805-9502 </p>', 'error');
                echo "<script>alert('Algto de errado não está certo.!');location.href='" . base_url() . "graduacao/inscricaoEad/$campus';</script>";
            }

        }

        $cursos = $this->bancosite->getWhere('courses', array('modalidade' => "ead", "types" => "ead"), array('campo' => 'name', 'ordem' => 'ASC'))->result();

        $polos = $this->Painelsite->where(
            array('polos_has_campus.id as poloCampusId', 'campus.name as campusName', 'campus.id as idCampus', 'polos.id as idPolo', 'polos.city', 'polos.responsible', 'polos.email as emailPolo')
            , 'polos', array('polos_has_campus' => 'polos_has_campus.poloscampusid=polos.id', 'campus' => 'campus.id = polos_has_campus.campusid'))->result();

        if ($courseId != NULL) {
            $courseEspecific = $this->bancosite->getWhere('courses', array('modalidade' => "ead", 'id' => $courseId))->row();
        } else {
            $courseEspecific = '';
        }

        $dataCampus = $this->Painelsite->where('*', 'campus', NULL, array('city' => $city))->row();

        $data = array(
            'head' => array(
                'title' => 'Inscrição Processo Seletivo - EaD UniAtenas',
                'css' => base_url('assets/wizzard/css/styleWizzard.css')
            ),

            'js' => NULL,
            'footer' => '',
            'dados' => array(
                'cursos' => $cursos,
                'uricamppus' => $campus,
                'campus' => $dataCampus,
                'courseEspecific' => $courseEspecific,
                'polos' => $polos
            )
        );

        $this->load->view('templates/masterRegistrationEad', $data);
    }*/
}