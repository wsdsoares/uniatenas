<?php

defined('BASEPATH') or exit('No direct script access allowed');

class IniciacaoCientifica extends CI_Controller {

    public function __construct() {
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
        $this->load->model('Site_model', 'bancosite');
        $this->load->model('Cpainel_model', 'sitebank');
    }

    public function index() {
        $this->inicio_pesquisa();
    }

    public function comite_etica($uricampus = NULL) {

        $dataCampus = $this->bancosite->where(array('campus.id','campus.instagram','campus.city','campus.facebook'),'campus',NULL, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'pesquisaComiteEticaPesquisa', 'campusid'=>$dataCampus->id))->row();


        //$page = $this->bancosite->getWhere('pages', array('title' => 'cep','campusid'=>$dataCampus->id))->row();

        // $consulta = "SELECT 
        //                     *
        //                 FROM
        //                     at_site.page_contents
        //                 where page_contents.order like 'texto%'
        //                 and pages_id = $page->id
        //                         ";

        //$pages_content = $this->bancosite->getQuery($consulta)->result();

        $whereConteudoPagina = array('page_contents.pages_id'=>$page->id, 'page_contents.tipo'=> 'informacoesPagina','page_contents.status'=> 1);
        $pages_content = $this->bancosite->where('*','page_contents',null, $whereConteudoPagina )->result();
        // $pages_content_contato = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'order' => 'contatos'))->row();
        $pages_content_contato = $this->bancosite->where('*','page_contents',null, array('pages_id' => $page->id, 'status'=>1,'order' => 'contatos'))->row();

        $colunasResultadoAtendimento = array('page_contents.id','page_contents.title','page_contents.description','page_contents.status','page_contents.pages_id');
        $conteudoAtendimento = $this->bancosite->where($colunasResultadoAtendimento,'page_contents',null, array('pages_id' => $page->id, 'status'=>1,'order' => 'atendimento'))->row();

        $colunasResultadoLinksUteis = array('page_contents.id','page_contents.title','page_contents.link_redir','page_contents.status','page_contents.pages_id');
        $conteudoLinksUteis = $this->bancosite->where($colunasResultadoLinksUteis,'page_contents',null, array('page_contents.pages_id' => $page->id, 'page_contents.status'=>1,'page_contents.order' => 'linksUteis'))->result();


        //$conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'page_contents.order' => 'description'))->result();
        //$pages_content_contato = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'order' => 'contatos'))->row();

        // $filedPhones = array("contatos_setores.phone", "contatos_setores.ramal","contatos_setores.visiblepage","contatos_setores.email","contatos_setores.phonesetor");
        // $tablePhones = "campus_has_setores";
        // $dataJoinPhones = array("contatos_setores" =>"contatos_setores.setoresidcamp = campus_has_setores.id");
        // $wherePhones = array("campus_has_setores.id"=> $page->setorcampid,"contatos_setores.visiblepage" => 1);
        // $phones = $this->sitebank->where($filedPhones,$tablePhones,$dataJoinPhones,$wherePhones)->result();


