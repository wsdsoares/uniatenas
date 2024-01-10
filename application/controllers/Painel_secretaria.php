<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Painel_secretaria extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('acesso_model', 'acesso');
    $this->load->model('inicio_model', 'inicio');
    $this->load->model('painel_model', 'painelbd');
    $this->load->model('Cpainel_model', 'bd');
    date_default_timezone_set('America/Sao_Paulo');
    verificaLogin();
  }

  public function lista_campus_secretaria()
  {
    verificaLogin();

    $colunasResultadoCursos =
      array(
        'campus.id',
        'campus.name',
        'campus.city',
        'campus.uf'
      );

    $listagemDosCampus = $this->painelbd->where('*', 'campus', NULL, array('visible' => 'SIM'))->result();
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/secretaria/lista_campus_secretaria',
      'dados' => array(
        'page' => "Lista informações calendário - Secretaria Acadêmica",
        'campus' => $listagemDosCampus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_informacoes_secretaria($uriCampus = NULL)
  {
    verificaLogin();

    $pagina = 'secretariaacademica';
    $verificaExistePaginaSecretaria = $this->painelbd->where('*', 'pages', null, array('pages.campusid' => $uriCampus, 'pages.title' => $pagina))->row();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/secretaria/lista_informacoes_secretaria',
      'dados' => array(
        'conteudosPagina' => '',
        //'contatosPaginaSecretaria'=>$contatosPaginaSecretaria,
        'page' => "Cadastro de informações da Secretaria - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'paginaSecretaria' => $verificaExistePaginaSecretaria = isset($verificaExistePaginaSecretaria) ? $verificaExistePaginaSecretaria : '',
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_itens_secretaria($uriCampus = NULL, $pageId = null)
  {
    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();


    $queryItensSecretaria = "
    SELECT 
    page_contents.id,
    page_contents.title,
    page_contents.title_short,
    page_contents.status,
    page_contents.tipo,
    page_contents.order,
    page_contents.description,
    page_contents.link_redir,
    page_contents.created_at,
    page_contents.updated_at,
    page_contents.user_id
    FROM
        page_contents
        JOIN pages ON pages.id = page_contents.pages_id
        JOIN campus ON campus.id = pages.campusid
    WHERE
        page_contents.pages_id = $pagina->id AND 
        page_contents.tipo = 'informacoesPagina' AND
        page_contents.order NOT IN ('linkComutacao','comutacao')
    ORDER BY page_contents.title ASC
    ";

    $listaItensPaginaSecretaria = $this->painelbd->getQuery($queryItensSecretaria)->result();

    $data = array(
      'titulo' => 'Secretaria Acadêmica - Uniatenas',
      'conteudo' => 'paineladm/secretaria/itens/lista_itens_secretaria',
      'dados' => array(
        'page' => "Informações da página SECRETARIA- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina' => $pagina,
        'listaItensPaginaSecretaria' => $listaItensPaginaSecretaria = isset($listaItensPaginaSecretaria) ? $listaItensPaginaSecretaria : '',
        'campus' => $campus,
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_itens_secretaria($uriCampus = NULL, $pageId = NULL)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadoPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadoPagina, 'pages', $joinPagina, $wherePagina)->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    // $this->form_validation->set_rules('title_short', 'Subtítulo', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    // $this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['description'] = $this->input->post('description');

      if (!empty($this->input->post('title_short'))) {
        $dados_form['title_short'] = $this->input->post('title_short');
      }

      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['order'] = $this->input->post('order');
      $dados_form['tipo'] = 'informacoesPagina';
      $dados_form['pages_id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Dados cadastrados com sucesso.</p>', 'success');
        redirect(base_url("Painel_secretaria/lista_itens_secretaria/$campus->id/$pagina->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/secretaria/itens/cadastrar_itens_secretaria',
      'dados' => array(
        'page' => "Cadastro de informações SECRETARIA ACADÊMICA - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'pagina' => $pagina,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_itens_secretaria($uriCampus = NULL, $pageId = null, $idInformacao = null)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadoPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadoPagina, 'pages', $joinPagina, $wherePagina)->row();

    $informacoesSecretaria = $this->painelbd->where("*", 'page_contents', null, array('page_contents.id' => $idInformacao))->row();

    //Validaçãoes via Form Validation
    $this->form_validation->set_rules('title', 'Titulo', 'required');
    //$this->form_validation->set_rules('title_short', 'Subtítulo', 'required');
    $this->form_validation->set_rules('description', 'Descrição', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    //$this->form_validation->set_rules('order', 'Ordem', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {
      if ($informacoesSecretaria->description !== $this->input->post('description')) {
        $dados_form['description'] = $this->input->post('description');
      }
      if ($informacoesSecretaria->title_short !== $this->input->post('title_short') and !empty($this->input->post('title_short'))) {
        $dados_form['title_short'] = $this->input->post('title_short');
      }
      if ($informacoesSecretaria->title !== $this->input->post('title') and !empty($this->input->post('title'))) {
        $dados_form['title'] = $this->input->post('title');
      }
      if ($informacoesSecretaria->status !== $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }

      if ($informacoesSecretaria->order !== $this->input->post('order')) {
        $dados_form['order'] = $this->input->post('order');
      }

      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['id'] = $informacoesSecretaria->id;
      $dados_form['updated_at'] = date('Y-m-d H:i:s');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Dados editados com sucesso.</p>', 'success');
        redirect(base_url("Painel_secretaria/lista_itens_secretaria/$campus->id/$pagina->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/secretaria/itens/editar_itens_secretaria',
      'dados' => array(
        'informacoesSecretaria' => $informacoesSecretaria,
        'page' => "Edição de informações SECRETARIA ACADÊMICA- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'pagina' => $pagina,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_secretaria($uriCampus = NULL, $pagina = null, $id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*', 'page_contents', NULL, array('page_contents.id' => $id))->row();

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_secretaria/lista_itens_secretaria/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_secretaria/lista_itens_secretaria/$uriCampus/$pagina");
    }
  }


  public function cadastrar_pagina_secretaria($uriCampus = NULL)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $verificaExistePagina = $this->painelbd->where('*', 'pages', null, array('pages.title' => 'secretariaacademica', 'pages.campusid' => $campus->id))->row();

    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['title'] = 'secretariaacademica';
      $dados_form['status'] = $this->input->post('status');
      $dados_form['campusid'] = $campus->id;

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if (isset($verificaExistePagina)) {
        $dados_form['id'] = $verificaExistePagina->id;
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (menu) Secretaria atualizados com sucesso.</p>', 'success');
          redirect(base_url("Painel_secretaria/cadastrar_pagina_secretaria/$campus->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      } else {
        if ($this->painelbd->salvar('pages', $dados_form) == TRUE) {
          setMsg('<p>Dados da página (menu) Secretaria cadastrados com sucesso.</p>', 'success');
          redirect(base_url("Painel_secretaria/cadastrar_pagina_secretaria/$campus->id"));
        } else {
          setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/secretaria/pagina_menu_secretaria/cadastrar_pagina_secretaria',
      'dados' => array(
        'paginaSecretaria' => $verificaExistePagina = isset($verificaExistePagina) ? $verificaExistePagina : '',
        'page' => "Cadastro/Edição de pagina (menu do site) do Secretaria - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function calendarios_semestre($uriCampus = null, $pageId = null)
  {

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $field = array(
      'campus_calendars.id',
      'campus_calendars.name',
      'campus_calendars.year',
      'campus_calendars.status',
      'campus_calendars.semester',
      'campus_calendars.files',
      'campus_calendars.datacreated',
      'campus_calendars.datemodified',
      'campus_calendars.usersid',
      'campus_calendars.type',
      'campus.city'
    );
    $table = 'campus_calendars';
    $datajoin = array('campus' => 'campus_calendars.campusid = campus.id');
    $where = array('campusid' => $campus->id);
    $order = array('campo' => 'id', 'ordem' => 'DESC');

    $listagem = $this->bd->Where($field, $table, $datajoin, $where, $order)->result();
    $table = str_replace('=', '', base64_encode($table));
    $data = array(
      'titulo' => 'Lista de Calendários ',
      'conteudo' => 'paineladm/secretaria/calendariosSemestre/lista_calendarios',
      'dados' => array(
        // 'permissionCampusArray' => $_SESSION['permissionCampus'],
        // 'namecity' => $namecity,
        'listagem' => $listagem,
        'campus' => $campus,
        'pagina' => $pagina,
        'page' => "Calendários Semestre - $campus->name $campus->city",
        'tipo' => 'tabelaDatatable',
        'table' => $table
      )
    );
    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_calendarios_semestre($uriCampus = null, $pageId = NULL)
  {

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $this->load->helper('file');
    verificaLogin();
    if ($uriCampus == null) {
      redirect('painel');
    }

    $this->form_validation->set_rules('title', 'Titulo', 'required');
    $this->form_validation->set_rules('semestre', 'Semestre', 'required');
    $this->form_validation->set_rules('year', 'Ano ', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');
    $this->form_validation->set_rules('tipo', 'Tipo de curso', 'required');


    if (empty($_FILES['files']['name'])) {
      $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
      $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
    }

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'erro');
      endif;
    } else {
      $path = "assets/secretaria/calendariosSemestre/$campus->id/";
      is_way($path);
      if (unique_name_args(noAccentuation($this->input->post('title'), 'Calendar'), $path)) {
        $name_tmp = null;
      } else {
        $name_tmp = noAccentuation($this->input->post('title'), 'Calendar');
      }

      $upload = $this->bd->uploadFiles('files', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF', $name_tmp);

      if ($upload) {
        //upload efetuado
        if ($this->input->post('tipo') == 1) {
          $curso = 'demais_cursos';
        } elseif ($this->input->post('tipo') == 2) {
          $curso = 'medicina';
        } elseif ($this->input->post('tipo') == 3) {
          $curso = 'medicina';
        }
        //coleta de dados
        $dados_form['campusid'] = $campus->id;
        $dados_form['name'] = $this->input->post('title');
        $dados_form['year'] = $this->input->post('year');
        $dados_form['semester'] = $this->input->post('semestre');
        $dados_form['status'] = $this->input->post('status') - 1;
        $dados_form['files'] = $path . $upload['file_name'];
        $dados_form['usersid'] = $this->session->userdata('codusuario');
        $dados_form['type'] = $curso;
        //salvando
        if ($this->painelbd->salvar('campus_calendars', $dados_form) == TRUE) {
          setMsg('<p>Calendário  cadastrada com sucesso.</p>', 'success');
          redirect("Painel_secretaria/calendarios_semestre/$campus->id/$pagina->id");
        } else {
          setMsg('<p>Erro! O calendário  não foi cadastrada.</p>', 'error');
          redirect("Painel_secretaria/calendarios_semestre/$campus->id/$pagina->id");
        }
      } else {
        //erro no upload
        $msg = $this->upload->display_erros();
        $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
        setMsg($msg, 'erro');
      }
    }
    $sql = "SELECT max(school_semester.year_semester) as ano FROM at_site.school_semester";
    $ano = $this->painelbd->getQuery($sql)->row();
    //devolvendo o formulario
    $data = array(
      'titulo' => "Cadastro de Calendários - Semestre",
      'conteudo' => 'paineladm/secretaria/calendariosSemestre/cadastrar_calendarios_semestre',
      'dados' => array(
        //'permissionCampusArray' => $_SESSION['permissionCampus'],
        //'table' => $tableD,
        'ano' => $ano->ano,
        'campus' => $campus,
        'pagina' => $pagina,
        //'namecity' => $namecity,
        'tipo' => 'calendario',
        'page' => "Cadastro de calendários $campus->name $campus->city"
      )
    );
    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_calendario_semestre($uriCampus = null, $id = NULL, $pageId = NULL)
  {
    $this->load->helper('file');
    date_default_timezone_set('America/Sao_Paulo');
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $field = array(
      'campus_calendars.id',
      'campus_calendars.name',
      'campus_calendars.year',
      'campus_calendars.status',
      'campus_calendars.semester',
      'campus_calendars.files',
      'campus_calendars.datacreated',
      'campus_calendars.datemodified',
      'campus_calendars.usersid',
      'campus_calendars.type',
      'campus.city'
    );
    $table = 'campus_calendars';
    $datajoin = array('campus' => 'campus_calendars.campusid = campus.id ');
    $where = array('campusid' => $campus->id, 'campus_calendars.id' => $id);

    $listagem = $this->bd->Where($field, $table, $datajoin, $where)->row();
    $this->form_validation->set_rules('title', 'Título', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {
      if ($this->input->post('tipo') == 1) {
        $curso = 'demais_cursos';
      } elseif ($this->input->post('tipo') == 2) {
        $curso = 'medicina';
      } elseif ($this->input->post('tipo') == 3) {
        $curso = 'medicina';
      } else {
        $curso = ' ';
      }

      if ($listagem->name != $this->input->post('title')) {
        $dados_form['name'] = $this->input->post('title');
      }
      if ($listagem->semester != $this->input->post('semestre')) {
        $dados_form['semester'] = $this->input->post('semestre');
      }
      if ($listagem->year != $this->input->post('year')) {
        $dados_form['year'] = $this->input->post('year');
      }
      if ($listagem->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }
      if ($listagem->type != $curso) {
        $dados_form['type'] = $curso;
      }

      if (isset($_FILES['files']) && !empty($_FILES['files']['name'])) {
        $path = "assets/secretaria/calendariosSemestre/$campus->id";
        is_way($path);

        if (unique_name_args(noAccentuation($this->input->post('title'), 'Calendar'), $path)) {
          $name_tmp = null;
        } else {
          $name_tmp = noAccentuation($this->input->post('title'), 'Calendar');
        }
        $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF|doc|DOC|docx|DOCX', $name_tmp);

        if ($upload) {
          //upload efetuado
          $dados_form['files'] = $path . '/' . $upload['file_name'];
        } else {
          //erro no upload
          $msg = $this->upload->display_errors();
          $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
          setMsg($msg, 'erro');
        }
      }

      $dados_form['usersid'] = $this->session->userdata('codusuario');
      $dados_form['datemodified'] = date('Y-m-d H:i:s');
      $dados_form['id'] = $id;

      if ($this->painelbd->salvar($table, $dados_form) == TRUE) {
        setMsg('<p>Dados alterados com sucesso.</p>', 'success');
        redirect("Painel_secretaria/calendarios_semestre/$campus->id/$pagina->id");
      } else {
        setMsg('<p>Erro! Os dados não foi alterado.</p>', 'error');
        redirect("Painel_secretaria/calendarios_semestre/$campus->id/$pagina->id");
      }
    }

    $sql = "SELECT max(school_semester.year_semester) as ano FROM at_site.school_semester";
    $ano = $this->painelbd->getQuery($sql)->row();
    $tipo = $listagem->type;
    if ($tipo == 'demais_cursos') {
      $idtipo = 1;
    } elseif ($tipo == 'medicina') {
      $idtipo = 2;
    } elseif ($tipo == 'Medicina-Omega') {
      $idtipo = 3;
    } else {
      $idtipo = 4;
    }
    //devolvendo o formulario
    $data = array(
      'titulo' => "Editar Calendadario",
      'conteudo' => 'paineladm/secretaria/calendariosSemestre/editar_calendario_semestre',
      'dados' => array(
        //'permissionCampusArray' => $_SESSION['permissionCampus'],
        'id' => $id,
        'idtipo' => $idtipo,
        'listagem' => $listagem,
        'ano' => $ano->ano,
        'campus' => $campus,
        'pagina' => $pagina,
        'page' => "Edição de informações Calendário Acadêmico",
        'tipo' => 'calendario',
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_calendario_semestre($campusId = NULL, $pageId = NULL, $idCalendario = NULL)
  {
    verifica_login();
    $item = $this->painelbd->where('*', 'campus_calendars', NULL, array('campus_calendars.id' => $idCalendario))->row();
    if ($this->painelbd->deletar('campus_calendars', $item->id)) {
      setMsg('<p>O item foi deletado com sucesso.</p>', 'success');
      redirect(base_url("Painel_secretaria/calendarios_semestre/$campusId/$pageId"));
    } else {
      setMsg('<p>Erro! O item foi não deletado.</p>', 'error');
      redirect(base_url("Painel_secretaria/calendarios_semestre/$campusId/$pageId"));
    }
  }
  /*Arqujivo -  Atividades compplementares*/
  public function lista_atividades_complementares($uriCampus = null, $pageId = null)
  {

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $field = array(
      'files.id',
      'files.name',
      'files.files',
      'files.status',
      'files.typesfile',
      'files.user_id',
      'files.created_at',
      'files.updated_at',
      'files.campusid',
      'campus.city'
    );
    $table = 'files_has_pages';
    $datajoin = array(

      'files' => 'files_has_pages.filesid = files.id',
      'campus' => 'files.campusid = campus.id'
    );
    $where = array(
      'files.campusid' => $campus->id,
      'files.typesfile' => 'cartilha'
    );

    $listagem = $this->painelbd->Where($field, $table, $datajoin, $where, null)->result();

    $data = array(
      'titulo' => 'Arquivo Atividades Complementares ',
      'conteudo' => 'paineladm/secretaria/atividadesComplementares/lista_atividades_complementares',
      'dados' => array(
        // 'permissionCampusArray' => $_SESSION['permissionCampus'],
        // 'namecity' => $namecity,
        'listagem' => $listagem,
        'campus' => $campus,
        'pagina' => $pagina,
        'page' => "Atividades Complementares - $campus->name $campus->city",
        'tipo' => 'tabelaDatatable'
      )
    );
    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_arquivo_atividades_complementares($uriCampus = null, $pageId = NULL)
  {

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $this->load->helper('file');
    verificaLogin();
    if ($uriCampus == null) {
      redirect('painel');
    }

    $this->form_validation->set_rules('name', 'Nome arquivo', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');

    if (empty($_FILES['files']['name'])) {
      $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
      $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
    }

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'erro');
      endif;
    } else {
      $path = "assets/files/secretaria/arquivoAtividadesComplementares/$campus->id/";
      is_way($path);

      if (unique_name_args(noAccentuation($this->input->post('name')), $path)) {
        $name_tmp = null;
      } else {
        $name_tmp = noAccentuation($this->input->post('name'));
      }
      $upload = $this->painelbd->uploadFiles('files', $path, $types = '*', $name_tmp);

      if ($upload) {
        //coleta de dados
        $dados_form['campusid'] = $campus->id;
        $dados_form['name'] = $this->input->post('name');
        $dados_form['status'] = $this->input->post('status');
        $dados_form['files'] = $path . $upload['file_name'];
        $dados_form['user_id'] = $this->session->userdata('codusuario');
        $dados_form['typesfile'] = 'cartilha';
        //salvando
        if ($idInsercao = $this->painelbd->salvar('files', $dados_form, 'exibirIdInsert')) {
          $dados_form_2['filesid'] = $idInsercao;
          $dados_form_2['pagesid'] = $pagina->id;

          if ($this->painelbd->salvar('files_has_pages', $dados_form_2)) {
            setMsg('<p>Calendário  cadastrada com sucesso.</p>', 'success');
            redirect("Painel_secretaria/lista_atividades_complementares/$campus->id/$pagina->id");
          }
        } else {
          setMsg('<p>Erro! O calendário  não foi cadastrada.</p>', 'error');
          redirect("Painel_secretaria/lista_atividades_complementares/$campus->id/$pagina->id");
        }
      } else {
        //erro no upload
        $msg = $this->upload->display_erros();
        $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
        setMsg($msg, 'erro');
      }
    }

    //devolvendo o formulario
    $data = array(
      'titulo' => "Cadastro Arquivo Atividade Complementares ",
      'conteudo' => 'paineladm/secretaria/atividadesComplementares/cadastrar_arquivo_atividades_complementares',
      'dados' => array(
        //'permissionCampusArray' => $_SESSION['permissionCampus'],

        'campus' => $campus,
        'pagina' => $pagina,
        'tipo' => 'calendario',
        'page' => "Atividades Complementares - $campus->name $campus->city",
      )
    );
    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_arquivo_atividades_complementares($uriCampus = null, $id = NULL,  $pageId = NULL)
  {
    $this->load->helper('file');
    date_default_timezone_set('America/Sao_Paulo');
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $field = array(
      'files.id',
      'files.name',
      'files.files',
      'files.status',
      'files.typesfile',
      'files.user_id',
      'files.created_at',
      'files.updated_at',
      'files.campusid',
      'campus.city'
    );
    $table = 'files_has_pages';
    $datajoin = array(
      'files' => 'files_has_pages.filesid = files.id',
      'campus' => 'files.campusid = campus.id'
    );
    $where = array(
      'files.id' => $id,
    );

    $arquivoCartilha = $this->painelbd->Where($field, $table, $datajoin, $where, null)->row();

    // $listagem = $this->bd->Where($field, $table, $datajoin, $where)->row();
    $this->form_validation->set_rules('name', 'Nome do Arquivo', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {
      if ($arquivoCartilha->name != $this->input->post('name')) {
        $dados_form['name'] = $this->input->post('name');
      }
      if ($arquivoCartilha->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }

      if (isset($_FILES['files']) && !empty($_FILES['files']['name'])) {
        $path = "assets/files/secretaria/arquivoAtividadesComplementares/$campus->id/";
        is_way($path);

        if (unique_name_args(noAccentuation($this->input->post('name')), $path)) {
          $name_tmp = null;
        } else {
          $name_tmp = noAccentuation($this->input->post('name'));
        }
        $upload = $this->painelbd->uploadFiles('files', $path, $types = '*', $name_tmp);

        if ($upload) {
          //upload efetuado
          $dados_form['files'] = $path . '/' . $upload['file_name'];
        } else {
          //erro no upload
          $msg = $this->upload->display_errors();
          $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
          setMsg($msg, 'erro');
        }
      }

      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['updated_at'] = date('Y-m-d H:i:s');
      $dados_form['id'] = $id;

      if ($this->painelbd->salvar('files', $dados_form) == TRUE) {
        setMsg('<p>Dados alterados com sucesso.</p>', 'success');
        redirect("Painel_secretaria/lista_atividades_complementares/$campus->id/$pagina->id");
      } else {
        setMsg('<p>Erro! Os dados não foi alterado.</p>', 'error');
        redirect("Painel_secretaria/lista_atividades_complementares/$campus->id/$pagina->id");
      }
    }

    //devolvendo o formulario
    $data = array(
      'titulo' => "Edição Arquivo Atividades Complementares ",
      'conteudo' => 'paineladm/secretaria/atividadesComplementares/editar_arquivo_atividades_complementares',
      'dados' => array(
        //'permissionCampusArray' => $_SESSION['permissionCampus'],
        'arquivoCartilha' => $arquivoCartilha,
        'campus' => $campus,
        'pagina' => $pagina,
        'tipo' => '',
        'page' => "Atividades Complementares - $campus->name $campus->city",
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_atividades_complementares($campusId = NULL, $pageId = NULL, $idArquivo = NULL)
  {
    verifica_login();

    $field = array(
      'files_has_pages.id'
    );
    $table = 'files_has_pages';
    $datajoin = array(
      'files' => 'files_has_pages.filesid = files.id',
      'campus' => 'files.campusid = campus.id'
    );
    $where = array(
      'files.id' => $idArquivo,
    );

    $filesHasPage = $this->painelbd->where($field, $table, $datajoin, $where, null)->row();

    $item = $this->painelbd->where('*', 'files', NULL, array('files.id' => $idArquivo))->row();

    $this->painelbd->deletar('files_has_pages', $filesHasPage->id);

    if ($this->painelbd->deletar('files', $item->id)) {

      setMsg('<p>O item foi deletado com sucesso.</p>', 'success');
      redirect(base_url("Painel_secretaria/lista_atividades_complementares/$campusId/$pageId"));
    } else {
      setMsg('<p>Erro! O item foi não deletado.</p>', 'error');
      redirect(base_url("Painel_secretaria/lista_atividades_complementares/$campusId/$pageId"));
    }
  }

  /** Gerenciamento de links uteis */
  public function lista_links_uteis_secretaria($uriCampus = NULL, $pageId = null)
  {
    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadoPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadoPagina, 'pages', $joinPagina, $wherePagina)->row();

    $colunaResultadoLinksUteisPaginaSecretaria = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.status',
      'page_contents.description',
      'page_contents.link_redir',
      'page_contents.created_at',
      'page_contents.updated_at',
      'page_contents.user_id',
    );
    $joinConteudoLinksUteisPaginaSecretaria = array(
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereLinksUteisPaginaSecretaria = array(
      'page_contents.pages_id' => $pagina->id,
      'page_contents.order' => 'linksUteis'
    );

    $listaLinksUteisPaginaSecretaria = $this->painelbd->where($colunaResultadoLinksUteisPaginaSecretaria, 'page_contents', $joinConteudoLinksUteisPaginaSecretaria, $whereLinksUteisPaginaSecretaria, array('campo' => 'title', 'ordem' => 'asc'))->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/secretaria/links_uteis/lista_links_uteis_secretaria',
      'dados' => array(
        'page' => "Lista <u>Links Úteis</u> página Secretaria- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'pagina' => $pagina,
        'listaLinksUteisPaginaSecretaria' => $listaLinksUteisPaginaSecretaria = isset($listaLinksUteisPaginaSecretaria) ? $listaLinksUteisPaginaSecretaria : '',
        'campus' => $campus,
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_links_uteis_secretaria($uriCampus = NULL, $pageId = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id', 'pages.title', 'pages.status');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $this->form_validation->set_rules('link_redir', 'Por favor, insira o LINK ', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');
    $this->form_validation->set_rules('tipo', 'Tipo Link', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      $dados_form['title'] = $this->input->post('title');
      $dados_form['status'] = $this->input->post('status');
      $dados_form['tipo'] = $this->input->post('tipo');
      $dados_form['link_redir'] = $this->input->post('link_redir');
      $dados_form['order'] = 'linksUteis';
      $dados_form['pages_id'] = $pagina->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Link Útil cadastrado com sucesso.</p>', 'success');
        redirect(base_url("Painel_secretaria/lista_links_uteis_secretaria/$campus->id/$pagina->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/secretaria/links_uteis/cadastrar_links_uteis_secretaria',
      'dados' => array(
        'page' => "Cadastro de Link Útil: Secretaria - <strong><i> $campus->name ($campus->city) </i></strong>",
        'pagina' => $pagina,
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_links_uteis_secretaria($uriCampus = NULL, $pageId = null, $idLink = null)
  {
    verifica_login();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $colunaResultadPagina = array('pages.id');
    $joinPagina = array('campus' => 'campus.id = pages.campusid');
    $wherePagina = array('pages.id' => $pageId);
    $pagina = $this->painelbd->where($colunaResultadPagina, 'pages', $joinPagina, $wherePagina)->row();

    $colunaResultadoLinksUteisPaginaSecretaria = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.tipo',
      'page_contents.status',
      'page_contents.link_redir',
      'page_contents.order',
      'page_contents.created_at',
      'page_contents.updated_at',
      'page_contents.user_id',
    );
    $joinConteudoLinksUteisPaginaSecretaria = array(
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );
    $whereLinksUteisPaginaSecretaria = array(
      'page_contents.pages_id' => $pagina->id,
      'page_contents.id' => $idLink,
      'page_contents.order' => 'linksUteis'
    );

    $listaLinksUteisPaginaSecretaria = $this->painelbd->where($colunaResultadoLinksUteisPaginaSecretaria, 'page_contents', $joinConteudoLinksUteisPaginaSecretaria, $whereLinksUteisPaginaSecretaria)->row();

    $this->form_validation->set_rules('link_redir', 'Por favor, insira o LINK ', 'required');
    $this->form_validation->set_rules('status', 'Situação', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) :
        setMsg(validation_errors(), 'error');
      endif;
    } else {

      if ($listaLinksUteisPaginaSecretaria->title !== $this->input->post('title')) {
        $dados_form['title'] = $this->input->post('title');
      }
      if ($listaLinksUteisPaginaSecretaria->status !== $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }
      if ($listaLinksUteisPaginaSecretaria->tipo !== $this->input->post('tipo')) {
        $dados_form['tipo'] = $this->input->post('tipo');
      }
      if ($listaLinksUteisPaginaSecretaria->link_redir !== $this->input->post('link_redir')) {
        $dados_form['link_redir'] = $this->input->post('link_redir');
      }
      $dados_form['id'] = $listaLinksUteisPaginaSecretaria->id;
      $dados_form['order'] = 'linksUteis';
      $dados_form['updated_at'] = date('Y-m-d H:i:s');

      $dados_form['user_id'] = $this->session->userdata('codusuario');

      if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE) {
        setMsg('<p>Link Útil atualizado com sucesso.</p>', 'success');
        redirect(base_url("Painel_secretaria/lista_links_uteis_secretaria/$campus->id/$pagina->id"));
      } else {
        setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
      }
    }

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/secretaria/links_uteis/editar_links_uteis_secretaria',
      'dados' => array(
        'tituloPagina' => "Edição de Link Útil: Secretaria - <strong><i> $campus->name ($campus->city) </i></strong>",
        'pagina' => $pagina,
        'listaLinksUteisPaginaSecretaria' => $listaLinksUteisPaginaSecretaria,
        'campus' => $campus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_links_uteis_secretaria($uriCampus = NULL, $pagina = null, $id = NULL)
  {
    verifica_login();

    $item = $this->painelbd->where('*', 'page_contents', NULL, array('page_contents.id' => $id))->row();

    if ($this->painelbd->deletar('page_contents', $item->id)) {
      setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
      redirect("Painel_secretaria/lista_links_uteis_secretaria/$uriCampus/$pagina");
    } else {
      setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
      redirect("Painel_secretaria/lista_links_uteis_secretaria/$uriCampus/$pagina");
    }
  }
}
