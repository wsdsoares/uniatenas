<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Site extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
        $this->load->model('Site_model', 'bancosite');
        $this->load->model('Cpainel_model', 'Painelsite');
    }

    public function inicio($uricampus)
    {
        if ($uricampus == null) {
            redirect("");
        }

        $local = $uricampus;

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $date = date('Y-m-d H:i:s');
        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $cursos = $this->bancosite->getWhere('courses', array('modalidade' => 'presencial'), array('campo' => 'name', 'ordem' => 'asc'))->result();

        $queryNews = 'select *
                        from news
                        where datestart <= "' . $date . '"
                        and campusid = ' . $dataCampus->id . '
                        and status = 1
                        order by id desc
                        limit 4';

        $news = $this->bancosite->getQuery($queryNews)->result();

        //$midias = $this->bancosite->getWhere('banners', array('type' => 'slideshowprincipal', 'campusid' => $dataCampus->id,'status'=> 1), array('campo' => 'id', 'ordem' => 'desc'))->result();
        $midiasql = "SELECT * FROM at_site.banners
                    WHERE type = 'slideshowprincipal' AND campusid = $dataCampus->id AND status = 1
                    ORDER BY priority asc";

        $midias = $this->bancosite->getQuery($midiasql)->result();

        $eventSpace = $this->bancosite->getWhere('event_space', array('campusid' => $dataCampus->id))->result();
        // $queryBannerLast = "select max(id) as lastRegister from banners where campusid =$dataCampus->id and status =1";

        //$idativo = $this->bancosite->getQuery($queryBannerLast)->row();
        $sqlCategoria = "
                     SELECT
                     photos_category.id,
                            concat('cat',photos_category.id) as categoria,
                        photos_category.title
                    FROM
                        at_site.photos_gallery
                            INNER JOIN
                        photos_category ON photos_category.id = photos_gallery.photoscategoryid
                            INNER JOIN
                        campus ON campus.id = photos_gallery.campusid
                    where campus.id = $dataCampus->id
                    group by photos_category.id
                    ORDER BY RAND()
                    Limit 8
                 ";
        $categoria = $this->bancosite->getQuery($sqlCategoria)->result();
        $i = 0;
        $catArray[] = array();

        foreach ($categoria as $item) {
            $catArray[$i]['id'] = $item->id;
            $catArray[$i]['title'] = $item->title;
            $catArray[$i]['categoria'] = $item->categoria;
            $catArray[$i]['fotos'] = $this->bancosite->getWhere('photos_gallery', array('photoscategoryid' => $item->id), null, 1)->row();
            $i = $i + 1;
        }

        $data = array(
            'head' => array(
                'title' => $dataCampus->name . ' - ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/home',
            'js' => 'templates/elements/jsMaster',
            'footer' => '',
            'menu' => 'templates/elements/menuMaster',
            'dados' => array(
                'slideshow' => $midias,
                //'idativo' => $idativo,
                'campus' => $dataCampus,
                'news' => isset($news) ? $news : '',
                'cursos' => $cursos,
                'espacoeventos' => $eventSpace = $uricampus == 'paracatu' ? $eventSpace : '',
                'fotos' => $catArray,
            ),
        );

        $this->load->view('templates/master', $data);
    }

    public function localizacao($uricampus)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $dataOuthersCampus = $this->bancosite->getWhere('campus', array('visible' => 'sim'), array('campo' => 'city', 'ordem' => 'asc'))->result();

        $data = array(
            'head' => array(
                'title' => 'Localização - ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/campus/localizacao',
            'dados' => array(
                'campus' => $dataCampus,
                'outherCampus' => $dataOuthersCampus,
            ),
            'js' => null,
            'footer' => '',
        );
        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }

    public function biblioteca($uricampus)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $colunaCampus = array('campus.name', 'campus.id', 'campus.city', 'campus.uf');
        $dataCampus = $this->bancosite->where($colunaCampus, 'campus', null, array('shurtName' => $uricampus))->row();

        // $pages_content = $this->bancosite->getWhere('pages', array('title' => 'biblioteca', 'campusid' => $dataCampus->id))->row();

        $page = $this->bancosite->where('*', 'pages', null, array('title' => 'biblioteca', 'campusid' => $dataCampus->id))->row();

        //$whereConteudoPrincipal = array('page_contents.pages_id' => $page->id,'page_contents.status'=>1,'page_contents.tipo'=> 'informacoesPagina');

        $queryItensBiblioteca = "
        SELECT
          page_contents.id,
          page_contents.title,
          page_contents.title_short,
          page_contents.status,
          page_contents.tipo,
          page_contents.order,
          page_contents.description
        FROM
          page_contents
          JOIN pages ON pages.id = page_contents.pages_id
          JOIN campus ON campus.id = pages.campusid
        WHERE
          page_contents.pages_id = $page->id AND
          page_contents.status = 1 AND
          page_contents.tipo = 'informacoesPagina' AND
          page_contents.order NOT IN ('linkComutacao','comutacao')
        ORDER BY page_contents.title ASC
        ";

        //$conteudoPrincipal = $this->bancosite->where('*','page_contents', null,$whereConteudoPrincipal, array('campo' => 'page_contents.order', 'ordem' => 'asc'))->result();
        $conteudoPrincipal = $this->bancosite->getQuery($queryItensBiblioteca)->result();

        // $pages_content_contato = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'order' => 'contatos'))->row();
        $pages_content_contato = $this->bancosite->where('*', 'page_contents', null, array('pages_id' => $page->id, 'status' => 1, 'order' => 'contatos'))->row();

        $colunasResultadoLinksUteis = array('page_contents.id', 'page_contents.title', 'page_contents.link_redir', 'page_contents.status', 'page_contents.pages_id');
        $whereLinksUteis = array('page_contents.pages_id' => $page->id, 'page_contents.status' => 1, 'page_contents.order' => 'linksUteis', 'page_contents.tipo' => 'linksUteis');
        $conteudoLinksUteis = $this->bancosite->where($colunasResultadoLinksUteis, 'page_contents', null, $whereLinksUteis)->result();

        $colunasResultadoAcessoRapido = array('page_contents.id', 'page_contents.title', 'page_contents.link_redir', 'page_contents.status', 'page_contents.pages_id');
        $whereAcessoRapido = array('page_contents.pages_id' => $page->id, 'page_contents.status' => 1, 'page_contents.order' => 'linksUteis', 'page_contents.tipo' => 'acessoRapido');
        $conteudoAcessoRapido = $this->bancosite->where($colunasResultadoAcessoRapido, 'page_contents', null, $whereAcessoRapido)->result();

        $colunasResultadoComutacao = array('page_contents.title', 'page_contents.description');
        $whereComutacao = array('page_contents.pages_id' => $page->id, 'page_contents.status' => 1, 'page_contents.tipo' => 'informacoesPagina', 'page_contents.order ' => 'comutacao');
        $conteudoComutacao = $this->bancosite->where($colunasResultadoComutacao, 'page_contents', null, $whereComutacao)->row();

        $colunasResultadoLinkComutacao = array('page_contents.title', 'page_contents.description', 'page_contents.link_redir');
        $whereLinkComutacao = array('page_contents.pages_id' => $page->id, 'page_contents.status' => 1, 'page_contents.tipo' => 'informacoesPagina', 'page_contents.order ' => 'linkComutacao');
        $conteudoLinkComutacao = $this->bancosite->where($colunasResultadoLinkComutacao, 'page_contents', null, $whereLinkComutacao, array('campo' => 'title', 'ordem' => 'ASC'))->result();

        $colunaFotosBiblioteca = array(
            'photos_gallery.id',
            'photos_gallery.id_page_contents',
            'photos_gallery.campusid',
            'photos_gallery.title',
            'photos_gallery.file',
            'photos_gallery.status',
        );
        $joinFotosSlideBiblioteca = array(
            'page_contents' => 'page_contents.id = photos_gallery.id_page_contents',
            'pages' => 'pages.id = page_contents.pages_id',
        );

        $whereFotosSlideBiblioteca = array(
            'page_contents.pages_id' => $page->id,
        );

        $conteudoFotosSlideBiblioteca = $this->bancosite->where($colunaFotosBiblioteca, 'photos_gallery', $joinFotosSlideBiblioteca, $whereFotosSlideBiblioteca)->result();

        $colunasResultadoLinkComutacao = array('page_contents.title', 'page_contents.description', 'page_contents.link_redir');
        $joinLinksRevistaPeriodicos = array(
            'magazines_area' => 'magazines_area.id = magazines_links.magazines_areaid',
            'campus' => 'campus.id = magazines_area.campus_id',
        );
        $whereLinksRevistaPeriodicos = array('magazines_area.status' => 1, 'magazines_area.campus_id' => $dataCampus->id);

        $conteudoLinksRevistaPeriodicos = $this->bancosite->where(array('magazines_links.id'), 'magazines_links', $joinLinksRevistaPeriodicos, $whereLinksRevistaPeriodicos)->result();

        $existeLinkRevistasPeriodicos = count($conteudoLinksRevistaPeriodicos);

        $pages_content_contato = $this->bancosite->where('*', 'page_contents', null, array('pages_id' => $page->id, 'order' => 'contatos'))->row();

        $data = array(
            'head' => array(
                'title' => 'Biblioteca - ' . $dataCampus->name,
            ),
            'conteudo' => 'uniatenas/biblioteca/homeBiblioteca',
            'dados' => array(
                'campus' => $dataCampus,
                'conteudoPag' => $conteudoPrincipal,
                //'fragmtext' => $texbibl,
                // 'conteudoContato' => $pages_content_contato,
                'conteudoAcessoRapido' => $conteudoAcessoRapido = isset($conteudoAcessoRapido) ? $conteudoAcessoRapido : '',
                'conteudoLinksUteis' => $conteudoLinksUteis = isset($conteudoLinksUteis) ? $conteudoLinksUteis : '',
                'conteudoComutacao' => $conteudoComutacao = isset($conteudoComutacao) ? $conteudoComutacao : '',
                'conteudoLinkComutacao' => $conteudoLinkComutacao = isset($conteudoLinkComutacao) ? $conteudoLinkComutacao : '',
                'conteudoFotosSlideBiblioteca' => $conteudoFotosSlideBiblioteca = isset($conteudoFotosSlideBiblioteca) ? $conteudoFotosSlideBiblioteca : '',
                'existeLinkRevistasPeriodicos' => $existeLinkRevistasPeriodicos = $existeLinkRevistasPeriodicos > 0 ? $existeLinkRevistasPeriodicos : '',
                'conteudoContato' => '',

                'contatos' => '',
            ),
            'js' => null,
            'footer' => '',

            //'news' => $news
        );
        $this->output->cache(10400);
        $this->load->view('templates/master', $data);
    }

    public function campus()
    {

        $data = array(
            'head' => array(
                'title' => 'Localização - UniAtenas ',
            ),
            'conteudo' => 'uniatenas/campus/inicioCampus',
            'dados' => array(),
            'js' => null,
            'footer' => '',

            //'news' => $news
        );
        $this->load->view('templates/master', $data);
    }

    /*     * ************
     * NOTICIAS
     * ************ */

    public function noticias($uricampus = null)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        //$news = $this->Painelsite->where('*','news', '', array('campusid'=>$dataCampus->id), array('campo' => 'id', 'ordem' => 'desc'))->result(); //Table, orderm, campo, limit -Retorno do banco de dados

        $date = date('Y-m-d H:i:s');
        $queryNews = 'select *
                        from news
                        where datestart <= "' . $date . '"
                        and campusid = ' . $dataCampus->id . '
                        and status = 1
                        order by id desc';
        $news = $this->bancosite->getQuery($queryNews)->result();

        $data = array(
            'head' => array(
                'title' => 'Notícias - UniAtenas ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/noticias/principal',
            'footer' => '',
            'menu' => '',
            'js' => null,
            'dados' => array(
                'news' => $news,
                'campus' => $dataCampus,
            ),
        );

        $this->load->view('templates/master', $data);
    }

    public function ver_noticia($uricampus = null, $id = null)
    {
        if ($uricampus == null) {
            redirect("");
        }

        if ($id == null) {
            redirect('Site/noticias');
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $news = $this->bancosite->getWhere('news', array('id' => $id, 'status' => '1'), null, 1)->row();

        //$recentNews = $this->bancosite->getWhere('news', array('status' => '1','campusid' =>$dataCampus->id), array('campo' => 'id', 'ordem' => 'desc'), 5)->result();

        $photosNews = $this->bancosite->getWhere('news_image', array('newsid' => $news->id))->result();

        $date = date('Y-m-d H:i:s');
        $queryNews = 'select *
                        from news
                        where datestart <= "' . $date . '"
                        and campusid = ' . $dataCampus->id . '
                        and status = 1
                        order by id desc
                        limit 5';
        $recentNews = $this->bancosite->getQuery($queryNews)->result();

        $data = array(
            'head' => array(
                'title' => 'Visualizar Notícias - UniAtenas ' . $dataCampus->city,
                'specific_CSS' => 'assets/plugins/lightbox/dist/css/lightbox.min.css',
            ),
            'conteudo' => 'uniatenas/noticias/ver_noticia',
            'footer' => array(
                'specific_JS' => 'assets/plugins/lightbox/dist/js/lightbox-plus-jquery.js',
            ),
            'menu' => null,
            'js' => null,
            'dados' => array(
                'news' => $news,
                'campus' => $dataCampus,
                'recentNews' => $recentNews,
                'photosNews' => $photosNews,
            ),
        );

        $this->load->view('templates/master', $data);
    }

    /****************
     * ESPAÇO EVENTOS
     * **************/

    public function espaco_eventos($uricampus = null)
    {
        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $pages_content = $this->bancosite->getWhere('pages', array('title' => 'espacoeventos', 'campusid' => $dataCampus->id))->row();
        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $pages_content->id))->result();
        $eventSpace = $this->bancosite->getWhere('event_space', array('campusid' => $dataCampus->id))->result();

        $spacePhotosArray = array();
        count($eventSpace);
        for ($i = 0; $i < count($eventSpace); $i++) {
            $spacePhotosArray[$i]['id'] = $eventSpace[$i]->id;
            $spacePhotosArray[$i]['campusid'] = $eventSpace[$i]->campusid;
            $spacePhotosArray[$i]['description'] = $eventSpace[$i]->description;
            $spacePhotosArray[$i]['name'] = $eventSpace[$i]->name;
            $spacePhotosArray[$i]['capacity'] = $eventSpace[$i]->capacity;
            $spacePhotosArray[$i]['photocape'] = $eventSpace[$i]->photocape;
            $spacePhotosArray[$i]['photos'] = $this->bancosite->getWhere('event_space_photos', array('eventspaceid' => $eventSpace[$i]->id))->result();
        }

        $data = array(
            'head' => array(
                'title' => 'Espaço para Eventos - UniAtenas',
            ),
            'conteudo' => 'uni_eventos/espaco_eventos',
            'footer' => array(),
            'menu' => null,
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'conteudo' => $pages_content,
                'conteudoPag' => $conteudoPrincipal,
                'fotosEspaco' => $spacePhotosArray,
            ),
        );

        $this->load->view('templates/master', $data);
    }

    public function fotos_espaco_eventos($uricampus = null, $idspace = null)
    {
        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $pages_content = $this->bancosite->getWhere('pages', array('title' => 'espacoeventos', 'campusid' => $dataCampus->id))->row();
        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $pages_content->id))->result();
        $eventSpace = $this->bancosite->getWhere('event_space', array('id' => $idspace, 'campusid' => $dataCampus->id))->result();

        $spacePhotosArray = array();
        count($eventSpace);
        for ($i = 0; $i < count($eventSpace); $i++) {
            $spacePhotosArray[$i]['id'] = $eventSpace[$i]->id;
            $spacePhotosArray[$i]['campusid'] = $eventSpace[$i]->campusid;
            $spacePhotosArray[$i]['description'] = $eventSpace[$i]->description;
            $spacePhotosArray[$i]['name'] = $eventSpace[$i]->name;
            $spacePhotosArray[$i]['capacity'] = $eventSpace[$i]->capacity;
            $spacePhotosArray[$i]['photocape'] = $eventSpace[$i]->photocape;
            $spacePhotosArray[$i]['photos'] = $this->bancosite->getWhere('event_space_photos', array('eventspaceid' => $eventSpace[$i]->id))->result();
        }

        $data = array(
            'head' => array(
                'title' => 'Fotos espaço para eventos',
            ),
            'conteudo' => 'uni_eventos/fotos_espaco_eventos',
            'footer' => array(),
            'menu' => null,
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'conteudo' => $pages_content,
                'conteudoPag' => $conteudoPrincipal,
                'fotosEspaco' => $spacePhotosArray,
            ),
        );

        $this->load->view('templates/master', $data);
    }

    /*     * ***********"*
     * GALERIA DE FOTOS
     * ************ */

    public function galeria($uricampus = null)
    {
        if ($uricampus == null) {
            redirect("");
        }
        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $colunasFotosGaleria = array(
            'photos_gallery.id',
            'photos_gallery.id_page_contents',
            'photos_gallery.file',
            'photos_gallery.title',
            'photos_gallery.status',
            'photos_gallery.created_at',
            'photos_gallery.updated_at',
            'photos_gallery.user_id',
        );

        $whereFotosGaleria = array(
            //'photos_gallery.id_page_contents'=>$idConteudoPaginaInfraestrutura,
        );

        $listaFotosInfraestrutura = $this->bancosite->where('*', 'photos_gallery', null, null)->result();

        $whereInfraestrutura = array(
            // 'page_contents.id'=>$idConteudoPaginaInfraestrutura,
        );
        $colunaInfraestrutura = array(
            'page_contents.id',
            'page_contents.title',
        );

        // $categoriaInfraestrutura = $this->painelbd->where($colunaInfraestrutura,'page_contents',NULL,$whereInfraestrutura, null, null)->row();

        $sqlCategoria = "
                     SELECT
                     photos_category.id,
                            concat('cat',photos_category.id) as categoria,
                        photos_category.title
                    FROM
                        at_site.photos_gallery
                            INNER JOIN
                        photos_category ON photos_category.id = photos_gallery.photoscategoryid
                            INNER JOIN
                        campus ON campus.id = photos_gallery.campusid
                        where photos_category.status = 1 and photos_gallery.campusid = $dataCampus->id
                    group by photos_category.id
                 ";
        $categoria = $this->bancosite->getQuery($sqlCategoria)->result();
        $i = 0;
        $catArray[] = array();

        foreach ($categoria as $item) {
            $catArray[$i]['id'] = $item->id;
            $catArray[$i]['title'] = $item->title;
            $catArray[$i]['categoria'] = $item->categoria;
            $catArray[$i]['fotos'] = $this->bancosite->where('*', 'photos_gallery', null, array('photos_gallery.photoscategoryid' => $item->id), null, 3)->result();
            $i = $i + 1;
        }

        $data = array(
            'head' => array(
                'title' => 'Fotos - UniAtenas ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/galeriaFotos/galeria',
            'footer' => '',
            'js' => null,
            'dados' => array(
                'city' => $uricampus,
                'campus' => $dataCampus,
                'catArray' => $catArray,
            ),
        );

        $this->load->view('templates/master', $data);
    }

    /*     * ************
     * Show Photograph
     * ************ */

    public function galeria_fotos($uricampus = null, $idCategory = null, $breadcrump = null)
    {
        if ($uricampus == null) {
            redirect("");
        }
        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        if ($breadcrump != null) {
            if ($breadcrump == 'huna') {
                $breadurl = "Huna/inicio/$uricampus";
            }
        } else {
            $breadurl = "site/galeria/$uricampus";
        }

        $catArray[] = array();

        $Category = $this->bancosite->getWhere('photos_category', array('id' => $idCategory))->row();
        $catArray['id'] = $Category->id;
        $catArray['title'] = $Category->title;
        $catArray['fotos'] = $this->bancosite->where('*', 'photos_gallery', null, array('photos_gallery.photoscategoryid' => $Category->id, 'photos_gallery.status' => 1))->result();
        //  $catArray['fotos'] = $this->bancosite->getWhere('photos_gallery', array('photoscategoryid' => $Category->id), null)->result();
        $data = array(
            'head' => array(
                'title' => 'Galeira - UniAtenas ' . $dataCampus->city,
                'css' => base_url('assets/css/css_course/style-course.css'),
            ),
            'conteudo' => "uniatenas/galeriaFotos/fotosGaleria",

            'js' => null,
            'footer' => '',
            'dados' => array(
                'campus' => $dataCampus,
                'catArray' => $catArray,
                'breadurl' => $breadurl,
            ),
        );
        $this->output->cache(9000);
        $this->load->view('templates/master', $data);
    }

    /*     * ************
     * INICIAÇÃO CIENTÍFICA
     * ************ */

    public function revistas_periodicos($uricampus)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $areasLinks = $this->bancosite->where('*', 'magazines_area', null, array('status' => 1, 'magazines_area.campus_id' => $dataCampus->id))->result();

        $data = array(
            'head' => array(
                'title' => 'Revistas e Periódicos  - UniAtenas ',
            ),
            'conteudo' => 'uniatenas/biblioteca/revistasPeriodicosCurso',
            'dados' => array(
                'campus' => $dataCampus,
                'areaslinks' => $areasLinks,
            ),
            'js' => null,
            'footer' => '',

            //'news' => $news
        );
        $this->output->cache(9400);
        $this->load->view('templates/master', $data);
    }

    public function links_revistas($uricampus, $cursoid)
    {
        if ($uricampus == null) {
            redirect("");
        }

        if ($cursoid == null) {
            redirect('Site/revistas_periodicos');
        }
        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        //$areasLinks = $this->bancosite->where('magazines_links', array('status' => 1, ))->result();
        $joinAreaRevistaPeriodico = array(
            'magazines_area' => 'magazines_area.id = magazines_links.magazines_areaid',
        );
        $whereAreaRevistaPeriodico = array(
            'magazines_links.magazines_areaid' => $cursoid,
            'magazines_links.status' => 1,
            'magazines_links.campus_id' => $dataCampus->id,
            'magazines_area.status' => 1,
        );
        $colunasLinksRevistasPeriodicos = array(
            'magazines_links.id',
            'magazines_links.title',
            'magazines_links.magazines_areaid',
            'magazines_links.link',
            'magazines_links.classification',
            'magazines_links.status',
            'magazines_area.status',
            'magazines_area.title as magazinesarea',

        );

        $areasLinks = $this->bancosite->where($colunasLinksRevistasPeriodicos, 'magazines_links', $joinAreaRevistaPeriodico, $whereAreaRevistaPeriodico, array('campo' => 'magazines_links.title', 'ordem' => 'ASC'))->result();

        //trocar função getWhere - TODO
        $areas = $this->bancosite->getWhere('magazines_area', array('magazines_area.id' => $cursoid))->row();

        $data = array(
            'head' => array(
                'title' => 'Revistas e periódicos - UniAtenas',
            ),
            'conteudo' => 'uniatenas/biblioteca/link_revistas',
            'footer' => '',
            'menu' => '',
            'js' => null,
            'dados' => array(
                'areaslinks' => $areasLinks,
                'idArea' => $cursoid,
                'area' => $areas,
                // 'area' => '',
                'campus' => $dataCampus,
            ),
        );
        $this->output->cache(180);
        $this->load->view('templates/master', $data);
    }

    /**************
     *****CPA******
     **************/

    public function CPA($uricampus = null)
    {
        if ($uricampus == null) {
            redirect("");
        }
        $page = $this->bancosite->getWhere('pages', array('title' => 'pesquisaIniciacao'))->row();

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'cpa', 'campusid' => $dataCampus->id))->row();

        $consulta = "SELECT
                            *
                        FROM
                            at_site.page_contents
                        where page_contents.order like 'texto%'
                        and status=1
                        and pages_id = $page->id";

        $banner = null;
        $consulta2 = $this->bancosite->getWhere('photos_category', array('title' => 'CPA', 'type' => 'banner', 'campusid' => $dataCampus->id))->result();
        if (!empty($consulta2)) {
            $banner = $this->bancosite->getWhere('photos_gallery', array('photoscategoryid' => $consulta2[0]->id))->result();
        }

        $pages_content = $this->bancosite->getQuery($consulta)->result();

        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'page_contents.order' => 'description'))->result();

        $filedPhones = array("contatos_setores.phone", "contatos_setores.ramal", "contatos_setores.visiblepage", "contatos_setores.email", "contatos_setores.phonesetor");
        $tablePhones = "campus_has_setores";
        $dataJoinPhones = array("contatos_setores" => "contatos_setores.setoresidcamp = campus_has_setores.id");
        $wherePhones = array("campus_has_setores.id" => $page->setorcampid, "contatos_setores.visiblepage" => 1);
        $phones = $this->Painelsite->where($filedPhones, $tablePhones, $dataJoinPhones, $wherePhones)->result();

        $data = array(
            'head' => array(
                'title' => 'CPA - Comissão Própria de Avaliação - UniAtenas',
            ),
            'conteudo' => 'uniatenas/cpa/principal',
            'footer' => '',
            'menu' => '',
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'conteudo' => $pages_content,
                'conteudoPag' => $conteudoPrincipal,

                'page_banner' => $banner,
                'contatos' => $phones,
            ),
        );
        $this->load->view('templates/master', $data);
    }

    /*     * ***********"*
     * NAPP
     * ************ */

    public function napp($uricampus = null)
    {
        $colunasCampus = array('campus.id', 'campus.name', 'campus.city', 'campus.uf', 'campus.shurtName');
        $dataCampus = $this->bancosite->where($colunasCampus, 'campus', null, array('campus.shurtName' => $uricampus))->row();

        $pages_content = $this->bancosite->where('*', 'pages', null, array('title' => 'napp', 'campusid' => $dataCampus->id))->row();
        $conteudoPrincipal = $this->bancosite->getQuery("SELECT * FROM page_contents where page_contents.pages_id = $pages_content->id and page_contents.order <>'contatos' and page_contents.status=1 order by page_contents.order ASC")->result();

        $conteudoContato = $this->bancosite->getQuery("SELECT * FROM page_contents where page_contents.pages_id = $pages_content->id and page_contents.order ='contatos' and page_contents.status=1")->result();

        $data = array(
            'head' => array(
                'title' => 'NAPP ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/napp/principal',
            'footer' => '',
            'menu' => '',
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'conteudoPaginaNapp' => $conteudoPrincipal,
                'contatosPagina' => $conteudoContato,
            ),
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }

    /*     * ***********"*
     * NPA - Administração
     * ************ */

    public function npa($uricampus = null)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();
        $page = $this->bancosite->getWhere('pages', array('title' => 'npa'))->row();

        $consulta = "SELECT
                            *
                        FROM
                            at_site.page_contents
                        where page_contents.order like 'texto%'
                        and pages_id = $page->id
                                ";

        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id))->result();
        $data = array(
            'head' => array(
                'title' => 'NPA - ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/npa/principal',
            'footer' => '',
            'menu' => '',
            'js' => null,
            'dados' => array(
                'city' => $dataCampus->city,
                'campus' => $dataCampus,
                'conteudoPag' => $conteudoPrincipal,
            ),
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }

    /*     * ***********"*
     * NPAS - SISTEMAS FÁBRICA DE SOFTWARE
     * ************ */

    public function npas($uricampus = null)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'npas'))->row();

        $consulta = "SELECT
                            *
                        FROM
                            at_site.page_contents
                        where page_contents.order like 'texto%'
                        and pages_id = $page->id
                                ";

        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id))->result();
        $data = array(
            'head' => array(
                'title' => 'NPAS - ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/npas/principal',
            'footer' => '',
            'menu' => '',
            'js' => null,
            'dados' => array(
                'city' => $dataCampus->city,
                'campus' => $dataCampus,
                'conteudoPag' => $conteudoPrincipal,
            ),
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }

    /*     * ***********"*
     * -----------------  NPJ
     * ************ */

    public function NPJ($uricampus = null)
    {
        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'npj'))->row();

        $consulta = "SELECT
                            *
                        FROM
                            at_site.page_contents
                        where page_contents.order like 'texto%'
                        and pages_id = $page->id
                                ";
        $pages_content = $this->bancosite->getQuery($consulta)->result();
        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'page_contents.order' => 'description'))->result();
        $pages_content_contato = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'order' => 'contatos'))->result();

        $data = array(
            'head' => array(
                'title' => 'NPJ ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/nucleos/npj',
            'footer' => '',
            'menu' => '',
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'conteudo' => $pages_content,
                'conteudoPag' => $conteudoPrincipal,
                'conteudoContatos' => $pages_content_contato,
            ),
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }

    /* ------------------------------------------------------------
    --------------              Graduação
    ------------------------------------------------------------ */

    public function graduacao()
    {
        redirect('graduacao/cursos');
    }

    public function publicacoes($campus)
    {

        $local = $this->bancosite->get_all('campus', $campus)->row();
        $revistas = $this->bancosite->getWhere('revistas', array('status' => 1, 'campus_id' => $campus))->result();
        $data = array(
            'head' => array(
                'title' => 'Revistas ',
            ),
            'titulo' => 'Publicações - UniAtenas',
            'conteudo' => 'uniatenas/publicacoes/publicacoes',
            'js' => null,
            'footer' => '',
            'dados' => array(
                'campus' => $local,
                'revistas' => $revistas,
            ),
        );
        $this->load->view('templates/master', $data);
    }

    public function revistaCientifica($id)
    {
        if (!isset($id) and $id == null) {
            redirect('site/publicacoes');
        }

        $campus = "
         SELECT
  revistas.id,
    revistas.titulo,
    campus.id as campus_id,
    campus.name,
    campus.city

FROM
    revistas
inner join campus on campus.id = revistas.campus_id
where revistas.status=1
and revistas.id =$id;
         ";

        $sql = "SELECT * FROM at_site.publicacoes
            where revistas_id =$id
            order by year desc";

        $sqlYear = "SELECT year FROM at_site.publicacoes
            where revistas_id=$id
            group by(year)
            order by 1 desc";

        $campus = $this->bancosite->getQuery($campus)->row();
        $revistas = $this->bancosite->getWhere('revistas', array('id' => $id))->row();
        $publicacoes = $this->bancosite->getQuery($sql)->result();
        $years = $this->bancosite->getQuery($sqlYear)->result();

        $data = array(
            'head' => array(
                'title' => 'Revistas - UniAtenas',
            ),
            'titulo' => 'Publicações - UniAtenas',
            'conteudo' => 'uniatenas/publicacoes/revistaCientifica',
            'js' => null,
            'footer' => '',
            'dados' => array(
                'publicacoes' => $publicacoes,
                'years' => $years,
                'campus' => $campus,
                'revistas' => $revistas,
                'revista_id' => $id,
            ),
        );
        $this->load->view('templates/master', $data);
    }

    public function contato($uricampus = null)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $this->form_validation->set_rules('name', 'Nome', 'required|ucfirst');
        $this->form_validation->set_rules('email', 'E-mail', 'valid_email|required');
        $this->form_validation->set_rules('phone', 'Telefone', 'required|in');
        $this->form_validation->set_rules('message', 'Mensagem', 'required|min_length[50]');

        if ($this->form_validation->run() == false) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if (!empty($this->input->post('enviarForm'))) {

                $url = "https://www.google.com/recaptcha/api/siteverify";
                $secret = "6Lc1NxEmAAAAADgQbDjiqScjBzvga54vmJt1jsmZ";
                $response = $this->input->post('g-recaptcha-response');
                $variaveis = "secret=" . $secret . "&response=" . $response;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $variaveis);
                $resposta = curl_exec($ch);
                curl_close($ch);

                $resultado = json_decode($resposta);

                if ($resultado->success == 1) {
                    if ($this->input->post('description') != '') {
                        $outhersInformation = $this->input->post('description');
                    } else {
                        $outhersInformation = '';
                    }

                    $data = elements(array('name', 'email', 'phone', 'message'), $this->input->post());
                    setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
                    date_default_timezone_set('America/Sao_Paulo');

                    $date = date('Y-m-d H:i:s');

                    $data['campusid'] = $dataCampus->id;

                    $mensagem = "<p>O (A)" .
                    "<b>" . $data['name'] . "</b> fez conato pelo site." . "<br/>" .
                    "Email: " . $data['email'] . "<br/>" .
                    "Celular: " . $data['phone'] . "<br/>" .
                    "Mensagem: " . $data['message'] . "<br/>" .
                    "O conato veio da página de " . $dataCampus->name . ' - ' . $dataCampus->city . "<br/>" . "<br/>" .
                    "O contato foi realizado no dia <b>" . date('d/m/Y H:i:s', strtotime($date)) . '</b>';

                    $this->load->library('email');

                    //Inicia o processo de configuração para o envio do email
                    $config['protocol'] = 'mail'; // define o protocolo utilizado
                    $config['wordwrap'] = true; // define se haverá quebra de palavra no texto
                    $config['validate'] = true; // define se haverá validação dos endereços de email
                    $config['mailtype'] = 'html';
                    $config['newline'] = '\r\n';
                    $config['charset'] = 'utf-8';

                    //$email = 'soaresdev.wil@gmail.com';
                    $email = $dataCampus->email;
                    $this->email->initialize($config);

                    $assunto = 'Fale Conosco' . $dataCampus->name . ' - ' . $dataCampus->city;
                    $this->email->from('faleconosco@atenas.edu.br', 'Fale Conosco'); //quem mandou
                    $this->email->to($email); // Destinatário
                    //$this->email->cc('comunicacao@atenas.edu.br');
                    $this->email->cc($data['email']);
                    //$this->email->bcc($data['email']);
                    $this->email->subject($assunto);
                    $this->email->message($mensagem);

                    if ($this->email->send()) {
                        $data['message'] = toBd($this->input->post('message'));
                        $this->bancosite->salvar('campus_contacts', $data);
                        setMsg('<p>Contato realizado com sucesso. <br>
                            Enviamos um email, em sua caixa postal, com as informações do seu contato.</p>', 'success');
                        redirect(base_url("site/contato/$dataCampus->shurtName"));
                    } else {
                        redirect(base_url("site/contato/$dataCampus->shurtName"));
                        setMsg('<p>Erro! Infelismente, houve um erro. Você pode tentar novamente mais tarde, ou nos enviar uma mensagem pelo nosso Whatsapp (38)9.9805-9502 </p>', 'error');
                    }
                } else {
                    setMsg('<p>Erro! O campo recaptcha precisa ser validado  </p>', 'error');
                }
            } else {
                setMsg('<p>Erro! reCaptcha não foi validado; </p>', 'error');
            }
        }

        $data = array(
            'head' => array(
                'title' => 'Contato - UniAtenas ',
            ),
            'titulo' => 'Contato - UniAtenas',
            'conteudo' => 'uniatenas/contato',
            'dados' => array(
                'campus' => $dataCampus,
            ),
            'js' => null,
            'footer' => '',
        );
        $this->load->view('templates/master', $data);
    }

    public function contatonapp($uricampus = null)
    {
        if ($uricampus == null) {
            redirect("");
        }
        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $this->form_validation->set_rules('name', 'Nome', 'required|ucfirst');
        $this->form_validation->set_rules('email', 'E-mail', 'valid_email|required');
        $this->form_validation->set_rules('phone', 'Telefone', 'required');
        $this->form_validation->set_rules('message', 'Mensagem', 'required');

        if ($this->form_validation->run() == false) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if ($this->input->post('description') != '') {
                $outhersInformation = $this->input->post('description');
            } else {
                $outhersInformation = '';
            }

            $data = elements(array('name', 'email', 'phone', 'message'), $this->input->post());
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');

            $date = date('Y-m-d H:i:s');

            $data['campusid'] = $dataCampus->id;

            $mensagem = "<p>O Sr.(Srª)" .
            "<b>" . $data['name'] . "</b> fez conato pelo site." . "<br/>" .
            "Email: " . $data['email'] . "<br/>" .
            "Celular: " . $data['phone'] . "<br/>" .
            "Mensagem: " . $data['message'] . "<br/>" .
            "O conato veio da página de " . $dataCampus->name . ' - ' . $dataCampus->city . "<br/>" . "<br/>" .
            "O contato foi realizado no dia <b>" . date('d/m/Y H:i:s', strtotime($date)) . '</b>';

            $this->load->library('email');

            //Inicia o processo de configuração para o envio do email
            $config['protocol'] = 'mail'; // define o protocolo utilizado
            $config['wordwrap'] = true; // define se haverá quebra de palavra no texto
            $config['validate'] = true; // define se haverá validação dos endereços de email
            $config['mailtype'] = 'html';
            $config['newline'] = '\r\n';
            $config['charset'] = 'utf-8';

            $email = "napp.uniatenas@uniatenas.edu.br";
            $this->email->initialize($config);

            $assunto = 'Fale Conosco' . $dataCampus->name . ' - ' . $dataCampus->city;
            $this->email->from('faleconosco@atenas.edu.br', 'Fale Conosco'); //quem mandou
            $this->email->to($email); // Destinatário
            //$this->email->cc('comunicacao@atenas.edu.br');
            $this->email->cc($data['email']);
            //$this->email->bcc($data['email']);
            $this->email->subject($assunto);
            $this->email->message($mensagem);

            if ($this->email->send()) {
                $this->bancosite->salvar('campus_contacts', $data);
                setMsg('<p>Contato realizado com sucesso. <br>
                    Enviamos um email, em sua caixa postal, com as informações do seu contato.</p>', 'success');
                echo "<script>alert('Email enviado com sucesso!');</script>";
            } else {
                setMsg('<p>Erro! Infelismente, houve um erro. Você pode tentar novamente mais tarde, ou nos enviar uma mensagem pelo nosso Whatsapp (38)9.9805-9502 </p>', 'error');
            }
        }

        $data = array(
            'head' => array(
                'title' => 'Napp - UniAtenas ',
            ),
            'titulo' => 'Napp - UniAtenas',
            'conteudo' => 'uniatenas/contatonapp',
            'dados' => array(
                'campus' => $dataCampus,
            ),
            'js' => null,
            'footer' => '',
        );
        $this->load->view('templates/master', $data);
    }

    public function erro_404()
    {
    }

    public function graduacaoEad($codEad = null)
    {

        $campus = '1'; //campus Paracatu
        $localidade = $this->bancosite->get_all('campus', $campus)->row();
        if (isset($codEad) and $codEad != 'uniasselvi') {
            $curso = $this->bancosite->getWhere('courses', array('modalidade' => "ead", 'types' => "ead", 'id' => $codEad))->row();

            $data = array(
                'titulo' => 'Graduação EAD - UniAtenas',
                'conteudo' => 'uniatenas/graduacaoEad/eadUniatenas',
                'dados' => array(
                    'campus' => $localidade,
                    'curso' => $curso,
                ),
            );
            $this->load->view('templates/layoutParacatu', $data);
        } elseif (isset($codEad) and $codEad == 'uniasselvi') {
            $cursos = $this->bancosite->getQuery('SELECT * FROM courses WHERE modalidade="ead" and types="eadUniasselvi"')->result();

            $data = array(
                'titulo' => 'Graduação EAD - Uniasselvi - UniAtenas',
                'conteudo' => 'uniatenas/graduacaoEad/uniasselvi',
                'dados' => array(
                    'campus' => $localidade,
                    'cursos' => $cursos,
                ),
            );
            $this->load->view('templates/layoutParacatu', $data);
        } else {
            $cursos = $this->bancosite->getQuery('SELECT * FROM courses WHERE modalidade="ead" and types="ead"')->result();

            $data = array(
                'titulo' => 'Graduação EAD - UniAtenas',
                'conteudo' => 'uniatenas/graduacaoEad/cursos',
                'dados' => array(
                    'campus' => $localidade,
                    'cursos' => $cursos,
                ),
            );
            $this->load->view('templates/layoutParacatu', $data);
        }
    }

    public function infraestrutura($uricampus = null)
    {
        // usar quando aprovado
        /*
         * https://codepen.io/dbgomez/pen/PowdgPB
         * */

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where(array('campus.id', 'campus.instagram', 'campus.city', 'campus.facebook'), 'campus', null, array('shurtName' => $uricampus))->row();

        //$dataCampus = $this->bancosite->getWhere('campus', array('city' => $dataCampus->city))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'infraestrutura', 'campusid' => $dataCampus->id))->row();

        $pages_content = $this->bancosite->where('*', 'page_contents', null, array('pages_id' => $page->id, 'status' => 1), array('campo' => 'order', 'ordem' => 'asc'))->result();
        $photosConted = array();

        // $datajoin = array(
        //     'page_contents' => 'page_contents.id = photos_gallery.id_page_contents',
        //     'photos_gallery' => 'photos_gallery.photoscategoryid = photos_category.id'
        // );
        foreach ($pages_content as $contend) {
            $where = array("page_contents_photos.id_page_contents" => $contend->id);
            $campos = array("page_contents_photos.file", "page_contents_photos.id");
            $photos = array("photo" => $this->bancosite->where('*', "page_contents_photos", null, $where)->result());
            $contend->array_fotos = $photos;
            // $contend->Fk_photosCat = $photos;
        }
        // $datajoin = array(
        //     'photos_category' => 'photos_category.id = page_contents.Fk_photosCat',
        //     'photos_gallery' => 'photos_gallery.photoscategoryid = photos_category.id'
        // );
        // foreach ($pages_content as $contend) {
        //     $where =  array("photos_category.id" => $contend->Fk_photosCat);
        //     $campos = array("photos_gallery.file", "photos_gallery.id");
        //     $photos = array("photo" => $this->bancosite->where($campos, "page_contents", $datajoin, $where)->result());
        //     $contend->Fk_photosCat = $photos;
        // }

        /*unset($where);
        unset($photos);
        unset($datajoin);*/

        $data = array(
            'head' => array(
                'title' => 'Infraestrutura - UniAtenas ',
            ),
            'conteudo' => 'uniatenas/infraestrutura',
            'dados' => array(
                //'dados' => $dados,
                'campus' => $dataCampus,
                'pages_content' => isset($pages_content) ? $pages_content : '',
            ),
            'js' => null,
            'footer' => '',
        );
        //unset($photosConted);
        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }

    public function nossaHistoria($uricampus = null)
    {

        if ($uricampus == null) {
            redirect("");
        }
        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'nossaHistoria', 'campusid' => $dataCampus->id))->row();
        $pages_content = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'status' => 1))->result();

        $data = array(
            'head' => array(
                'title' => 'História ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/nossaHistoria',
            'dados' => array(
                'campus' => $dataCampus,
                'pages_content' => $pages_content,
            ),
            'js' => null,
            'footer' => '',

            //'news' => $news
        );
        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }

    public function secretaria_academica($uricampus = null)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'secretariaacademica', 'campusid' => $dataCampus->id))->row();

        $pages_content = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'status' => 1))->result();

        $calendars = $this->bancosite->getWhere('campus_calendars', array('campusid' => $dataCampus->id, 'status' => 1, 'type' => 'demais_cursos'), array('campo' => 'semester', 'ordem' => 'desc'))->result();
        $calendarsMedicine = $this->bancosite->getWhere('campus_calendars', array('campusid' => $dataCampus->id, 'status' => 1, 'type' => 'medicina'), array('campo' => 'semester', 'ordem' => 'desc'))->result();

        $horasComplementares = $this->bancosite->getWhere('files', array('campusid' => $dataCampus->id, 'typesfile' => 'cartilha'))->row();

        $pages_content_contato = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'order' => 'contatos'))->row();

        $filedPhones = array("contatos_setores.phone", "contatos_setores.ramal", "contatos_setores.visiblepage", "contatos_setores.email", "contatos_setores.phonesetor");
        $tablePhones = "campus_has_setores";
        $dataJoinPhones = array("contatos_setores" => "contatos_setores.setoresidcamp = campus_has_setores.id");
        $wherePhones = array("campus_has_setores.id" => $page->setorcampid, "contatos_setores.visiblepage" => 1);
        $phones = $this->Painelsite->where($filedPhones, $tablePhones, $dataJoinPhones, $wherePhones)->result();

        $data = array(
            'head' => array(
                'title' => 'Secretaría Acadêmica - ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/secretariaacademica/homesecretaria',
            'dados' => array(
                'campus' => $dataCampus,
                'conteudoPag' => $pages_content,
                'calendars' => $calendars,
                'calendarsMedicine' => $calendarsMedicine,
                'conteudoContato' => $pages_content_contato,
                'horasComplementares' => $horasComplementares,
                'contatos' => $phones,
            ),
            'js' => null,
            'footer' => '',
        );
        $this->load->view('templates/master', $data);
    }

    public function dirigentes($uricampus = null)
    {
        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $dirigentes = $this->bancosite->getQuery("SELECT * FROM dirigentes WHERE cargo NOT LIKE '%coordenador%' ")->result();

        $data = array(
            'head' => array(
                'title' => 'Dirigentes ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/dirigentes',
            'dados' => array(
                'campus' => $dataCampus,
                'dirigentes' => $dirigentes,
            ),
            'js' => null,
            'footer' => '',
        );
        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }

    /* ------------------------------------------------------------
    --------------              Trabalhe Conosco
    ------------------------------------------------------------ */

    public function trabalheConosco($uricampus = null)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'trabalheconosco', 'campusid' => $dataCampus->id))->row();

        $localidades = $this->bancosite->getAll('campus')->result();

        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id))->result();

        $areasAtuacao = $this->bancosite->getWhere('areas')->result();
        $vagasAbertas = $this->bancosite->getWhere('resume_job_vacancy', array('status' => '1'))->result();

        $filedPhones = array("contatos_setores.phone", "contatos_setores.ramal", "contatos_setores.visiblepage", "contatos_setores.email", "contatos_setores.phonesetor");
        $tablePhones = "campus_has_setores";
        $dataJoinPhones = array("contatos_setores" => "contatos_setores.setoresidcamp = campus_has_setores.id");
        $wherePhones = array("campus_has_setores.id" => 1, "contatos_setores.visiblepage" => 1);
        $phones = $this->Painelsite->where($filedPhones, $tablePhones, $dataJoinPhones, $wherePhones)->result();

        $data = array(
            'head' => array(
                'title' => 'Trabalhe Conosco - ' . $dataCampus->city,
            ),
            'conteudo' => 'uni_trabalheConosco/inicio',
            'menu' => '',
            'footer' => '',
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'idativo' => '$idativo',
                'localidades' => $localidades,
                'conteudoPag' => $conteudoPrincipal,
                'vagasAbertas' => $vagasAbertas,
                'contatos' => $phones,
            ),
        );
        $this->load->view('templates/master', $data);
    }

    public function envioCurriculo($uricampus = null, $vaga = null)
    {

        if ($uricampus == null) {
            redirect("");
        }
        $dataCampus = $this->bancosite->where('*', 'campus', null, array('shurtName' => $uricampus, 'visible' => 'SIM'))->row();
        $this->load->helper('file');

        $this->form_validation->set_rules('name', 'Nome', 'required|ucfirst');
        $this->form_validation->set_rules('email', 'E-mail', 'required');
        $this->form_validation->set_rules('gender', 'Gênero', 'required');
        $this->form_validation->set_rules('areacodecelphone', 'Código de Àrea', 'required');
        $this->form_validation->set_rules('celphone', 'Telefone', 'required');

        if ($this->input->post('schoolingid') == '0') {
            $this->form_validation->set_rules('schoolingid', 'Escolaridade', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar sua escolaridade.');
        } else {
            $this->form_validation->set_rules('schoolingid', 'Escolaridade');
        }

        $this->form_validation->set_rules('address', 'Endereço', 'required');
        $this->form_validation->set_rules('city', 'Cidade', 'required');

        if ($this->input->post('state') == '0') {
            $this->form_validation->set_rules('state', 'Estado', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar um estado (UF).');
        } else {
            $this->form_validation->set_rules('state', 'Estado');
        }

        if ($vaga == 1) {

            if ($this->input->post('campusid') == '0') {
                $this->form_validation->set_rules('campusid', 'Campus', 'select_validate');
                $this->form_validation->set_message('select_validate', 'Você precisa selecionar um local/Campus para envio do seu currículo.');
            } else {
                $this->form_validation->set_rules('campusid', 'Campus');
            }
            $this->form_validation->set_rules('typeResume', 'Tipo de Currículo', 'required');
        }

        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }

        if ($this->form_validation->run() == false) {
            if (validation_errors()) {
                setMsg(validation_errors(), 'error');
            }
        } else {

            $path = 'assets/files/trabalheConosco/panel/resume';
            $name_tmp = preg_replace(array(
                "/(á|à|ã|â|ä)/",
                "/(Á|À|Ã|Â|Ä)/",
                "/(é|è|ê|ë)/",
                "/(É|È|Ê|Ë)/",
                "/(í|ì|î|ï)/",
                "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/",
            ), explode(" ", "a A e E i I o O u U n N"), $this->input->post('name'));
            $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', "’");

            // matriz de saída
            $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

            // devolver a string
            $name_tmp = str_replace($what, $by, $name_tmp);

            $upload = $this->bancosite->do_uploadFiles('files', $path, $types = 'pdf', $name_tmp);

            if ($upload) {

                $dadosForm = elements(array('name', 'email', 'gender', 'areacodecelphone', 'celphone', 'schoolingid', 'address', 'city', 'state'), $this->input->post());

                $dadosForm['campusid'] = ($vaga == 1) ? $this->input->post('campusid') : $this->bancosite->getWhere('resume_job_vacancy', array('id' => $vaga))->row()->campusid;
                $dadosForm['vacancyid'] = ($vaga != 1) ? $vaga : 1;

                $dadosForm['files'] = $path . '/' . $upload['file_name'];

                $dadosForm['whatsapp'] = $this->input->post('whatsapp');

                if (!empty($dadosForm['whatsapp'])) {
                    $dadosForm['whatsapp'] = $this->input->post('whatsapp');
                } else {
                    $dadosForm['whatsapp'] = null;
                }

                //$dadosForm['whatsapp'] = !empty($this->input->post('whatsapp')) ? $this->input->post('whatsapp') : null;

                if (!empty($dadosForm['areacode'])) {
                    $dadosForm['areacode'] = $this->input->post('areacode');
                } else {
                    $dadosForm['areacode'] = null;
                }
                //$dadosForm['areacode'] = !empty($this->input->post('areacode')) ? $this->input->post('areacode') : null;

                if (!empty($dadosForm['phone'])) {
                    $dadosForm['phone'] = $this->input->post('phone');
                } else {
                    $dadosForm['phone'] = null;
                }

                // $dadosForm['phone'] = !empty($this->input->post('phone')) ? $this->input->post('phone') : null;

                setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
                date_default_timezone_set('America/Sao_Paulo');

                $this->load->library('email');

                //Inicia o processo de configuração para o envio do email
                $config['protocol'] = 'mail'; // define o protocolo utilizado
                $config['wordwrap'] = true; // define se haverá quebra de palavra no texto
                $config['validate'] = true; // define se haverá validação dos endereços de email
                $config['mailtype'] = 'html';
                $config['newline'] = '\r\n';
                $config['charset'] = 'utf-8';

                $this->email->initialize($config);

                $mensagem = '<style type="text/css">
    @media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:14px!important; line-height:150%!important } h1 { font-size:26px!important; text-align:center; line-height:120%!important } h2 { font-size:24px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:26px!important } h2 a { font-size:24px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:13px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:13px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:13px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:11px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:14px!important; display:block!important; border-left-width:0px!important; border-right-width:0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
    #outlook a {
        padding:0;
    }
    .ExternalClass {
        width:100%;
    }
    .ExternalClass,
    .ExternalClass p,
    .ExternalClass span,
    .ExternalClass font,
    .ExternalClass td,
    .ExternalClass div {
        line-height:100%;
    }
    .es-button {
        mso-style-priority:100!important;
        text-decoration:none!important;
    }
    a[x-apple-data-detectors] {
        color:inherit!important;
        text-decoration:none!important;
        font-size:inherit!important;
        font-family:inherit!important;
        font-weight:inherit!important;
        line-height:inherit!important;
    }
    .es-desk-hidden {
        display:none;
        float:left;
        overflow:hidden;
        width:0;
        max-height:0;
        line-height:0;
        mso-hide:all;
    }
    .es-button-border:hover a.es-button {
        background:#3498db!important;
        border-color:#3498db!important;
    }
    .es-button-border:hover {
        border-color:#42d159 #42d159 #42d159 #42d159!important;
        background:#3498db!important;
    }
</style>
<div style="width:100%;font-family:roboto,    helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
    <div class="es-wrapper-color" style="background-color:#F6F6F6;">
        <!--[if gte mso 9]>
                             <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                                     <v:fill type="tile" color="#f6f6f6"></v:fill>
                             </v:background>
                     <![endif]-->
        <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;">
            <tr style="border-collapse:collapse;">
                <td valign="top" style="padding:0;Margin:0;">
                    <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                        <tr style="border-collapse:collapse;">
                            <td align="center" style="padding:0;Margin:0;">
                                <table bgcolor="transparent" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;">
                                    <tr style="border-collapse:collapse;">
                                        <td align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px;">
                                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">

                                            </table></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                    <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                        <tr style="border-collapse:collapse;">
                            <td align="center" style="padding:0;Margin:0;">
                                <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;" width="600" cellspacing="0" cellpadding="0" bgcolor="transparent" align="center">
                                    <tr style="border-collapse:collapse;">
                                        <td style="Margin:0;padding-top:15px;padding-bottom:15px;padding-left:20px;padding-right:20px;background-position:center bottom;" align="left">
                                            <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                <tr style="border-collapse:collapse;">
                                                    <td width="560" valign="top" align="center" style="padding:0;Margin:0;">
                                                        <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                            <tr style="border-collapse:collapse;">
                                                                <td align="center" style="padding:0;Margin:0;"><img src="http://www.atenas.edu.br/uniatenas/assets/images/logoUniatenas.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="189"></td>
                                                            </tr>
                                                        </table></td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                    <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                        <tr style="border-collapse:collapse;">
                            <td align="center" style="padding:0;Margin:0;">
                                <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;" width="600" cellspacing="0" cellpadding="0" bgcolor="transparent" align="center">
                                    <tr style="border-collapse:collapse;">
                                        <td style="padding:0;Margin:0;padding-bottom:20px;background-position:center top;" align="left">
                                            <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                <tr style="border-collapse:collapse;">
                                                    <td width="600" valign="top" align="center" style="padding:0;Margin:0;">
                                                        <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-position:center bottom;background-color:#FFFFFF;border-radius:5px;" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                                            <tr style="border-collapse:collapse;">
                                                                <td align="left"  class="es-m-txt-l" style="Margin:0;padding-bottom:5px;padding-top:20px;padding-left:20px;padding-right:20px;"><h2 style="Margin:0;line-height:26px;mso-line-height-rule:exactly;font-family:roboto,    helvetica, arial, sans-serif;font-size:22px;font-style:normal;font-weight:normal;color:#3F3D3D;">Olá ' . $dadosForm['name'] . ',</h2></td>
                                                            </tr>
                                                            <tr style="border-collapse:collapse;">
                                                                <td align="center" style="Margin:0;padding-bottom:5px;padding-top:10px;padding-left:20px;padding-right:20px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:roboto,    helvetica, arial, sans-serif;line-height:21px;color:#3F3D3D;">


                                                                <img style="width: 700px;" src="http://www.atenas.edu.br/uniatenas/assets/images/uploads/img-email.png" >
                                                                </td>
                                                            </tr>
                                                            <tr style="border-collapse:collapse;">

                                                                <td align="center" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px;"><span class="es-button-border" style="border-style:solid;border-color:#2CB543;background:#31CB4B none repeat scroll 0% 0%;border-width:0px;display:inline-block;border-radius:7px;width:auto;">

                                                                </span>

                                                                </td>

                                                            </tr>
                                                        </table></td>

                                                        <p>Esta é uma mensagem automática, favor não responder este e-mail.<br/></p>
                                                </tr>
                                            </table>
                                            </td>

                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                    <table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top;">
                        <tr style="border-collapse:collapse;">
                            <td align="center" style="padding:0;Margin:0;">
                                <table class="es-footer-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;" width="600" cellspacing="0" cellpadding="0" bgcolor="rgba(0, 0, 0, 0)" align="center">
                                    <tr style="border-collapse:collapse;">
                                        <td style="Margin:0;padding-top:5px;padding-bottom:20px;padding-left:20px;padding-right:10px;background-position:center top;background-color:transparent;" bgcolor="transparent" align="left">
                                            <!--[if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="270" valign="top"><![endif]-->
                                            <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;">
                                                <tr style="border-collapse:collapse;">
                                                    <td width="520" valign="top" align="center" style="padding:0;Margin:0;">

                          </td>
                                                </tr>
                                            </table>

                                            <!--[if mso]></td></tr></table><![endif]--></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                        <tr style="border-collapse:collapse;">
                            <td align="center" style="padding:0;Margin:0;">
                                <table bgcolor="transparent" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;">
                                    <tr style="border-collapse:collapse;">
                                        <td align="left" style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;background-position:left top;">
                                            <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">

                                            </table>
                                        </td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
        </table>
    </div>
</div>';

                $assunto = 'Inscrição - Trabalhe Conosco Site Uniatenas';

                $this->email->from('resposta@uniatenas.edu.br', 'Trabalhe conosco - UniAtenas'); //quem mandou
                $this->email->to($dadosForm['email']);

                $this->email->subject($assunto);
                $this->email->message($mensagem);

                if ($this->email->send()) {
                    $this->bancosite->salvar('resume', $dadosForm);
                    $this->email->clear();

                    $this->email->from('resposta@uniatenas.edu.br', 'Trabalhe Conosco'); //quem mandou
                    $this->email->to('rh.estrategico@uniatenas.edu.br');

                    $this->email->subject($assunto);
                    $arquivoPDF = $dadosForm['files'];

                    if ($dadosForm['campusid'] == 1) {
                        $campusName = 'Paracatu';
                    } elseif ($dadosForm['campusid'] == 2) {
                        $campusName = 'Sete Lagoas';
                    } elseif ($dadosForm['campusid'] == 1) {
                        $campusName = 'Passos';
                    } elseif ($dadosForm['campusid'] == 99) {
                        $campusName = " Qualquer campus que tenha vaga";
                        $campusName = " Qualquer campus que tenha vaga";
                    }

                    date_default_timezone_set('America/Sao_Paulo');

                    $mensagemRH = "<p>O(A) Sr.(a) " .
                        "<b>" . $dadosForm['name'] . "</b> fez contato pelo site, interessado em trabalhar conosco." . "<br/>" .
                        "Email: " . $dadosForm['email'] . "<br/>" .
                        "Celular/ Telefone: (" . $dadosForm['areacodecelphone'] . ")" . $dadosForm['celphone'] . " -  (" . $dadosForm['areacode'] . ") " . $dadosForm['phone'] . " <br/>" .
                        "Endereço: " . $dadosForm['address'] . ", " . $dadosForm['city'] . " - " . $dadosForm['state'] . " <br/>" .
                        "Curriculo PDF: " . "<a href='http://www.atenas.edu.br/uniatenas/$arquivoPDF'>Ver arquivo.</a>" .
                        "Interessado no Campus : " . $campusName . "<br/>";

                    $this->email->message($mensagemRH);

                    $this->email->send();
                    $this->email->clear();

                    setMsg('<p>Cadastro realizado com sucesso! <br>
                        Enviamos um email, em sua caixa postal, com as informações a respeito do seu cadastro.</p>', 'success');
                    redirect(current_url());
                } else {
                    setMsg('<p>Erro! Infelismente, houve um erro. Você pode tentar novamente mais tarde, ou nos enviar uma mensagem para faleconosco@atenas.edu.br </p>', 'error');
                    redirect(current_url());
                }
            } else {
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }
        }

        $localidades = $this->bancosite->getAll('campus')->result();
        $escolaridades = $this->bancosite->getWhere('resume_schooling')->result();
        $areasAtuacaoDocente = $this->bancosite->getWhere('resume_sector_area', array('type' => 'areas', 'situacao' => '1'))->result();
        $areasAtuacaoTecnico = $this->bancosite->getWhere('resume_sector_area', array('type' => 'setor', 'situacao' => '1'))->result();

        if (!empty($vaga)) {
            $queryVacancy = "
                        SELECT
                        resume_job_vacancy.id,
                        resume_job_vacancy.name,
                        resume_job_vacancy.files,
                        campus.id as campusid,
                        campus.name as campus_name,
                        resume_sector_area.id as id_area,
                        resume_sector_area.name as name_area
                    FROM
                        at_site.resume_job_vacancy
                    inner join campus on campus.id = resume_job_vacancy.campusid
                    inner join resume_sector_area on resume_sector_area.id = resume_job_vacancy.sectorareaid
                    where resume_job_vacancy.id = 9
                    ";

            $infoVaga = $this->bancosite->getQuery($queryVacancy)->row();
        } else {
            $infoVaga = '';
        }

        $data = array(
            'head' => array(
                'title' => 'Trabalhe Conosco',
            ),
            'conteudo' => 'uni_trabalheConosco/envioCurriculo',
            'menu' => '',
            'footer' => '',
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'idativo' => '$idativo',
                'localidades' => $localidades,
                'escolaridades' => $escolaridades,
                'infoVaga' => $infoVaga,
                'areasAtuacaoDocente' => $areasAtuacaoDocente,
                'areasAtuacaoTecnico' => $areasAtuacaoTecnico,
            ),
        );
        $this->load->view('templates/master', $data);
    }

    public function informanapp($uricampus = null)
    {

        if ($uricampus == null) {
            redirect("");
        }
        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $dataCampus->city))->row();

        $data = array(
            'head' => array(
                'title' => 'Napp ',
            ),
            'conteudo' => 'templates/envionapp',
            'dados' => array(
                'campus' => $dataCampus,
            ),
            'js' => null,
            'footer' => '',
        );
        $this->load->view('templates/master', $data);
    }

    /* ------------------------------------------------------------
    --------------              Comunicados
    ------------------------------------------------------------ */

    public function comunicados($uricampus = null)
    {
        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $dataCampus->city))->row();

        $data = array(
            'head' => array(
                'title' => 'Processo Seletivo ',
            ),
            'conteudo' => 'uniatenas/comunicados/processoSeletivo',
            'dados' => array(
                'campus' => $dataCampus,
            ),
            'js' => null,
            'footer' => '',
        );
        $this->load->view('templates/master', $data);
    }

    public function processoSeletivo($uricampus = null)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $dataCampus->city))->row();

        $data = array(
            'head' => array(
                'title' => 'Processo Seletivo ',
            ),
            'conteudo' => 'uniatenas/comunicados/processoSeletivo',
            'dados' => array(
                'campus' => $dataCampus,
            ),
            'js' => null,
            'footer' => '',
        );
        $this->load->view('templates/master', $data);
    }

    /* ------------------------------------------------------------
    --------------              Telefones uteis
    ------------------------------------------------------------ */

    public function telefones($uricampus = 'paracatu')
    {

        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $dataCampus->city))->row();

        $field = array('contatos_setores.id', 'contatos_setores.responsible', 'contatos_setores.ramal', 'contatos_setores.phone', 'setores.nome');
        $table = 'contatos_setores';
        $datajoin = array(
            'campus_has_setores' => 'contatos_setores.setoresidcamp = campus_has_setores.id ',
            'setores' => 'campus_has_setores.setores_id = setores.id',
        );
        $where = array('campus_id ' => $dataCampus->id, "contatos_setores.status" => 1);
        $order["campo"] = "setores.nome";
        $order["ordem"] = "ASC";

        $phones = $this->Painelsite->where($field, $table, $datajoin, $where, $order)->result();
        $i = 0;
        $result = array();
        foreach ($phones as $phone) {
            $result[$i] = array($phone->id, $phone->responsible, $phone->nome, $phone->phone, $phone->ramal);
            $i++;
        }

        $data = array(
            'head' => array(
                'title' => 'telefones uteis ',
            ),
            'conteudo' => 'uniatenas/telefones/phone',
            'menu' => '',
            'footer' => '',
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'phones' => $result,
            ),
            'js' => null,
            'footer' => '',
        );
        $this->load->view('templates/master', $data);
    }
}