        $data = array(
            'head' => array(
                'title' => 'Comitê de Ética em Pesquisa ' . $dataCampus->name . ' ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/cep/homeComiteEtica',
            'footer' => '',
            'menu' => '',
            'js' => null,
            'dados' => array(
                // 'conteudo' => $pages_content,
                // 'conteudoContato' => $pages_content_contato,
                // 'campus' => $dataCampus,
                // 'conteudoPag' => $conteudoPrincipal,
                // 'contatos' => $phones
                'conteudo' => $pages_content,
                'conteudoContato' => $pages_content_contato,
                'conteudoAtendimento' => $conteudoAtendimento = isset($conteudoAtendimento) ? $conteudoAtendimento : '',
                'conteudoLinksUteis' => $conteudoLinksUteis = isset($conteudoLinksUteis) ? $conteudoLinksUteis : '',
            )
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }

    public function inicio_pesquisa($uricampus = NULL) {
        if($uricampus == null){
            redirect("");
        }

        $dataCampus = $this->bancosite->where(array('campus.id','campus.instagram','campus.city','campus.facebook'),'campus',NULL, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'pesquisaIniciacao', 'campusid'=>$dataCampus->id))->row();

        // $consulta = "SELECT *
        //                 FROM
        //                     at_site.page_contents
        //                 where page_contents.tipo like 'informacoesPagina'
        //                 and page_contents.pages_id = $page->id";
// $consulta = "SELECT *
// FROM
//     at_site.page_contents
// where page_contents.order like 'texto%'
// and page_contents.pages_id = $page->id";                        

        // $pages_content = $this->bancosite->getQuery($consulta)->result();
        $whereConteudoPagina = array('page_contents.pages_id'=>$page->id, 'page_contents.tipo'=> 'informacoesPagina' );
        $pages_content = $this->bancosite->where('*','page_contents',null, $whereConteudoPagina )->result();
        // $pages_content_contato = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'order' => 'contatos'))->row();
        $pages_content_contato = $this->bancosite->where('*','page_contents',null, array('pages_id' => $page->id, 'status'=>1,'order' => 'contatos'))->row();

        $colunasResultadoAtendimento = array('page_contents.id','page_contents.title','page_contents.description','page_contents.status','page_contents.pages_id');
        $conteudoAtendimento = $this->bancosite->where($colunasResultadoAtendimento,'page_contents',null, array('pages_id' => $page->id, 'status'=>1,'order' => 'atendimento'))->row();

        $colunasResultadoLinksUteis = array('page_contents.id','page_contents.title','page_contents.link_redir','page_contents.status','page_contents.pages_id');
        $conteudoLinksUteis = $this->bancosite->where($colunasResultadoLinksUteis,'page_contents',null, array('page_contents.pages_id' => $page->id, 'page_contents.status'=>1,'page_contents.order' => 'linksUteis'))->result();

        //$filedPhones = array("contatos_setores.phone", "contatos_setores.ramal","contatos_setores.visiblepage","contatos_setores.email","contatos_setores.phonesetor");
        //$tablePhones = "campus_has_setores";
        //$dataJoinPhones = array("contatos_setores" =>"contatos_setores.setoresidcamp = campus_has_setores.id");
        //$wherePhones = array("campus_has_setores.id"=> $page->setorcampid,"contatos_setores.visiblepage" => 1);
        //$phones = $this->sitebank->where($filedPhones,$tablePhones,$dataJoinPhones,$wherePhones)->result();

        $data = array(
            'head' => array(
                'title' => 'Pesquisa e inicição científica - UniAtenas',
            ),
            'conteudo' => 'uniatenas/pesquisaIniciacao/iniciacao',
            'footer' => '',
            'menu' => '',
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'conteudo' => $pages_content,
                'conteudoContato' => $pages_content_contato,
                'conteudoAtendimento' => $conteudoAtendimento = isset($conteudoAtendimento) ? $conteudoAtendimento : '',
                'conteudoLinksUteis' => $conteudoLinksUteis = isset($conteudoLinksUteis) ? $conteudoLinksUteis : '',
                'contatos' => '',
                //'contatos' => $phones,
            )
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }

    public function revista_cientifica($uricampus = NULL, $idRevista) {
      if($uricampus == null){
        redirect("");
      }

      $dataCampus = $this->bancosite->where(array('campus.id','campus.name','campus.shurtName','campus.instagram','campus.city','campus.uf','campus.facebook'),'campus',NULL, array('shurtName' => $uricampus))->row();

      $sql = "SELECT * FROM at_site.publicacoes
            where revistas_id =$idRevista
            order by year desc";

        $sqlYear = "SELECT year FROM at_site.publicacoes
            where revistas_id =$idRevista
            group by(year)
            order by 1 desc";

        $publicacoes = $this->bancosite->getQuery($sql)->result();
        $years = $this->bancosite->getQuery($sqlYear)->result();
        $revistas = $this->bancosite->getWhere('revistas', array('id'=>$idRevista))->row();

        $data = array(
            'head' => array(
                'title' => 'Revistas ',
            ),
            'footer' => '',
            'menu' => '',
            'js' => null,
            'conteudo' => 'uniatenas/publicacoes/revistaCientifica',
            'dados' => array(
                'publicacoes' => $publicacoes,
                'campus' => $dataCampus,
                'revistas'=>$revistas,
                'years' => $years,
                'revista_id' => $idRevista,
            )
                //'news' => $news
        );
        $this->load->view('templates/master', $data);
    }

