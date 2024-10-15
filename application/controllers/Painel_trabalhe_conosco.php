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

  public function lista_imagens_termo_aceite($uriCampus = NULL, $idPagina = NuLL)
  {

    verificaLogin();

    $queryImagemLGPD =
      "SELECT 
        page_contents.id, page_contents.tipo, page_contents.img_destaque
        FROM page_contents 
        WHERE page_contents.pages_id = '$page->id'
        and page_contents.tiponz = 'imagem'";

    $imagemLGPD =  $this->bancosite->getQuery($queryImagemLGPD)->result();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunasPagina = array(
      'pages.id',
      'pages.title'
    );
    $pagina =  $this->painelbd->where($colunasPagina, 'pages', null, array('pages.id' => $idPagina))->row();

    $colunasConteudoPagina = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.img_destaque',
      'page_contents.description',
      'page_contents.order',
      'page_contents.created_at',
      'page_contents.updated_at',
      'page_contents.user_id',
      'campus.city'
    );
    $joinConteudoPagina = array(
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereConteudoPagina = array(
      'page_contents.pages_id' => $pagina->id,
      'page_contents.tipo' => 'imagem'
    );

    $conteudosPagina = $this->painelbd->where($colunasConteudoPagina, 'page_contents', $joinConteudoPagina, $whereConteudoPagina)->result();

    $data = array(
      'titulo' => 'UniAtenas - Submenu Serviços',
      'conteudo' => 'paineladm/servicos/pagina/itens_pagina/lista_item_pagina_especifica',
      'dados' => array(
        'conteudosPagina' => $conteudosPagina,
        'page' => "Lista itens específicos do Menu >> (<b>$pagina->title</b>) << -<strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'pagina' => $pagina,
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }






  public function editar_dados_cpa($uriCampus = NULL, $paginaId)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $pagina = 'cpa';
    $wherePagina = array('page_contents.id' => $paginaId);

    $joinConteudoPagina = array(
      'pages' => 'pages.id = page_contents.pages_id',
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

    $listaInformmacoesCPA = $this->painelbd->where($colunaResultadPagina, 'page_contents', $joinConteudoPagina, $wherePagina, null)->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

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

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
        redirect(base_url("Painel_trabalhe_conosco/lista_dados_cpa/$campus->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/campus/cpa/editar_dados_cpa',
      'dados' => array(
        'conteudosPagina' => $listaInformmacoesCPA,
        'page' => "Edição de Informações - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }


  public function deletar_item_cpa($uriCampus = NULL, $id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*', 'page_contents', NULL, array('page_contents.id' => $id))->row();

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_trabalhe_conosco/lista_dados_cpa/$uriCampus");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_trabalhe_conosco/lista_dados_cpa/$uriCampus");
    }
  }


  public function lista_arquivos_cpa($uriCampus = NULL, $idConteudoPagina = NULL)
  {

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $coluntaResultadoConteudoItemCPA = array(
      'page_contents.title',
      'page_contents.id',
      'page_contents.pages_id'
    );
    $whereConteudoItemCPA = array('page_contents.id' => $idConteudoPagina);
    $conteudoItemCPA = $this->painelbd->where($coluntaResultadoConteudoItemCPA, 'page_contents', NULL, $whereConteudoItemCPA)->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $conteudoItemCPA->pages_id);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();


    $colunaResultadoArquivosItensCpa = array(
      'page_contents_files.id',
      'page_contents_files.title',
      'page_contents_files.id_page_contents',
      'page_contents_files.status',
      'page_contents_files.files',
      'page_contents_files.order',
      'page_contents_files.created_at',
      'page_contents_files.updated_at',
      'page_contents_files.user_id',
    );

    $joinArquivosConteudosCpa = array(
      'page_contents' => 'page_contents.id = page_contents_files.id_page_contents',
    );
    $whereArquivosConteudosCpa = array('page_contents_files.id_page_contents' => $conteudoItemCPA->id);
    $listaArquivosConteudosCpa = $this->painelbd->where($colunaResultadoArquivosItensCpa, 'page_contents_files', $joinArquivosConteudosCpa, $whereArquivosConteudosCpa,)->result();

    $data = array(
      'titulo' => 'Arquivos CPA - Painel ADM',
      'conteudo' => 'paineladm/campus/cpa/arquivos/lista_arquivos_cpa',
      'dados' => array(
        'page' => "Lista Arquivos <u><i> $conteudoItemCPA->title </i></u> <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'listaArquivosConteudosCpa' => $listaArquivosConteudosCpa,
        'conteudoItemCPA' => $conteudoItemCPA,
        'campus' => $campus,
        'pagina' => $pagina,
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_arquivos_cpa($uriCampus = NULL, $idConteudoPagina = NULL)
  {
    $this->load->helper('file');

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $coluntaResultadoConteudoItemCPA = array(
      'page_contents.title',
      'page_contents.id',
      'page_contents.pages_id'
    );
    $whereConteudoItemCPA = array('page_contents.id' => $idConteudoPagina);
    $conteudoItemCPA = $this->painelbd->where($coluntaResultadoConteudoItemCPA, 'page_contents', NULL, $whereConteudoItemCPA)->row();


    $this->form_validation->set_rules('title', 'Título arquivo', 'required');
    $this->form_validation->set_rules('order', 'Ordem', 'required');

    if (empty($_FILES['files']['name'])) {
      $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
      $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
    }

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) {
        setMsg(validation_errors(), 'error');
      }
    } else {
      $path = "assets/files/CPA/$campus->id";
      is_way($path);

      if (unique_name_args(noAccentuation($this->input->post('title'), NULL), $path)) {
        $name_tmp = null;
      } else {
        $name_tmp = noAccentuation($this->input->post('title'), NULL);
      }
      //$name_tmp = noAccentuation($this->input->post('title').'-'.$this->input->post('year').'-'.date('h:i:s d/m/Y'));
      $upload = $this->painelbd->uploadFiles('files', $path, $types = 'PDF|pdf', $name_tmp);

      if ($upload) {
        //upload efetuado
        $dados_form = elements(array('title', 'order', 'status'), $this->input->post());
        $dados_form['id_page_contents'] = $conteudoItemCPA->id;
        $dados_form['files'] = $path . '/' . $upload['file_name'];
        $dados_form['user_id'] = $this->session->userdata('codusuario');

        if ($this->painelbd->salvar('page_contents_files', $dados_form) == TRUE) {
          setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
          redirect("Painel_trabalhe_conosco/lista_arquivos_cpa/$campus->id/$conteudoItemCPA->id");
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }
    $data = array(
      'titulo' => 'Arquivos CPA - Painel ADM',
      'conteudo' => 'paineladm/campus/cpa/arquivos/cadastrar_arquivos_cpa',
      'dados' => array(
        'page' => "Cadastro de Arquivos CPA >> ITEM <u><i> $conteudoItemCPA->title</i></u> <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'conteudoItemCPA' => $conteudoItemCPA,
        'campus' => $campus,
        //'pagina'=>$pagina,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }



  public function deletar_arquivo_cpa($uriCampus = NULL, $idConteudoItemCPA = NULL, $id = null)
  {

    $item = $this->painelbd->where('*', 'page_contents_files', NULL, array('page_contents_files.id' => $id))->row();

    $arquivo = $item->files;

    if ($this->painelbd->deletar('page_contents_files', $item->id)) {
      unlink($item->files);
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_trabalhe_conosco/lista_arquivos_cpa/$uriCampus/$idConteudoItemCPA");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_trabalhe_conosco/lista_arquivos_cpa/$uriCampus/$idConteudoItemCPA");
    }
  }
}
