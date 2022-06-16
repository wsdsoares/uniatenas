<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class ProcessoSeletivo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        verificaLogin();
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('site_model', 'bancosite');
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function index() {
        $this->inscricoesEad();
    }

    public function insricoesEad() {
        $page = 'ListaInscricoes';
        $aql = "SELECT 
                    *
                FROM 
                    inscricoesSite
                WHERE
                    tipo='eadUniatenas'
                 order by data_contato desc
                ";
        $dados = $this->painelbd->getQuery($aql)->result();
        $data = array(
            'titulo' => 'Início',
            'conteudo' => 'paineladm/itensProcessoSeletivo/inscricoesEad',
            'dados' => array(
                'inscricoesEad' => $dados,
                'tipo' => 'revistas')
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

   
}
