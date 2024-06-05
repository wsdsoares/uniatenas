<?php

defined('BASEPATH') or exit('No direct script access allowed');

class EstagiosConvenios extends CI_Controller
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
        $this->inicio();
    }

    public function inicio($uricampus)
    {
        if ($uricampus == null) {
            redirect("");
        }

        $colunasCampus = array('campus.id', 'campus.name', 'campus.city', 'campus.uf', 'campus.shurtName');
        $dataCampus = $this->bancosite->where($colunasCampus, 'campus', NULL, array('campus.shurtName' => $uricampus))->row();

        $pages_content = $this->bancosite->where('*', 'pages', null, array('title' => 'estagiosConvenios', 'campusid' => $dataCampus->id))->row();
        $conteudoPrincipal =  $this->bancosite->getQuery("SELECT * FROM page_contents where page_contents.pages_id = $pages_content->id and page_contents.order <>'contatos' and page_contents.status=1 order by page_contents.order ASC")->result();
        $conteudoContato = $this->bancosite->getQuery("SELECT * FROM page_contents where page_contents.pages_id = $pages_content->id and page_contents.order ='contatos' and page_contents.status=1")->result();

        $sqlVagas = "SELECT 
                internship_companies.id as idcompany, 
                internship_companies.name as namecompany, 
                internship_city.name as namecity
                
            FROM
                at_site.internship_companies
            inner join internship_city on internship_city.id = internship_companies.cityid";
        $empresasEstagio = $this->bancosite->getQuery($sqlVagas)->result();


        $data = array(
            'head' => array(
                'title' => "Estágio e Convênios $dataCampus->name $dataCampus->city ($dataCampus->uf)",
            ),
            'conteudo' => "uniatenas/estagioseconvenios/inicio",
            'js' => NULL,
            'footer' => array(),

            'dados' => array(
                'city' => $dataCampus->city,
                'campus' => $dataCampus,
                'conteudoPag' => $conteudoPrincipal,
                'contatosPagina' => $conteudoContato,
                'dadosEstagio' => array(
                    'empresas' => $empresasEstagio,
                    'vagasEstagio' => $this->bancosite->getWhere('internship_vacancy', array('status' => 1))->result(),
                )

            )
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }

    public function inicio2($uricampus = NULL, $course = NULL)
    {

        if ($uricampus == 'paracatu') {
            $city = "Paracatu";
        } elseif ($uricampus == 'passos') {
            $city = "Passos";
        } elseif ($uricampus == 'setelagoas') {
            $city = "Sete Lagoas";
        } elseif ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $city))->row();


        $page = $this->bancosite->getWhere('pages', array('title' => 'estagiosEconvenios', 'campusid' => $dataCampus->id))->row();

        $consulta = "SELECT 
                            *
                        FROM
                            at_site.page_contents
                        where page_contents.order like 'texto%'
                        and pages_id = $page->id
                                ";


        $pages_content = $this->bancosite->getQuery($consulta)->result();


        $sql = "SELECT 
                internship_companies.id as idcompany, 
                internship_companies.name as namecompany, 
                internship_city.name as namecity
                
            FROM
                at_site.internship_companies
            inner join internship_city on internship_city.id = internship_companies.cityid";
        $empresasEstagio = $this->bancosite->getQuery($sql)->result();

        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'page_contents.order' => 'description'))->result();

        $filedPhones = array("contacts.phone", "contacts.ramal", "contacts.visiblepage", "contacts.email", "contacts.phonesetor");
        $tablePhones = "campus_has_setores";
        $dataJoinPhones = array("contacts" => "contacts.setoresidcamp = campus_has_setores.id");
        $wherePhones = array("campus_has_setores.id" => $page->setorcampid, "contacts.visiblepage" => 1);
        $phones = $this->Painelsite->where($filedPhones, $tablePhones, $dataJoinPhones, $wherePhones)->result();


        $data = array(
            'head' => array(
                'title' => 'Estágios e Convênios - UniAtenas'
            ),
            'conteudo' => "uniatenas/estagioseconvenios/inicio",
            'js' => NULL,
            'footer' => array(
                //'specific_JS' => 'assets/plugins/lightbox/dist/js/lightbox-plus-jquery.js',
            ),

            'dados' => array(
                'conteudo' => $pages_content,
                'conteudoPag' => $conteudoPrincipal,
                'campus' => $dataCampus,
                'contatos' => $phones,
                'dadosEstagio' => array(
                    'empresas' => $empresasEstagio,
                    'vagasEstagio' => $this->bancosite->getWhere('internship_vacancy', array('status' => 1))->result(),
                )
            )
        );

        //echo "<script>alert('$course')</script>";
        $this->output->cache(4320);
        $this->load->view('templates/master', $data);
    }
}
