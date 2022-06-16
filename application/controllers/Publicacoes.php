<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Publicacoes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        verificaLogin();
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('site_model', 'bancosite');
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function index() {
        $this->publicacoes();
    }

    public function revistas() {
        $page = 'revistas';
        $aql = "SELECT 
                    revistas.id,
                    revistas.id as pagina_id,
                    revistas.titulo,
                    revistas.status, 
                    revistas.datacriacao
                FROM 
                    revistas
                WHERE
                    status =1
                ";
        $dados = $this->painelbd->getQuery($aql)->result();
        $data = array(
            'titulo' => 'Início',
            'conteudo' => 'paineladm/itens_iniciacao/publicacoes/revistas',
            'dados' => array(
                'revistas' => $dados,
                'tipo' => 'revistas')
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function publicacoes() {
        $campus = '1'; //campus Paracatu 
        $idPage = $this->uri->segment(3);

        if (empty($idPage)) {
            redirect('painel/index');
        }

        $tipoRevista = $this->painelbd->getWhere('revistas', array('id' => $idPage))->row();

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
                    AND campus.id = $campus
                    AND publicacoes.revistas_id = $idPage
                ORDER BY
                publicacoes.id DESC,
                publicacoes.created DESC";

        $dados = $this->painelbd->get_query($aql)->result();
        $data = array(
            'titulo' => 'Início',
            'conteudo' => 'paineladm/itens_iniciacao/publicacoes/publicacoes',
            'dados' => array(
                'publicacoes' => $dados,
                'cursos' => $this->painelbd->getCourses($campus)->result(),
                'pagina' => $tipoRevista->titulo,
                'pagina_id' => $tipoRevista->id,
                'tipo' => 'revistas')
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function salvar() {
        $this->load->helper('file');
        $campus = '1'; //campus Paracatu 
        $idPage = $this->uri->segment(3);

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
                $dados_form = elements(array('title', 'courses_id', 'year', 'volume', 'number_vol', 'revistas_id'), $this->input->post());

                $dados_form['files'] = $path . '/' . $upload['file_name'];
                $dados_form['campus_id'] = $campus;
                $dados_form['users_id'] = $this->session->userdata('codusuario');
                $dados_form['types'] = 'magazines';
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
        $tipoRevista = $this->painelbd->getWhere('revistas', array('id' => $idPage))->row();


        $data = array(
            'titulo' => 'Início',
            'conteudo' => 'paineladm/itens_iniciacao/publicacoes/salvar',
            'dados' => array('publicacoes' => $dados,
                'cursos' => $this->painelbd->getCourses($campus)->result(),
                'revistas_titulo' => $tipoRevista->titulo,
                'revistas_id' => $tipoRevista->id,
                'tipo' => '')
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletarMagazine($id = NULL) {

        $table = 'publicacoes';
        $dados = $this->painelbd->getWhere($table, array('id' => $id))->row();
        $arquivo = $dados->files;

        if ($id != NULL && $dados) {
            if ($del = $this->painelbd->delete($table, array('id' => $id))) {

                if (!unlink($arquivo)) {
                    setMsg('Não foi possível remover o arquivo de nome ' . $arquivo . '', 'alert');
                    redirect('publicacoes/publicacoes/' . $dados->revistas_id);
                } else {
                    setMsg('<p>Informação removida com sucesso.</p>', 'success');
                    redirect('publicacoes/publicacoes/' . $dados->revistas_id);
                }
            } else {
                setMsg('<p>Erro! A publicação não pode ser deletada.</p>', 'error');
                redirect('publicacoes/publicacoes/' . $dados->revistas_id);
            }
        } else {
            setMsg('<p>Erro! Não existe publicações para os dados informados.</p>', 'error');
            redirect('publicacoes/publicacoes/' . $dados->revistas_id);
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
