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

    public function inicio($campus)
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
        $pages_content = $this->bancosite->getWhere('pages', array('title' => 'financeiro','campusid'=>$dataCampus->id))->row();
        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $pages_content->idpages),array('campo'=>'order','ordem'=>'ASC'))->result();


        $filedPhones = array("contatos_setores.phone", "contatos_setores.ramal", "contatos_setores.visiblepage", "contatos_setores.email", "contatos_setores.phonesetor");
        $tablePhones = "campus_has_setores";
        $dataJoinPhones = array("contatos_setores" => "contatos_setores.setoresidcamp = campus_has_setores.id");
        $wherePhones = array("campus_has_setores.id" => $pages_content->setorcampid, "contatos_setores.visiblepage" => 1);
        $phones = $this->Painelsite->where($filedPhones, $tablePhones, $dataJoinPhones, $wherePhones)->result();

        $data = array(
            'head' => array(
                'title' => 'Financeiro - UniAtenas '.$city,
                
            ),
            'conteudo' => "uniatenas/financeiro/index",
            'js' => NULL,
            'footer' => array(
                
            ),

            'dados' => array(
                'city'=>$city,
                'campus' => $dataCampus,
                'camp' => $this->bancosite->getWhere('campus', array('city' => $city))->row(),
                'conteudoPag' => $conteudoPrincipal,
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
    