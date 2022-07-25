<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_galeria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('painel_model', 'painelbd');
        date_default_timezone_set('America/Sao_Paulo');
    }
    

      /*************************************************************************
     * Galeria de fotos do Campus
     * Página: Página galeria de fotos - Informações no link
     * uniatenas/site/galeria/NOME_DO_CAMPUS
    *************************************************************************/

    public function lista_campus_galeria_fotos() {
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
            'conteudo' => 'paineladm/campus/galeria_fotos_campus/lista_campus_galeria_fotos',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => 'Galeria de Fotos do Campus - <strong>Gestão Por Campus</strong>',
                'campus'=> $listagemDosCampus,
                'tipo'=>'',
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_galeria_fotos($uriCampus) {
        verificaLogin();

        $uriCampus = $this->uri->segment(3);
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $whereCategoriasFotos= array(
            'photos_category.campusid'=>$campus->id,
        );
        
        $listaCategoriasFotos = $this->painelbd->where('*','photos_category',null,$whereCategoriasFotos,array('campo' => 'photos_category.title', 'ordem' => 'asc'), )->result();     

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/galeria_fotos_campus/lista_galeria_fotos',
            'dados' => array(
                'listaCategoriasFotos'=>$listaCategoriasFotos,
                'campus'=>$campus,
                'page' => "Categorias da galeria de fotos - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'tipo'=>'tabelaDatatable'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_categoria_foto($uriCampus=NULL){
        verificaLogin();
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $this->form_validation->set_rules('title', 'Nome da categoria', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $dados_form['title'] = $this->input->post('title');
            $dados_form['status'] = $this->input->post('status');
            $dados_form['campusid'] = $campus->id;
            $dados_form['user_id'] = $this->session->userdata('codusuario');

            if ($id=$this->painelbd->salvar('photos_category', $dados_form)) {
                setMsg('<p>Categoria de foto cadastrada com sucesso.</p>', 'success');
                redirect("Painel_galeria/lista_galeria_fotos/$uriCampus");
            } else {
                setMsg('<p>Erro! Erro no cadastro.</p>', 'error');
                redirect("Painel_galeria/lista_galeria_fotos/$uriCampus");
            }
        }
        $data = array(
            'conteudo' => 'paineladm/campus/galeria_fotos_campus/cadastrar_categoria_foto',
            'titulo' => 'Categoria de fotos - UniAtenas',
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'page' => "Cadastro de categoria de fotos (GALERIA) - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_categoria_foto($uriCampus=NULL,$idCategoria=NULL){

        verificaLogin();
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $categoriaFoto = $this->painelbd->where('*','photos_category', null, array('photos_category.id' => $idCategoria, 'campusid' => $campus->id))->row();
        
        $this->form_validation->set_rules('title', 'Nome da área', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $dados_form['title'] = $this->input->post('title');
            $dados_form['status'] = $this->input->post('status');
            $dados_form['campusid'] = $campus->id;
            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['id'] = $categoriaFoto->id;
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            
            if ($this->painelbd->salvar('photos_category', $dados_form)==TRUE) {
                setMsg('<p>Categoria de foto editada com sucesso.</p>', 'success');
                redirect("Painel_galeria/lista_galeria_fotos/$uriCampus");
            } else {
                setMsg('<p>Erro! Erro na edição.</p>', 'error');
                redirect("Painel_galeria/lista_galeria_fotos/$uriCampus");
            }
        }
        $data = array(
            'conteudo' => 'paineladm/campus/galeria_fotos_campus/editar_categoria_foto',
            'titulo' => 'Categoria de fotos - UniAtenas',
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'categoriaFoto' => $categoriaFoto,
                'page' => "Edição de categoria de fotos (GALERIA) - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_galeria_foto($uriCampus=NULL,$id = NULL)
    {
        verifica_login();    
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        $item = $this->painelbd->where('*','photos_category', NULL, array('photos_category.id' => $id))->row(); 
        if ($this->painelbd->deletar('photos_category', $item->id)) {
            setMsg('<p>Item deletado com sucesso.</p>', 'success');
            redirect("Painel_galeria/lista_galeria_fotos/$campus->id");
        } else {
            setMsg('<p>Erro! O Item não deletado.</p>', 'error');
            redirect("Painel_galeria/lista_galeria_fotos/$campus->id");
        }

    }   

    public function lista_fotos_categoria($uriCampus=NULL,$idCategoria=NULL)
    {
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        $categoriaFoto = $this->painelbd->where('*','photos_category', null, array('photos_category.id' => $idCategoria, 'campusid' => $campus->id))->row();

        $colunasFotosCategoria = array(
            'photos_gallery.id',
            'photos_gallery.photoscategoryid',
            'photos_gallery.file',
            'photos_gallery.campusid',
            'photos_gallery.title',
            'photos_gallery.status',
            'photos_gallery.created_at',
            'photos_gallery.updated_at',
            'photos_gallery.user_id',
        );

        $joinFotosCategoria = array(
            'photos_category'=>'photos_category.id = photos_gallery.photoscategoryid'
        );

        $whereFotosCategoria = array(
            'photos_gallery.photoscategoryid'=>$categoriaFoto->id
        );
        $listaFotosCategoria = $this->painelbd->where($colunasFotosCategoria,'photos_gallery',$joinFotosCategoria,$whereFotosCategoria)->result();     

         
        $data = array(
            'conteudo' => 'paineladm/campus/galeria_fotos_campus/galeria_fotos/lista_fotos_categoria',
            'titulo' => 'Fotos da Infraestrutura',
            'dados' => array(
                'page' => "Fotos da categoria  <strong>  $categoriaFoto->title <i>Campus - $campus->name ($campus->city) </i></strong>",
                'tipo' => 'tabelaDatatable',
                'listaFotosCategoria' => $listaFotosCategoria,
                'categoriaFoto'=>$categoriaFoto,
                'campus' => $campus,
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }
    

    
}