<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_campus extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('acesso_model', 'acesso');
        $this->load->model('inicio_model', 'inicio');
        $this->load->model('painel_model', 'painelbd');
        $this->load->model('Cpainel_model', 'bd');

        date_default_timezone_set('America/Sao_Paulo');
    }
    
    public function lista_campus() {
        verificaLogin();
        
        $listagemDosCampus = $this->painelbd->where('*','campus',NULL, array('status' => 1))->result();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/lista_campus',
            'dados' => array(
                'permissionCampusArray' => '',
                'listagemDosCampus'=>$listagemDosCampus,
                'page' => 'Todos os CAMPI - Grupo Uniatenas',
                'tipo'=>'tabelaDatatable'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_campus(){
        verificaLogin();
        $this->load->helper('file');

        //Validaçãoes via Form Validation
        $this->form_validation->set_rules('name', 'Tipo do Campus', 'required');
        // $this->form_validation->set_rules('email', 'Email', 'required');
        // $this->form_validation->set_rules('logo', 'Logotipo', 'required');
        // $this->form_validation->set_rules('logoBranca', 'Logotipo cor Branca', 'required');
        // $this->form_validation->set_rules('iconeCampus', 'Icone Campus', 'required');
        // $this->form_validation->set_rules('street', 'Endereço do Campus', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {

            $pathLogo = "assets/images/logos";
            is_way($pathLogo);

            if (isset($_FILES['logo']) && !empty($_FILES['logo']['name'])) {
                
                
                $upload = $this->painelbd->uploadFiles('logo', $pathLogo, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', null);
                if($upload){
                    $dados_form['logo'] = $pathLogo.'/'.$upload['file_name'];
                }else{
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }

            }

            if (!empty($_FILES['logoBranca']['name'])) {
                
                $upload = $this->painelbd->uploadFiles('logoBranca', $pathLogoBranca, $types = 'jpg|JPG|png|jpeg|JPEG|PNG', null);

                if($upload){
                    $dados_form['logoBranca'] = $pathLogo.'/'.$upload['file_name'];
                }else{
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }        
            
            if (!empty($_FILES['iconeCampus']['name'])) {
                
                $upload = $this->painelbd->uploadFiles('iconeCampus', $pathLogo, $types = 'jpg|JPG|png|jpeg|JPEG|PNG', null);

                if($upload){
                    $dados_form['iconeCampus'] = $pathLogo.'/'.$upload['file_name'];
                }else{
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }

            }  

            if (!empty($_FILES['backgroundPrincipal']['name'])) {
                
                $upload = $this->painelbd->uploadFiles('backgroundPrincipal', $pathLogo, $types = 'jpg|JPG|png|jpeg|JPEG|PNG', null);

                if($upload){
                    $dados_form['backgroundPrincipal'] = $pathLogo.'/'.$upload['file_name'];
                }else{
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            $shurtName = strtolower(noAccentuation($this->input->post('city')));
          
            //aqui pega os dados dos formulários por meio do input
            //os nomes - names dos inputs devem ser iguais aos do BD.
            $dados_form['name'] =$this->input->post('name');
            $dados_form['phone'] =$this->input->post('phone');
            $dados_form['cor_fundo_lista_campusRGBA'] =$this->input->post('cor_fundo_lista_campusRGBA');
            $dados_form['email'] =$this->input->post('email');
            $dados_form['facebook'] =$this->input->post('facebook');
            $dados_form['instagram'] =$this->input->post('instagram');
            $dados_form['youtube'] =$this->input->post('youtube');
            $dados_form['locationMaps'] =$this->input->post('locationMaps');
            $dados_form['mapsFrame'] =$this->input->post('mapsFrame');
            $dados_form['street'] =$this->input->post('street');
            $dados_form['uf'] =$this->input->post('uf');
            $dados_form['city'] =$this->input->post('city');
            $dados_form['type'] =$this->input->post('type');
            $dados_form['description'] =$this->input->post('description');
            $dados_form['visible'] =$this->input->post('visible');
            $dados_form['status'] =$this->input->post('status');
            $dados_form['shurtName'] = $shurtName;
            $dados_form['user_id'] = $this->session->userdata('codusuario');

        
            if ($this->painelbd->salvar('campus', $dados_form) == TRUE) {

                setMsg('<p>Campus cadastrado com sucesso.</p>', 'success');
                redirect('Painel_campus/lista_campus');
            } else {
                setMsg('<p>Erro! O campus não foi cadastrado.</p>', 'error');
                redirect('Painel_campus/lista_campus');
            }
        }



        $page = $this->uri->segment(2);

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/campus/cadastrar_campus',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => $page,
                'listagem'=> $this->bd->getWhere('dirigentes')->result(),
                'tipo'=>''
            )
        );


        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_campus($uriCampus = NULL){
        verificaLogin();
        $this->load->helper('file');

        $campus = $this->painelbd->where('*','campus',NULL, array('campus.id'=>$uriCampus))->row();

        //Validaçãoes via Form Validation
        $this->form_validation->set_rules('name', 'Nome do Campus', 'required');
        $this->form_validation->set_rules('type', 'Tipo do Campus', 'required');
        $this->form_validation->set_rules('city', 'Cidade', 'required');
        $this->form_validation->set_rules('uf', 'Estado (UF)', 'required');
        $this->form_validation->set_rules('street', 'Endereço Completo', 'required');
        $this->form_validation->set_rules('description', 'Descrição do campus', 'required');

        // if (empty($_FILES['logo']['name'])) {
        //     $this->form_validation->set_rules('logo', 'Logo do Campus', 'callback_file_check');
        //     $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
        // }
          
        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {

            if ($campus->name != $this->input->post('name')) {
                $dados_form['name'] = $this->input->post('name');
            }
            if ($campus->type != $this->input->post('type')) {
                $dados_form['type'] = $this->input->post('type');
            }
            if ($campus->city != $this->input->post('city')) {
                $dados_form['city'] = $this->input->post('city');
            }
            if ($campus->uf != $this->input->post('uf')) {
                $dados_form['uf'] = $this->input->post('uf');
            }
            if ($campus->phone != $this->input->post('phone')) {
                $dados_form['phone'] = $this->input->post('phone');
            }
            if ($campus->email != $this->input->post('email')) {
                $dados_form['email'] = $this->input->post('email');
            }
            
            if ($campus->cor_fundo_lista_campusRGBA != $this->input->post('cor_fundo_lista_campusRGBA')) {
                $dados_form['cor_fundo_lista_campusRGBA'] = $this->input->post('cor_fundo_lista_campusRGBA');
            }
            if ($campus->facebook != $this->input->post('facebook')) {
                $dados_form['facebook'] = $this->input->post('facebook');
            }
            if ($campus->instagram != $this->input->post('instagram')) {
                $dados_form['instagram'] = $this->input->post('instagram');
            }
            if ($campus->youtube != $this->input->post('youtube')) {
                $dados_form['youtube'] = $this->input->post('youtube');
            }
            if ($campus->street != $this->input->post('street')) {
                $dados_form['street'] = $this->input->post('street');
            }
            if ($campus->mapsFrame != $this->input->post('mapsFrame')) {
                $dados_form['mapsFrame'] = $this->input->post('mapsFrame');
            }
            if ($campus->description != $this->input->post('description')) {
                $dados_form['description'] = $this->input->post('description');
            }
            if ($campus->type != $this->input->post('type')) {
                $dados_form['type'] = $this->input->post('type');
            }
            if ($campus->type != $this->input->post('type')) {
                $dados_form['type'] = $this->input->post('type');
            }
            if ($campus->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }
            if ($campus->visible != $this->input->post('visible')) {
                $dados_form['visible'] = $this->input->post('visible');
            }

            $pathLogos = "assets/images/logos";
            is_way($pathLogos);

            if (isset($_FILES['logo']) && !empty($_FILES['logo']['name'])) {
                if (file_exists($campus->logo)) {
                    unlink($campus->logo);
                }
                $upload = $this->painelbd->uploadFiles('logo', $pathLogos, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);
                if ($upload){
                    $dados_form['logo'] = $pathLogos . '/' . $upload['file_name'];
                }else{
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }
            
            if (isset($_FILES['logoBranca']) && !empty($_FILES['logoBranca']['name'])) {
                if (file_exists($campus->logoBranca)) {
                    unlink($campus->logoBranca);
                }
                $upload = $this->painelbd->uploadFiles('logoBranca', $pathLogos, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);
                if ($upload){
                    $dados_form['logoBranca'] = $pathLogos . '/' . $upload['file_name'];
                }else{
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            if (isset($_FILES['logoBranca']) && !empty($_FILES['logoBranca']['name'])) {
                if (file_exists($campus->logoBranca)) {
                    unlink($campus->logoBranca);
                }
                $upload = $this->painelbd->uploadFiles('logoBranca', $pathLogos, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);
                if ($upload){
                    $dados_form['logoBranca'] = $pathLogos . '/' . $upload['file_name'];
                }else{
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            if (isset($_FILES['iconeCampus']) && !empty($_FILES['iconeCampus']['name'])) {
                if (file_exists($campus->iconeCampus)) {
                    unlink($campus->iconeCampus);
                }
                $upload = $this->painelbd->uploadFiles('iconeCampus', $pathLogos, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);
                if ($upload){
                    $dados_form['iconeCampus'] = $pathLogos . '/' . $upload['file_name'];
                }else{
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            if (isset($_FILES['backgroundPrincipal']) && !empty($_FILES['backgroundPrincipal']['name'])) {
                if (file_exists($campus->backgroundPrincipal)) {
                    unlink($campus->backgroundPrincipal);
                }
                $upload = $this->painelbd->uploadFiles('backgroundPrincipal', $pathLogos, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);
                if ($upload){
                    $dados_form['backgroundPrincipal'] = $pathLogos . '/' . $upload['file_name'];
                }else{
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }
            
            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            $dados_form['id'] = $campus->id;

            // echo '<pre>';
            // echo '<br/>';
            // echo '<br/>';
            // echo '<br/>';
            // echo '<br/>';
            // echo '<br/>';
            // echo '<br/>';
            // print_r($dados_form);
            // echo '</pre>';

            if ($this->painelbd->salvar('campus', $dados_form) == TRUE){
              setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
              redirect(base_url("Painel_campus/lista_campus/$campus->id"));
            }else{
              setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
        }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/campus/editar_campus',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => "Edição Informações <strong><i> Campus - $campus->name ($campus->city) </i></strong>",
                'listagem'=> '',
                'campus'=>$campus,
                'tipo'=>''
            )
        );


        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_campus($id)
    {
        verifica_login();
        
        $item = $this->painelbd->where('*','campus', NULL, array('campus.id' => $id))->row();

        if (file_exists($item->logo)) {
            unlink($item->logo);
        }
        if (file_exists($item->logoBranca)) {
            unlink($item->logoBranca);
        }
        if (file_exists($item->iconeCampus)) {
            unlink($item->iconeCampus);
        }
        if (file_exists($item->backgroundPrincipal)) {
            unlink($item->backgroundPrincipal);
        }

        if ($this->painelbd->deletar('campus', $id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect("Painel_Campus/lista_campus");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_Campus/lista_campus");
        }

    }

    /*************************************************************************
     * Botões de acesso rápido - Página dos campus - Segunda Página
     * Página: www.atenas.edu.br/uniatenas/NOME_DO_CAMPUS
    *************************************************************************/

    public function lista_campus_botoes_acessos(){
        verificaLogin();

        $page = '';
        $colunasResultadoCursos = 
            array('campus.id',
            'campus.name',
            'campus.city',
            'campus.uf'
        );
    
        $listagemDosCampus = $this->painelbd->where('*','campus',NULL, array('visible' => 'SIM'))->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/botoes_acesso_rapido/lista_campus_acessos_rapido',
            'dados' => array(
                'page' => 'Lista de Campus - Botões de acesso Rápido',
                'campus'=> $listagemDosCampus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_botoes_acesso_rapido($uriCampus=NULL) {
        verificaLogin();
        
        // $uriCampus = $this->uri->segment(3);

        $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        
        $colunasResultadoConsulta = 
            array('acessos_rapidos.id as idBotao',
            'acessos_rapidos.title',
            'acessos_rapidos.link_redirecionamento',
            'acessos_rapidos.cor_hexadecimal',
            'acessos_rapidos.status',
            'acessos_rapidos.arquivo',
            'acessos_rapidos.created_at',
            'acessos_rapidos.updated_at',
            'campus.id',
            'campus.city',
        );
        $joinBotoesAcessoRapido = array(
            'campus' => 'campus.id = acessos_rapidos.campusid'
        );
        $whereBotoesAcessoRapido = array('campus.id'=>$uriCampus);
        $listaDosBotoesAcessoRapido = $this->painelbd->where($colunasResultadoConsulta,'acessos_rapidos',$joinBotoesAcessoRapido, $whereBotoesAcessoRapido)->result();

        $data = array(
            'titulo' => 'Botões de Acesso Rápido - UniAtenas',
            'conteudo' => 'paineladm/botoes_acesso_rapido/lista_botoes_acesso_rapido',
            'dados' => array(
                'listaDosBotoesAcessoRapido'=>$listaDosBotoesAcessoRapido,
                'campus'=>$campus,
                'page' => "Lista - Botões de acesso Rápido<strong><i> Campus - $campus->name ($campus->city) </i></strong>",
                'tipo'=>'tabelaDatatable',
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_botoes_acesso_rapido($uriCampus=NULL){
        verificaLogin();
        $this->load->helper('file');
      
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        //Validaçãoes via Form Validation
        $this->form_validation->set_rules('title', 'Título do Botão', 'required');
        $this->form_validation->set_rules('cor_hexadecimal', 'Cor HEXADECIMAN do Botão', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {

            $dados_form = elements(array('title','cor_hexadecimal','status'), $this->input->post());
            $dados_form['link_redirecionamento'] = $this->input->post('link_redirecionamento');

            if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['name'])) {
                
                $path = "assets/arquivos_botoes_acesso_rapido/$campus->id";
                is_way($path);

                $upload = $this->painelbd->uploadFiles('arquivo', $path, $types = 'docx|pdf|PDF|jpg|JPG|png|PNG|jpeg|JPEG', NULL);

                if ($upload){
                    //upload efetuado
                    $dados_form['arquivo'] = $path . '/' . $upload['file_name'];
                }else{
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            $dados_form['userid'] = $this->session->userdata('codusuario');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            $dados_form['campusid'] = $campus->id;
            // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
            
            if ($this->painelbd->salvar('acessos_rapidos', $dados_form) == TRUE){
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_Campus/lista_botoes_acesso_rapido/$campus->id"));
            }else{
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
        }

        $data = array(
            'titulo' => 'Botões de Acesso Rápido - UniAtenas',
            'conteudo' => 'paineladm/botoes_acesso_rapido/cadastrar_botao_acesso_rapido',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => "Cadastro de Botão de acesso rápido <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=> $campus,
                'tipo'=>'tabelaDatatable'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_botoes_acesso_rapido($uriCampus=NULL, $idBotao=NULL){
        verificaLogin();
        $this->load->helper('file');
      
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        $botaoAcessoRapido = $this->painelbd->where('*','acessos_rapidos',NULL, array('acessos_rapidos.id'=>$idBotao))->row();

        //Validaçãoes via Form Validation
        $this->form_validation->set_rules('title', 'Título do Botão', 'required');
        $this->form_validation->set_rules('cor_hexadecimal', 'Cor HEXADECIMAN do Botão', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        }else {

            $dados_form = elements(array('title','cor_hexadecimal','status'), $this->input->post());
            $dados_form['link_redirecionamento'] = $this->input->post('link_redirecionamento');

            if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['name'])) {

                if (file_exists($botaoAcessoRapido->arquivo)) {
                    unlink($botaoAcessoRapido->arquivo);
                }

                $path = "assets/arquivos_botoes_acesso_rapido/$campus->id";
                is_way($path);

                $upload = $this->painelbd->uploadFiles('arquivo', $path, $types = 'docx|pdf|PDF|jpg|JPG|png|PNG|jpeg|JPEG', NULL);

                if ($upload){
                    //upload efetuado
                    $dados_form['arquivo'] = $path . '/' . $upload['file_name'];
                }else{
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            $dados_form['id'] = $botaoAcessoRapido->id;
            $dados_form['userid'] = $this->session->userdata('codusuario');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            $dados_form['campusid'] = $campus->id;
            // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
            
            if ($this->painelbd->salvar('acessos_rapidos', $dados_form) == TRUE){
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_Campus/lista_botoes_acesso_rapido/$campus->id"));
            }else{
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
        }

        $data = array(
            'titulo' => 'Botões de Acesso Rápido - UniAtenas',
            'conteudo' => 'paineladm/botoes_acesso_rapido/editar_botao_acesso_rapido',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => "Edição de Botão de acesso rápido <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=> $campus,
                'botaoAcessoRapido'=> $botaoAcessoRapido,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

 /*************************************************************************
     * Nossa história - Página da História do Uniatenas - Menu 
     * Página: www.atenas.edu.br/uniatenas/site/nossaHistoria/valenca
    *************************************************************************/

    public function lista_campus_nossa_historia(){
        verificaLogin();

        $page = '';
        $colunasResultadoCursos = 
            array('campus.id',
            'campus.name',
            'campus.city',
            'campus.uf'
        );
    
        $listagemDosCampus = $this->painelbd->where('*','campus',NULL, array('visible' => 'SIM'))->result();
        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/historia/lista_campus_historia',
            'dados' => array(
                'page' => 'Lista de Campus - História do Campus',
                'campus'=> $listagemDosCampus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_historia($uriCampus=NULL) {
        verificaLogin();

        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $pagina = 'nossaHistoria';
        $wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

        $joinConteudoPagina = array(
            'pages'=>'pages.id = page_contents.pages_id',
            'campus' => 'campus.id= pages.campusid'
            
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
        
        $listaInformmacoesHistoria = $this->painelbd->where($colunaResultadPagina,'page_contents',$joinConteudoPagina, $wherePagina,null)->result();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/historia/lista_historia',
            'dados' => array(
                'conteudosPagina'=>$listaInformmacoesHistoria,
                'page' => "Cadastro de História - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_historia($uriCampus=NULL) {
        verificaLogin();


        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $pagina = 'nossaHistoria';
        $wherePagina = array('pages.title'=> $pagina,'pages.campusid'=>$campus->id);

        $colunasTabelaPages = array('pages.id','pages.title');
        $joinConteudoPagina = array(
            'campus' => 'campus.id= pages.campusid'
            
        );
        $listaItemPages = $this->painelbd->where($colunasTabelaPages,'pages',$joinConteudoPagina, $wherePagina,null)->row();

           //Validaçãoes via Form Validation
       $this->form_validation->set_rules('description', 'Descrição', 'required');

       if ($this->form_validation->run() == FALSE) {
           if (validation_errors()):
               setMsg(validation_errors(), 'error');
           endif;
       }else {

            $dados_form['description'] = $this->input->post('description');
            $dados_form['title'] = $this->input->post('title');
            $dados_form['status'] = $this->input->post('status');
            $dados_form['pages_id'] = $listaItemPages->id;

            $dados_form['user_id'] = $this->session->userdata('codusuario');
            // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
            
            if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_campus/lista_historia/$campus->id"));
            }else{
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
       }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/historia/cadastrar_historia',
            'dados' => array(
                'conteudosPagina'=>'',
                'page' => "Cadastro de Informações História - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_historia($uriCampus=NULL,$paginaId) {
        verificaLogin();

        //echo '<script>alert('.$paginaId.')</script>';

        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $pagina = 'nossaHistoria';
        $wherePagina = array('page_contents.id'=>$paginaId);

       

        $joinConteudoPagina = array(
            'pages'=>'pages.id = page_contents.pages_id',
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
        
        $listaInformmacoesHistoria = $this->painelbd->where($colunaResultadPagina,'page_contents',$joinConteudoPagina, $wherePagina,null)->row();

       //Validaçãoes via Form Validation
       $this->form_validation->set_rules('description', 'Descrição e informações do curso', 'required');

       if ($this->form_validation->run() == FALSE) {
           if (validation_errors()):
               setMsg(validation_errors(), 'error');
           endif;
       }else {

            if ($listaInformmacoesHistoria->description != $this->input->post('description')) {
                $dados_form['description'] = $this->input->post('description');
            }
            if ($listaInformmacoesHistoria->title != $this->input->post('title')) {
                $dados_form['title'] = $this->input->post('title');
            }
            if ($listaInformmacoesHistoria->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }

            $dados_form['id'] = $listaInformmacoesHistoria->id;
            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
            
            if ($this->painelbd->salvar('page_contents', $dados_form) == TRUE){
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_campus/lista_historia/$campus->id"));
            }else{
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
       }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/historia/editar_historia',
            'dados' => array(
                'conteudosPagina'=>$listaInformmacoesHistoria,
                'page' => "Edição de Informações - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }


    /*************************************************************************
     * Indicadores que são exibidos no rodapé das páginas
     * Página: todas as páginas - Informações no RODAPÉ DO SITE
    *************************************************************************/

    public function lista_campus_indicadores() {
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
            'conteudo' => 'paineladm/campus/indicadores/lista_campus_indicadores',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => 'Lista de Indicadores (Itens exibidos no rodapé) - <strong>Gestão Por Campus</strong>',
                'campus'=> $listagemDosCampus,
                'tipo'=> '' 
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_indicadores($uriCampus) {
        verificaLogin();

        $uriCampus = $this->uri->segment(3);
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $joinIndicadoresComCampus = array(
            'campus' => 'campus.id = campus_indicadores.campusid'
        );
        $colunasIndicadores = array(
            'campus.id as idCampus',
            'campus.city',

            'campus_indicadores.id',
            'campus_indicadores.nome ',
            'campus_indicadores.campusid ',
            'campus_indicadores.arquivo',
            'campus_indicadores.status',
            'campus_indicadores.created_at',
            'campus_indicadores.updated_at',
            'campus_indicadores.user_id',
        );
        
        $listaDosIndicadores = $this->painelbd->where($colunasIndicadores,'campus_indicadores',$joinIndicadoresComCampus, array('campus_indicadores.campusid'=>$uriCampus))->result();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/indicadores/lista_indicadores',
            'dados' => array(
                'listaDosIndicadores'=>$listaDosIndicadores,
                'campus'=>$campus,
                'page' => "Gestão de Indicadores <i>(Exibido no Rodapé)</i> - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'tipo'=>'tabelaDatatable'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_indicador($uriCampus=NULL) {
        verificaLogin();

        $uriCampus = $this->uri->segment(3);

        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        //Validaçãoes via Form Validation
       $this->form_validation->set_rules('nome', 'Nome', 'required');
    
        if (empty($_FILES['arquivo']['name'])) {
            $this->form_validation->set_rules('arquivo', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
        }

       if ($this->form_validation->run() == FALSE) {
           if (validation_errors()):
               setMsg(validation_errors(), 'error');
           endif;
       }else {

            $path = "assets/images/indicadores/$campus->id";
            is_way($path);

            $upload = $this->painelbd->uploadFiles('arquivo', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

            $dados_form['nome'] = $this->input->post('nome');
            $dados_form['arquivo'] = $path . '/' . $upload['file_name'];
            $dados_form['status'] = $this->input->post('status');
            $dados_form['campusid'] = $campus->id;
            $dados_form['user_id'] = $this->session->userdata('codusuario');

            // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
           if ($this->painelbd->salvar('campus_indicadores', $dados_form) == TRUE){
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_campus/lista_indicadores/$campus->id"));
            }else{
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
       }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/indicadores/cadastrar_indicador',
            'dados' => array(
                'page' => "Cadastro de Indicadores <i>(Exibido no Rodapé)</i> - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_indicador($uriCampus=NULL,$idIndicador=NULL) {
        verificaLogin();

        $uriCampus = $this->uri->segment(3);
        $idIndicador = $this->uri->segment(4);

        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
       
        $joinIndicadoresComCampus = array(
            'campus' => 'campus.id = campus_indicadores.campusid'
        );
        $colunasIndicadores = array(
            'campus.id as idCampus',
            'campus.city',

            'campus_indicadores.id',
            'campus_indicadores.nome ',
            'campus_indicadores.campusid ',
            'campus_indicadores.arquivo',
            'campus_indicadores.status',
            'campus_indicadores.created_at',
            'campus_indicadores.updated_at',
            'campus_indicadores.user_id',
        );
        
        $indicador = $this->painelbd->where($colunasIndicadores,'campus_indicadores',$joinIndicadoresComCampus, array('campus_indicadores.id'=>$idIndicador))->row();

        // $indicador = $this->painelbd->where('*','campus_indicadores',NULL, array('campus_indicadores.id'=>$idIndicador))->row();

        //Validaçãoes via Form Validation
       $this->form_validation->set_rules('nome', 'Nome', 'required');
        if (empty($_FILES['arquivo']['name']) and !isset($indicador->arquivo)) {
            $this->form_validation->set_rules('arquivo', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato JPG ou PNG.');
        }

       if ($this->form_validation->run() == FALSE) {
           if (validation_errors()):
               setMsg(validation_errors(), 'error');
           endif;
       }else {

            if ($indicador->nome != $this->input->post('nome')) {
                $dados_form['nome'] = $this->input->post('nome');
            }
            if ($indicador->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }
            
            if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['name'])) {

                if (file_exists($indicador->arquivo)) {
                    unlink($indicador->arquivo);
                }

                $path = "assets/images/indicadores/$campus->id";
                is_way($path);

                $upload = $this->painelbd->uploadFiles('arquivo', $path, $types = 'jpg|JPG|png|PNG|jpeg|JPEG', NULL);

                if ($upload){
                    //upload efetuado
                    $dados_form['arquivo'] = $path . '/' . $upload['file_name'];
                }else{
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

           
            $dados_form['campusid'] = $campus->id;
            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            $dados_form['id'] = $indicador->id;

            // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
            if ($this->painelbd->salvar('campus_indicadores', $dados_form) == TRUE){
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect(base_url("Painel_campus/lista_indicadores/$campus->id"));
            }else{
                setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
            }
       }

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/indicadores/editar_indicador',
            'dados' => array(
                'page' => "Edição Indicador <i>(Exibido no Rodapé)</i> - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'campus'=>$campus,
                'indicador'=>$indicador,
                'tipo'=>''
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function delete_indicador($uriCampus=NULL,$id)
    {
        verifica_login();
        

        $uriCampus = $this->uri->segment(3);
        $colunasCampus = array('campus.id','campus.name','campus.city','campus.uf');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $id=$this->uri->segment(4);
        $item = $this->painelbd->where('*','campus_indicadores', NULL, array('campus_indicadores.id' => $id))->row();

        if (file_exists($item->arquivo)) {
            unlink($item->arquivo);
        }

        if ($this->painelbd->deletar('campus_indicadores', $id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect("Painel_Campus/lista_indicadores/$campus->id");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_Campus/lista_indicadores/$campus->id");
        }

    }

    /*************************************************************************
     * Indicadores que são exibidos no rodapé das páginas
     * Página: todas as dirigentes - Informações no link
     * uniatenas/site/dirigentes/NOME_DO_CAMPUS
    *************************************************************************/

    public function lista_dirigentes() {
        verificaLogin();
      
        $listaDosDirigentes = $this->painelbd->where('*','dirigentes',NULL, array('dirigentes.perfil'=>'diretor'))->result();

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/dirigentes/lista_dirigentes',
            'dados' => array(
                'dirigentes'=>$listaDosDirigentes,
                'page' => 'Gestão de Dirigentes <strong> (Diretor/Reitores)</strong> - TODOS OS CAMPUS',

                'tipo'=>'tabelaDatatable'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function cadastrar_dirigente(){
        verificaLogin();
       
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('cargo', 'Cargo', 'required');
        $this->form_validation->set_rules('cargo2', 'Cargo 2', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            $dados_form = elements(array('nome', 'email', 'status','cargo','cargo2'), $this->input->post());
            
            $path = "assets/images/dirigentes";
            is_way($path);

            if (!empty($_FILES['photo']['name'])) {
              $upload = $this->painelbd->uploadFiles('photo', $path, $types = 'jpg|JPG|png|jpeg|JPEG|PNG', null);

              if($upload){
                $dados_form['photo'] = $path.'/'.$upload['file_name'];
              }else{
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
              }
            }

            $dados_form['user_id'] = $this->session->userdata('codusuario');;
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            $dados_form['perfil'] = 'diretor';

           
            if ($this->painelbd->salvar('dirigentes', $dados_form)== TRUE ) {
              setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
              redirect("Painel_Campus/lista_dirigentes");
            } else {
              setMsg('<p>Erro! Erro no cadastro.</p>', 'error');
              redirect("Painel_Campus/lista_dirigentes");
            }
        }
        $data = array(
            'conteudo' => 'paineladm/campus/dirigentes/cadastrar_dirigentes',
            'titulo' => 'Dirigentes - UniAtenas',
            'dados' => array(
              'tipo' => '',
              'page'=> "<span>Cadastro de dirigente.</span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_dirigente($dirigenteId=NULL){
        verificaLogin();

        $dirigente = $this->painelbd->where('*','dirigentes',NULL, array('dirigentes.id'=>$dirigenteId))->row();

        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('cargo', 'Cargo', 'required');
        $this->form_validation->set_rules('cargo2', 'Cargo 2', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if ($dirigente->nome != $this->input->post('nome')) {
                $dados_form['nome'] = $this->input->post('nome');
            }
            if ($dirigente->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }

            if ($dirigente->email != $this->input->post('email')) {
                $dados_form['email'] = $this->input->post('email');
            }
            if ($dirigente->cargo != $this->input->post('cargo')) {
                $dados_form['cargo'] = $this->input->post('cargo');
            }
            if ($dirigente->cargo2 != $this->input->post('cargo2')) {
                $dados_form['cargo2'] = $this->input->post('cargo2');
            }
            
            $path = "assets/images/dirigentes";
            is_way($path);
            if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
              $upload = $this->painelbd->uploadFiles('backgroundPrincipal', $path, $types = 'jpg|JPG|png|jpeg|JPEG|PNG', null);

              if($upload){
                $dados_form['photo'] = $path.'/'.$upload['file_name'];
              }else{
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
              }
            }
            
            $dados_form['user_id'] = $this->session->userdata('codusuario');;
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            $dados_form['perfil'] = 'diretor';

            $dados_form['id'] = $dirigenteId;

            if ($this->painelbd->salvar('dirigentes', $dados_form)== TRUE ) {
                setMsg('<p>Informações do curso atualizada com sucesso.</p>', 'success');
                redirect("Painel_Campus/lista_dirigentes");
            } else {
                setMsg('<p>Erro! Erro no cadastro.</p>', 'error');
                redirect("Painel_Campus/lista_dirigentes");
            }
        }
        $data = array(
            'conteudo' => 'paineladm/campus/dirigentes/editar_dirigente',
            'titulo' => 'Editar Dirigentes - UniAtenas',
            'dados' => array(
                'tipo' => '',
                'dirigente' => $dirigente,
                'page'=> "<span>Edição de dirigente.</span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    /*************************************************************************
     * Indicadores que são exibidos no rodapé das páginas
     * Página: Página infraestrutura - Informações no link
     * uniatenas/site/infraestrutura/NOME_DO_CAMPUS
    *************************************************************************/
    
    public function lista_campus_infraestrutura() {
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
            'conteudo' => 'paineladm/campus/infraestrutura/lista_campus_infraestrutura',
            'dados' => array(
                // 'permissionCampusArray' => $_SESSION['permissionCampus'],
                'page' => 'Infraestrutura do Campus - <strong>Gestão Por Campus</strong>',
                'campus'=> $listagemDosCampus,
                'tipo'=>'',
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function lista_infraestrutura($uriCampus) {
        verificaLogin();

        $uriCampus = $this->uri->segment(3);
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $page = $this->painelbd->getWhere('pages', array('title' => 'infraestrutura', 'campusid' => $campus->id))->row();
        
        $joinCategoriasInfraestruturaCampus = array(
            'campus' => 'campus.id = pages.campusid',
            'page_contents' => "page_contents.pages_id = $page->id",
        );
        $colunasResultadoInfraestrutura = array(
            'page_contents.id',
            'page_contents.title',
            'page_contents.description', 
            'page_contents.img_destaque', 
            'page_contents.pages_id', 
            'page_contents.status', 
            'page_contents.created_at', 
            'page_contents.updated_at', 
            'page_contents.user_id', 

        );
        $whereCategoriasInfraestrutura= array(
            'pages.id'=>$page->id,
        );
        
        $listaInfraestrutura = $this->painelbd->where($colunasResultadoInfraestrutura,'pages',$joinCategoriasInfraestruturaCampus,$whereCategoriasInfraestrutura, null, null)->result();     

        $data = array(
            'titulo' => 'UniAtenas',
            'conteudo' => 'paineladm/campus/infraestrutura/lista_infraestrutura',
            'dados' => array(
                'listaInfraestrutura'=>$listaInfraestrutura,
                'campus'=>$campus,
                'page' => "itens da infraestrutura - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
                'tipo'=>'tabelaDatatable'
            )
        );

        $this->load->view('templates/layoutPainelAdm', $data);
    }


    public function cadastrar_infraestrutura($uriCampus=NULL){
        verificaLogin();
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $page = $this->painelbd->where('*','pages', null, array('title' => 'infraestrutura', 'campusid' => $campus->id))->row();
        
        $this->form_validation->set_rules('title', 'Nome da área', 'required');
        $this->form_validation->set_rules('description', 'Descrição da área', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            $dados_form['title'] = $this->input->post('title');
            $dados_form['description'] = $this->input->post('description');
            $dados_form['status'] = $this->input->post('status');
            $dados_form['pages_id'] = $page->id;
            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            $dados_form['order'] = 'service';


            if ($id=$this->painelbd->salvar('page_contents', $dados_form)) {
                setMsg('<p>Informações da infraestrutura cadastradas com sucesso.</p>', 'success');
                redirect("Painel_Campus/lista_infraestrutura/$uriCampus");
            } else {
                setMsg('<p>Erro! Erro no cadastro.</p>', 'error');
                redirect("Painel_Campus/lista_infraestrutura/$uriCampus");
            }
        }
        $data = array(
            'conteudo' => 'paineladm/campus/infraestrutura/cadastrar_infraestrutura',
            'titulo' => 'Infraestrutura - UniAtenas',
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'page' => "Cadastro de infraestrutura - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_infraestrutura($idCoteudoPaginaInfraestrutura=NULL,$uriCampus=NULL){
        verificaLogin();
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $page = $this->painelbd->getWhere('pages', array('title' => 'infraestrutura', 'campusid' => $campus->id))->row();

        $colunasPaginaInfraestrutura = array(
            'page_contents.id',
            'page_contents.title',
            'page_contents.description', 
            'page_contents.title_short', 
            'page_contents.img_destaque', 
            'page_contents.pages_id', 
            'page_contents.status', 
            'page_contents.created_at', 
            'page_contents.updated_at', 
            'page_contents.user_id', 

        );
        $wherePaginaInfraestrutura= array(
            'page_contents.id'=>$idCoteudoPaginaInfraestrutura,
        );
        
        $dadosInfraestrutura = $this->painelbd->where($colunasPaginaInfraestrutura,'page_contents',null,$wherePaginaInfraestrutura)->row();     

        $this->form_validation->set_rules('title', 'Nome da área', 'required');
        $this->form_validation->set_rules('description', 'Descrição da área', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if ($dadosInfraestrutura->title != $this->input->post('title')) {
                $dados_form['title'] = $this->input->post('title');
            }
            if ($dadosInfraestrutura->description != $this->input->post('description')) {
                $dados_form['description'] = $this->input->post('description');
            }

            if ($dadosInfraestrutura->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }

            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
            $dados_form['id'] = $dadosInfraestrutura->id;

            if ($id = $this->painelbd->salvar('page_contents', $dados_form)) {
                setMsg('<p>Informações da infraestrutura atualizada com sucesso.</p>', 'success');
                redirect("Painel_Campus/lista_infraestrutura/$uriCampus");
            } else {
                setMsg('<p>Erro! Erro no edição.</p>', 'error');
                redirect("Painel_Campus/lista_infraestrutura/$uriCampus");
            }
        }
        $data = array(
            'conteudo' => 'paineladm/campus/infraestrutura/editar_infraestrutura',
            'titulo' => 'Infraestrutura - UniAtenas',
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'dadosInfraestrutura' => $dadosInfraestrutura,
                'page' => "Editar infraestrutura - <strong>$dadosInfraestrutura->title <i>Campus - $campus->name ($campus->city) </i></strong>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_infraestrutura($uriCampus=NULL,$id = NULL)
    {
        verifica_login();
    
        $item = $this->painelbd->where('*','page_contents', NULL, array('page_contents.id' => $id))->row(); 

        if ($this->painelbd->deletar('page_contents', $item->id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect("Painel_Campus/lista_infraestrutura/$uriCampus");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_Campus/lista_infraestrutura/$uriCampus");
        }

    }
    
    public function lista_fotos_infraestrutura($idConteudoPaginaInfraestrutura=NULL,$uriCampus=NULL)
    {
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

        $colunaPagina = array('pages.id');

        $pagina = $this->painelbd->where($colunaPagina,'pages',Null, array('title' => 'infraestrutura', 'campusid' => $campus->id))->row();

     
        $colunasFotosInfraestrutura = array(
            'page_contents_photos.id',
            'page_contents_photos.id_page_contents',
            'page_contents_photos.file',
            'page_contents_photos.title',
            'page_contents_photos.status',
            'page_contents_photos.created_at',
            'page_contents_photos.updated_at',
            'page_contents_photos.user_id',
        );

        $whereFotosInfraestrutura= array(
            'page_contents_photos.id_page_contents'=>$idConteudoPaginaInfraestrutura,
        );
        
        $listaFotosInfraestrutura = $this->painelbd->where($colunasFotosInfraestrutura,'page_contents_photos',NULL,$whereFotosInfraestrutura)->result();     

        $whereInfraestrutura= array(
            'page_contents.id'=>$idConteudoPaginaInfraestrutura,
        );
        $colunaInfraestrutura = array(
            'page_contents.id',
            'page_contents.title',
        );
        $categoriaInfraestrutura = $this->painelbd->where($colunaInfraestrutura,'page_contents',NULL,$whereInfraestrutura, null, null)->row();         
        
        $data = array(
            'conteudo' => 'paineladm/campus/infraestrutura/fotos_infra/lista_fotos_infra',
            'titulo' => 'Fotos da Infraestrutura',
            'dados' => array(
                'page' => "Fotos da infraestrutura  <strong>  $categoriaInfraestrutura->title <i>Campus - $campus->name ($campus->city) </i></strong>",
                'tipo' => 'tabelaDatatable',
                'fotosInfraestrutura' => $listaFotosInfraestrutura,
                'pagina'=>$pagina,
                'categoriaInfraestrutura'=>$categoriaInfraestrutura,
                'campus' => $campus,
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }
    
    public function cadastrar_fotos_infraestrutura($idConteudoPaginaInfraestrutura=NULL,$uriCampus=NULL)
    {
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
       
        $colunaInfraestrutura = array('page_contents.id','page_contents.title');
        $whereInfraestrutura= array('page_contents.id'=>$idConteudoPaginaInfraestrutura);
        $categoriaInfraestrutura = $this->painelbd->where($colunaInfraestrutura,'page_contents',NULL,$whereInfraestrutura, null, null)->row();         
                
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
            
            $path = "assets/images/gallery/$campus->id/$categoriaInfraestrutura->id";
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
                    // $dados_form['categoria'] = trim($categoriaInfraestrutura->title);
                    $dados_form['id_page_contents'] = $categoriaInfraestrutura->id;

                    if ($id = $this->painelbd->salvar('page_contents_photos', $dados_form)) {
                        if ($number_of_files == ($i + 1)) {
                            setMsg('<p>Fotos cadastrada com sucesso.</p>', 'success');
                            redirect("Painel_Campus/lista_fotos_infraestrutura/$categoriaInfraestrutura->id/$campus->id");
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
            'conteudo' => 'paineladm/campus/infraestrutura/fotos_infra/cadastrar_fotos_infra',
            'titulo' => "Fotos - $categoriaInfraestrutura->title $campus->name - $campus->city",
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'categoriaFoto'=>$categoriaInfraestrutura,
                'page'=> "<span>Cadastro Fotos: <strong> $categoriaInfraestrutura->title <i>$campus->name - $campus->city</i></strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function editar_foto_infraestrutura($idConteudoPaginaInfraestrutura=NULL,$uriCampus=NULL,$id=NULL)
    {
        $colunasCampus = array('campus.id','campus.name','campus.city');
        $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
        
        $colunaInfraestrutura = array('page_contents.id','page_contents.title');
        $whereInfraestrutura= array('page_contents.id'=>$idConteudoPaginaInfraestrutura);
        $categoriaInfraestrutura = $this->painelbd->where($colunaInfraestrutura,'page_contents',NULL,$whereInfraestrutura)->row();         

        $fotoInfraestrutura = $this->painelbd->where('*','page_contents_photos',null,array('page_contents_photos.id'=>$id))->row();     
        
        $this->form_validation->set_rules('title', 'Título', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()):
                setMsg(validation_errors(), 'error');
            endif;
        } else {
            if ($fotoInfraestrutura->title != $this->input->post('title')) {
                $dados_form['title'] = $this->input->post('title');
            }

            if ($fotoInfraestrutura->status != $this->input->post('status')) {
                $dados_form['status'] = $this->input->post('status');
            }
            

            if (isset($_FILES['file']) and !empty($_FILES['file']['name'])) {
                
                $path = "assets/images/gallery/$campus->id/$categoriaInfraestrutura->id";

                is_way($path);

                if (file_exists($fotoInfraestrutura->file)) {
                    unlink($fotoInfraestrutura->file);
                }
                
                $upload = $this->painelbd->uploadFiles('file', $path, $types = 'jpg|JPG|jpeg|JPEG|png|PNG', NULL);

                if ($upload){
                    //upload efetuado
                    $dados_form['file'] = $path . '/' . $upload['file_name'];
                }else{
                    //erro no upload
                    $msg = $this->upload->display_errors();
                    $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                    setMsg($msg, 'erro');
                }
            }

            $dados_form['id'] = $fotoInfraestrutura->id;
            $dados_form['user_id'] = $this->session->userdata('codusuario');
            $dados_form['updated_at'] = date('Y-m-d H:i:s');
           
            if ($this->painelbd->salvar('page_contents_photos', $dados_form) == TRUE){
                setMsg('<p>Fotos cadastrada com sucesso.</p>', 'success');
                redirect("Painel_Campus/lista_fotos_infraestrutura/$idConteudoPaginaInfraestrutura/$campus->id");
            }else{
                setMsg('<p>Erro! A foto não pode ser cadastrada.</p>', 'error');
            }   
        }

        $data = array(
            'conteudo' => 'paineladm/campus/infraestrutura/fotos_infra/editar_fotos_infra',
            'titulo' => "Fotos - $categoriaInfraestrutura->title $campus->name - $campus->city",
            'dados' => array(
                'tipo' => '',
                'campus' => $campus,
                'fotoInfraestrutura' => $fotoInfraestrutura,
                'categoriaInfraestrutura'=>$categoriaInfraestrutura,
                'page'=> "<span>Edição dados foto: <strong>$categoriaInfraestrutura->title <i>$campus->name - $campus->city</i></strong></span>",
            )
        );
        $this->load->view('templates/layoutPainelAdm', $data);
    }

    public function deletar_foto_infra($idCategoriaInfraestrutura=NULL,$uriCampus=NULL,$id = NULL)
    {
        verifica_login();
    
        $uriCampus=$this->uri->segment(4);
        $id=$this->uri->segment(5);
        $item = $this->painelbd->where('*','page_contents_photos', NULL, array('page_contents_photos.id' => $id))->row(); 

        if (file_exists($item->file)) {
            unlink($item->file);
        }

        if ($this->painelbd->deletar('page_contents_photos', $item->id)) {
            setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
            redirect("Painel_Campus/lista_fotos_infraestrutura/$idCategoriaInfraestrutura/$uriCampus");
        } else {
            setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
            redirect("Painel_Campus/lista_fotos_curso/$idCategoriaInfraestrutura/$uriCampus");
        }

    }    
}