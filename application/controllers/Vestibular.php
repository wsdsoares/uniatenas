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
        //redirect("http://www.atenas.edu.br/uniatenas");
        //$this->inicio();
    }
    public function resultado()
    {
        $data = array(
            'head' => array(
                'title' => 'Vestibular 2022 - UniAtenas - NOTAS DE REDAÇÃO',
            ),
             'conteudo' => 'uni_vestibular/resultado_geral',
            'js' => 'js_result',
            'footer' => '',
            'menu' => NULL,
            'dados' => array(
                'idCampus' => 1,
                'local' => 'Paracatu',
                'campus' => 'Uniatenas'
            )
        );
        

        $this->load->view('templates/vestibular/master', $data);
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
            
    
            $vestibularSituation = $this->bancosite->where($fieldsBd,'campus',$dataJoin,$whereBd)->result();
                   
            $fieldsBdCampus = array('campus.city as cityCampus',
            'campus.name as nameCampus',
            'campus.id as idCampus');

            $colunasCampus = array('campus.name','campus.city','campus.id');
            $joinCampusVestibular = array(
                'vestibular' => 'vestibular.campusid = campus.id',
            );
            //$whereCampusVestibularStatus = array('campus.status'=>1,'vestibular');
            $whereCampusVestibularStatus = array('vestibular.vestibular_situationid' => 5, 'campus.status'=>1,'visible'=>'SIM');
            
            $consultaResultadosVestibular = '
                SELECT vestibular.id as idVestibular, campus.name,campus.city,campus.id
                FROM campus 
                JOIN vestibular on vestibular.campusid = campus.id
                WHERE vestibular.vestibular_situationid = 5 
                    AND campus.status = 1 
                    AND vestibular.status = 1
                    AND visible = "SIM"
                GROUP BY campus.city
            ';

            $dadosCampus = $this->bancosite->getQuery($consultaResultadosVestibular)->result();

            // echo '<pre>';
            // print_r($dadosCampus);
            // echo '</pre>';
            
            $data = array(
                'head' => array(
                    'title' => 'Vestibular - UniAtenas ',
                ),
                'conteudo' => 'uni_vestibular/index',
                'dados' => array(
                    //'campus'=>$this->bancosite->where($fieldsBdCampus,'campus',null,array('visible'=>'SIM'), array('campo'=>'id','ordem'=>'asc'))->result(),
                    'campus'=>$dadosCampus,
            
                    'situacaoVestibular'=>$vestibularSituation
                ),
                'js' => 'js_result',
                'footer' => '',
                'menu' => NULL,
            );
            $this->load->view('templates/vestibular/master', $data);
        }
        

    public function resultado_geral(){

        $dados_formInicio = elements(array('idCampus','idVestibular'), $this->input->post());

        $idCampus = $dados_formInicio['idCampus'];
        $idVestibular = $dados_formInicio['idVestibular'];
        $actionVestibular = 'consultaClassificacaoFinal';
//        $actionVestibular = $this->input->post('typeSearch');
        $infCandidato = $this->input->post('inputDataVest');

        $dados = $this->input->post('actionQuery');

        if (!empty($dados)) {
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
            $tabela = 'paracatu_2022_12_resultados';
            $resultadosOficiais = count($this->bancoVestibular->getWhere($tabela)->result());
        } elseif ($idCampus == 2) {
            $tabela = 'setelagoas_2022_12_resultados';
            $resultadosOficiais = count($this->bancoVestibular->getWhere($tabela)->result());
        } elseif ($idCampus == 3) {
            $tabela = 'passos_2022_12_resultados';
            $resultadosOficiais = count($this->bancoVestibular->getWhere($tabela)->result());
        }elseif ($idCampus == 6) {
            $tabela = 'valenca_2022_12_resultados';
            $resultadosOficiais = count($this->bancoVestibular->getWhere($tabela)->result());
        }elseif ($idCampus == 7) {
            $tabela = 'sorriso_2022_12_resultados';
            $resultadosOficiais = count($this->bancoVestibular->getWhere($tabela)->result());
        }elseif ($idCampus == 8) {
            $tabela = 'porto_seguro_2022_12_resultados';
            $resultadosOficiais = count($this->bancoVestibular->getWhere($tabela)->result());
        }
    
        /** 
        * Informações da consulta do vestibular, passadas por variáveis, campo, join e where
        **/
        $fieldsBd = array('vestibular.name as nameVestibular',
            'vestibular.id as idVestibular',
            'campus.name as nameCampus',
            'campus.id as idCampus',
            'campus.city as cityCampus',
            'vestibular_situation.name as vestibularSituation', 'vestibular_situation.id as idSituation');
        $dataJoin = array(
            'vestibular' => 'vestibular.campusid = campus.id',
            'vestibular_situation' => 'vestibular_situation.id = vestibular.vestibular_situationid'
        );
        $whereBd = array('vestibular.status' => 1, 'vestibular.id' => $idVestibular);
        /*fim consulta*/

        /** Consulta de arquivos do resultado final do vestibular - LISTA APROVADOS **/
        $fieldsResult = array('vestibular_files.name', 'vestibular_files.files', 'vestibular_exams_types.title as tipo_prova');
        $dataJoinResult = array(
            'vestibular_files' => 'vestibular_files.vestibularid = vestibular.id',
            'vestibular_exams_types' => 'vestibular_exams_types.id = vestibular_files.typesid'
        );
        $whereFilesResult = array('vestibular.campusid' => $idCampus, 'vestibular_exams_types.id' => '11', 'vestibular_files.status' => 1,'vestibular_situationid'=>5);
        $whereFilesResultEspera = array('vestibular.campusid' => $idCampus, 'vestibular_exams_types.id' => '12', 'vestibular_files.status' => 1,'vestibular_situationid'=>5);
        /** fim da consulta* */

        $vestibularSituation = $this->bancosite->where($fieldsBd, 'campus', $dataJoin, $whereBd)->row();

        $filesListaAprovados = $this->bancosite->where($fieldsResult, 'vestibular', $dataJoinResult, $whereFilesResult)->result();
        $filesListaEspera = $this->bancosite->where($fieldsResult, 'vestibular', $dataJoinResult, $whereFilesResultEspera)->result();


        //$whereEssay = array($tabela, $tabela . 'ano' => '2022', $tabela . '.' . $fieldQuery => $infCandidato);
        $whereEssay = array($tabela, $tabela . '.ano' => '2023', $tabela . '.' . $fieldQuery => $infCandidato);

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

        $dadosCampus = $this->bancosite->where(array('campus.name','campus.id','campus.city'), 'campus', null, array('id' => $idCampus))->row();

        $data = array(
            'head' => array(
                'title' => 'Vestibular 2023 - Medicina',
            ),
            'conteudo' => 'uni_vestibular/resultado_geral',
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

    public function resultFinal($cpfCandidato, $idCampus, $tabela, $actionVestibular)
    {
        $this->load->library('M_pdf');
        $dadosCandidato = $this->bancoVestibular->getWhere($tabela, array('cpf' => $cpfCandidato))->row();
        $hash = $dadosCandidato->posicao . '-' . $dadosCandidato->inscricao . '-2022-13-12' . $dadosCandidato->cpf;
        $vestibular = $this->bancosite->getWhere('vestibular', array('campusid' => $idCampus))->row();
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($actionVestibular == 'consultaNotaRedacao') {
           /* if ($idCampus == '1') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/PARACATU-resultNotaRedacao.png';
            } elseif ($idCampus == '2') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/SETELAGOAS-resultNotaRedacao.png';
            } elseif ($idCampus == '3') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/PASSOS-resultNotaRedacao.png';
            } elseif ($idCampus == '6') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/VALENCA.png';
            }elseif ($idCampus == '7') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/2022/sorriso.png';
            }elseif ($idCampus == '8') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/2022/2022PortoSeguro.png';
            }
            $infoCandidato = 'Nota de redação: ' . $dadosCandidato->notaRedacao . '';*/
        } elseif ($actionVestibular == 'consultaClassificacaoFinal') {
            if ($idCampus == '1') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/2022-2/ConsultadeClassificacaoParacatu.jpg';
            } elseif ($idCampus == '2') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/2022-2/ConsultadeClassificacaoSete.jpg';
            } elseif ($idCampus == '3') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/2022-2/ConsultadeClassificacaoPassos.jpg';
            }elseif ($idCampus == '6') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/2022-2/ConsultadeClassificacaoValenca.jpg';
            }elseif ($idCampus == '7') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/2022-2/ConsultadeClassificacaoSorriso.jpg';
            }elseif ($idCampus == '8') {
                $img_fundo = 'http://www.atenas.edu.br/uniatenas/assets/images/vestibular/2022-2/ConsultadeClassificacaoPorto.jpg';
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

    
  
    

    



    // public function buscaResultado($campo = NULL, $tabela = NULL)
    // {

    //     $dadosCandidato = $this->input->post('inputDataVest');

       

    //     $this->form_validation->set_rules('inputDataVest', 'Necessário informar inscrição ou CPF ', 'required');
    //     $this->form_validation->set_rules('inputDataVest', 'Apenas Número', 'numeric');

    //     if ($this->form_validation->run() == FALSE) {
    //         if (validation_errors()):
    //             setMsg(validation_errors(), 'error');
    //         endif;
    //     } else {            
    //         if ((strlen($dadosCandidato) == 11)) {

    //             $busca = $retorno['resultado'] = $this->bancoVestibular->getQuery("Select * from paracatu_2022_resultados where cpf = $dadosCandidato")->row();

    //             if(!empty($busca)){
    //                 $retorno['tipo'] = 'cpf';
        
    //                 setMsg('<p style="font-size:30px; font-weight:bold;">'.$retorno['resultado']->nome.' <br/> A sua nota da redação foi: '.$retorno['resultado']->notaRedacao.'</p>', 'success');
    //                 redirect('http://www.atenas.edu.br/uniatenas/vestibular/resultado');
                    

    //             } else {
    //                 setMsg('<p style="font-size:30px; font-weight:bold;"> CPF e/ou inscrição incorretos.</p>', 'error');
    //                redirect('http://www.atenas.edu.br/uniatenas/vestibular/resultado');
    //             }
    //             //$this->resultFinal('1', $retorno['resultado']->cpf  );
    //         } elseif (strlen($dadosCandidato) == 8) {

    //             $busca = $retorno['resultado'] = $this->bancoVestibular->getQuery("Select * from paracatu_2022_resultados where inscricao = $dadosCandidato")->row();

    //             if(!empty($busca)){
    //                 setMsg('<p style="font-size:30px; font-weight:bold;">'.$retorno['resultado']->nome.' <br/> A sua nota da redação foi: '.$retorno['resultado']->notaRedacao.'</p>', 'success');
    //                 redirect('http://www.atenas.edu.br/uniatenas/vestibular/resultado');

    //             } else {
    //                 setMsg('<p style="font-size:30px; font-weight:bold;"> CPF e/ou inscrição incorretos.</p>', 'error');
    //                 redirect('http://www.atenas.edu.br/uniatenas/vestibular/resultado');
    //             }                
    //         }
    //          else {
    //                 setMsg('<p style="font-size:30px; font-weight:bold;"> CPF e/ou inscrição incorretos.</p>', 'error');
    //                 redirect('http://www.atenas.edu.br/uniatenas/vestibular/resultado');
    //             }   
    //     }
        
       



    //     /*if ($campo) {
    //         if ((strlen($campo) == 11)) {

    //             $retorno['resultado'] = $this->bancoVestibular->getQuery("Select * from paracatu_2022_resultados where cpf = $campo")->row();
    //             $retorno['tipo'] = 'cpf';
    //             //$this->resultFinal('1', $retorno['resultado']->cpf  );
    //         } elseif (strlen($campo) == 8) {

    //             $retorno['resultado'] = $this->bancoVestibular->getQuery("Select * from paracatu_2022_resultados where inscricao = $campo")->row();
    //             $retorno['tipo'] = 'inscricao';
    //             //$this->resultFinal('1', $retorno['resultado']->cpf );
    //         } else {
    //             $retorno = NULL;
    //         }
    //         $retorno;

    //     } else {

    //         $retorno = NULL;
    //         echo json_encode($retorno);
    //     }*/
    // }


    

}