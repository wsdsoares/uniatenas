<?php

if (!defined("BASEPATH"))
  exit("No direct script access allowed");

class Painel_galeria extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('painel_model', 'painelbd');
    date_default_timezone_set('America/Sao_Paulo');
  }


  /*************************************************************************
   * Galeria de fotos do Campus
   * Página: Página galeria de fotos - Informações no link
   * uniatenas/site/galeria/NOME_DO_CAMPUS
   *************************************************************************/

  public function lista_campus_galeria_fotos()
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
      'conteudo' => 'paineladm/campus/galeria_fotos_campus/lista_campus_galeria_fotos',
      'dados' => array(
        // 'permissionCampusArray' => $_SESSION['permissionCampus'],
        'page' => 'Galeria de Fotos do Campus - <strong>Gestão Por Campus</strong>',
        'campus' => $listagemDosCampus,
        'tipo' => '',
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_galeria_fotos($uriCampus)
  {
    verificaLogin();

    $uriCampus = $this->uri->segment(3);
    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $whereCategoriasFotos = array(
      'photos_category.campusid' => $campus->id,
    );

    $listaCategoriasFotos = $this->painelbd->where('*', 'photos_category', null, $whereCategoriasFotos, array('campo' => 'photos_category.title', 'ordem' => 'asc'),)->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/campus/galeria_fotos_campus/lista_galeria_fotos',
      'dados' => array(
        'listaCategoriasFotos' => $listaCategoriasFotos,
        'campus' => $campus,
        'page' => "Categorias da galeria de fotos - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'tipo' => 'tabelaDatatable'
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_categoria_foto($uriCampus = NULL)
  {
    verificaLogin();
    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

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

      if ($id = $this->painelbd->salvar('photos_category', $dados_form)) {
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

  public function editar_categoria_foto($uriCampus = NULL, $idCategoria = NULL)
  {

    verificaLogin();
    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $categoriaFoto = $this->painelbd->where('*', 'photos_category', null, array('photos_category.id' => $idCategoria, 'campusid' => $campus->id))->row();

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

      if ($this->painelbd->salvar('photos_category', $dados_form) == TRUE) {
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

  public function deletar_galeria_foto($uriCampus = NULL, $id = NULL)
  {
    verifica_login();
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();
    $item = $this->painelbd->where('*', 'photos_category', NULL, array('photos_category.id' => $id))->row();
    if ($this->painelbd->deletar('photos_category', $item->id)) {
      setMsg('<p>Item deletado com sucesso.</p>', 'success');
      redirect("Painel_galeria/lista_galeria_fotos/$campus->id");
    } else {
      setMsg('<p>Erro! O Item não deletado.</p>', 'error');
      redirect("Painel_galeria/lista_galeria_fotos/$campus->id");
    }
  }

  public function lista_fotos_categoria($uriCampus = NULL, $idCategoria = NULL)
  {
    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();
    $categoriaFoto = $this->painelbd->where('*', 'photos_category', null, array('photos_category.id' => $idCategoria, 'campusid' => $campus->id))->row();

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
      'photos_category' => 'photos_category.id = photos_gallery.photoscategoryid'
    );

    $whereFotosCategoria = array(
      'photos_gallery.photoscategoryid' => $categoriaFoto->id
    );
    $listaFotosCategoria = $this->painelbd->where($colunasFotosCategoria, 'photos_gallery', $joinFotosCategoria, $whereFotosCategoria)->result();


    $data = array(
      'conteudo' => 'paineladm/campus/galeria_fotos_campus/galeria_fotos/lista_fotos_categoria',
      'titulo' => 'Fotos da Infraestrutura',
      'dados' => array(
        'page' => "Fotos da categoria  <strong>  $categoriaFoto->title <i>Campus - $campus->name ($campus->city) </i></strong>",
        'tipo' => 'tabelaDatatable',
        'listaFotosCategoria' => $listaFotosCategoria,
        'categoriaFoto' => $categoriaFoto,
        'campus' => $campus,
      )
    );
    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_fotos_galeria($uriCampus = NULL, $idCategoria = NULL)
  {
    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();
    $categoriaFoto = $this->painelbd->where('*', 'photos_category', null, array('photos_category.id' => $idCategoria, 'campusid' => $campus->id))->row();

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

      $path = "assets/images/gallery/$campus->id/$categoriaFoto->id";
      is_way($path);
      $number_of_files = count($_FILES['file']['name']);
      $files = $_FILES;

      for ($i = 0; $i < $number_of_files; $i++) {
        $_FILES['file']['name'] = $files['file']['name'][$i];
        $_FILES['file']['type'] = $files['file']['type'][$i];
        $_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$i];
        $_FILES['file']['error'] = $files['file']['error'][$i];
        $_FILES['file']['size'] = $files['file']['size'][$i];


        $upload = $this->painelbd->uploadFiles('file', $path, $types = 'jpg|JPG|jpeg|JPEG|png|PNG', NULL);

        if ($upload) {
          $dados_form['user_id'] = $this->session->userdata('codusuario');
          $dados_form['file'] = $path . '/' . $upload['file_name'];
          $dados_form['title'] = $this->input->post('title');
          $dados_form['status'] = $this->input->post('status');
          $dados_form['campusid'] =  $campus->id;
          // $dados_form['categoria'] = trim($categoriaInfraestrutura->title);
          $dados_form['photoscategoryid'] = $categoriaFoto->id;

          if ($id = $this->painelbd->salvar('photos_gallery', $dados_form)) {
            if ($number_of_files == ($i + 1)) {
              setMsg('<p>Fotos cadastrada com sucesso.</p>', 'success');
              redirect("Painel_galeria/lista_fotos_categoria/$campus->id/$categoriaFoto->id");
            }
          } else {
            setMsg('<p>Erro! A foto não pode ser cadastrada.</p>', 'error');
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
      'conteudo' => 'paineladm/campus/galeria_fotos_campus/galeria_fotos/cadastrar_fotos_galeria',
      'titulo' => "Fotos - $categoriaFoto->title $campus->name - $campus->city",
      'dados' => array(
        'tipo' => '',
        'campus' => $campus,
        'categoriaFoto' => $categoriaFoto,
        'page' => "<span>Cadastro Fotos: <strong> $categoriaFoto->title <i>$campus->name - $campus->city</i></strong></span>",
      )
    );
    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_foto_galeria($uriCampus = NULL, $idCategoria = NULL, $idFoto = NULL)
  {
    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();
    $categoriaFoto = $this->painelbd->where('*', 'photos_category', null, array('photos_category.id' => $idCategoria, 'campusid' => $campus->id))->row();
    $foto = $this->painelbd->where('*', 'photos_gallery', null, array('photos_gallery.id' => $idFoto))->row();

    $this->form_validation->set_rules('title', 'Título', 'required');

    if ($this->form_validation->run() == FALSE) {
      if (validation_errors()) {
        setMsg(validation_errors(), 'error');
      }
    } else {

      if ($foto->title != $this->input->post('title')) {
        $dados_form['title'] = $this->input->post('title');
      }

      if ($foto->status != $this->input->post('status')) {
        $dados_form['status'] = $this->input->post('status');
      }

      if (isset($_FILES['file']) and !empty($_FILES['file']['name'])) {

        $path = "assets/images/gallery/$campus->id/$categoriaFoto->id";
        is_way($path);

        if (file_exists($foto->file)) {
          unlink($foto->file);
        }
        $name_tmp = noAccentuation($this->input->post('title'));
        $upload = $this->painelbd->uploadFiles('file', $path, $types = 'jpg|JPG|jpeg|JPEG|png|PNG', $name_tmp);

        if ($upload) {
          //upload efetuado
          $dados_form['file'] = $path . '/' . $upload['file_name'];
        } else {
          //erro no upload
          $msg = $this->upload->display_errors();
          $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
          setMsg($msg, 'erro');
        }
      }

      $dados_form['id'] = $foto->id;
      $dados_form['user_id'] = $this->session->userdata('codusuario');
      $dados_form['updated_at'] = date('Y-m-d H:i:s');

      if ($this->painelbd->salvar('photos_gallery', $dados_form) == TRUE) {
        setMsg('<p>Fotos cadastrada com sucesso.</p>', 'success');
        redirect("Painel_galeria/lista_fotos_categoria/$campus->id/$categoriaFoto->id");
      } else {
        setMsg('<p>Erro! A foto não pode ser cadastrada.</p>', 'error');
      }
    }

    $data = array(
      'conteudo' => 'paineladm/campus/galeria_fotos_campus/galeria_fotos/editar_foto_galeria',
      'titulo' => "Fotos - $categoriaFoto->title $campus->name - $campus->city",
      'dados' => array(
        'tipo' => '',
        'campus' => $campus,
        'categoriaFoto' => $categoriaFoto,
        'foto' => $foto,
        'page' => "<span>Edição Foto: <strong> $categoriaFoto->title <i>$campus->name - $campus->city</i></strong></span>",
      )
    );
    $this->load->view('templates/layoutPainelAdm', $data);
  }


  public function deletar_foto_galeria($uriCampus = NULL, $categoriaFoto = NULL, $id = NULL)
  {
    verifica_login();
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();
    $item = $this->painelbd->where('*', 'photos_category', NULL, array('photos_category.id' => $categoriaFoto))->row();
    $foto = $this->painelbd->where('*', 'photos_gallery', NULL, array('photos_gallery.id' => $id))->row();
    $imagem = $foto->file;


    if ($this->painelbd->deletar('photos_gallery', $foto->id)) {
      if (!unlink($imagem)) {
        setMsg('Não foi possível remover o arquivo de nome ' . $foto->title . '', 'alert');
        redirect("Painel_galeria/lista_fotos_categoria/$campus->id/$item->id");
      } else {
        setMsg('<p>Foto removida com sucesso.</p>', 'success');
        redirect("Painel_galeria/lista_fotos_categoria/$campus->id/$item->id");
      }
    } else {
      setMsg('<p>Erro! O Item não deletado.</p>', 'error');
      redirect("Painel_galeria/lista_fotos_categoria/$campus->id/$item->id");
    }
  }
}
