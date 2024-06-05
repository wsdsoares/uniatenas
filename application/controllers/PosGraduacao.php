<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Posgraduacao extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
        $this->load->model('Site_model', 'bancosite');
    }

    public function cursos($campus = null)
    {
        if ($campus == null) {
            echo '<script>alert("CAmpus nul - TODO")</script>;';
        }

        $ColunasTabelaCampus = array('campus.name', 'campus.id', 'campus.city', 'campus.shurtName');
        $dataCampus = $this->bancosite->where($ColunasTabelaCampus, 'campus', NULL, array('shurtName' => $campus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'posgraduacao'))->row();
        $sql = "SELECT 
                courses.id as id,
                courses.name as name, 
                campus_has_courses.id as idCourseCampus,
                courses.areas_id, 
                courses.status,
                courses.capa,
                courses.types,
                courses.icone,
                courses.imagem, 
                courses.links,
                courses.modalidade,
                campus.id as idCampus, 
                campus.name as nameCampus ,
                campus.city, 
                courses_pages.link_vestibular /** TODO - Analisar depois */
            FROM
                at_site.campus_has_courses
            inner join campus on campus.id = campus_has_courses.campus_id
            inner join courses on courses.id = campus_has_courses.courses_id
            INNER JOIN courses_pages on courses_pages.campus_has_courses_id = campus_has_courses.id
            
            where campus.id =" . $dataCampus->id . "
            and courses.modalidade='ead'
            and courses.types='PosGraduacao'
            order by courses.name";

        $campusCursos = $this->bancosite->getQuery($sql)->result();

        $data = array(
            'head' => array(
                'title' => "Pós-Graduação $dataCampus->name",
            ),
            'conteudo' => "uni_posGraduacao/lista_cursos",
            'js' => NULL,
            'footer' => array(),
            'dados' => array(
                'campus' => $dataCampus,
                // 'conteudoPag' => $conteudoPrincipal,
                'campusCursos' => $campusCursos
            )
        );

        $this->load->view('templates/master', $data);
    }

    public function dados_curso($uricampus, $idCourse = NULL)
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

        $queryDisciplinas = "SELECT 
                           courses_curricular_grid_pos_graduacao.id, 
                           courses_curricular_grid_pos_graduacao.disciplina,
                           courses_curricular_grid_pos_graduacao.modulo,
                           courses_curricular_grid_pos_graduacao.carga_horaria, 
                           courses.name
                        FROM
                            at_site.courses_curricular_grid_pos_graduacao
                        inner join campus_has_courses on campus_has_courses.id =courses_curricular_grid_pos_graduacao.campus_has_courses_id
                        inner join courses on courses.id = campus_has_courses.courses_id
                        where campus_has_courses.id = $idCourse";

        $queryModulo = " SELECT 
                               courses_curricular_grid_pos_graduacao.modulo,
                               courses_curricular_grid_pos_graduacao.nome_modulo
                            FROM
                               at_site.courses_curricular_grid_pos_graduacao
                            inner join campus_has_courses on campus_has_courses.id =courses_curricular_grid_pos_graduacao.campus_has_courses_id
                            inner join courses on courses.id = campus_has_courses.courses_id
                            where campus_has_courses.id = $idCourse  
                            group by 1,2";




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

        $queryAutorizacaoReconhecimento =
            "SELECT 
          courses_autorizacao_reconhecimento.id as idAutorizacaoReconhecimento,
          courses_autorizacao_reconhecimento.files,
          courses_autorizacao_reconhecimento.tipo_arquivo,         
          courses_autorizacao_reconhecimento.status         
            FROM
                at_site.courses_autorizacao_reconhecimento
            INNER JOIN campus_has_courses ON campus_has_courses.id = courses_autorizacao_reconhecimento.campus_has_courses_id
            INNER JOIN campus ON campus.id = campus_has_courses.campus_id
            WHERE
            courses_autorizacao_reconhecimento.status = 1 and
            campus_has_courses.id = $idCourse
            group by (courses_autorizacao_reconhecimento.tipo_arquivo)";

        $queryConteudosCursos =
            "SELECT 
            courses_conteudos.id,
            courses_conteudos.titulo,
            courses_conteudos.descricao,
            courses_conteudos.status,
            courses_conteudos.tipo,
            courses_conteudos.ordem, 
            courses_conteudos.user_id 
            FROM 
            courses_conteudos
            INNER JOIN campus_has_courses ON campus_has_courses.id = courses_conteudos.id_curso_campus
            INNER JOIN campus ON campus.id= campus_has_courses.campus_id
            WHERE 
                campus_has_courses.id = $idCourse AND
                courses_conteudos.status=1
            ORDER BY courses_conteudos.ordem ASC";

        $pageCourse = $this->bancosite->getQuery($query)->row();
        $conteudosCurso = $this->bancosite->getQuery($queryConteudosCursos)->result();
        $courseCampus = $this->bancosite->getQuery($queryCourseCampus)->row();
        $autorizacaoReconhecimento = $this->bancosite->getQuery($queryAutorizacaoReconhecimento)->result();

        $disciplinasPos = $this->bancosite->getQuery($queryDisciplinas)->result();
        $modulosCursosPos = $this->bancosite->getQuery($queryModulo)->result();

        $data = array(
            'head' => array(
                'title' => "Pós - Graduação",
                'css' => base_url('assets/css/css_course/style-course.css')
            ),
            'conteudo' => "uni_posGraduacao/dados_curso",
            'js' => NULL,
            'footer' => array(
                //'specific_JS' => 'assets/plugins/lightbox/dist/js/lightbox-plus-jquery.js',
            ),

            'dados' => array(
                'dadosCurso' => array(
                    'curso' => $courseCampus,
                    'autorizacaoReconhecimento' => $autorizacaoReconhecimento,
                    'informacoesCurso' => $pageCourse,
                    'disciplinasPos' => $disciplinasPos,
                    'modulosCursosPos' => $modulosCursosPos,
                    'conteudosCursos' => $conteudosCurso
                ),
                'campus' => $dataCampus
            )
        );
        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }
}
