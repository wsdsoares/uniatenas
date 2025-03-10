<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vestibular_Results extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Vestibular_model', 'bancoVestibular');
        $this->load->model('Site_model', 'site');
        $this->load->library('M_pdf');

    }

    public function resultFinal($campus = NULL)
    {
        $campus = 1;

        $dadosCandidato = $this->bancoVestibular->getWhere('results', array('cpf' => '01874253617'))->row();
        $hash = $dadosCandidato->posicao . '-' . $dadosCandidato->inscricao . '-2019-09-12' . $dadosCandidato->cpf;
        $vestibular = $this->site->getWhere('vestibular', array('campusid'=>$campus))->row();
        $ip = $_SERVER['REMOTE_ADDR'];
       
        $data = array(
            'dados' => array(
                'titulo' => 'Classificação Resultado Vestibular - Medicina',
                'nomeCandidato' => $dadosCandidato->nome,
                'posicaoCandidato' => $dadosCandidato->posicao,
                'posicaoInscricaoCpf' => $hash,
            )
        );
        $arrayLog = array('candidato' => $dadosCandidato->nome, 'posicao' => $dadosCandidato->posicao, 'cod_autentication' => $hash,'vestibular_id'=>$vestibular->id,'ip'=>$ip);
        $this->bancoVestibular->salvar('logs_vestibular_consulta', $arrayLog);

        //load the view and saved it into $html variable
        $html = $this->load->view('uni_vestibular/results_PDF', $data, true);

        //this the the PDF filename that user will get to download
        $pdfFilePath = $dadosCandidato->nome . ' - Classificação Resultado Vestibular - Medicina' . '.pdf';

        //load mPDF library
        $this->load->library('m_pdf');

        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
    }
}