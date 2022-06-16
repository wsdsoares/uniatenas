<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uniatenas extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
        $this->load->model('Site_model', 'bancosite');
    }

    public function index()
    {
        $data = array(
            'head' => array(
                'title' => 'Centro Universitário - Atenas (Grupo Atenas)',
            ),
            'dados' => array(
                'campus' => $this->bancosite->getWhere('campus', array('id' => 1), array('campo' => 'city', 'ordem' => 'asc'))->result()
            ),
            'js' => null,
            'footer' => ''
        );

        $this->load->view('templates/principal', $data);
    }
}