<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_noticias extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('acesso_model', 'acesso');
        $this->load->model('inicio_model', 'inicio');
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('Cpainel_model', 'bd');

        date_default_timezone_set('America/Sao_Paulo');
    }

    public function lista_campus_noticias(){
        verificaLogin();

        $page = 'Lista de Campus';
        $colunasResultadoCursos = 
            array('campus.id',
            'campus.name',
            'campus.city',
            'campus.uf'
        );
    
        $listagemDosCampus = $this->painelbd->where('*','campus',NULL, array('visible' => 'SIM'))->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/noticias/lista_campus_noticias',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => 'Lista de Notícias - Por Campus',
                'campus'=> $listagemDosCampus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }


    public function noticias($uriCampus)
    {
        verificaLogin();

        $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf','campus.shurtName');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        //$listaNoticias = $this->painelbd->getWhere('news', NULL, array('campo' => 'id', 'ordem' => 'desc'))->result();
        $listaNoticias = $this->painelbd->where('*','news',NULL,array('news.campusid'=>$campus->id),array('campo' => 'id', 'ordem' => 'desc'))->result();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/noticias/listar_noticias',
            'dados' => array(
                'lista' => $listaNoticias,
                'tipo'=>'tabelaDatatable',
                'page'=> "<span>Lista de Notícias: <strong><i> $campus->name - $campus->city</i></strong></span>",
                'campus' => $campus
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_noticias($campusId=NULL)
    {
        verificaLogin();
        $this->load->helper('file');
       
        $uriCampus = $this->uri->segment(3);
        $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $this->form_validation->set_rules('title', 'Título', 'required');
        $this->form_validation->set_rules('keywords', 'Palavras-chave', 'required');

        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPEG, PNG ou JPG.');
        }

        $this->form_validation->set_rules('description', 'Texto da Matéria', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $name_tmp = preg_replace(array(
                "/(á|à|ã|â|ä)/",
                "/(Á|À|Ã|Â|Ä)/",
                "/(é|è|ê|ë)/",
                "/(É|È|Ê|Ë)/",
                "/(í|ì|î|ï)/",
                "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"
            ), explode(" ", "a A e E i I o O u U n N"), $this->input->post('keywords'));
            $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', "’", '.');

            // matriz de saída
            $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '');

            // devolver a string
            $name_tmp = str_replace($what, $by, $name_tmp);


            $result = $this->painelbd->getQuery("Select max(id) as id from news")->row();
            $maxId = $result->id + 1;

            if (is_dir(FCPATH . "/assets/images/news/campus$campus->id/n$maxId")) {
                $path = "assets/images/news/campus$campus->id/n$maxId";
            } else {
                mkdir(FCPATH . "/assets/images/news/campus$campus->id/n$maxId", 0777, true);
                $path = "assets/images/news/campus$campus->id/n$maxId";
            }
            $dados_form = elements(array('title', 'keywords'), $this->input->post());

            if($this->input->post('datestart')){
                $dados_form['datestart'] = $this->input->post('datestart');
            }
           

            $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|png|jpeg|jfif|JFIF|PNG|JPEG|JPG', 'capa_'.$name_tmp);

            if ($upload) {
                //upload efetuado

                $user = $this->session->userdata('codusuario');
                $dados_form['user_id'] = $user;

                $dados_form['img_destaque'] = $path . '/' . $upload['file_name'];
                $dados_form['url_youtube'] = NULL;
                $dados_form['campusid'] = $campus->id; 
                
                $dados_form['status'] = $this->input->post('status');

                $dados_form['description'] = toBd($this->input->post('description'));

                if ($id = $this->painelbd->salvar('news', $dados_form)) {
                    setMsg('<img src="' . base_url('assets/images/icons/succes-smile.png') . '" alt=""><br><p>Notícia cadastrada com sucesso.</p>', 'success');
                    redirect("Painel_noticias/noticias/$campusId");
                } else {
                    setMsg('<p>Erro! A notícia não pode ser cadastrada.</p>', 'error');
                    redirect("Painel_noticias/noticias/$campusId");
                }
            } else {
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }
        }
        $data = array(
            'conteudo' => 'paineladm/noticias/cadastrar_noticia',
            'titulo' => 'Notícias - UniAtenas',
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'page'=> "<span>Cadastro de Notícia: <strong><i> $campus->name - $campus->city</i></strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }


    public function editar_noticia($uriCampus=NULL,$idNoticia = NULL)
    {
        verificaLogin();
        $this->load->helper('file');

        $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf','campus.shurtName');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $news = $this->painelbd->where('*','news',NULL,array('news.id'=>$idNoticia),array('campo' => 'id', 'ordem' => 'desc'))->row();


        $this->form_validation->set_rules('title', 'Título', 'required');
        $this->form_validation->set_rules('keywords', 'Palavras-chave', 'required');
        $this->form_validation->set_rules('description', 'Texto da Matéria', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            $dados_form = elements(array('title', 'campusid', 'keywords','datestart'), $this->input->post());
            $novoArquivo = isset($_FILES['files']) ? $_FILES['files'] : '';

            if ($novoArquivo !='' and !empty($novoArquivo['name'])) {

              $name_tmp = preg_replace(array(
                  "/(á|à|ã|â|ä)/",
                  "/(Á|À|Ã|Â|Ä)/",
                  "/(é|è|ê|ë)/",
                  "/(É|È|Ê|Ë)/",
                  "/(í|ì|î|ï)/",
                  "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"
              ), explode(" ", "a A e E i I o O u U n N"), $this->input->post('keywords'));
              $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', "’", '.');
  
              // matriz de saída
              $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '');
  
              // devolver a string
              $name_tmp = str_replace($what, $by, $name_tmp);
              
              $path = "assets/images/news/campus$campus->id/n".$news->id;
              is_way($path);
              
              $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|png|jpeg|jfif|JFIF|PNG|JPEG|JPG', 'capa_'.$name_tmp);
            
              if ($upload) {
                  $dados_form['img_destaque'] = $path.'/'.$upload['file_name'];
              } else {
                  //erro no upload
                  $msg = $this->upload->display_errors();
                  $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                  setMsg($msg, 'erro');
              }
            }

            if ($this->input->post('title')) {
                $dados_form['title'] = $this->input->post('title');
            }

            if ($this->input->post('datestart')) {
                $dados_form['datestart'] = $this->input->post('datestart');
            }

            if ($this->input->post('keywords')) {
                $dados_form['keywords'] = $this->input->post('keywords');
            }
            if ($this->input->post('description')) {
                $dados_form['description'] = $this->input->post('description');
            }
            if ($this->input->post('url_youtube')) {
                $dados_form['url_youtube'] = $this->input->post('url_youtube');
            }
             //depois da validação cria apenas um dados - Elements
             
            $description = $this->input->post('description');
            $user = $this->session->userdata('codusuario');

            $dados_form['status'] = $this->input->post('status');
            $dados_form['datemodified'] = date('Y-m-d H:i:s');
            $dados_form['user_id'] = $user;
            $dados_form['campusid'] = $campus->id;
            $dados_form['id'] = $news->id;
          
            if ($id = $this->painelbd->salvar('news', $dados_form)) {
              setMsg('<p>Notícia editada com sucesso.</p>', 'success');
              redirect("Painel_noticias/noticias/$campus->id");
            } else {
              setMsg('<p>Erro! A notícia não pode ser editada.</p>', 'error');
              redirect("Painel_noticias/noticias/$campus->id");
            }
        }
        $data = array(
            'conteudo' => 'paineladm/noticias/editar_noticia',
            'titulo' => 'Notícias - Edição - UniAtenas',
            'dados' => array(
                'tipo' => '',
                'news' => $news,
                'page'=> "<span>Edição de Notícia: <strong><i> $campus->name - $campus->city</i></strong></span>",
                'campus' => $campus
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_noticia($uriCampus=NULL,$id)
    {
      verifica_login();
    
      $uriCampus = $this->uri->segment(3);
      $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

      $item = $this->painelbd->getWhere('news', array('id' => $id))->row();
      
      $origem = $item->img_destaque;
      $nome = explode('/', $origem);
      $nome = end($nome);

      $destino = "assets/delete/images/news/campus$campus->id/n".$id;
      is_way($destino);
      $destino = $destino . $nome;

      if(copy($origem,$destino)|| $nome == '<') {

      }
      if ($this->bd->deletar('news', $id)) {
          setMsg('<p>A notícia foi deletada com sucesso.</p>', 'success');
          redirect("Painel_noticias/noticias/$campus->id");
      } else {
          setMsg('<p>Erro! A notícia foi não deletada.</p>', 'error');
          redirect("Painel_noticias/noticias/$campus->id");
      }
    }

    public function verFotos($campusId=NULL,$id)
    {
        $uriCampus = $this->uri->segment(3);
        $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        $id=$this->uri->segment(4);

        if (empty($id)) {
            redirect("Painel_noticias/noticias/$campus->id");
        }
       
        $news = $this->painelbd->getWhere('news', array('id' => $id))->row();
        $data = array(
            'conteudo' => 'paineladm/noticias/fotos/verFotos',
            'titulo' => 'Fotos - Cadastro - UniAtenas',
            'dados' => array(
                'tipo' => '',
                'news' => $news,
                'fotos' => $this->painelbd->getWhere('news_image', array('newsid' => $news->id))->result(),
                'campus' => $campus,
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrarFotos($uriCampus=NULL,$id)
    {
        $uriCampus = $this->uri->segment(3);
        $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        if (empty($id)) {
            redirect("Painel_noticias/noticias/$campus->id");
        }
        $news = $this->painelbd->getWhere('news', array('id' => $id))->row();

        if (empty($_FILES['files'])) {
            $_FILES['files']['size'][0] = 0;
        }

        if ($_FILES['files']['size'][0] <= 0) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPEG, PNG ou JPG.');
        }

        $this->form_validation->set_rules('usersid', 'Usuários', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $number_of_files = count($_FILES['files']['name']);
            $files = $_FILES;

            $path = "assets/images/news/campus$campus->id/n".$news->id;
            for ($i = 0; $i < $number_of_files; $i++) {
                $_FILES['files']['name'] = $files['files']['name'][$i];
                $_FILES['files']['type'] = $files['files']['type'][$i];
                $_FILES['files']['tmp_name'] = $files['files']['tmp_name'][$i];
                $_FILES['files']['error'] = $files['files']['error'][$i];
                $_FILES['files']['size'] = $files['files']['size'][$i];

                $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|jpeg|png|PNG', NULL);

                if ($upload) {
                    $user = $this->session->userdata('codusuario');
                    $dados_form['usersid'] = $user;

                    $dados_form['file'] = $path . '/' . $upload['file_name'];
                    $dados_form['datecreated'] = date('Y-m-d H:i:s');
                    $dados_form['newsid'] = $news->id;
                    $dados_form['status'] = 1;

                    if ($id = $this->painelbd->salvar('news_image', $dados_form)) {
                        if ($number_of_files == ($i + 1)) {
                            setMsg('<p>Fotos cadastrada com sucesso.</p>', 'success');
                            redirect("Painel_noticias/verFotos/$campus->id/$news->id");
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
            'conteudo' => 'paineladm/noticias/fotos/cadastrarFotos',
            'titulo' => 'Fotos - Cadastro - UniAtenas',
            'dados' => array(
                'tipo' => '',
                'news' => $news,
                'campus' => $campus,
                'page'=> "<span>Lista de Notícias: <strong><i> $campus->name - $campus->city</i></strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);

    }

    function deletarFoto($uriCampus = NULL,$id = NULL)
    {
			
      verifica_login();
    
      $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

      $item = $this->painelbd->getWhere('news_image', array('id' => $id))->row();
      
      $destino = $destino.$nome;
      if (file_exists($item->file)) {
        unlink($item->file);
    	}    
	
      if ($this->bd->deletar('news_image', $id)) {
          setMsg('<p>Foto deletada com sucesso.</p>', 'success');
          redirect("Painel_noticias/verFotos/$campus->id/$item->newsid");
      } else {
          setMsg('<p>Erro! Foto não pode ser deletada.</p>', 'error');
          redirect("Painel_noticias/verFotos/$campus->id/$item->newsid");
      }
    }

    


}