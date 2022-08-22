<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Financiamentos extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
        $this->load->model('Site_model', 'bancosite');
    }

    public function index()
    {
        redirect('financiamentos/inicio');

    }

    public function inicio($campus)
    {

        if ($campus == 'paracatu') {
            $city = "Paracatu";
        } elseif ($campus == 'passos') {
            $city = "Passos";
        } elseif ($campus == 'setelagoas') {
            $city = "Sete Lagoas";
        }

        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $city))->row();
        $pages_content = $this->bancosite->getWhere('pages', array('title' => 'financiamentos'))->row();
        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $pages_content->id),array('campo'=>'order','ordem'=>'ASC'))->result();

        $data = array(
            'head' => array(
                'title' => 'Financiamentos - UniAtenas '.$city,
                
            ),
            'conteudo' => "uniatenas/financiamentos/index",
            'js' => NULL,
            'footer' => array(
                
            ),

            'dados' => array(
                'city'=>$city,
                'campus' => $dataCampus,
                'conteudoPag' => $conteudoPrincipal,
            )
        );

        $this->load->view('templates/master', $data);
    }

    public function pagina($campus,$id)
    {
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
                'title' => 'Financiamentos - UniAtenas'.$city,
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
    