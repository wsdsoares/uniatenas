<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_publicacoes extends CI_Controller {

  public function __construct() {
    parent::__construct();
    verificaLogin();
    $this->load->model('painel_model', 'painelbd');
    $this->load->model('site_model', 'bancosite');
    date_default_timezone_set('America/Sao_Paulo');
    $this->load->helper('file');
  }

  public function lista_campus_revistas() {
      verificaLogin();

      $colunasCampus = 
          array('campus.id',
          'campus.name',
          'campus.city',
          'campus.uf'
      );
  
      $listagemDosCampus = $this->painelbd->where($colunasCampus,'campus',NULL, array('visible' => 'SIM'))->result();
      $data = array(
          'titulo' => 'UniAtenas',
          'conteudo' => 'paineladm/itens_iniciacao/lista_campus_revistas',
          'dados' => array(
              'page' => "Informações Revistas Científicas",
              'campus'=> $listagemDosCampus,
              'tipo'=>''
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_revistas($uriCampus=NULL) {
    
      $colunasResultadoRevistas = array(
        'revistas.id',
        'revistas.id as pagina_id',
        'revistas.titulo',
        'revistas.status', 
        'revistas.capa', 
        'revistas.modalidade',
        'revistas.linkRedirect',
        'revistas.user_id', 
        'revistas.created_at',
        'revistas.updated_at'
      );
      
      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

      $dadosRevistas = $this->painelbd->where($colunasResultadoRevistas,'revistas',null,array('revistas.campus_id'=>$campus->id))->result();
      $data = array(
        'titulo' => 'Início',
        'conteudo' => 'paineladm/itens_iniciacao/publicacoes/lista_revistas',
        'dados' => array(
          'page'=> "Lista de Revistas <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
          'revistas' => $dadosRevistas,
          'campus'=>$campus,
          'tipo' => 'tabelaDatatable')
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function registro_revistas($uriCampus=NULL,$itemRevista=NULL) {
    
    $colunasResultadoRevistas = array(
      'revistas.id',
      'revistas.id as pagina_id',
      'revistas.titulo',
      'revistas.status', 
      'revistas.capa', 
      'revistas.modalidade',
      'revistas.linkRedirect',
      'revistas.user_id', 
      'revistas.created_at',
      'revistas.updated_at'
    );
    
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $dadosRevistas = $this->painelbd->where($colunasResultadoRevistas,'revistas',null,array('revistas.campus_id'=>$campus->id))->result();
    
    $this->form_validation->set_rules('titulo', 'Título', 'required');
    $this->form_validation->set_rules('modalidade', 'Modalidade', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if (empty($_FILES['capa']['name'])) {
      $this->form_validation->set_rules('files', 'Capa', 'callback_file_check');
      $this->form_validation->set_message('file_check', 'Você precisa informar uma imagem (JPEG, PNG, JPG)');
    }

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()):
          setMsg(validation_errors(), 'error');
      endif;
    }else {
      
      $path = "assets/images/revistas/$campus->id";
      is_way($path);

      $name_tmp = noAccentuation($this->input->post('titulo'));

      $upload = $this->painelbd->uploadFiles('capa', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', $name_tmp);

      $dados_form['capa'] = $path.'/'.$upload['file_name'];
      $dados_form['titulo'] = $this->input->post('titulo');
      $dados_form['modalidade'] = $this->input->post('modalidade');
      $dados_form['description'] = $this->input->post('description');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['campus_id'] = $campus->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');
      
      if($this->input->post('modalidade')=='EXTERNA' and $this->input->post('linkRedirect') != ''){
        $dados_form['linkRedirect'] = $this->input->post('linkRedirect');
      }
      if($this->input->post('issn') != ''){
        $dados_form['issn'] = $this->input->post('issn');
      }

      if ($this->painelbd->salvar('revistas', $dados_form) == TRUE){
        setMsg('<p>Revista incluída com sucesso.</p>', 'success');
        redirect(base_url("Painel_publicacoes/lista_revistas/$campus->id"));
      }else{
        setMsg('<p>Erro! Houve erro no cadastro.</p>', 'error');
      }

    }
    $data = array(
      'titulo' => 'Cadastro de Revistas',
      'conteudo' => 'paineladm/itens_iniciacao/revistas/registro_revistas',
      'dados' => array(
        'page'=> "Cadastro de Revista <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        // /'revistas' => $dadosRevistas,
        'campus'=>$campus,
        'tipo' => '')
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_registro_revistas($uriCampus=NULL,$idRevista=NULL) {
      
    $colunasResultadoRevistas = array(
      'revistas.id',
      'revistas.id as pagina_id',
      'revistas.titulo',
      'revistas.status', 
      'revistas.capa', 
      'revistas.description', 
      'revistas.issn', 
      'revistas.modalidade',
      'revistas.linkRedirect',
      'revistas.user_id', 
      'revistas.created_at',
      'revistas.updated_at'
    );
    
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $revista = $this->painelbd->where($colunasResultadoRevistas,'revistas',null,array('revistas.id'=>$idRevista))->row();
    
    $this->form_validation->set_rules('titulo', 'Título', 'required');
    $this->form_validation->set_rules('modalidade', 'Modalidade', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if (empty($_FILES['capa']['name']) and $revista->capa == '') {
      $this->form_validation->set_rules('files', 'Capa', 'callback_file_check');
      $this->form_validation->set_message('file_check', 'Você precisa informar uma imagem (JPEG, PNG, JPG)');
    }

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()):
          setMsg(validation_errors(), 'error');
      endif;
    }else {
      if (isset($_FILES['capa']) && !empty($_FILES['capa']['name'])) {
        if (file_exists($revista->capa)) {
          unlink($revista->capa);
        }
        $path = "assets/images/revistas/$campus->id";
        is_way($path);
        
        $name_tmp = noAccentuation($this->input->post('titulo'));

        $upload = $this->painelbd->uploadFiles('capa', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', $name_tmp);
        
        $dados_form['capa'] = $path.'/'.$upload['file_name'];
      }

      if ($revista->titulo != $this->input->post('titulo')) {
        $dados_form['titulo'] = $this->input->post('titulo');
      }
      if ($revista->modalidade != $this->input->post('modalidade')) {
        $dados_form['modalidade'] = $this->input->post('modalidade');
      }
      if ($revista->description != $this->input->post('description')) {
        $dados_form['description'] = $this->input->post('description');
      }
      if ($revista->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }
      if ($revista->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }
      
      if($this->input->post('modalidade')=='EXTERNA' and $this->input->post('linkRedirect') != '' and $revista->linkRedirect != $this->input->post('linkRedirect')){
        $dados_form['linkRedirect'] = $this->input->post('linkRedirect');
      }
      if($this->input->post('issn') != '' and $revista->issn != $this->input->post('issn')){
        $dados_form['issn'] = $this->input->post('issn');
      }
      
      $dados_form['id'] = $revista->id;
      $dados_form['campus_id'] = $campus->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');


      if ($this->painelbd->salvar('revistas', $dados_form) == TRUE){
        setMsg('<p>Revista editada com sucesso.</p>', 'success');
        redirect(base_url("Painel_publicacoes/lista_revistas/$campus->id"));
      }else{
        setMsg('<p>Erro! Houve erro no cadastro.</p>', 'error');
      }

    }
    $data = array(
      'titulo' => 'Cadastro de Revistas',
      'conteudo' => 'paineladm/itens_iniciacao/revistas/editar_registro_revistas',
      'dados' => array(
        'page'=> "Edição dados de Revista <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'revista' => $revista,
        'campus'=>$campus,
        'tipo' => '')
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_revista($uriCampus=NULL,$id = NULL)
    {
        verifica_login();
    
        $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

        if ($this->painelbd->deletar('page_contents', $item->id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect("Painel_financeiro/lista_informacoes_financeiro/$uriCampus");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_financeiro/lista_informacoes_financeiro/$uriCampus");
        }
    }

 
    public function revistas($uriCampus=NULL) {
  
      $colunasResultadoRevistas = array(
        'revistas.id',
        'revistas.id as pagina_id',
        'revistas.titulo',
        'revistas.status', 
        'revistas.created_at'
      );
      
      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

      $dadosRevistas = $this->painelbd->where($colunasResultadoRevistas,'revistas',null,array('revistas.status'=>1,'revistas.campus_id'))->result();
      $data = array(
        'titulo' => 'Início',
        'conteudo' => 'paineladm/itens_iniciacao/publicacoes/revistas',
        'dados' => array(
          'revistas' => $dadosRevistas,
          'campus'=>$campus,
          'tipo' => '')
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_artigos_revistas($uriCampus=NULL, $idRevista=null) {
    
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    if (empty($idRevista)) {
      //redirect('painel/index');
    }

    $revista = $this->painelbd->where('*','revistas', null,array('id' => $idRevista))->row();

    $aql = "SELECT 
              publicacoes.id,
              publicacoes.title,
              publicacoes.volume,
              publicacoes.number_vol,
              publicacoes.revistas_id as paginas_id,
              publicacoes.created,
              publicacoes.files,
              publicacoes.status,
              courses.name as 'courses',
              CASE
                  WHEN publicacoes.types = 'magazines' THEN 'Revistas'
              END AS 'types',
              publicacoes.year,
              campus.name as 'campus'
          FROM
              at_site.publicacoes
                  INNER JOIN courses ON courses.id = publicacoes.courses_id
                  INNER JOIN campus on campus.id = publicacoes.campus_id
                  AND campus.id = $campus->id
                  AND publicacoes.revistas_id = $idRevista
              ORDER BY
              publicacoes.id DESC,
              publicacoes.created DESC";

    $dados = $this->painelbd->get_query($aql)->result();

    $data = array(
      'titulo' => 'Início',
      'conteudo' => 'paineladm/itens_iniciacao/revistas/lista_artigos_revistas',
      'dados' => array(
        'publicacoes' => $dados,
        'campus'=>$campus,
        // 'cursos' => 'teste',
        'page'=> "Lista de Artigos: <u> $revista->titulo</u> - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'revista' => $revista,
        'tipo' => 'revistas')
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_artigo_revista($uriCampus=NULL, $idRevista=NULL) {
    $this->load->helper('file');
    
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $revista = $this->painelbd->where("*",'revistas', null, array('revistas.id' => $idRevista))->row();
    
    $colunaCursos = array('courses.name','courses.id');
    $joinCursosCampus = array(
      'campus_has_courses'=> 'campus_has_courses.courses_id = courses.id',
      'campus'=> "campus.id = campus_has_courses.campus_id",
    );
    $cursos = $this->painelbd->where($colunaCursos,"courses",$joinCursosCampus,array('campus.id'=>$campus->id,'courses.modalidade'=>'presencial'),array('campo' => 'name', 'ordem' => 'ASC'))->result();
    
    $this->form_validation->set_rules('title', 'Título', 'required');

    if ($this->input->post('courses_id') == '0') {
        $this->form_validation->set_rules('courses_id', 'Curso', 'select_validate');
        $this->form_validation->set_message('select_validate', 'Você precisa selecionar ao menos um curso.');
    } else {
        $this->form_validation->set_rules('courses_id', 'Curso');
    }

    $this->form_validation->set_rules('year', 'Ano', 'required');
    if (empty($_FILES['files']['name'])) {
        $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
        $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
    }
    $this->form_validation->set_rules('volume', 'Volume', 'required');
    $this->form_validation->set_rules('number_vol', 'Número do Volume', 'required');

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {
      $path = "assets/files/magazines/$campus->id";
      is_way($path);

      $name_tmp = noAccentuation($this->input->post('title'));

      $upload = $this->painelbd->uploadFiles('files', $path, $types = 'PDF|pdf', $name_tmp);
      
      if ($upload){
        $dados_form['files'] = $path.'/'.$upload['file_name'];
      }

      //$dados_form = elements(array('title', 'courses_id', 'year', 'volume', 'number_vol','status'), $this->input->post());
      $dados_form['title'] = $this->input->post('title');
      $dados_form['courses_id'] = $this->input->post('courses_id');
      $dados_form['year'] = $this->input->post('year');
      $dados_form['volume'] = $this->input->post('volume');
      $dados_form['number_vol'] = $this->input->post('number_vol');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['campus_id'] = $campus->id;
      $dados_form['users_id'] = $this->session->userdata('codusuario');
      $dados_form['revistas_id'] = $revista->id;
      $dados_form['types'] = 'magazines';
      $dados_form['typepublicationid'] = '1';
      

      if ($this->painelbd->salvar('publicacoes', $dados_form)){
        setMsg('<p>Publicação cadastrada com sucesso.</p>', 'success');
        redirect(base_url("Painel_publicacoes/lista_artigos_revistas/$campus->id/$revista->id"));
      }else{
        setMsg('<p>Erro! A publicação não foi cadastrada.</p>', 'error');
      }
    }
      
    $data = array(
      'titulo' => 'Início',
      'conteudo' => 'paineladm/itens_iniciacao/revistas/artigos/cadastrar_artigo_revista',
      'dados' => array(
        // 'publicacoes' => '$dados',
        'page'=> "Cadastro de Artigo na <u> $revista->titulo</u> - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus'=>$campus,
        'cursos' => $cursos,
        'revista' => $revista,
        'tipo' => '')
    );
    $this->load->view('templates/layoutPainelAdm', $data);
  }

  
  public function editar_artigo_revista($uriCampus=NULL, $idRevista=NULL, $idArtigo = NULL) {
    $this->load->helper('file');
    
    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

    $revista = $this->painelbd->where("*",'revistas', null, array('revistas.id' => $idRevista))->row();
    $artigoRevista = $this->painelbd->where("*",'publicacoes', null, array('publicacoes.id' => $idArtigo))->row();
    
    $colunaCursos = array('courses.name','courses.id');
    $joinCursosCampus = array(
      'campus_has_courses'=> 'campus_has_courses.courses_id = courses.id',
      'campus'=> "campus.id = campus_has_courses.campus_id",
    );
    $cursos = $this->painelbd->where($colunaCursos,"courses",$joinCursosCampus,array('campus.id'=>$campus->id,'courses.modalidade'=>'presencial'),array('campo' => 'name', 'ordem' => 'ASC'))->result();
    
    $this->form_validation->set_rules('title', 'Título', 'required');

    if ($this->input->post('courses_id') == '0') {
        $this->form_validation->set_rules('courses_id', 'Curso', 'select_validate');
        $this->form_validation->set_message('select_validate', 'Você precisa selecionar ao menos um curso.');
    } else {
        $this->form_validation->set_rules('courses_id', 'Curso');
    }

    $this->form_validation->set_rules('year', 'Ano', 'required');
    if (empty($_FILES['files']['name'])) {
        $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
        $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
    }
    $this->form_validation->set_rules('volume', 'Volume', 'required');
    $this->form_validation->set_rules('number_vol', 'Número do Volume', 'required');

    if ($this->form_validation->run() == FALSE) {
        if (validation_errors()):
            setMsg(validation_errors(), 'error');
        endif;
    }else {

      if (isset($_FILES['files']) && !empty($_FILES['files']['name'])) {

        if (file_exists($artigoRevista->files)) {
          unlink($artigoRevista->files);
        }

        $path = "assets/files/magazines/$campus->id";
        is_way($path);

        $name_tmp = noAccentuation($this->input->post('title'));
        $upload = $this->painelbd->uploadFiles('files', $path, $types = 'PDF|pdf', $name_tmp);

        if ($upload){
          $dados_form['files'] = $path.'/'.$upload['file_name'];
        }
      }

      if ($this->input->post('title')) {
        $dados_form['title'] = $this->input->post('title');
      }
      if ($this->input->post('courses_id')) {
        $dados_form['courses_id'] = $this->input->post('courses_id');
      }
      if ($this->input->post('year')) {
        $dados_form['year'] = $this->input->post('year');
      }
      if ($this->input->post('volume')) {
        $dados_form['volume'] = $this->input->post('volume');
      }
      if ($this->input->post('number_vol')) {
        $dados_form['number_vol'] = $this->input->post('number_vol');
      }
      if ($this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }
      // $dados_form['campus_id'] = $campus->id;
      $dados_form['users_id'] = $this->session->userdata('codusuario');
      // $dados_form['revistas_id'] = $revista->id;
      //$dados_form['types'] = 'magazines';
      //$dados_form['typepublicationid'] = '1';
      $dados_form['id'] = $artigoRevista->id;
      

      if ($this->painelbd->salvar('publicacoes', $dados_form)){
        setMsg('<p>Publicação editada com sucesso.</p>', 'success');
        redirect(base_url("Painel_publicacoes/lista_artigos_revistas/$campus->id/$revista->id"));
      }else{
        setMsg('<p>Erro! A publicação não foi cadastrada.</p>', 'error');
      }
    }
      
    $data = array(
      'titulo' => 'Início',
      'conteudo' => 'paineladm/itens_iniciacao/revistas/artigos/editar_artigo_revista',
      'dados' => array(
        // 'publicacoes' => '$dados',
        'page'=> "Edição de artigo da <u> $revista->titulo</u> - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus'=>$campus,
        'cursos' => $cursos,
        'revista' => $revista,
        'artigoRevista' => $artigoRevista,
        'tipo' => '')
    );
    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletarMagazine($uriCampus = NULL, $id = NULL) {

    $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf','campus.shurtName');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
 
    $dados = $this->painelbd->where('*','publicacoes',null, array('id' => $id))->row();
    $arquivo = $dados->files;

    if ($id != NULL && $dados) {
      if ($del = $this->painelbd->delete('publicacoes', array('id' => $id))) {
        if (!unlink($arquivo)) {
          setMsg('Não foi possível remover o arquivo de nome ' . $arquivo . '', 'alert');
          redirect("Painel_publicacoes/lista_artigos_revistas/$campus->id/$dados->revistas_id");
        } else {
          setMsg('<p>Informação removida com sucesso.</p>', 'success');
          redirect("Painel_publicacoes/lista_artigos_revistas/$campus->id/$dados->revistas_id");
        }
      } else {
        setMsg('<p>Erro! A publicação não pode ser deletada.</p>', 'error');
        redirect("Painel_publicacoes/lista_artigos_revistas/$campus->id/$dados->revistas_id");
      }
    } else {
      setMsg('<p>Erro! Não existe publicações para os dados informados.</p>', 'error');
      redirect("Painel_publicacoes/lista_artigos_revistas/$campus->id/$dados->revistas_id");
    }
  }

  public function editarMagazine($id = NULL, $idPage = NULL) {

      if (empty($id)) {
          redirect('publicacoes/publicacoes/magazine');
      }
      $this->load->helper('file');

      $campus = '1'; //campus Paracatu
      $sql = "SELECT 
                  publicacoes.id,
                  publicacoes.title,
                  publicacoes.volume,
                  publicacoes.number_vol,
                  publicacoes.revistas_id as paginas_id,
                  publicacoes.created,
                  publicacoes.files,
                  publicacoes.status,
                  courses.id as 'courses_id',
                  courses.name as 'courses',
                  CASE
                      WHEN publicacoes.types = 'magazines' THEN 'Revistas'
                  END AS 'types',
                  publicacoes.year,
                  campus.id as 'campus_id',
                  campus.name as 'campus'
              FROM
                  at_site.publicacoes
                      INNER JOIN courses ON courses.id = publicacoes.courses_id
                      INNER JOIN campus on campus.id = publicacoes.campus_id
                      AND campus.id = 1
                      AND publicacoes.id=" . $idPage;

      $this->form_validation->set_rules('title', 'Título', 'required');

      if ($this->input->post('courses_id') == '0') {
          $this->form_validation->set_rules('courses_id', 'Curso', 'select_validate');
          $this->form_validation->set_message('select_validate', 'Você precisa selecionar ao menos um curso.');
      } else {
          $this->form_validation->set_rules('courses_id', 'Curso');
      }

      /* if (isset($_FILES['files']) && empty($_FILES['files']['name'])) {
        $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
        $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        } */
      $this->form_validation->set_rules('year', 'Ano', 'required');
      $this->form_validation->set_rules('volume', 'Volume', 'required');
      $this->form_validation->set_rules('number_vol', 'Número do Volume', 'required');

      if ($this->form_validation->run() == FALSE) {
          if (validation_errors()):
              setMsg(validation_errors(), 'error');
          endif;
      }else {

          $publicacoes = $this->painelbd->getQuery($sql)->row();

          if (isset($_FILES['files']) && !empty($_FILES['files']['name'])) {
              $path = 'assets/files/magazines';
              $file_antigo = $publicacoes->files;

              $name_tmp = preg_replace(array(
                  "/(á|à|ã|â|ä)/",
                  "/(Á|À|Ã|Â|Ä)/",
                  "/(é|è|ê|ë)/",
                  "/(É|È|Ê|Ë)/",
                  "/(í|ì|î|ï)/",
                  "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post('title'));

              $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

              // matriz de saída
              $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');

              // devolver a string
              $name_tmp = str_replace($what, $by, $name_tmp);

              $upload = $this->painelbd->do_uploadFiles('files', $path, $types = 'pdf', $name_tmp);

              if ($upload):
                  //upload efetuado
                  unlink($file_antigo);
                  $dados_form = elements(array('title', 'courses_id', 'year', 'volume', 'number_vol', 'revistas_id'), $this->input->post());

                  $dados_form['files'] = $path . '/' . $upload['file_name'];
                  $dados_form['campus_id'] = $campus;
                  $dados_form['users_id'] = $this->session->userdata('codusuario');
                  $dados_form['types'] = 'magazines';
                  $dados_form['status'] = '1';
                  $dados_form['id'] = $publicacoes->id;

                  if ($this->painelbd->salvar('publicacoes', $dados_form) == TRUE):
                      setMsg('<p>Publicação editada com sucesso.</p>', 'success');
                      redirect('publicacoes/publicacoes/' . $id);
                  else:
                      setMsg('<p>Erro! A publicação não foi editada.</p>', 'error');
                  endif;
              else:
                  //erro no upload
                  $msg = $this->upload->display_errors();
                  $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                  setMsg($msg, 'erro');
              endif;

              //opção de quando não é enviado um novo arquivo para upload.
          }else {

              $dados_form = elements(array('title', 'courses_id', 'year', 'volume', 'number_vol', 'revistas_id'), $this->input->post());

              $dados_form['campus_id'] = $campus;
              $dados_form['users_id'] = $this->session->userdata('codusuario');
              $dados_form['types'] = 'magazines';
              $dados_form['status'] = '1';
              $dados_form['id'] = $publicacoes->id;


              if ($this->painelbd->salvar('publicacoes', $dados_form) == TRUE):
                  setMsg('<p>Publicação editada com sucesso.</p>', 'success');
                  redirect('publicacoes/publicacoes/' . $id);
              else:
                  setMsg('<p>Erro! A publicação não foi editada.</p>', 'error');
              endif;
          }
      }


      $revistas = $this->painelbd->getQuery($sql)->row();
      $tipoRevista = $this->painelbd->getWhere('revistas', array('id' => $id))->row();



      $data = array(
          'titulo' => 'Início',
          'conteudo' => 'paineladm/itens_iniciacao/publicacoes/editar',
          'dados' => array(
              'cursos' => $this->painelbd->getCourses($campus)->result(),
              'revista' => $revistas,
              'revistas_titulo' => $tipoRevista->titulo,
              'revistas_id' => $tipoRevista->id,
              'tipo' => '')
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function anaisMonografia() {
      
      $data = array(
          'titulo' => 'Início',
          'conteudo' => 'paineladm/itens_iniciacao/publicacoes/anaisMonografia',
          'dados' => array(
              'cursos' => $this->painelbd->getCourses()->result(),
              'tipo' => 'anais'
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }
  
  public function cursosMonografia() {
      
      $data = array(
          'titulo' => 'Início',
          'conteudo' => 'paineladm/itens_iniciacao/publicacoes/cursosMonografia',
          'dados' => array(
              'cursos' => $this->painelbd->getCourses()->result(),
              'tipo' => 'anais'
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }


  public function publicacoesAnais() {
      $campus = '1'; //campus Paracatu 
      $id = $this->uri->segment(3);
      if (empty($id)) {
          redirect('publicacoes/publicacoes/anaisMonografia');
      }

      $tipoRevista = $this->painelbd->getWhere('revistas', array('id' => $id))->row();
      $aql = "SELECT 
              publicacoes.id,
              publicacoes.title,
              publicacoes.volume,
              publicacoes.number_vol,
              publicacoes.revistas_id as paginas_id,
              publicacoes.created,
              publicacoes.files,
              publicacoes.status,
              courses.name as 'courses',
              
              publicacoes.year,
              campus.name as 'campus'
          FROM
              at_site.publicacoes 
                  INNER JOIN courses ON courses.id = publicacoes.courses_id
                  INNER JOIN campus on campus.id = publicacoes.campus_id
                  INNER JOIN publication_type on publication_type.id = publicacoes.typepublicationid
                  AND campus.id = $campus
              WHERE publication_type.id =2
              AND courses.id = $id
              ORDER BY
              publicacoes.id DESC,
              publicacoes.created DESC";

      $dados = $this->painelbd->get_query($aql)->result();
      $data = array(
          'titulo' => 'Início',
          'conteudo' => 'paineladm/itens_iniciacao/publicacoes/anais/listaAnaisMonografia',
          'dados' => array(
              'curso' => $this->painelbd->getWhere('courses', array('id'=>$id))->row(),
              'tipo' => 'anais'
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }
  
  
  public function publicacoesMonografia() {
      $campus = '1'; //campus Paracatu 
      $id = $this->uri->segment(3);
      if (empty($id)) {
          redirect('publicacoes/publicacoes/cursosMonografia');
      }

      
      $aql = "SELECT 
                  *
              FROM
                  at_site.monography
              inner join courses on courses.id = monography.coursesid
              WHERE courses.id = $id";

      $monografias = $this->painelbd->getQuery($aql)->result();
      $data = array(
          'titulo' => 'Início',
          'conteudo' => 'paineladm/itens_iniciacao/publicacoes/monografias/listaMonografias',
          'dados' => array(
              'curso' => $this->painelbd->getWhere('courses', array('id'=>$id))->row(),
              'monografias' => $monografias,
              'tipo' => 'anais'
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function salvarAnais() {
      $this->load->helper('file');
      $campus = '1'; //campus Paracatu 
      $idCourse = $this->uri->segment(3);

      $this->form_validation->set_rules('title', 'Título', 'required');

      if ($this->input->post('courses_id') == '0') {
          $this->form_validation->set_rules('courses_id', 'Curso', 'select_validate');
          $this->form_validation->set_message('select_validate', 'Você precisa selecionar ao menos um curso.');
      } else {
          $this->form_validation->set_rules('courses_id', 'Curso');
      }

      $this->form_validation->set_rules('year', 'Ano', 'required');
      if (empty($_FILES['files']['name'])) {
          $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
          $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
      }
      $this->form_validation->set_rules('volume', 'Volume', 'required');
      $this->form_validation->set_rules('number_vol', 'Número do Volume', 'required');

      if ($this->form_validation->run() == FALSE) {
          if (validation_errors()):
              setMsg(validation_errors(), 'error');
          endif;
      }else {
          $path = 'assets/files/magazines';
          $name_tmp = preg_replace(array(
              "/(á|à|ã|â|ä)/",
              "/(Á|À|Ã|Â|Ä)/",
              "/(é|è|ê|ë)/",
              "/(É|È|Ê|Ë)/",
              "/(í|ì|î|ï)/",
              "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post('title'));
          $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', "’");

          // matriz de saída
          $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');

          // devolver a string
          $name_tmp = str_replace($what, $by, $name_tmp);


          $upload = $this->painelbd->do_uploadFiles('files', $path, $types = 'pdf', $name_tmp);

          if ($upload):
              //upload efetuado

              $dados_form = elements(array('title', 'courses_id', 'year', 'volume', 'number_vol', 'revistas_id'), $this->input->post());

              $dados_form['files'] = $path . '/' . $upload['file_name'];
              $dados_form['campus_id'] = $campus;
              $dados_form['users_id'] = $this->session->userdata('codusuario');
              $dados_form['types'] = 'anaisMonografia';
              $dados_form['typepublicationid'] = '1';
              $dados_form['status'] = '1';

              if ($id = $this->painelbd->do_insert('publicacoes', $dados_form)):
                  setMsg('<p>Publicação cadastrada com sucesso.</p>', 'success');
              else:
                  setMsg('<p>Erro! A publicação não foi cadastrada.</p>', 'error');
              endif;
          else:
              //erro no upload
              $msg = $this->upload->display_errors();
              $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
              setMsg($msg, 'erro');
          endif;
      }


      $condition = array('status' => 1, 'campus_id' => $campus);
      $dados = $this->painelbd->getWhere('publicacoes', $condition)->result();
      


      $data = array(
          'titulo' => 'Início',
          'conteudo' => 'paineladm/itens_iniciacao/publicacoes/anais/cadastrarAnais',
          'dados' => array(
              
              'curso' => $this->painelbd->getWhere('courses',array('id'=>$idCourse))->row(),
              
              'tipo' => '')
      );
      $this->load->view('templates/layoutPainelAdm', $data);
  }
  
  public function cadastrarMonografias() {
      $this->load->helper('file');
      $campus = '1'; //campus Paracatu 
      $idCourse = $this->uri->segment(3);

      $this->form_validation->set_rules('title', 'Título', 'required');

      

      $this->form_validation->set_rules('year', 'Ano', 'required');
      if (empty($_FILES['files']['name'])) {
          $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
          $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
      }

      if ($this->form_validation->run() == FALSE) {
          if (validation_errors()):
              setMsg(validation_errors(), 'error');
          endif;
      }else {
          
          $path = 'assets/files/spic/monography';
          $name_tmp = preg_replace(array(
              "/(á|à|ã|â|ä)/",
              "/(Á|À|Ã|Â|Ä)/",
              "/(é|è|ê|ë)/",
              "/(É|È|Ê|Ë)/",
              "/(í|ì|î|ï)/",
              "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $this->input->post('title'));
          $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', "’");

          // matriz de saída
          $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');

          // devolver a string
          $name_tmp = str_replace($what, $by, $name_tmp);


          $upload = $this->painelbd->do_uploadFiles('files', $path, $types = 'pdf', $name_tmp);

          if ($upload):
              $dados_form = elements(array('title', 'year', 'author','coursesid'), $this->input->post());
              $user = $this->session->userdata('codusuario');

              $dados_form['usersid'] = $user;
              $dados_form['files'] = $path . '/' . $upload['file_name'];
              $dados_form['status'] = '1';



              if ($id = $this->painelbd->salvar('monography', $dados_form)):
                  setMsg('<p>Monografia cadastrada com sucesso.</p>', 'success');
                  redirect("publicacoes/publicacoesMonografia/".$idCourse);
              else:
                  setMsg('<p>Erro! A Monografia não foi cadastrada.</p>', 'error');
                  redirect("publicacoes/publicacoesMonografia/".$idCourse);
              endif;
          else:
              //erro no upload
              $msg = $this->upload->display_errors();
              $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
              setMsg($msg, 'erro');
          endif;
      }


    
      $data = array(
          'titulo' => 'Início - Painel UniaAtenas',
          'conteudo' => 'paineladm/itens_iniciacao/publicacoes/monografias/CadastrarMonografias',
          'dados' => array(
              
              'curso' => $this->painelbd->getWhere('courses',array('id'=>$idCourse))->row(),
              
              'tipo' => 'revistas')
      );
      $this->load->view('templates/layoutPainelAdm', $data);
  }

}