<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Atenas extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
        $this->load->model('Site_model', 'bancosite');
    }

    public function index()
    {
        $colunaCampus = array('campus.name', 'campus.city', 'campus.uf', 'campus.facebook', 'campus.youtube', 'campus.iconeCampus', 'campus.instagram');

        $informacoesTodosCampus = $this->bancosite->where($colunaCampus, 'campus', NULL, array('campus.visible' => 'SIM'), array('campo' => 'city', 'ordem' => 'asc', NULL))->result();

        $data = array(
            'head' => array(
                'title' => 'Centro Universitário Atenas - (Grupo Atenas)',
            ),
            'dados' => array(
                'informacoesTodosCampus' => $informacoesTodosCampus
            ),
            'js' => null,
            'footer' => ''
        );
        $this->output->cache(11520);
        $this->load->view('templates/principal', $data);
    }


    public function inicio($campus = NULL)
    {

        $colunaCampus = array('campus.city', 'campus.shurtName');

        $informacoesTodosCampus = $this->bancosite->where($colunaCampus, 'campus', NULL, array('campus.visible' => 'SIM'), NULL, NULL)->result();

        /*transforma o resultado em objeto em um ARRAY*/
        $arrayValidacao = array();
        for ($i = 0; $i < count($informacoesTodosCampus); $i++) {
            $arrayValidacao[$i] = $informacoesTodosCampus[$i]->shurtName;
        }

        /*Verifica se existe campus por meio do PARÂMTRO CAMPUS)passado pela URL*/
        if (!in_array($campus, $arrayValidacao)) {
            redirect('atenas');
        } else {
            //$colunaCampusEspecifico = array('campus.id', 'campus.name', 'campus.shurtName', 'campus.city', 'campus.uf', 'campus.facebook', 'campus.instagram', 'campus.youtube', 'campus.phone', 'campus.backgroundPrincipal');
            $dadosCampus = $this->bancosite->where('*', 'campus', NULL, array('campus.shurtName' => $campus, 'campus.visible' => 'SIM'), NULL, NULL)->row();

            $listaBotoes = $this->bancosite->where('*', 'acessos_rapidos', NULL, array('acessos_rapidos.campusid' => $dadosCampus->id, 'acessos_rapidos.status' => 1), array('campo' => 'priority', 'ordem' => 'asc'), NULL)->result();

            $data = array(
                'head' => array(
                    'title' => $dadosCampus->name . '-' . $dadosCampus->city,
                ),
                'conteudo' => 'home',
                'dados' => array(
                    'campus' => $dadosCampus,
                    'lista_botoes_acesso' => $listaBotoes,
                ),
                'js' => null,
                'footer' => ''
            );
        }
        $this->output->cache(14400);
        $this->load->view('templates/campus', $data);
    }


    public function resultadovalenca($campus = NULL)
    {
        if ($campus != 'paracatu' and $campus != 'passos' and $campus != 'setelagoas' and $campus != 'valenca' and $campus != 'sorriso') {
            redirect('atenas');
        } else {
            if ($campus == 'paracatu') {
                $city = "Paracatu";
            } elseif ($campus == 'passos') {
                $city = "Passos";
            } elseif ($campus == 'setelagoas') {
                $city = "Sete Lagoas";
            } elseif ($campus == 'valenca') {
                $city = "Valença";
            } elseif ($campus == 'sorriso') {
                $city = "Sorriso";
            }

            $data = array(
                'head' => array(
                    'title' => 'Centro Universitário - Atenas',
                ),
                'conteudo' => 'home',
                'dados' => array(
                    'campus' => $this->bancosite->getWhere('campus', array('city' => $city), array('campo' => 'city', 'ordem' => 'asc'))->row()
                ),
                'js' => null,
                'footer' => ''
            );
        }
        $this->output->cache(14400);

        $this->load->view('templates/campusresult', $data);
    }

    public function resultadoEnem($campus = NULL)
    {
        if ($campus != 'paracatu' and $campus != 'passos' and $campus != 'setelagoas' and $campus != 'valenca' and $campus != 'sorriso') {
            //redirect('atenas');
        } else {
            if ($campus == 'paracatu') {
                $city = "Paracatu";
            } elseif ($campus == 'passos') {
                $city = "Passos";
            } elseif ($campus == 'setelagoas') {
                $city = "Sete Lagoas";
            } elseif ($campus == 'valenca') {
                $city = "Valença";
            }elseif ($campus == 'sorriso') {
                $city = "Sorriso";
            }
            

            $data = array(
                'head' => array(
                    'title' => 'Centro Universitário - Atenas',
                ),
                'conteudo' => 'home',
                'dados' => array(
                    'campus' => $this->bancosite->getWhere('campus', array('city' => $city), array('campo' => 'city', 'ordem' => 'asc'))->row()
                ),
                'js' => null,
                'footer' => ''
            );
        }
        $this->output->cache(14400);

        $this->load->view('templates/campusEnem', $data);
    }

    public function portais()
    {
        $data = array(
            'head' => array(
                'title' => 'Centro Universitário - Atenas (Grupo Atenas)',
            ),
            'dados' => array(
                'campus' => $this->bancosite->getWhere('campus', array('visible' => 'SIM'), array('campo' => 'city', 'ordem' => 'asc'))->result()
            ),
            'js' => null,
            'footer' => ''
        );
        $this->output->cache(14400);
        $this->load->view('templates/portais', $data);
    }
}