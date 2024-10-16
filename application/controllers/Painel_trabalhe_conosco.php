<?php

if (!defined("BASEPATH"))
  exit("No direct script access allowed");

class Painel_trabalhe_conosco extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('painel_model', 'painelbd');
    date_default_timezone_set('America/Sao_Paulo');
  }

  public function lista_campus_trabalhe_conosco()
  {
    verificaLogin();

    $colunasCampus =
      array(
        'campus.id',
        'campus.name',
        'campus.city',
        'campus.uf'
      );

    $listagemDosCampus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('visible' => 'SIM'))->result();
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/trabalhe_conosco/lista_campus_trabalhe_conosco',
      'dados' => array(
        'page' => "Links e informações - Trabalhe Conosco",
        'campus' => $listagemDosCampus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_pagina_trabalhe_conosco($uriCampus = NULL)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $verificaExistePagina = $this->painelbd->where('*', 'pages', null, array('pages.title' => 'trabalheconosco', 'pages.campusid' => $campus->id))->row();

    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['title'] = 'trabalheconosco';
      $dados_form['status'] = $this->input->post('status');
      $dados_form['campusid'] = $campus->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if (isset($verificaExistePagina)) {
        $dados_form['id'] = $verificaExistePagina->id;

        if ($this->painelbd->salvar('pages', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (menu) Trabalhe Conosco atualizado com sucesso.</p>', 'success');
          redirect(base_url("Painel_trabalhe_conosco/cadastrar_pagina_trabalhe_conosco/$campus->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      } else {
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (menu) Trabalhe Conosco cadastrado com sucesso.</p>', 'success');
          redirect(base_url("Painel_trabalhe_conosco/cadastrar_pagina_trabalhe_conosco/$campus->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/trabalhe_conosco/pagina_menu_trabalhe_conosco/cadastrar_pagina_trabalhe_conosco',
      'dados' => array(
        'paginaTrabalheConosco' => $verificaExistePagina = isset($verificaExistePagina) ? $verificaExistePagina : '',
        'page' => "Cadastro de pagina (menu do site) Trabalhe Conosco - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_informacoes_trabalhe_conosco($uriCampus = NULL)
  {
    verificaLogin();

    $pagina = 'trabalheconosco';
    $verificaExistePaginaTrabalheConosco = $this->painelbd->where('*', 'pages', null, array('pages.campusid' => $uriCampus, 'pages.title' => $pagina))->row();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $listaInformmacoesTrabalheConosco =  $this->painelbd->getQuery(
      "SELECT 
          page_contents.id,
          page_contents.title,
          page_contents.img_destaque,
          page_contents.status,
          page_contents.title_short,
          page_contents.description, 
          page_contents.order, 
          page_contents.created_at, 
          page_contents.updated_at, 
          page_contents.user_id, 
          campus.city
        FROM 
          page_contents
        INNER JOIN pages ON pages.id = page_contents.pages_id
        INNER JOIN campus ON campus.id= pages.campusid
        WHERE 
            pages.title = '$pagina'AND 
            pages.campusid = $campus->id AND 
            page_contents.order <>'contatos' AND 
            page_contents.status=1 
        ORDER BY page_contents.order ASC"
    )->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/trabalhe_conosco/lista_informacoes_trabalhe_conosco',
      'dados' => array(
        'conteudosPagina' => $listaInformmacoesTrabalheConosco,
        'page' => "Página Trabalhe Conosco - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'paginaTrabalheConosco' => $verificaExistePaginaTrabalheConosco = isset($verificaExistePaginaTrabalheConosco) ? $verificaExistePaginaTrabalheConosco : '',
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_itens_trabalhe_conosco($uriCampus = NULL, $idPagina = NuLL)
  {

    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $verificaExistePaginaTrabalheConosco = $this->painelbd->where('*', 'pages', null, array('pages.campusid' => $uriCampus, 'pages.id' => $idPagina))->row();

    $colunasPagina = array('pages.id', 'pages.title');
    $pagina =  $this->painelbd->where($colunasPagina, 'pages', null, array('pages.id' => $idPagina))->row();

    $colunasConteudoPagina = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.img_destaque',
      'page_contents.description',
      'page_contents.tipo',
      'page_contents.created_at',
      'page_contents.updated_at',
      'page_contents.user_id',
      'campus.city'
    );
    $joinConteudoPagina = array('pages' => 'pages.id = page_contents.pages_id', 'campus' => 'campus.id = pages.campusid');
    $whereConteudoPagina = array('page_contents.pages_id' => $pagina->id);

    $conteudosPagina = $this->painelbd->where($colunasConteudoPagina, 'page_contents', $joinConteudoPagina, $whereConteudoPagina)->result();

    $data = array(
      'titulo' => 'UniAtenas - Submenu Trabalhe Conosco',
      'conteudo' => 'paineladm/trabalhe_conosco/informacoes/lista_itens_trabalhe_conosco',
      'dados' => array(
        'conteudosPagina' => $conteudosPagina,
        'page' => "Lista itens Trabalhe Conosco <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'pagina' => $pagina,
        'paginaTrabalheConosco' => $verificaExistePaginaTrabalheConosco = isset($verificaExistePaginaTrabalheConosco) ? $verificaExistePaginaTrabalheConosco : '',
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_trabalhe_conosco($uriCampus = NULL,  $idPagina, $id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*', 'page_contents', NULL, array('page_contents.id' => $id))->row();

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Item foi deletado com sucesso.</p>', 'success');
      redirect("Painel_trabalhe_conosco/lista_itens_trabalhe_conosco/$uriCampus/$idPagina");
    } else {
      setMsg('<p>Erro! O Item foi não deletado.</p>', 'error');
      redirect("Painel_trabalhe_conosco/lista_itens_trabalhe_conosco/$uriCampus/$idPagina");
    }
  }


  public function cadastrar_itens_trabalhe_conosco($uriCampus = NULL, $pageId = null)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunasTabelaPages = array('pages.id', 'pages.title');
    $joinConteudoPagina = array('campus' => 'campus.id= pages.campusid');
    $wherePagina = array('pages.id' => $pageId, 'pages.campusid' => $campus->id);

    $pagina = $this->painelbd->where($colunasTabelaPages, 'pages', $joinConteudoPagina, $wherePagina, null)->row();
    $verificaExistePaginaTrabalheConosco = $this->painelbd->where('*', 'pages', null, array('pages.campusid' => $uriCampus, 'pages.id' => $pagina->id))->row();

    if (!isset($pagina)) {
      redirect(base_url("Painel_trabalhe_conosco/lista_informacoes_trabalhe_conosco/$campus->id"));
    }

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {
      if (!empty($this->input->post('description'))) {
        $dados_form['description'] = $this->input->post('description');
      }
      if (!empty($this->input->post('link_redir'))) {
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }

      $dados_form['title'] = $this->input->post('title');
      $dados_form['tipo'] = $this->input->post('tipo');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['pages_id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Dados da página cadastrados com sucesso.</p>', 'success');
        redirect(base_url("Painel_trabalhe_conosco/lista_itens_trabalhe_conosco/$campus->id/$pagina->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas - Itens trabalhe Conosco',
      'conteudo' => 'paineladm/trabalhe_conosco/informacoes/cadastrar_itens_trabalhe_conosco',
      'dados' => array(
        'pagina' => $pagina,
        'page' => "Cadastro de informações - Trabalhe Conosco - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'paginaTrabalheConosco' => $verificaExistePaginaTrabalheConosco = isset($verificaExistePaginaTrabalheConosco) ? $verificaExistePaginaTrabalheConosco : '',
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_itens_trabalhe_conosco($uriCampus = NULL, $paginaId = null, $itemId = null)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    if (!isset($paginaId)) {
      redirect(base_url("Painel_trabalhe_conosco/lista_informacoes_trabalhe_conosco/$campus->id"));
    }

    $wherePagina = array('pages.id' => $paginaId, 'pages.campusid' => $campus->id);
    $colunasTabelaPages = array('pages.id', 'pages.title');
    $joinConteudoPagina = array('campus' => 'campus.id = pages.campusid');

    $pagina = $this->painelbd->where($colunasTabelaPages, 'pages', $joinConteudoPagina, $wherePagina, null)->row();

    $colunasTabelaPagesTrabalheConosco = array('page_contents.id', 'page_contents.title', 'page_contents.description', 'page_contents.tipo', 'page_contents.img_destaque', 'page_contents.link_redir', 'page_contents.status');
    $joinConteudoPagina = array('pages' => 'pages.id = page_contents.pages_id');
    $wherePaginaTrabalheConosco = array('page_contents.id' => $itemId);

    $paginaTrabalheConosco = $this->painelbd->where($colunasTabelaPagesTrabalheConosco, 'page_contents', $joinConteudoPagina, $wherePaginaTrabalheConosco, null)->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {
      if ($paginaTrabalheConosco->description != $this->input->post('description')) {
        $dados_form['description'] = $this->input->post('description');
      }
      if ($paginaTrabalheConosco->description != $this->input->post('link_redir')) {
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }
      if ($paginaTrabalheConosco->title != $this->input->post('title')) {
        $dados_form['title'] = $this->input->post('title');
      }
      if ($paginaTrabalheConosco->tipo != $this->input->post('tipo')) {
        $dados_form['tipo'] = $this->input->post('tipo');
      }
      if ($paginaTrabalheConosco->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }

      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['id'] = $paginaTrabalheConosco->id;

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Dados da página cadastrados com sucesso.</p>', 'success');
        redirect(base_url("Painel_trabalhe_conosco/lista_itens_trabalhe_conosco/$campus->id/$pagina->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas - Itens trabalhe Conosco',
      'conteudo' => 'paineladm/trabalhe_conosco/informacoes/editar_itens_trabalhe_conosco',
      'dados' => array(
        'pagina' => $pagina,
        'page' => "Edição de informações - Trabalhe Conosco - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'paginaTrabalheConosco' => $paginaTrabalheConosco = isset($paginaTrabalheConosco) ? $paginaTrabalheConosco : '',
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_imagens_termo_aceite($uriCampus = NULL, $idPagina = NuLL, $idPaginaConteudo = Null)
  {

    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunasPagina = array('pages.id', 'pages.title');
    $pagina =  $this->painelbd->where($colunasPagina, 'pages', null, array('pages.id' => $idPagina))->row();
    $colunasPaginaConteudo = array('page_contents.id');
    $paginaConteudos =  $this->painelbd->where($colunasPaginaConteudo, 'page_contents', null, array('page_contents.id' => $idPaginaConteudo))->row();

    $colunasConteudoPagina = array(
      'page_contents.id as idPageContents',
      'page_contents_photos.id',
      'page_contents_photos.title',
      'page_contents_photos.status',
      'page_contents_photos.file',
      'page_contents_photos.created_at',
      'page_contents_photos.updated_at',
      'page_contents_photos.user_id'
    );
    $joinConteudoPagina = array(
      'page_contents' => 'page_contents.id = page_contents_photos.id_page_contents',
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereConteudoPagina = array(
      'page_contents.id' => $idPaginaConteudo
    );

    $conteudosPagina = $this->painelbd->where($colunasConteudoPagina, 'page_contents_photos', $joinConteudoPagina, $whereConteudoPagina)->result();

    $data = array(
      'titulo' => 'UniAtenas - Submenu Trabalhe Conosco',
      'conteudo' => 'paineladm/trabalhe_conosco/imagens/lista_imagens_termo_aceite',
      'dados' => array(
        'conteudosPagina' => $conteudosPagina,
        'page' => "Lista imagens do Termo de Aceite -  >> (<b>$pagina->title</b>) << -<strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'pagina' => $pagina,
        'paginaConteudos' => $paginaConteudos,
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_imagem_termo_aceite($uriCampus = NULL, $idPagina = NULL, $idPaginaConteudos = null)
  {
    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunasPagina = array('pages.id', 'pages.title');
    $pagina =  $this->painelbd->where($colunasPagina, 'pages', null, array('pages.id' => $idPagina))->row();

    $colunasPaginaConteudo = array('page_contents.id');
    $paginaConteudos =  $this->painelbd->where($colunasPaginaConteudo, 'page_contents', null, array('page_contents.id' => $idPaginaConteudos))->row();

    $this->form_validation->set_rules('title', 'Título', 'required');

    if (empty($_FILES['file'])) {
      $_FILES['file']['size'][0] = 0;
    }

    if ($_FILES['file']['size'][0] <= 0) {
      $this->form_validation->set_rules('file', 'Arquivo', 'callback_file_check');
      $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPEG, PNG ou JPG.');
    }

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()):
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $path = "assets/images/trabalheConosco/$campus->id/";
      is_way($path);
      $number_of_files = count($_FILES['file']['name']);
      $files = $_FILES;

      for ($i = 0; $i < $number_of_files; $i++) {
        $_FILES['file']['name'] = $files['file']['name'][$i];
        $_FILES['file']['type'] = $files['file']['type'][$i];
        $_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$i];
        $_FILES['file']['error'] = $files['file']['error'][$i];
        $_FILES['file']['size'] = $files['file']['size'][$i];

        $name_tmp = noAccentuation($this->input->post('title') . '-' . [$i]);
        $upload = $this->painelbd->uploadFiles('file', $path, $types = 'jpg|JPG|jpeg|JPEG|png|PNG', $name_tmp);

        if ($upload) {
          $dados_form['user_id'] = $this->session->userdata('codusuario');
          $dados_form['file'] = $path . '/' . $upload['file_name'];
          $dados_form['title'] = $this->input->post('title');
          $dados_form['status'] = $this->input->post('status');
          $dados_form['id_page_contents'] =  $paginaConteudos->id;
          // $dados_form['categoria'] = trim($categoriaInfraestrutura->title);


          if ($id = $this->painelbd->salvar('page_contents_photos', $dados_form)) {
            if ($number_of_files == ($i + 1)) {
              setMsg('<p>Imagem cadastrada com sucesso.</p>', 'success');
              redirect("Painel_trabalhe_conosco/lista_imagens_termo_aceite/$campus->id/$pagina->id/$paginaConteudos->id");
            }
          } else {
            setMsg('<p>Erro! A Imagem não pode ser cadastrada.</p>', 'error');
          }
        } else {
          //erro no upload
          $msg = $this->upload->display_errors();
          $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
          setMsg($msg, 'erro');
        }
      }
    }

    $data = array(
      'conteudo' => 'paineladm/trabalhe_conosco/imagens/cadastrar_imagem_termo_aceite',
      'titulo' => "Termoo de Aceite - Trabalhe Conosco  $campus->name - $campus->city",
      'dados' => array(
        'tipo' => '',
        'campus' => $campus,
        'paginaConteudos' => $paginaConteudos,
        'pagina' => $pagina,
        'page' => "<span>Cadastro imagem <strong>Termo de aceite <i>$campus->name - $campus->city</i></strong></span>",
      )
    );
    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_imgem_termo_aceite($uriCampus = NULL, $idImagemTermoAceite = NULL, $id = null)
  {

    $item = $this->painelbd->where('*', 'page_contents_files', NULL, array('page_contents_files.id' => $id))->row();

    $arquivo = $item->files;

    if ($this->painelbd->deletar('page_contents_files', $item->id)) {
      unlink($item->files);
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_trabalhe_conosco/lista_arquivos_cpa/$uriCampus/$idImagemTermoAceite");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_trabalhe_conosco/lista_arquivos_cpa/$uriCampus/$idImagemTermoAceite");
    }
  }
}
