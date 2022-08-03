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

    public function index()
    {
        redirect('posgraduacao/inicio');
    }

    public function inicio($campus=NULL)
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
        
        $page = $this->bancosite->getWhere('pages', array('title' => 'posgraduacao'))->row();
        $consulta = "SELECT 
                            *
                        FROM
                            at_site.page_contents
                        where page_contents.order like 'texto%'
                        and pages_id = $page->id
                                ";

        $conteudoPrincipal = $this->bancosite->getQuery($consulta)->result();

        $data = array(
            'head' => array(
                'title' => 'Pós-Graduação - UniAtenas '.$city,
                'css' => base_url('assets/css/css_posgraduacao/styleposgraduacao.css')
            ),
            'conteudo' => "uniatenas/posgraduacao/principalPosGraduacao",
            'js' => NULL,
            'footer' => array(),
            'dados' => array(
                'campus'=>$dataCampus,
                'conteudoPag' => $conteudoPrincipal,
            )
        );

        $this->load->view('templates/master', $data);

    }



}
    