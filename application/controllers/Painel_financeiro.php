<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_financeiro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('painel_model', 'painelbd');
        date_default_timezone_set('America/Sao_Paulo');
    }
    
    public function lista_campus_financeiro() {
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
            'conteudo' => 'paineladm/financeiro/lista_campus_financeiro',
            'dados' => array(
                'page' => "Informações Financeiro",
                'campus'=> $listagemDosCampus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_informacoes_financeiro($uriCampus=NULL) {
        verificaLogin();

        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $pagina = 'financeiro';
        $wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

        $joinConteudoPagina = array(
            'pages'=>'pages.idpages = page_contents.pages_id',
            'campus' => 'campus.id= pages.campusid'
            
        );

        $colunaResultadPagina = array(
            'page_contents.id',
            'page_contents.title',
            'page_contents.status',
            'page_contents.title_short',
            'page_contents.description', 
            'page_contents.order', 
            'page_contents.created_at', 
            'page_contents.updated_at', 
            'page_contents.user_id', 
            'campus.city'
        );
        
        $listaInformmacoesPaginasFinanceiro = $this->painelbd->where($colunaResultadPagina,'page_contents',$joinConteudoPagina, $wherePagina,null)->result();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/financeiro/lista_informacoes_financeiro',
            'dados' => array(
                'conteudosPagina'=>$listaInformmacoesPaginasFinanceiro,
                'page' => "Cadastro de informações do Financeiro - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_dados_cpa($uriCampus=NULL) {
        verificaLogin();


        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $pagina = 'cpa';
        $wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

        $colunasTabelaPages = array('pages.idpages','pages.title');
        $joinConteudoPagina = array(
            'campus' => 'campus.id= pages.campusid'
            
        );
        $listaItemPages = $this->painelbd->where($colunasTabelaPages,'pages',$joinConteudoPagina, $wherePagina,null)->row();

           //Validaçãoes via Form Validation
       $this->form_validation->set_rules('title', 'Titulo', 'required');
       $this->form_validation->set_rules('description', 'Descrição', 'required');

       if ($this->form_validation->run() == FALSE) {
           if (validation_errors()):
               setMsg(validation_errors(), 'error');
           endif;
       }else {

            $dados_form['description'] = $this->input->post('description');
            $dados_form['title'] = $this->input->post('title');
            $dados_form['status'] = $this->input->post('status');
            $dados_form['pages_id'] = $listaItemPages->idpages;

            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['order'] = 'texto';
            // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
            
            if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
                setMsg('<p>Dados da CPA cadastrado com sucesso.</p>', 'success');
                redirect(base_url("Painel_cpa/lista_dados_cpa/$campus->id"));
            }else{
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
       }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/cpa/cadastrar_dados_cpa',
            'dados' => array(
                'conteudosPagina'=>'',
                'page' => "Cadastro de Informações CPA - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_dados_cpa($uriCampus=NULL,$paginaId) {
        verificaLogin();

        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $pagina = 'cpa';
        $wherePagina = array('page_contents.id'=>$paginaId);

        $joinConteudoPagina = array(
            'pages'=>'pages.idpages = page_contents.pages_id',
            'campus' => 'campus.id = pages.campusid',
        );

        $colunaResultadPagina = array(
            'page_contents.id',
            'page_contents.title',
            'page_contents.status',
            'page_contents.title_short',
            'page_contents.description', 
            'page_contents.order', 
            'page_contents.created_at', 
            'page_contents.updated_at', 
            'page_contents.user_id', 

            'campus.city'
        );
        
        $listaInformmacoesCPA = $this->painelbd->where($colunaResultadPagina,'page_contents',$joinConteudoPagina, $wherePagina,null)->row();

       //Validaçãoes via Form Validation
       $this->form_validation->set_rules('title', 'Titulo', 'required');
       $this->form_validation->set_rules('description', 'Descrição', 'required');

       if ($this->form_validation->run() == FALSE) {
           if (validation_errors()):
               setMsg(validation_errors(), 'error');
           endif;
       }else {

            if ($listaInformmacoesCPA->description != $this->input->post('description')) {
                $dados_form['description'] = $this->input->post('description');
            }
            if ($listaInformmacoesCPA->title != $this->input->post('title')) {
                $dados_form['title'] = $this->input->post('title');
            }
            if ($listaInformmacoesCPA->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }

            $dados_form['id'] = $listaInformmacoesCPA->id;
            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
            
            if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_cpa/lista_dados_cpa/$campus->id"));
            }else{
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
       }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/cpa/editar_dados_cpa',
            'dados' => array(
                'conteudosPagina'=>$listaInformmacoesCPA,
                'page' => "Edição de Informações - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }


    public function deletar_item_cpa($uriCampus=NULL,$id = NULL)
    {
        verifica_login();
    
        $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

        if ($this->painelbd->deletar('page_contents', $item->id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect("Painel_cpa/lista_dados_cpa/$uriCampus");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_cpa/lista_dados_cpa/$uriCampus");
        }
    }
}