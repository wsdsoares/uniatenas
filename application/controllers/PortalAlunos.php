<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PortalAlunos extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
        $this->load->model('Site_model', 'bancosite');
    }

    public function index()
    {
        $this->portal();
    }

    public function portal($campus)
    {
        if ($campus == null) {
            redirect("");
        }
        $dataCampus = $this->bancosite->where('*', 'campus', NULL, array('shurtName' => $campus))->row();
        $page = $this->bancosite->where(array('pages.id'), 'pages', null, array('title' => 'portalalunos', 'campusid' => $dataCampus->id))->row();

        $queryItensPortalAcademico = "
        SELECT 
          page_contents.id,
          page_contents.title,
          page_contents.img_destaque,
          page_contents.link_redir,
          page_contents.status,
          page_contents.order
        FROM
          page_contents
          JOIN pages ON pages.id = page_contents.pages_id
          JOIN campus ON campus.id = pages.campusid
        WHERE
          page_contents.pages_id = $page->id AND 
          page_contents.status = 1 AND 
          page_contents.img_destaque NOT LIKE '%/<%' AND
          page_contents.img_destaque != '' AND
          page_contents.tipo = 'informacoesPagina' 
        ORDER BY page_contents.order
        ";
        // $pages_content = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'status' => 1))->result();
        $pages_content = $this->bancosite->getQuery($queryItensPortalAcademico)->result();

        $colunasResultadoLinksUteis = array('page_contents.id', 'page_contents.title', 'page_contents.link_redir', 'page_contents.status', 'page_contents.pages_id');
        $whereLinksUteis = array('page_contents.pages_id' => $page->id, 'page_contents.status' => 1, 'page_contents.order' => 'linksUteis', 'page_contents.tipo' => 'linksUteis');
        $conteudoLinksUteis = $this->bancosite->where($colunasResultadoLinksUteis, 'page_contents', null, $whereLinksUteis)->result();

        $colunasResultadoAcessoRapido = array('page_contents.id', 'page_contents.title', 'page_contents.link_redir', 'page_contents.status', 'page_contents.pages_id');
        $whereAcessoRapido = array('page_contents.pages_id' => $page->id, 'page_contents.status' => 1, 'page_contents.order' => 'linksUteis', 'page_contents.tipo' => 'acessoRapido');
        $conteudoAcessoRapido = $this->bancosite->where($colunasResultadoAcessoRapido, 'page_contents', null, $whereAcessoRapido)->result();

        $horasComplementares = $this->bancosite->getWhere('files', array('campusid' => $dataCampus->id, 'typesfile' => 'cartilha'))->row();
        $data = array(
            'head' => array(
                'title' => 'Portal Acadêmico',
            ),
            'conteudo' => 'uniatenas/portalAlunos/portal',
            'menu' => '',
            'footer' => '',
            'js' => null,

            'dados' => array(
                'campus' => $dataCampus,
                'conteudoAcessoRapido' => $conteudoAcessoRapido = isset($conteudoAcessoRapido) ? $conteudoAcessoRapido : '',
                'conteudoLinksUteis' => $conteudoLinksUteis = isset($conteudoLinksUteis) ? $conteudoLinksUteis : '',
                'horasComplementares' => $horasComplementares = isset($horasComplementares) ? $horasComplementares : '',
                'conteudoPag' => $pages_content,

                // 'horasComplementares' => $horasComplementares,

                'localidades' => ''
            )
        );
        $this->output->cache(14400);
        if ($campus == 'valenca') {
            $this->load->view('templates/mastervale', $data);
        } else {
            $this->load->view('templates/master', $data);
        }
    }

    public function portalinterno($campus)
    {
        if (empty($campus)) {
            $this->portal();
        }
        $local = $this->bancosite->getAll('campus', $campus)->row();

        $colunaResultadoLinksUteisPaginaSecretaria = array(
            'page_contents.id',
            'page_contents.title',
            'page_contents.status',
            'page_contents.link_redir',
            'page_contents.created_at',
            'page_contents.updated_at',
            'page_contents.user_id',
        );
        $joinConteudoLinksUteisPaginaSecretaria = array(
            'pages' => 'pages.id = page_contents.pages_id',
            'campus' => 'campus.id= pages.campusid'
        );
        $whereLinksUteisPaginaSecretaria = array(
            'page_contents.pages_id' => $pagina->id,
            'page_contents.order' => 'linksUteis'

        );

        $listaLinksUteisPaginaSecretaria = $this->painelbd->where($colunaResultadoLinksUteisPaginaSecretaria, 'page_contents', $joinConteudoLinksUteisPaginaSecretaria, $whereLinksUteisPaginaSecretaria, array('campo' => 'title', 'ordem' => 'asc'))->result();


        $cartilhas = "SELECT 
                    files.id,
                    files.campusid,
                    files.typesfile,
                    (select campus.name from campus where campus.id = files.campusid) as namecampus,
                    (select campus.city from campus where campus.id = files.campusid) as cidadecampus,
                    files.name, 
                    files.files,
                    pages.id,
                    pages.title

                FROM
                    files_has_pages
                    inner join files on files.id = files_has_pages.filesid
                    inner join pages on pages.id = files_has_pages.pagesid
                WHERE pages.title='portalinterno'
                    AND files.typesfile='cartilha'";

        $filesArray =
            array(
                'cartilha' => $this->bancosite->getQuery($cartilhas)->row(),
            );
        $data = array(
            'head' => array(
                'title' => 'Portal dos alunos - UniAtenas',
            ),
            'conteudo' => 'uniatenas/portalAlunos/portalinterno',
            'menu' => '',
            'footer' => '',
            'js' => null,
            'dados' => array(
                'campus' => $local,
                'filesarray' => $filesArray,
                'idativo' => '$idativo',
                'localidades' => ''
            )
        );
        $this->load->view('templates/master', $data);
    }

    public function informativoCampus($campus)
    {

        if ($campus == null) {
            redirect("");
        }

        // if($campus =='paracatu'){
        //     $city = "Paracatu";
        // }elseif($campus =='passos'){
        //     $city = "Passos";
        // }elseif($campus =='setelagoas'){
        //     $city = "Sete Lagoas";
        // }elseif($campus =='valenca'){
        //     $city = "Valenca";

        // }

        $dataCampus = $this->bancosite->getWhere('campuss', array('city' => $city))->row();

        //$campus = $this->bancosite->getWhere("campus", array('id'=>$campusid))->row();


        $data = array(
            'head' => array(
                'title' => 'Portal dos alunos - UniAtenas',
            ),
            'conteudo' => 'uniatenas/portalAlunos/informativoCampus',
            'menu' => '',
            'footer' => '',
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'filesarray' => '',
                'idativo' => '$idativo',
                'localidades' => ''
            )
        );
        $this->load->view('templates/master', $data);
    }
}
