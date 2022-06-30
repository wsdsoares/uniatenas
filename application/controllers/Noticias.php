<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Noticias extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('acesso_model', 'acesso');
        $this->load->model('inicio_model', 'inicio');
        $this->load->model('painel_model', 'painelbd');
        date_default_timezone_set('America/Sao_Paulo');

    }

    /*     * *************************************************************************
     * PARTE DE ACESSO - LOGIN - LOGOUT
     * ************************************************************************* */

    public function index()
    {
        redirect('Site/Noticias');
    }

    public function noticias($idCampus = NULL)
    {
        verificaLogin();
        $lista = $this->painelbd->getWhere('news', NULL, array('campo' => 'id', 'ordem' => 'desc'))->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/noticias/listaNoticias',
            'dados' => array(
                'lista' => $lista,
                'tipo' => 'revistas'
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    // public function cadastrar()
    // {
    //     verificaLogin();
    //     $this->load->helper('file');
    //     $page = $this->uri->segment(3);

    //     $this->form_validation->set_rules('title', 'Título', 'required');
    //     $this->form_validation->set_rules('keywords', 'Palavras-chave', 'required');

    //     if ($this->input->post('campusid') == '0') {
    //         $this->form_validation->set_rules('campusid', 'Campus', 'select_validate');
    //         $this->form_validation->set_message('select_validate', 'Você precisa selecionar ao menos um campus.');
    //     } else {
    //         $this->form_validation->set_rules('campusid', 'Campus');
    //     }

    //     if (empty($_FILES['files']['name'])) {
    //         $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
    //         $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPEG, PNG ou JPG.');
    //     }

    //     $this->form_validation->set_rules('description', 'Texto da Matéria', 'required');

    //     if ($this->form_validation->run() == FALSE) {
    //         if (validation_errors()):
    //             setMsg(validation_errors(), 'error');
    //         endif;
    //     } else {

    //         $name_tmp = preg_replace(array(
    //             "/(á|à|ã|â|ä)/",
    //             "/(Á|À|Ã|Â|Ä)/",
    //             "/(é|è|ê|ë)/",
    //             "/(É|È|Ê|Ë)/",
    //             "/(í|ì|î|ï)/",
    //             "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"
    //         ), explode(" ", "a A e E i I o O u U n N"), $this->input->post('keywords'));
    //         $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', "’", '.');

    //         // matriz de saída
    //         $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '');

    //         // devolver a string
    //         $name_tmp = str_replace($what, $by, $name_tmp);


    //         $result = $this->painelbd->getQuery("Select max(id) as id from news")->row();
    //         $maxId = $result->id + 1;

    //         if (is_dir(FCPATH . "/assets/images/news/n$maxId")) {
    //             $path = "assets/images/news/n$maxId";
    //         } else {
    //             mkdir(FCPATH . "/assets/images/news/n$maxId", 0777, true);
    //             $path = "assets/images/news/n$maxId";
    //         }

    //         $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|png|jpeg', 'capa_' . $name_tmp);

    //         if ($upload) {

    //             //upload efetuado
    //             $dados_form = elements(array('title', 'campusid', 'keywords'), $this->input->post());
    //             $user = $this->session->userdata('codusuario');
    //             $dados_form['usersid'] = $user;

    //             $dados_form['img_destaque'] = $path . '/' . $upload['file_name'];
    //             $dados_form['url_youtube'] = NULL;
    //             // $dados_form['usersid'] = $user->id;
    //             $dados_form['status'] = 1;

    //             $dados_form['description'] = toBd($this->input->post('description'));

    //             if ($id = $this->painelbd->salvar('news', $dados_form)) {
    //                 setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Notícia cadastrada com sucesso.</p>', 'success');
    //                 redirect('Noticias/noticias');
    //             } else {
    //                 setMsg('<p>Erro! A notícia não pode ser cadastrada.</p>', 'error');
    //                 redirect('Noticias/noticias');
    //             }
    //         } else {
    //             //erro no upload
    //             $msg = $this->upload->display_errors();
    //             $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
    //             setMsg($msg, 'erro');
    //         }
    //     }
    //     $data = array(
    //         'conteudo' => 'paineladm/noticias/cadastrar',
    //         'titulo' => 'Notícias - UniAtenas',
    //         'dados' => array(
    //             'tipo' => '',
    //             'campus' => $this->painelbd->getWhere('campus')->result()
    //         )
    //     );
    //     $this->load->view('templates/layoutPainelAdm', $data);
    // }

    // public function editar($id = NULL)
    // {
    //     if (empty($id)) {
    //         redirect('Noticias/noticias');
    //     }
    //     $newsfotos = $this->painelbd->getWhere('news_image', array('id' => 544))->row();

    //     $news = $this->painelbd->getWhere('news', array('id' => $newsfotos->newsid))->row();

    //     if (empty($_FILES['files'])) {
    //         $_FILES['files']['size'][0] = 0;
    //     }


    //     if ($_FILES['files']['size'][0] <= 0) {
    //         $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
    //         $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPEG, PNG ou JPG.');
    //     }

    //     $this->form_validation->set_rules('usersid', 'Usuários', 'required');

    //     if ($this->form_validation->run() == FALSE) {
    //         if (validation_errors()):
    //             setMsg(validation_errors(), 'error');
    //         endif;
    //     }else {
    //         $number_of_files = count($_FILES['files']['name']);
    //         $files = $_FILES;

    //         $path = "assets/images/news/n$news->id";
    //         is_way($path);
    //         for ($i = 0; $i < $number_of_files; $i++) {
    //             $_FILES['files']['name'] = $files['files']['name'][$i];
    //             $_FILES['files']['type'] = $files['files']['type'][$i];
    //             $_FILES['files']['tmp_name'] = $files['files']['tmp_name'][$i];
    //             $_FILES['files']['error'] = $files['files']['error'][$i];
    //             $_FILES['files']['size'] = $files['files']['size'][$i];

    //             $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|jpeg|png', NULL);

    //             if ($upload) {
    //                 $user = $this->session->userdata('codusuario');
    //                 $dados_form['usersid'] = $user;
    //                 $dados_form['id'] = $id;

    //                 $dados_form['file'] = $path . '/' . $upload['file_name'];
    //                 $dados_form['datecreated'] = date('Y-m-d H:i:s');
    //                 $dados_form['newsid'] = $news->id;
    //                 $dados_form['status'] = 1;

    //                 if ($id = $this->painelbd->salvar('news_image', $dados_form)) {
    //                     if ($number_of_files == ($i + 1)) {
    //                         setMsg('<p>Foto Editada com sucesso.</p>', 'success');
    //                         redirect('Painel_noticias/noticias');
    //                     }
    //                 } else {
    //                     setMsg('<p>Erro! A foto não pode ser cadastrada.</p>', 'error');
    //                 }
    //             } else {
    //                 //erro no upload
    //                 $msg = $this->upload->display_errors();
    //                 $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
    //                 setMsg($msg, 'erro');
    //             }
    //         }
    //     }

    //     $data = array(
    //         'conteudo' => 'paineladm/noticias/fotos/editarFotos',
    //         'titulo' => 'Fotos - Edição - UniAtenas',
    //         'dados' => array(
    //             'tipo' => '',
    //             'news' => $news,
    //             'newsfoto' => $newsfotos,
    //             'id' => $id,
    //         )
    //     );
    //     $this->load->view('templates/layoutPainelAdm', $data);
    // }

    // public function verFotos($id)
    // {
    //     if (empty($id)) {
    //         redirect('Noticias/noticias');
    //     }
    //     $news = $this->painelbd->getWhere('news', array('id' => $id))->row();
    //     $data = array(
    //         'conteudo' => 'paineladm/noticias/fotos/verFotos',
    //         'titulo' => 'Fotos - Cadastro - UniAtenas',
    //         'dados' => array(
    //             'tipo' => '',
    //             'news' => $news,
    //             'fotos' => $this->painelbd->getWhere('news_image', array('newsid' => $news->id))->result()
    //         )
    //     );
    //     $this->load->view('templates/layoutPainelAdm', $data);
    // }

    // public function cadastrarFotos($id)
    // {
    //     if (empty($id)) {
    //         redirect('Noticias/noticias');
    //     }
    //     $news = $this->painelbd->getWhere('news', array('id' => $id))->row();

    //     if (empty($_FILES['files'])) {
    //         $_FILES['files']['size'][0] = 0;
    //     }


    //     if ($_FILES['files']['size'][0] <= 0) {
    //         $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
    //         $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPEG, PNG ou JPG.');
    //     }

    //     $this->form_validation->set_rules('usersid', 'Usuários', 'required');

    //     if ($this->form_validation->run() == FALSE) {
    //         if (validation_errors()):
    //             setMsg(validation_errors(), 'error');
    //         endif;
    //     } else {

    //         $number_of_files = count($_FILES['files']['name']);
    //         $files = $_FILES;

    //         $path = "assets/images/news/n$news->id";
    //         for ($i = 0; $i < $number_of_files; $i++) {
    //             $_FILES['files']['name'] = $files['files']['name'][$i];
    //             $_FILES['files']['type'] = $files['files']['type'][$i];
    //             $_FILES['files']['tmp_name'] = $files['files']['tmp_name'][$i];
    //             $_FILES['files']['error'] = $files['files']['error'][$i];
    //             $_FILES['files']['size'] = $files['files']['size'][$i];

    //             $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|jpeg|png', NULL);

    //             if ($upload) {
    //                 $user = $this->session->userdata('codusuario');
    //                 $dados_form['usersid'] = $user;

    //                 $dados_form['file'] = $path . '/' . $upload['file_name'];
    //                 $dados_form['datecreated'] = date('Y-m-d H:i:s');
    //                 $dados_form['newsid'] = $news->id;
    //                 $dados_form['status'] = 1;

    //                 if ($id = $this->painelbd->salvar('news_image', $dados_form)) {
    //                     if ($number_of_files == ($i + 1)) {
    //                         setMsg('<p>Fotos cadastrada com sucesso.</p>', 'success');
    //                         redirect('Painel_noticias/noticias');
    //                     }
    //                 } else {
    //                     setMsg('<p>Erro! A foto não pode ser cadastrada.</p>', 'error');
    //                 }
    //             } else {
    //                 //erro no upload
    //                 $msg = $this->upload->display_errors();
    //                 $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
    //                 setMsg($msg, 'erro');
    //             }
    //         }
    //     }

    //     $data = array(
    //         'conteudo' => 'paineladm/noticias/fotos/cadastrarFotos',
    //         'titulo' => 'Fotos - Cadastro - UniAtenas',
    //         'dados' => array(
    //             'tipo' => '',
    //             'news' => $news,
    //             'campus' => $this->painelbd->getWhere('campus')->result()
    //         )
    //     );
    //     $this->load->view('templates/layoutPainelAdm', $data);

    // }

    // function deletarFoto($id = NULL)
    // {
    //     $table = 'news_image';
    //     $explodeId = explode('-', $id);
    //     $dados = $this->painelbd->getWhere($table, array('id' => $explodeId[1]))->row();
    //     $arquivo = isset($dados->file) ? $dados->file : '';
    //     if ($explodeId[1] != NULL && $dados) {

    //         if ($this->painelbd->delete($table, array('id' => $explodeId[1])) == TRUE) {


    //             $files = realpath($dados->file);
    //             $fileDeleted = current(array_reverse(explode('/', $dados->file)));

    //             if (is_dir(FCPATH . "/assets/images/old/news/n$explodeId[0]")) {
    //                 $path = "assets/assets/images/old/news/n$explodeId[0]";
    //             } else {
    //                 mkdir(FCPATH . "/assets/images/old/news/n$explodeId[0]", 0777, true);
    //                 $path = "assets/images/old/news/n$explodeId[0]";
    //             }


    //             if (copy($files, $path . '/' . date('d-m-y') . $fileDeleted)) {
    //                 $msg = "";
    //             } else {
    //                 $msg = "não foi possível fazer a cópia de segurança para '$path'.";
    //             }

    //             if (!unlink($arquivo)) {
    //                 setMsg('Não foi possível remover o arquivo de nome ' . $arquivo . " e  $msg", 'alert');
    //                 redirect(current_url());
    //             } else {
    //                 setMsg('<p>Foto deletada com sucesso.</p>', 'success');
    //                 redirect('Noticias/verFotos/' . $explodeId[0]);
    //             }
    //         } else {
    //             setMsg('<p>Erro! A foto não pode ser deletada.</p>', 'error');
    //             redirect('Noticias/verFotos/' . $explodeId[0]);
    //         }
    //     } else {
    //         setMsg('<p>Erro! A foto desejada não pode ser deletada.</p>', 'error');
    //         redirect('Noticias/verFotos/' . $explodeId[0]);
    //     }
    // }
}