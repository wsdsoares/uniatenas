<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_mensagens_contatos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('painel_model', 'painelbd');
        date_default_timezone_set('America/Sao_Paulo');
    }
    
    public function lista_campus_mensagens_contatos() {
        verificaLogin();

        $colunasResultadoCursos = 
            array('campus.id',
            'campus.name',
            'campus.city',
            'campus.uf'
        );
    
        $listagemDosCampus = $this->painelbd->where('*','campus',NULL, array('visible' => 'SIM'))->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/mensagens_fomulario_contato/lista_campus_mensagens_contatos',
            'dados' => array(
                'page' => "Lista - Mensagens recebidas - Formulário de contato do Site",
                'campus'=> $listagemDosCampus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function ver_mensagem($uriCampus=NULL,$idMensagem) {
        verificaLogin();

        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $colunasMensagem = array(
            'campus_contacts.id',
            'campus_contacts.name',
            'campus_contacts.message',
            'campus_contacts.email',
            'campus_contacts.phone',
            'campus_contacts.datacreated',
            'campus.city'
        );
        $joinMessage = array(
            'campus'=>'campus.id = campus_contacts.campusid'
        );
        $mensagemContato = $this->painelbd->where($colunasMensagem,'campus_contacts', $joinMessage, array('campus_contacts.id'=>$idMensagem))->row();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/mensagens_fomulario_contato/ver_mensagem',
            'dados' => array(
                'mensagemContato'=>$mensagemContato,
                'page' => "Mensagem recebida - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_mensagens_contatos($uriCampus=NULL) {
        verificaLogin();

        $colunasCampus = array('campus.id','campus.name','campus.city','campus.email');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $listaMensagensContato = $this->painelbd->where('*','campus_contacts',null, array('campus_contacts.campusid'=>$campus->id),array('campo' => 'datacreated', 'ordem' => 'DESC'))->result();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/mensagens_fomulario_contato/lista_mensagens_contatos',
            'dados' => array(
                'listaMensagensContato'=>$listaMensagensContato,
                'page' => "Lista de mensagens recebidas - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'tipo'=>'tabelaDatatable'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_mensagem_contato($uriCampus=NULL,$id = NULL)
    {
        verifica_login();
    
        $item = $this->painelbd->where('*','campus_contacts', NULL, array('campus_contacts.id' => $id))->row(); 

        if ($this->painelbd->deletar('campus_contacts', $item->id)) {
            setMsg('<p>Mensagem deletada com sucesso.</p>', 'success');
            redirect("Painel_mensagens_contatos/lista_mensagens_contatos/$uriCampus");
        } else {
            setMsg('<p>Erro!Mensagem não pode ser deletada.</p>', 'error');
            redirect("Painel_mensagens_contatos/lista_mensagens_contatos/$uriCampus");
        }
    }
}