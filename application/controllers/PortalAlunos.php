<?php

defined('BASEPATH') or exit('No direct script access allowed');

class PortalAlunos extends CI_Controller {

    public function __construct() {
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
        $this->load->model('Site_model', 'bancosite');

    }

    public function index() {
        $this->portal();
    }

    public function portal($campus) {
        if($campus == null){
            redirect("");
        }

        // if($campus =='paracatu'){
        //     $city = "Paracatu";
        // }elseif($campus =='passos'){
        //     $city = "Passos";
        // }elseif($campus =='setelagoas'){
        //     $city = "Sete Lagoas";
        // }elseif($campus =='valenca'){
        //     $city = "Valença";
        // }

        $dataCampus = $this->bancosite->where('*','campus',NULL, array('shurtName' => $campus))->row();
        
        $horasComplementares = $this->bancosite->getWhere('files', array('campusid' => $dataCampus->id, 'typesfile' => 'cartilha'))->row();
        $data = array(
            'head' => array(
                'title' => 'Portal dos alunos - UniAtenas',
            ),
            'conteudo' => 'uniatenas/portalAlunos/portal',
            'menu' => '',
            'footer' => '',
            'js' => null,

            'dados' => array(
                'campus'=>$dataCampus,
                'horasComplementares'=>$horasComplementares,
                'localidades' => '')
        );
        $this->output->cache(14400);
        if($campus =='valenca'){
        $this->load->view('templates/mastervale', $data);
        
        }else{
        $this->load->view('templates/master', $data);
        }
      
        }

    public function portalinterno($campus) {
        if(empty($campus)){
            $this->portal();
        }
        $local = $this->bancosite->getAll('campus',$campus)->row();

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

        $filesArray=
                array(
                    'cartilha'=>$this->bancosite->getQuery($cartilhas)->row(),
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
                'campus'=>$local,
                'filesarray'=>$filesArray,
                'idativo'=>'$idativo',
                'localidades' => '')
        );
        $this->load->view('templates/master', $data);
    }

    public function informativoCampus($campus){

        if($campus == null){
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

        $dataCampus = $this->bancosite->getWhere('campuss', array('city'=>$city))->row();

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
                'campus'=>$dataCampus,
                'filesarray'=>'',
                'idativo'=>'$idativo',
                'localidades' => '')
        );
        $this->load->view('templates/master', $data);

    }

}