<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Vestibular extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
        $this->load->model('Site_model', 'bancosite');
        $this->load->model('Vestibular_model', 'bancoVestibular');
    }

    public function index()
    {
        redirect("http://www.atenas.edu.br/vestibular");
    }

    public function inicio(){
    
            $fieldsBd = array('vestibular.name as nameVestibular',
                'vestibular.link as link',
                'campus.name as nameCampus' ,
                'campus.id as idCampus',
                'campus.city as cityCampus',
                'vestibular_situation.name as vestibularSituation',
                'vestibular_situation.id as idSituation');
    
            $dataJoin = array(
                'vestibular' => 'vestibular.campusid = campus.id',
                'vestibular_situation' => 'vestibular_situation.id = vestibular.vestibular_situationid'
            ); 
    
            $whereBd = array('vestibular.status'=>1); 
    
            $vestibularSituation = $this->site->where($fieldsBd,'campus',$dataJoin,$whereBd)->result();
    
            $data = array(
                'head' => array(
                    'title' => 'Vestibular - UniAtenas ',
                ),
                'conteudo' => 'home',
                'dados' => array(
                    'campus'=>$this->site->getWhere('campus',array('visible'=>'SIM'), array('campo'=>'id','ordem'=>'asc'))->result(),
                    'situacaoVestibular'=>$vestibularSituation
                ),
                'js' => null,
                'footer' => ''
            );
            $this->load->view('aatemplates/master', $data);
        }
        

    public function resultado_geral(){

        //Infomrmação que vem oculta por meio de um POST do Vestibular.uniatenas.edu.br
        $idCampus = $this->input->post('campus');
        $actionVestibular = $this->input->post('typeSearch');
        $infCandidato = $this->input->post('inputDataVest');





        if (!empty($this->input->post('actionQuery'))) {
            $actionBtnQuery = $this->input->post('actionQuery');
        } else {
            $actionBtnQuery = '';
        }

        $typeQuery = strlen($infCandidato);
        if ($typeQuery == 11) {
            $fieldQuery = 'cpf';
        } else {
            $fieldQuery = 'inscricao';
        }



        if ($idCampus == 1) {
            $tabela = 'paracatu_2021_resultados';
            $resultadosOficiais = count($this->bancoVestibular->getWhere($tabela)->result());
        } elseif ($idCampus == 2) {
            $tabela = 'setelagoas_2021_resultados';
            $resultadosOficiais = count($this->bancoVestibular->getWhere($tabela)->result());
        } elseif ($idCampus == 3) {
            $tabela = 'passos_2021_resultados';
            $resultadosOficiais = count($this->bancoVestibular->getWhere($tabela)->result());
        }elseif ($idCampus == 6) {
            $tabela = 'valenca_2021_resultados';
            $resultadosOficiais = count($this->bancoVestibular->getWhere($tabela)->result());
        }
        


        /*
             * Informações da consulta do vestibular, passadas por variáveis, campo, join e where
             * */
        $fieldsBd = array('vestibular.name as nameVestibular',
            'campus.name as nameCampus',
            'campus.id as idCampus',
            'campus.city as cityCampus',
            'vestibular_situation.name as vestibularSituation', 'vestibular_situation.id as idSituation');
        $dataJoin = array(
            'vestibular' => 'vestibular.campusid = campus.id',
            'vestibular_situation' => 'vestibular_situation.id = vestibular.vestibular_situationid'
        );
        $whereBd = array('vestibular.status' => 1, 'vestibular.campusid' => $idCampus);
        /*fim consulta*/


        /** Consulta de arquivos do resultado final do vestibular - LISTA APROVADOS **/
        $fieldsResult = array('vestibular_files.name', 'vestibular_files.files', 'vestibular_exams_types.title as tipo_prova');
        $dataJoinResult = array(
            'vestibular_files' => 'vestibular_files.vestibularid = vestibular.id',
            'vestibular_exams_types' => 'vestibular_exams_types.id = vestibular_files.typesid'
        );
        $whereFilesResult = array('vestibular.campusid' => $idCampus, 'vestibular_exams_types.id' => '11', 'vestibular_files.status' => 1);
        $whereFilesResultEspera = array('vestibular.campusid' => $idCampus, 'vestibular_exams_types.id' => '12', 'vestibular_files.status' => 1);
        /** fim da consulta* */

        $vestibularSituation = $this->bancosite->where($fieldsBd, 'campus', $dataJoin, $whereBd)->row();

        $filesListaAprovados = $this->bancosite->where($fieldsResult, 'vestibular', $dataJoinResult, $whereFilesResult)->row();
        $filesListaEspera = $this->bancosite->where($fieldsResult, 'vestibular', $dataJoinResult, $whereFilesResultEspera)->row();

        $whereEssay = array($tabela, $tabela . '.ano' => '2021', $tabela . '.' . $fieldQuery => $infCandidato);
        $essay = $this->bancoVestibular->where('*', $tabela, null, $whereEssay)->row();

        if (!empty($essay) and $essay->status == 2) {

            $this->form_validation->set_rules('inputDataVest', 'required', $essay->justificativa);
            if ($this->form_validation->run() == false) {
                if (validation_errors()) :
                    setMsg(validation_errors(), 'error');
                endif;
            }
        } else {

            if ($actionBtnQuery != '') {
                if (empty($infCandidato)) {
                    $this->form_validation->set_rules('inputDataVest', 'CPF ou INSCRIÇÃO', 'required');
                    $this->form_validation->set_message('required', 'Você precisa preencher as informações. O campo não pode ser vazio.');
                } elseif ($essay == NULL) {
                    $this->form_validation->set_rules('inputDataVest', 'required', 'Não encontramos nenhuma informação para o CPF e/ou Nº. de Inscrição digitados.');
                } else {
                    $this->form_validation->set_rules('inputDataVest', 'CPF ou INSCRIÇÃO', 'required|numeric|max_length[11]|integer|is_natural_no_zero');
                }

                if ($this->form_validation->run() == false) {
                    if (validation_errors()) :
                        setMsg(validation_errors(), 'error');
                    endif;
                } else {
                    $this->resultFinal($essay->cpf, $idCampus, $tabela, $actionVestibular);
                }
            }
        }
  

        $dadosCampus = $this->bancosite->where('*', 'campus', null, array('id' => $idCampus))->row();

        $data = array(
            'head' => array(
                'title' => 'Vestibular 2021 - Medicina',
            ),
            'conteudo' => 'uni_vestibular/results',
            'js' => 'js_result',
            'footer' => '',
            'menu' => NULL,
            'dados' => array(
                'idCampus' => $idCampus,
                'acaoVestibular' => $actionVestibular,
                'situacaoVestibular' => $vestibularSituation,
                'campus' => $dadosCampus,
                'fileListaAprovados' => $filesListaAprovados,
                'fileListaEspera' => $filesListaEspera,
                'resultadosOficiais' => $resultadosOficiais

            )
        );

        $this->load->view('templates/vestibular/master', $data);
    }

    
  
    

    public function resultado()
    {
        $data = array(
            'head' => array(
                'title' => 'Vestibular 2021 - UniAtenas',
            ),
            'conteudo' => 'uni_vestibular/resultado',
            'js' => 'js_result',
            'footer' => '',
            'menu' => NULL,
            'dados' => array(
                'idCampus' => 1,
                'local' => 'Valenca',
                'campus' => 'Faculdade Atenas'
            )
        );

        $this->load->view('templates/vestibular/master', $data);
    }

    public function buscaResultado($campo = NULL, $tabela = NULL)
    {
        if ($campo) {
            if ((strlen($campo) == 11)) {

                $retorno['resultado'] = $this->bancoVestibular->getQuery("Select * from valenca_2021_resultados where cpf = $campo")->row();
                $retorno['tipo'] = 'cpf';
                //$this->resultFinal('1', $retorno['resultado']->cpf  );
            } elseif (strlen($campo) == 8) {

                $retorno['resultado'] = $this->bancoVestibular->getQuery("Select * from valenca_2021_resultados where where inscricao = $campo")->row();
                $retorno['tipo'] = 'inscricao';
                //$this->resultFinal('1', $retorno['resultado']->cpf );
            } else {
                $retorno = NULL;
            }
            $retorno;

        } else {
            $retorno = NULL;
            echo json_encode($retorno);
        }
    }


    public function resultFinal($cpfCandidato, $idCampus, $tabela, $actionVestibular)
    {
        $this->load->library('M_pdf');
        $dadosCandidato = $this->bancoVestibular->getWhere($tabela, array('cpf' => $cpfCandidato))->row();
        $hash = $dadosCandidato->posicao . '-' . $dadosCandidato->inscricao . '-2019-09-12' . $dadosCandidato->cpf;
        $vestibular = $this->bancosite->getWhere('vestibular', array('campusid' => $idCampus))->row();
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($actionVestibular == 'consultaNotaRedacao') {
            if ($idCampus == '1') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/PARACATU-resultNotaRedacao.png';
            } elseif ($idCampus == '2') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/SETELAGOAS-resultNotaRedacao.png';
            } elseif ($idCampus == '3') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/PASSOS-resultNotaRedacao.png';
            } elseif ($idCampus == '6') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/VALENCA.png';
            }
            $infoCandidato = 'Nota de redação: ' . $dadosCandidato->notaRedacao . '';
        } elseif ($actionVestibular == 'consultaClassificacaoFinal') {
            if ($idCampus == '1') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/PARACATU-resultFinal.png';
            } elseif ($idCampus == '2') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/SETELAGOAS-resultFinal.png';
            } elseif ($idCampus == '3') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/PASSOS-resultFinal.png';
            }elseif ($idCampus == '6') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/VALENCA.png';
            }
            $infoCandidato = $dadosCandidato->posicao . 'º';
        }


        $data = array(
            'dados' => array(
                'titulo' => 'Classificação Resultado Vestibular - Medicina',
                'nome' => $dadosCandidato->nome,
                'infoCandidado' => $infoCandidato,
                'actionVestibular' => $actionVestibular,
                'idcampus' => $idCampus,
                'img_fundo' => $img_fundo,
                'posicaoInscricaoCpf' => $hash,
            )
        );
        $arrayLog = array('candidato' => $dadosCandidato->nome, 'posicao' => $dadosCandidato->posicao, 'cod_autentication' => $hash, 'hash' => base64_encode($hash), 'vestibular_id' => $vestibular->id, 'ip' => $ip, 'tipo_consulta' => $actionVestibular);
        $this->bancoVestibular->salvar('logs_vestibular_consulta', $arrayLog);

        //load the view and saved it into $html variable
        $html = $this->load->view('uni_vestibular/results_PDF', $data, true);

        //this the the PDF filename that user will get to download
        $pdfFilePath = 'Informações - Vestibular - Medicina' . '.pdf';

        //load mPDF library
        $this->load->library('m_pdf');

        //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);

        //view it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D", array('target' => '_blank'));
    }

}
