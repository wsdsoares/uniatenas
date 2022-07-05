<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('acesso_model', 'acesso');
        $this->load->model('inicio_model', 'inicio');
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('Cpainel_model', 'bd');
        $this->load->model('Site_model', 'bancosite');

        date_default_timezone_set('America/Sao_Paulo');
    }

    public function lista_campus(){
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
            'conteudo' => 'paineladm/home/lista_campus',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => 'Lista de BANNERS - Por Campus',
                'campus'=> $listagemDosCampus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    /**     Módulo de Slideshow   **/
    public function slideshow()
    {
        $uriCampus = $this->uri->segment(3);

        $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $fieldsSlide = array(
            'banners.id', 'banners.created_at', 'banners.updated_at',
            'banners.title', 'banners.datestart', 'banners.dateend',
            'banners.files', 'banners.user_id',
            'banners.status',
            'campus.name as nameCampus',
            'campus.city',
        );

        $dataJoinSlide = array(
            'campus' => 'campus.id = banners.campusid '
        );
        $itens = $this->painelbd->where($fieldsSlide, 'banners', $dataJoinSlide, array('campus.id'=>$campus->id), array('campo' => 'id', 'ordem' => 'desc'))->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/home/slideshow/lista_slideshow',
            'dados' => array(
                'page' => "Banners - Página Principal<i>($campus->name - $campus->city)</i>",
                'campus' => $campus,
                'tipo' => 'tabelaDatatable',
                'slideshow' => $itens
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }


    public function cadastrar_slideshow($uriCampus=NULL)
    {
        $this->load->helper('file');
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $this->form_validation->set_rules('title', 'Título', 'required');

        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $path = 'assets/images/slideshow/'.$campus->id;
            is_way($path);
            
            if (unique_name_args(noAccentuation($this->input->post('title'), NULL), $path)) {
                $name_tmp = null;
            } else {
                $name_tmp = noAccentuation($this->input->post('title'), NULL);
            }

            $upload = $this->bd->uploadFiles('files', $path, $types = 'jpg|JPG|png|jpeg|JPEG', $name_tmp);

            if ($upload):
                //upload efetuado

                $dados_form = elements(array('title', 'datestart', 'dateend', 'linkRedir', 'status', 'priority', 'briefText'), $this->input->post());

                $dados_form['files'] = $path . '/' . $upload['file_name'];
                $dados_form['campusid'] = $campus->id;
                $dados_form['type'] = 'slideshowprincipal';
                $dados_form['user_id'] = $this->session->userdata('codusuario');

                $ordens = $this->getBannerPositionbyCampus($dados_form['campusid']);
                $updatePosition = FALSE;
                foreach ($ordens as $key => $ordem) {
                    $posic[$key] = $ordem->id . "///" . $dados_form['priority'];

                    if ($updatePosition == TRUE) {

                        $this->bd->alterar('banners', 'priority', 'id', $ordem->id, $ordem->priority + 1);
                    }
                    if ($ordem->priority == $dados_form['priority']) {

                        $dados_form['priority'] = $ordem->priority;
                        $updatePosition = true;
                        $this->bd->alterar('banners', 'priority', 'id', $ordem->id, $ordem->priority + 1);

                    }
                }

            else:
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            endif;
            if ($this->bd->salvar('banners', $dados_form) == TRUE) {

                setMsg('<p>Publicação cadastrada com sucesso.</p>', 'success');
                redirect('Painel_home/slideshow/'.$campus->id);
            } else {
                setMsg('<p>Erro! A publicação não foi cadastrada.</p>', 'error');
                redirect('Painel_home/slideshow/'.$campus->id);
            }
        }


        $condition = array('status' => 1, 'campus_id' => '$campus');
        $dados = $this->painelbd->getWhere('midias', $condition)->result();
        $locaisCampus = $this->bd->where('*', 'campus', null, array('visible' => 'SIM'))->result();


        $data = array(
            'titulo' => 'Início - Slides',
            'conteudo' => 'paineladm/home/slideshow/cadastrar_slideshow',
            'dados' => array('slideshow' => $dados,
                'locaisCampus' => $locaisCampus,
                'page' => "Cadastro Banners - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'revistas_id' => '',
                'campus' => $campus,
                'tipo' => 'slideshow'
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function getBannerPositionbyCampus($idCampus = NULL)
    {
        //recebe o id selecionado pelo script na page cadastrar slideshow
        $campus_id = $this->input->post('campus_id');

        $result_order = null;

        if ($campus_id) {
            $midiasql = "SELECT * FROM at_site.banners
                    WHERE type = 'slideshowprincipal' AND campusid = $campus_id AND status = 1 
                    ORDER BY priority asc";

            $orders = $this->bancosite->getQuery($midiasql)->result();
            foreach ($orders as $order) {
                $result_order .= '<option value="' . $order->id . '">' . $order->priority . '</option>';
            }
            echo(json_encode($orders));
        } else {
            //take all banners, visible and not visible
            $midiasql = "SELECT * FROM at_site.banners
                    WHERE type = 'slideshowprincipal' AND campusid = $idCampus
                    ORDER BY priority asc";
            $orders = $this->bancosite->getQuery($midiasql)->result();

            return $orders;
        };
    }

    public function editarSlideShow($uriCampus=NULL,$id = NULL)
    {
        date_default_timezone_set('America/Sao_Paulo');

        if (empty($id)) {
            redirect('Paginas/editarSlideShow');
        }
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $itens = $this->painelbd->where('*', 'banners', null, array('banners.id'=>$id), array('campo' => 'id', 'ordem' => 'desc'))->result();
        
        $this->form_validation->set_rules('title', 'Título', 'required');
        $this->form_validation->set_rules('status', 'Situação', 'required');
        // $this->form_validation->set_message('greater_than', 'Informe o campus');

        $arquivos = isset($_FILES["files"]) ? $_FILES["files"] :'';
        $arquivoAtual = $this->input->post('fileatual');

        if (!isset($arquivos) and isset($arquivoAtual)) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
        }

        $fieldsSlide = array(
            'banners.id', 'banners.created_at', 'banners.updated_at',
            'banners.title', 'banners.datestart', 'banners.dateend',
            'banners.files', 'banners.user_id', 'banners.priority',
            'banners.status', 'banners.linkredir', 'banners.briefText',
            'campus.id as idCampus',
            'campus.name as nameCampus',
            'campus.city',
        );

        $dataJoinSlide = array(
            'campus' => 'campus.id = banners.campusid '
        );

        $itens = $this->painelbd->where($fieldsSlide, 'banners', $dataJoinSlide, array('banners.id' => $id))->row();


        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if ($itens->title != $this->input->post('title')) {
                $dados_form['title'] = $this->input->post('title');
            }
            if ($itens->briefText != $this->input->post('briefText')) {
                $dados_form['briefText'] = $this->input->post('briefText');
            }
            if ($itens->priority != $this->input->post('priority')) {
                $dados_form['priority'] = $this->input->post('priority');
            }
            if ($this->input->post('datestart')) {
                $dados_form['datestart'] = $this->input->post('datestart');
            }
            if ($this->input->post('dateend')) {
                $dados_form['dateend'] = $this->input->post('dateend');
            }
            if ($itens->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }
            if ($itens->linkRedir != $this->input->post('linkRedir') and $this->input->post('linkRedir') !='') {
                $dados_form['linkRedir'] = $this->input->post('linkRedir');
            }

            if ($itens->user_id != $this->session->userdata('codusuario')) {
                $dados_form['user_id'] = $this->session->userdata('codusuario');
            }
            
            if (isset($_FILES['files']) && !empty($_FILES['files']['name'])) {

                $path = 'assets/images/slideshow/'.$campus->id;
                is_way($path);
                if (unique_name_args(noAccentuation($this->input->post('title'), NULL), $path)) {
                    $name_tmp = null;
                } else {
                    $name_tmp = noAccentuation($this->input->post('title'), NULL);
                }

                $upload = $this->painelbd->uploadFiles('files', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', $name_tmp);
                if ($upload){
                    //upload efetuado
                    $dados_form['files'] = $path.'/'.$upload['file_name'];
                    $dados_form['type'] = 'slideshowprincipal';

                }else{
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            $dados_form['id'] = $itens->id;
            $dados_form['campusid'] = $campus->id;
            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            
            if ($this->painelbd->salvar('banners', $dados_form) == TRUE){
                setMsg('<p>Publicação editada com sucesso.</p>', 'success');
                redirect('Painel_home/slideShow/'.$campus->id);
            }else{
                setMsg('<p>Erro! A publicação não foi editada.</p>', 'error');
            }
        }

        $locaisCampus = $this->bd->where('*', 'campus', null, array('visible' => 'SIM'))->result();


        $data = array(
            'titulo' => 'Início - Editar Slides',
            'conteudo' => 'paineladm/home/slideshow/editar_slideshow',
            'dados' => array(
                'slideshow' => $itens,
                // 'locaisCampus' => $locaisCampus,
                'campus' => $campus,
                'tipo' => 'slideshow',
                'page' => "Edição Banners - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'idSlid' => $id)
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function delete_slideshow($uriCampus=NULL,$id)
    {
        verifica_login();
        $slideold = $this->painelbd->getWhere('banners', array('id' => $id))->row();

        $origem = $slideold->files;
        $nome = explode('/', $origem);
        $nome = end($nome);

        $destino = "assets/delete/slideshow/$uriCampus";
        is_way($destino);
        $destino = $destino . $nome;


        if (copy($origem, $destino) || $nome == '<') {

        }
        if ($this->bd->deletar('banners', $id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect("Painel_home/slideshow/$uriCampus");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_home/slideshow/$uriCampus");
        }

    }


    /***************função genérica de alterar status********************/
    public function statusAlter($id = NULL, $status = null, $redirect = null, $table = null)
    {
        verificaLogin();
        $dados_form['status'] = $status;
        $dados_form['usersid'] = $this->session->userdata('codusuario');
        $dados_form['datemodified'] = date('Y-m-d H:i:s');
        $dados_form['id'] = $id;
        $messagem = null;
        $messageNot = null;

        if ($status == 0) {
            $messagem = '<p>O Arquivo foi inativado com sucesso.</p>';
            $messageNot = '<p>Erro! O Arquivo foi não inativado.</p>';
        } else {
            $messagem = '<p>O Arquivo foi ativido com sucesso.</p>';
            $messageNot = '<p>Erro! O Arquivo foi não ativado.</p>';
        }
        $redirect = str_replace('-', '/', $redirect);
        if ($this->bd->salvar($table, $dados_form)) {
            setMsg($messagem, 'success');
            redirect($redirect);
        } else {
            setMsg($messageNot, 'error');
            redirect($redirect);
        }

    }

    /***************Fim função genérica de alterar status********************/


    /**     Modulo de finaceiro  */

    public function financeiro()
    {

        $page = $this->painelbd->getWhere('pages', array('title' => 'financeiro', 'campusid' => 1))->row();
        $listagem = $this->painelbd->getWhere('page_contents', array('pages_id' => $page->idpages))->result();
        $data = array(
            'titulo' => 'UniAtenas',
            // 'conteudo' => 'paineladm/itens_paginas/dirigentes/lista',
            'conteudo' => 'paineladm/financeiro/lista',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $listagem,
                'tipo' => ''
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_financeiro()
    {

        $page = $this->painelbd->getWhere('pages', array('title' => 'financeiro', 'campusid' => 1))->row();
        $condition = array('status' => 1, 'pages_id' => $page->idpages);
        $dados = $this->painelbd->getWhere('page_contents', $condition)->result();
        $data = array(
            'titulo' => 'Início - Slides',
            'conteudo' => 'paineladm/financeiro/cadastrar',
            'dados' => array('slideshow' => $dados,
                'cursos' => '',
                'page' => '',
                'revistas_id' => '',
                'tipo' => 'slideshow')
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }


    /************************************
     *  Modulo de arquivos e fotos temporarios  
     * ***********************************/
    public function lista_campus_temps(){
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
            'conteudo' => 'paineladm/temps/lista_campus_temps',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => 'Listagem de Arquivos temporários - Por Campus',
                'campus'=> $listagemDosCampus,
                'tipo'=> '' 
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }
    
    public function tempArg()
    {
        verificaLogin();
        $listagem = $this->bd->where('*', 'files_temp', NULL, array('status' => '1'), array('campo' => 'id', 'ordem' => 'DESC'))->result();
        
        $data = array(
            'titulo' => 'Arquivos -temporarios',
            'conteudo' => 'paineladm/temps/lista',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $listagem,
                'tipo' => 'temps'
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_tempArg()
    {
        verificaLogin();
        $this->load->helper('file');
        $campus = 1;

        $this->form_validation->set_rules('title', 'Titulo', 'required');

        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
        }

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            $path = "assets/temps";
            is_way($path);

            $name_tmp = noAccentuation($this->input->post('title'), 'temp');

            if (unique_name_args($name_tmp, $path)) {
                $name_tmp = null;
            }

            $upload = $this->bd->uploadFiles('files', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF', $name_tmp);

            if ($upload) {
                //upload efetuado

                $dados_form = elements(array('title'), $this->input->post());
                $dados_form['files'] = $path . '/' . $upload['file_name'];
                $dados_form['link'] = base_url($dados_form['files']);
                $dados_form['campusid'] = $campus;
                $dados_form['userid'] = $this->session->userdata('codusuario');
                $dados_form['status'] = '1';

                if ($this->bd->salvar('files_temp', $dados_form)) {
                    setMsg('<p>Publicação cadastrada com sucesso.</p>', 'success');
                    redirect('Painel_home/tempArg');
                } else {
                    setMsg('<p>Erro! A publicação não foi cadastrada.</p>', 'error');
                    redirect('Painel_home/tempArg');
                }
            } else {
                //erro no upload
                $msg = $this->upload->display_erros();
                $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }
        }


        $dados = $this->painelbd->getWhere('files_temp')->result();
        $data = array(
            'titulo' => 'Arquivos - Temporarios',
            'conteudo' => 'paineladm/temps/cadastrar',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'temps' => $dados,
                'tipo' => 'temps')
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_tempArg($id = NULL)
    {
        verificaLogin();
        $campus = '1';

        $this->load->helper('file');
        $dados = $this->painelbd->getWhere('files_temp', array('id' => $id))->row();

        date_default_timezone_set('America/Sao_Paulo');

        $this->form_validation->set_rules('title', 'Título', 'required');

        $path = 'assets/temps';

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            $dados_form['userid'] = $this->session->userdata('codusuario');
            $dados_form['dateupdate'] = date('Y-m-d H:i:s');
            $dados_form['id'] = $id;
            if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['name'])) {
                $path = 'assets/temps';
                $name_tmp = noAccentuation($this->input->post('title'), 'temp');
                $upload = $this->bd->uploadFiles('arquivo', $path, $types = 'jpg|JPG|png|jpeg|JPEG|pdf|PDF|doc|DOC|docx|DOCX', $name_tmp);

            }

            if ($dados->title != $this->input->post('title')) {
                $dados_form['title'] = $this->input->post('title');
            }

            if (isset($upload)) {
                if ($upload) {
                    $dados_form['files'] = $path . '/' . $upload['file_name'];
                    $dados_form['link'] = base_url($dados_form['files']);

                    if ($this->bd->salvar('files_temp', $dados_form)) {
                        setMsg('<p>Arquivo alterado com sucesso.</p>', 'success');
                        redirect('Painel_home/tempArg');
                    } else {
                        setMsg('<p>Erro! O Arquivo não foi alterado.</p>', 'error');
                        redirect('Painel_home/tempArg');
                    }
                } else {
                    //erro no upload
                    $msg = $this->upload->display_erros();
                    $msg .= '<p> São Permetidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            } elseif (isset($dados_form['title'])) {
                if ($this->bd->salvar('files_temp', $dados_form)) {
                    setMsg('<p>Apenas o título alterado com sucesso.</p>', 'success');
                    redirect('Painel_home/tempArg');
                } else {
                    setMsg('<p>Erro! O título não foi alterado.</p>', 'error');
                    redirect('Painel_home/tempArg');
                }
            } else {
                setMsg('<p>Atenção!Não houve alteração.</p>', 'alert');
            }
        }

        $dados = $this->painelbd->getWhere('files_temp', array('id' => $id))->row();
        $data = array(
            'titulo' => 'Editar - Arquivo Temp.',
            'conteudo' => 'paineladm/temps/editar',
            'dados' => array(
                'tempsarg' => $dados,
                'item' => $id,
                'tipo' => 'temps'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function statusAlter_tempArg($id = NULL, $status = null)
    {
        verificaLogin();
        $dados_form['status'] = $status;
        $dados_form['userid'] = $this->session->userdata('codusuario');
        $dados_form['dateupdate'] = date('Y-m-d H:i:s');
        $dados_form['id'] = $id;
        $messagem = null;
        $messageNot = null;


        if ($status == 0) {
            $messagem = '<p>O Arquivo foi inativado com sucesso.</p>';
            $messageNot = '<p>Erro! O Arquivo foi não inativado.</p>';
        } else {
            $messagem = '<p>O Arquivo foi ativido com sucesso.</p>';
            $messageNot = '<p>Erro! O Arquivo foi não ativado.</p>';
        }

        if ($this->bd->salvar('files_temp', $dados_form)) {
            setMsg($messagem, 'success');
            redirect('Painel_home/tempArg');
        } else {
            setMsg($messageNot, 'error');
            redirect('Painel_home/tempArg');
        }

        $dados = $this->painelbd->getWhere('files_temp')->result();
        $data = array(
            'titulo' => 'Editar - Arquivo Temp.',
            'conteudo' => 'paineladm/temps/lista',
            'dados' => array(
                'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $dados,
                'item' => $id,
                'tipo' => 'temps'
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function d1elete_tempArg($id = NULL)
    {
        verificaLogin();
        $dtemps = $this->painelbd->getWhere('files_temp', array('id' => $id))->row();

        $origem = $dtemps->files;
        $nome = explode('/', $origem);
        $nome = end($nome);

        $destino = "assets/delete/temps/";
        is_way($destino);
        $destino = $destino . $nome;
        if (copy($origem, $destino) || $nome == '<') {
            if ($this->bd->deletar('files_temp', $id)) {
                unlink($origem);
                setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
                redirect('Painel_home/tempArg');
            } else {
                setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
                redirect('Painel_home/tempArg');
            }
        }

        $dados = $this->painelbd->getWhere('files_temp')->result();
        $data = array(
            'titulo' => 'Editar - Arquivo Temp.',
            'conteudo' => 'paineladm/temps/lista',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'listagem' => $dados,
                'item' => $id,
                'tipo' => 'temps'
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }
}