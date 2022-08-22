<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Financeiro extends CI_Controller
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
        redirect('financiamentos/inicio');

    }

    public function inicio($uricampus)
    {
        if ($uricampus == null) {
            redirect("");
        }

        $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf','campus.shurtName');
        $dataCampus = $this->bancosite->where($colunasCampus,'campus',NULL, array('campus.shurtName'=>$uricampus))->row();

        $pages_content = $this->bancosite->where('*','pages', null, array('title' => 'financeiro','campusid'=>$dataCampus->id))->row();
        // $conteudoPrincipal = $this->bancosite->where("*",'page_contents', null, array('pages_id' => $pages_content->id),array('campo'=>'order','ordem'=>'ASC'))->result();
        $conteudoPrincipal =  $this->bancosite->getQuery("SELECT * FROM page_contents where page_contents.pages_id = $pages_content->id and page_contents.order <>'contatos' and page_contents.status=1 order by page_contents.order ASC")->result();

        //$conteudoContato = $this->bancosite->where("*",'page_contents', null, array('pages_id' => $pages_content->id,'order'=>'contatos'),array('campo'=>'order','ordem'=>'ASC'))->result();
        $conteudoContato = $this->bancosite->getQuery("SELECT * FROM page_contents where page_contents.pages_id = $pages_content->id and page_contents.order ='contatos' and page_contents.status=1")->result();

        $filedPhones = array("contatos_setores.phone", "contatos_setores.ramal", "contatos_setores.visiblepage", "contatos_setores.email", "contatos_setores.phonesetor");
        $tablePhones = "campus_has_setores";
        $dataJoinPhones = array("contatos_setores" => "contatos_setores.setoresidcamp = campus_has_setores.id");
        $wherePhones = array("campus_has_setores.id" => $pages_content->setorcampid, "contatos_setores.visiblepage" => 1);
        $phones = $this->Painelsite->where($filedPhones, $tablePhones, $dataJoinPhones, $wherePhones)->result();

        $data = array(
            'head' => array(
                'title' => "Financeiro $dataCampus->name $dataCampus->city ($dataCampus->uf)",
            ),
            'conteudo' => "uniatenas/financeiro/index",
            'js' => NULL,
            'footer' => array(),

            'dados' => array(
                'city'=>$dataCampus->city,
                'campus' => $dataCampus,
                'camp' => $this->bancosite->getWhere('campus', array('city' => $dataCampus->city))->row(),
                'conteudoPag' => $conteudoPrincipal,
                'contatosPagina' => $conteudoContato,
                'contatos' => $phones,
            )
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }

    public function pagina($campus,$id)
    {
        if($campus == null){
            redirect("");
        }
        if ($campus == 'paracatu') {
            $city = "Paracatu";
        } elseif ($campus == 'passos') {
            $city = "Passos";
        } elseif ($campus == 'setelagoas') {
            $city = "Sete Lagoas";
        }

        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $city))->row();
        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('id' => $id))->row();

        $data = array(
            'head' => array(
                'title' => 'Financeiro - UniAtenas'.$city,
                'css' => base_url('assets/css/financing.css')
            ),
            'conteudo' => "uniatenas/financeiro/pagina",
            'js' => NULL,
            'footer' => array(),
            'dados' => array(
                'campus' => $dataCampus,
                'conteudoPag' => $conteudoPrincipal,
            )
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }
}
    