    public function revistas($uricampus = NULL) {
        if($uricampus == null){
            redirect("");
        }
        
        $dataCampus = $this->bancosite->where(array('campus.id','campus.name','campus.shurtName','campus.instagram','campus.city','campus.uf','campus.facebook'),'campus',NULL, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'revistas','campusid'=>$dataCampus->id))->row();
        $pages_content = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id))->result();

		$revistas = $this->bancosite->getQuery("SELECT * FROM revistas where capa<>'null' and status =1 and campus_id=$dataCampus->id")->result();


        $data = array(
            'head' => array(
                'title' => 'Revistas ',
            ),
            'footer' => '',
            'menu' => '',
            'js' => null,
            'conteudo' => 'uniatenas/publicacoes/revistas',
            'dados' => array(
                'campus' => $dataCampus,
                'conteudoPag' => $pages_content,
                'revistas' => $revistas,
            )
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }
    
    
    public function trabalho_conclusao_curso($uricampus = NULL) {
        if($uricampus == null){
            redirect("");
        }

        $dataCampus = $this->bancosite->where(array('campus.id','campus.instagram','campus.city','campus.shurtName','campus.facebook'),'campus',NULL, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'pesquisaTcc', 'campusid'=>$dataCampus->id))->row();

        $whereConteudoPagina = array('page_contents.pages_id'=>$page->id, 'page_contents.tipo'=> 'informacoesPagina','page_contents.status'=>1);
        $pages_content = $this->bancosite->where('*','page_contents',null, $whereConteudoPagina )->result();
        
        $pages_content_contato = $this->bancosite->where('*','page_contents',null, array('pages_id' => $page->id, 'status'=>1,'order' => 'contatos'))->row();

        $colunasResultadoAtendimento = array('page_contents.id','page_contents.title','page_contents.description','page_contents.status','page_contents.pages_id');
        $conteudoAtendimento = $this->bancosite->where($colunasResultadoAtendimento,'page_contents',null, array('pages_id' => $page->id, 'status'=>1,'order' => 'atendimento'))->row();

        $colunasResultadoLinksUteis = array('page_contents.id','page_contents.title','page_contents.link_redir','page_contents.status','page_contents.pages_id');
        $conteudoLinksUteis = $this->bancosite->where($colunasResultadoLinksUteis,'page_contents',null, array('page_contents.pages_id' => $page->id, 'page_contents.status'=>1,'page_contents.order' => 'linksUteis'))->result();

   
        
        // $pages_content_contato = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'order' => 'contatos'))->row();
        // $filedPhones = array("contatos_setores.phone", "contatos_setores.ramal","contatos_setores.visiblepage","contatos_setores.email","contatos_setores.phonesetor");
        // $tablePhones = "campus_has_setores";
        // $dataJoinPhones = array("contatos_setores" =>"contatos_setores.setoresidcamp = campus_has_setores.id");
        // $wherePhones = array("campus_has_setores.id"=> $page->setorcampid,"contatos_setores.visiblepage" => 1);
        // $phones = $this->sitebank->where($filedPhones,$tablePhones,$dataJoinPhones,$wherePhones)->result();

        $revistas = $this->bancosite->getQuery('SELECT * FROM revistas where id in(2,3)')->result();
        
        $queryConteudoCursosTCCs = "
        SELECT 
          campus_has_courses.id as idCursoCampus,
            `courses`.`id`,
            `courses`.`name`,
            `courses`.`types`,
            `courses`.`icone`
        FROM
            `campus_has_courses`
        JOIN courses 
          on courses.id = campus_has_courses.courses_id
        JOIN campus 
          on campus.id = campus_has_courses.campus_id
        WHERE
            courses.modalidade = 'presencial'
            and campus.id = $dataCampus->id
          and ( SELECT count(tcc.id) FROM monography as tcc where tcc.campus_has_courses_id = campus_has_courses.id) > 0
          
        ORDER BY courses.name ASC
        ";
        // $conteudoTrabalhoDeConclusaoCurso = $this->bancosite->where(array('coursesWWW.id','courses.name','courses.types','courses.icone'),'courses',NULL, array('modalidade' => 'presencial'))->result();
        $conteudoTrabalhoDeConclusaoCurso = $this->bancosite->getQuery($queryConteudoCursosTCCs)->result();

        $data = array(
            'head' => array(
                'title' => 'Trabalho de Conclusão de Curso - TCC ',
            ),
            'footer' => '',
            'menu' => '',
            'js' => null,
            'conteudo' => 'uniatenas/pesquisaIniciacao/trabalhoConclusao',
            'dados' => array(
                'campus' => $dataCampus,
                'conteudo' => $pages_content,
                'conteudoContato' => $pages_content_contato,
                'conteudoAtendimento' => $conteudoAtendimento = isset($conteudoAtendimento) ? $conteudoAtendimento : '',
                'conteudoLinksUteis' => $conteudoLinksUteis = isset($conteudoLinksUteis) ? $conteudoLinksUteis : '',
                'conteudoTrabalhoDeConclusaoCurso' => $conteudoTrabalhoDeConclusaoCurso = isset($conteudoTrabalhoDeConclusaoCurso) ? $conteudoTrabalhoDeConclusaoCurso : '',
                'contatos' => '',
                // 'campus' => $dataCampus,
                // 'conteudoPag' => $pages_content,
                // 'revistas' => $revistas,
                // 'tcss_cursos' =>$tccs,
                // 'conteudoContato' => $pages_content_contato,
                // 'phones' => $phones,
            )
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }

    public function artigos_cientificos($uricampus=NULL,$idRevista=NULL, $year=NULL) {
        if($uricampus == null){
            redirect("");
        }
        if (!isset($idRevista) and $revista == NULL) {
            redirect("iniciacaoCientifica/revistas/$uricampus");
        }
        
        $dataCampus = $this->bancosite->where(array('campus.id','campus.name','campus.shurtName','campus.instagram','campus.city','campus.uf','campus.facebook'),'campus',NULL, array('shurtName' => $uricampus))->row();

        $sql = "SELECT * FROM at_site.publicacoes
            where revistas_id =$idRevista
                and year=$year
            order by year desc";

        $publicacoes = $this->bancosite->getQuery($sql)->result();
        $revista = $this->bancosite->getWhere('revistas', array('id' => $idRevista))->row();

        $data = array(
            'head' => array(
                'title' => 'Artigos Revista Científica',
            ),
            'footer' => '',
            'menu' => '',
            'js' => null,
            'conteudo' => 'uniatenas/publicacoes/publicacaoCientifica',
            'dados' => array(
                'campus' => $dataCampus,
                'publicacoes' => $publicacoes,
                'revistas' => $revista,
            )
        );
        $this->output->cache(6200);
        $this->load->view('templates/master', $data);
    }
    
    public function listaSemestresTCC($uricampus = NULL,$courseId=NULL) {
        if($uricampus == null){
            redirect("");
        }
        $colunasCampus = array(
          'campus.id',
          'campus.name',
          'campus.city',
          'campus.shurtName');
        $dataCampus = $this->bancosite->where($colunasCampus,'campus',NULL, array('shurtName' => $uricampus))->row();
        
        $colunaResultadosCursos = array(
          'campus_has_courses.id','courses.name','courses.types','courses.icone'
        );
        $joinCursosCampus = array(
          'courses'=>'courses.id = campus_has_courses.courses_id',
          'campus'=>'campus.id = campus_has_courses.campus_id'
        );

        $whereCusosCampus = array(
          'campus_has_courses.id'=>$courseId,
          'campus.id' => $dataCampus->id
        );
        $cursos = $this->bancosite->where($colunaResultadosCursos,'campus_has_courses',$joinCursosCampus, $whereCusosCampus)->row();

        // $consultaAnosTCC =
        //   "SELECT 
        //       year
        //     FROM monography 
        //     JOIN campus_has_courses on campus_has_courses.id = monography.campus_has_courses_id
        //     where monography.campus_has_courses_id =$courseId 
        //     and ( SELECT count(tcc.id) FROM monography as tcc where tcc.campus_has_courses_id = campus_has_courses.id) = 0
        //     group by(year) order by 1 desc";

        $consultaAnosTCC =
        "SELECT 
          monography.year
        FROM
            `campus_has_courses`
        JOIN courses 
          on courses.id = campus_has_courses.courses_id
        JOIN campus 
          on campus.id = campus_has_courses.campus_id
		join monography
		  on monography.campus_has_courses_id = campus_has_courses.id
        WHERE
            courses.modalidade = 'presencial'
          and campus.id =  $dataCampus->id
          and monography.campus_has_courses_id =$courseId 
          and monography.files not like ('%<')
          and  ( SELECT count(tcc.id) FROM monography as tcc where tcc.campus_has_courses_id = campus_has_courses.id and tcc.year = monography.year) > 0
		group by ( monography.year)
        ORDER BY 1 desc";

      
         $yearsTCC = $this->bancosite->getQuery($consultaAnosTCC)->result();
        //$yearsTCC = $this->bancosite->getQuery("SELECT year FROM monography where coursesid =$courseId group by(year) order by 1 desc")->result();

        $data = array(
            'head' => array(
                'title' => 'Trabalho de Conclusão de Curso - TCC ',
            ),
            'footer' => '',
            'menu' => '',
            'js' => null,
            'conteudo' => 'uniatenas/pesquisaIniciacao/listaSemestres',
            'dados' => array(
                'campus' => $dataCampus,
                'curso' => $cursos,
                'semestresTCC' => $yearsTCC,
            )
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }

    public function listaMonografias($uricampus = NULL,$courseId=NULL,$yearMonography=NULL) {
        if($uricampus == null){
            redirect("");
        }
       
        $colunasCampus = array(
          'campus.id',
          'campus.name',
          'campus.city',
          'campus.shurtName');
        $dataCampus = $this->bancosite->where($colunasCampus,'campus',NULL, array('shurtName' => $uricampus))->row();
        
        $colunaResultadosCursos = array(
          'campus_has_courses.id','courses.name','courses.types','courses.icone'
        );
        $joinCursosCampus = array(
          'courses'=>'courses.id = campus_has_courses.courses_id',
          'campus'=>'campus.id = campus_has_courses.campus_id'
        );

        $whereCusosCampus = array(
          'campus_has_courses.id'=>$courseId,
          'campus.id' => $dataCampus->id
        );
        $cursos = $this->bancosite->where($colunaResultadosCursos,'campus_has_courses',$joinCursosCampus, $whereCusosCampus)->row();
        
        $consultaMonografia = "
        select 
          monography.id, 
          monography.title,
          monography.files
        from 
          monography 
        where 
        monography.campus_has_courses_id = $courseId 
          and year = $yearMonography 
          and monography.files not like '%/<'
          and monography.status = 1
        ";
        $monographys = $this->bancosite->getQuery($consultaMonografia)->result();           

        $data = array(
            'head' => array(
                'title' => 'Trabalho de Conclusão de Curso - TCC ',
            ),
            'footer' => '',
            'menu' => '',
            'js' => null,
            'conteudo' => 'uniatenas/pesquisaIniciacao/listaMonografias',
            'dados' => array(
                'campus' => $dataCampus,
                'curso' => $cursos,
                'year'=>$yearMonography,
                'listasMonografias' => $monographys,
            )
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }


}