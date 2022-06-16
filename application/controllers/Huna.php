<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Huna extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
        $this->load->model('Site_model', 'bancosite');
    }

    public function index()
    {
        redirect('huna/inicio');

    }

    public function inicio($uricamous)
    {
        if($uricamous == null){
            redirect("");
        }
        if ($uricamous == 'paracatu') {
            $city = "Paracatu";
        } elseif ($uricamous == 'passos') {
            $city = "Passos";
        } elseif ($uricamous == 'setelagoas') {
            $city = "Sete Lagoas";
        }



        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $city))->row();

        $pages_content = $this->bancosite->getWhere('pages', array('title' => 'huna','campusid'=> $dataCampus->id))->row();
        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $pages_content->idpages),array('campo'=>'order','ordem'=>'ASC'))->result();

        if ($uricamous == 'paracatu') {
            $categoriafotos = $pages_content->Fk_photosCat;
            $orderby = array('campo'=> 'id','ordem' => 'DESC');
            $fotos = $this->bancosite->getWhere('photos_gallery',array('photoscategoryid' => $categoriafotos),$orderby,4)->result();
        } elseif ($uricamous == 'passos') {
            $fotos = '';
        } elseif ($uricamous == 'setelagoas') {
            $fotos = '';
        }





        /*$filedPhones = array("contacts.phone", "contacts.ramal","contacts.visiblepage","contacts.email","contacts.phonesetor");
        $tablePhones = "campus_has_setores";
        $dataJoinPhones = array("contacts" =>"contacts.setoresidcamp = campus_has_setores.id");
        $wherePhones = array("campus_has_setores.id"=> $page->setorcampid,"contacts.visiblepage" => 1);
        $phones = $this->Painelsite->where($filedPhones,$tablePhones,$dataJoinPhones,$wherePhones)->result();
        Para contatos do hospital
        */

        $data = array(
            'head' => array(
                'title' => 'Huna - UniAtenas',
                
            ),
            'conteudo' => "uniatenas/huna/homeHuna",
            'js' => NULL,
            'footer' => array(
                
            ),

            'dados' => array(
                'city'=>$city,
                'urlcamp'=>$uricamous,
                'campus' => $dataCampus,
                'conteudoPag' => $conteudoPrincipal,
                'fotos' => $fotos,
                'fotosCat' => $pages_content->Fk_photosCat
            )
        );
        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }

    public function pagina($uricampus = null,$id)
    {
        if($uricampus == null){
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
        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('id' => $id))->row();

        $data = array(
            'head' => array(
                'title' => 'Huna - UniAtenas',
                'css' => base_url('assets/css/financing.css')
            ),
            'conteudo' => "uniatenas/financiamentos/pagina",
            'js' => NULL,
            'footer' => array(),
            'dados' => array(
                'campus' => $dataCampus,
                'conteudoPag' => $conteudoPrincipal,
            )
        );

        $this->load->view('templates/master', $data);
    }
}
    