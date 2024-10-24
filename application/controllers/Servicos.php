<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Servicos extends CI_Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        parent::__construct();
        $this->load->model('Site_model', 'bancosite');
        $this->load->model('Cpainel_model', 'Painelsite');
    }

    public function nucleos($uricampus = NULL, $pagina = NULL)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where(array('campus.id', 'campus.instagram', 'campus.city', 'campus.shurtName', 'campus.facebook'), 'campus', NULL, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => $pagina, 'tipo_pagina' => 'nucleos', 'pagina' => 'servicos', 'campusid' => $dataCampus->id))->row();

        $whereConteudoPagina = array('page_contents.pages_id' => $page->id, 'page_contents.tipo' => 'informacoesPagina', 'page_contents.status' => 1);
        $pages_content = $this->bancosite->where('*', 'page_contents', null, $whereConteudoPagina)->result();

        $pages_content_contato = $this->bancosite->where('*', 'page_contents', null, array('pages_id' => $page->id, 'status' => 1, 'order' => 'contatos'))->row();

        $colunasResultadoAtendimento = array('page_contents.id', 'page_contents.title', 'page_contents.description', 'page_contents.status', 'page_contents.pages_id');
        $conteudoAtendimento = $this->bancosite->where($colunasResultadoAtendimento, 'page_contents', null, array('pages_id' => $page->id, 'status' => 1, 'order' => 'atendimento'))->row();

        $data = array(
            'head' => array(
                'title' => strtoupper($page->title) . ' ' . $dataCampus->city,
            ),
            'footer' => '',
            'menu' => '',
            'js' => null,
            'conteudo' => 'uniatenas/servicos/nucleos',
            'dados' => array(
                'campus' => $dataCampus,
                'conteudoPagina' => $pages_content,
                'conteudoContato' => $pages_content_contato,
                'conteudoAtendimento' => $conteudoAtendimento = isset($conteudoAtendimento) ? $conteudoAtendimento : '',
            )
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }

    public function gerais($uricampus = NULL, $pagina = NULL)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where(array('campus.id', 'campus.instagram', 'campus.city', 'campus.shurtName', 'campus.facebook'), 'campus', NULL, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => $pagina, 'tipo_pagina' => 'item_geral', 'pagina' => 'servicos', 'campusid' => $dataCampus->id))->row();

        $whereConteudoPagina = array('page_contents.pages_id' => $page->id, 'page_contents.tipo' => 'informacoesPagina', 'page_contents.status' => 1);
        $pages_content = $this->bancosite->where('*', 'page_contents', null, $whereConteudoPagina)->result();

        $pages_content_contato = $this->bancosite->where('*', 'page_contents', null, array('pages_id' => $page->id, 'status' => 1, 'order' => 'contatos'))->row();

        $colunasResultadoAtendimento = array('page_contents.id', 'page_contents.title', 'page_contents.description', 'page_contents.status', 'page_contents.pages_id');
        $conteudoAtendimento = $this->bancosite->where($colunasResultadoAtendimento, 'page_contents', null, array('pages_id' => $page->id, 'status' => 1, 'order' => 'atendimento'))->row();

        $data = array(
            'head' => array(
                'title' => strtoupper($page->title) . ' ' . $dataCampus->city,
            ),
            'footer' => '',
            'menu' => '',
            'js' => null,
            'conteudo' => 'uniatenas/servicos/geral',
            'dados' => array(
                'campus' => $dataCampus,
                'conteudoPagina' => $pages_content,
                'conteudoContato' => $pages_content_contato,
                'conteudoAtendimento' => $conteudoAtendimento = isset($conteudoAtendimento) ? $conteudoAtendimento : '',
            )
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }


    public function NPJ($uricampus = null)
    {
        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', NULL, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'npj'))->row();

        $consulta = "SELECT
                            *
                        FROM
                            at_site.page_contents
                        where page_contents.order like 'texto%'
                        and pages_id = $page->id
                                ";
        $pages_content = $this->bancosite->getQuery($consulta)->result();
        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'page_contents.order' => 'description'))->result();
        $pages_content_contato = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'order' => 'contatos'))->result();

        $data = array(
            'head' => array(
                'title' => 'NPJ ' .  $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/nucleos/npj',
            'footer' => '',
            'menu' => '',
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'conteudo' => $pages_content,
                'conteudoPag' => $conteudoPrincipal,
                'conteudoContatos' => $pages_content_contato,
            )
        );
        $this->output->cache(14400);
        $this->load->view('templates/master', $data);
    }

    /* ------------------------------------------------------------
      --------------              Graduação
      ------------------------------------------------------------ */

    public function graduacao()
    {
        redirect('graduacao/cursos');
    }

    public function publicacoes($campus)
    {

        $local = $this->bancosite->get_all('campus', $campus)->row();
        $revistas = $this->bancosite->getWhere('revistas', array('status' => 1, 'campus_id' => $campus))->result();
        $data = array(
            'head' => array(
                'title' => 'Revistas ',
            ),
            'titulo' => 'Publicações - UniAtenas',
            'conteudo' => 'uniatenas/publicacoes/publicacoes',
            'js' => null,
            'footer' => '',
            'dados' => array(
                'campus' => $local,
                'revistas' => $revistas
            )
        );
        $this->load->view('templates/master', $data);
    }

    public function revistaCientifica($id)
    {
        if (!isset($id) and $id == null) {
            redirect('site/publicacoes');
        }

        $campus = "
         SELECT
  revistas.id,
    revistas.titulo,
    campus.id as campus_id,
    campus.name,
    campus.city
    
FROM
    revistas
inner join campus on campus.id = revistas.campus_id
where revistas.status=1
and revistas.id =$id;
         ";

        $sql = "SELECT * FROM at_site.publicacoes
            where revistas_id =$id
            order by year desc";

        $sqlYear = "SELECT year FROM at_site.publicacoes
            where revistas_id=$id
            group by(year)
            order by 1 desc";

        $campus = $this->bancosite->getQuery($campus)->row();
        $revistas = $this->bancosite->getWhere('revistas', array('id' => $id))->row();
        $publicacoes = $this->bancosite->getQuery($sql)->result();
        $years = $this->bancosite->getQuery($sqlYear)->result();

        $data = array(
            'head' => array(
                'title' => 'Revistas - UniAtenas',
            ),
            'titulo' => 'Publicações - UniAtenas',
            'conteudo' => 'uniatenas/publicacoes/revistaCientifica',
            'js' => null,
            'footer' => '',
            'dados' => array(
                'publicacoes' => $publicacoes,
                'years' => $years,
                'campus' => $campus,
                'revistas' => $revistas,
                'revista_id' => $id,
            )
        );
        $this->load->view('templates/master', $data);
    }

    public function contato($uricampus = NULL)
    {

        if ($uricampus == null) {
            redirect("");
        }


        $dataCampus = $this->bancosite->where('*', 'campus', NULL, array('shurtName' => $uricampus))->row();

        $this->form_validation->set_rules('name', 'Nome', 'required|ucfirst');
        $this->form_validation->set_rules('email', 'E-mail', 'required');
        $this->form_validation->set_rules('phone', 'Telefone', 'required');
        $this->form_validation->set_rules('message', 'Mensagem', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if (!empty($this->input->post('enviarForm'))) {


                $url = "https://www.google.com/recaptcha/api/siteverify";
                $secret = "6Lc1NxEmAAAAADgQbDjiqScjBzvga54vmJt1jsmZ";
                $response = $this->input->post('g-recaptcha-response');
                $variaveis = "secret=" . $secret . "&response=" . $response;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $variaveis);
                $resposta = curl_exec($ch);
                curl_close($ch);

                $resultado = json_decode($resposta);

                if ($resultado->success == 1) {
                    if ($this->input->post('description') != '') {
                        $outhersInformation = $this->input->post('description');
                    } else {
                        $outhersInformation = '';
                    }


                    $data = elements(array('name', 'email', 'phone', 'message'), $this->input->post());
                    setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
                    date_default_timezone_set('America/Sao_Paulo');

                    $date = date('Y-m-d H:i:s');

                    $data['campusid'] = $dataCampus->id;

                    $mensagem = "<p>O (A)" .
                        "<b>" . $data['name'] . "</b> fez conato pelo site." . "<br/>" .
                        "Email: " . $data['email'] . "<br/>" .
                        "Celular: " . $data['phone'] . "<br/>" .
                        "Mensagem: " . $data['message'] . "<br/>" .
                        "O conato veio da página de " . $dataCampus->name . ' - ' . $dataCampus->city . "<br/>" . "<br/>" .
                        "O contato foi realizado no dia <b>" . date('d/m/Y H:i:s', strtotime($date)) . '</b>';

                    $this->load->library('email');

                    //Inicia o processo de configuração para o envio do email
                    $config['protocol'] = 'mail'; // define o protocolo utilizado
                    $config['wordwrap'] = TRUE; // define se haverá quebra de palavra no texto
                    $config['validate'] = TRUE; // define se haverá validação dos endereços de email
                    $config['mailtype'] = 'html';
                    $config['newline'] = '\r\n';
                    $config['charset'] = 'utf-8';

                    //$email = 'soaresdev.wil@gmail.com';
                    $email = $dataCampus->email;
                    $this->email->initialize($config);

                    $assunto = 'Fale Conosco' . $dataCampus->name . ' - ' . $dataCampus->city;
                    $this->email->from('faleconosco@atenas.edu.br', 'Fale Conosco'); //quem mandou
                    $this->email->to($email); // Destinatário
                    //$this->email->cc('comunicacao@atenas.edu.br');
                    $this->email->cc($data['email']);
                    //$this->email->bcc($data['email']);
                    $this->email->subject($assunto);
                    $this->email->message($mensagem);



                    if ($this->email->send()) {
                        $data['message'] = toBd($this->input->post('message'));
                        $this->bancosite->salvar('campus_contacts', $data);
                        setMsg('<p>Contato realizado com sucesso. <br>
                            Enviamos um email, em sua caixa postal, com as informações do seu contato.</p>', 'success');
                        redirect(base_url("site/contato/$dataCampus->shurtName"));
                    } else {
                        redirect(base_url("site/contato/$dataCampus->shurtName"));
                        setMsg('<p>Erro! Infelismente, houve um erro. Você pode tentar novamente mais tarde, ou nos enviar uma mensagem pelo nosso Whatsapp (38)9.9805-9502 </p>', 'error');
                    }
                } else {
                    setMsg('<p>Erro! O campo recaptcha precisa ser validado  </p>', 'error');
                }
            } else {
                setMsg('<p>Erro! reCaptcha não foi validado; </p>', 'error');
            }
        }

        $data = array(
            'head' => array(
                'title' => 'Contato - UniAtenas ',
            ),
            'titulo' => 'Contato - UniAtenas',
            'conteudo' => 'uniatenas/contato',
            'dados' => array(
                'campus' => $dataCampus
            ),
            'js' => null,
            'footer' => ''
        );
        $this->load->view('templates/master', $data);
    }

    public function contatonapp($uricampus = NULL)
    {
        if ($uricampus == null) {
            redirect("");
        }
        $dataCampus = $this->bancosite->where('*', 'campus', NULL, array('shurtName' => $uricampus))->row();

        $this->form_validation->set_rules('name', 'Nome', 'required|ucfirst');
        $this->form_validation->set_rules('email', 'E-mail', 'valid_email|required');
        $this->form_validation->set_rules('phone', 'Telefone', 'required');
        $this->form_validation->set_rules('message', 'Mensagem', 'required');

        if ($this->form_validation->run() == FALSE) {
            if (validation_errors()) :
                setMsg(validation_errors(), 'error');
            endif;
        } else {

            if ($this->input->post('description') != '') {
                $outhersInformation = $this->input->post('description');
            } else {
                $outhersInformation = '';
            }

            $data = elements(array('name', 'email', 'phone', 'message'), $this->input->post());
            setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
            date_default_timezone_set('America/Sao_Paulo');

            $date = date('Y-m-d H:i:s');

            $data['campusid'] = $dataCampus->id;

            $mensagem = "<p>O Sr.(Srª)" .
                "<b>" . $data['name'] . "</b> fez conato pelo site." . "<br/>" .
                "Email: " . $data['email'] . "<br/>" .
                "Celular: " . $data['phone'] . "<br/>" .
                "Mensagem: " . $data['message'] . "<br/>" .
                "O conato veio da página de " . $dataCampus->name . ' - ' . $dataCampus->city . "<br/>" . "<br/>" .
                "O contato foi realizado no dia <b>" . date('d/m/Y H:i:s', strtotime($date)) . '</b>';

            $this->load->library('email');

            //Inicia o processo de configuração para o envio do email
            $config['protocol'] = 'mail'; // define o protocolo utilizado
            $config['wordwrap'] = TRUE; // define se haverá quebra de palavra no texto
            $config['validate'] = TRUE; // define se haverá validação dos endereços de email
            $config['mailtype'] = 'html';
            $config['newline'] = '\r\n';
            $config['charset'] = 'utf-8';

            $email = "napp.uniatenas@uniatenas.edu.br";
            $this->email->initialize($config);

            $assunto = 'Fale Conosco' . $dataCampus->name . ' - ' . $dataCampus->city;
            $this->email->from('faleconosco@atenas.edu.br', 'Fale Conosco'); //quem mandou
            $this->email->to($email); // Destinatário
            //$this->email->cc('comunicacao@atenas.edu.br');
            $this->email->cc($data['email']);
            //$this->email->bcc($data['email']);
            $this->email->subject($assunto);
            $this->email->message($mensagem);

            if ($this->email->send()) {
                $this->bancosite->salvar('campus_contacts', $data);
                setMsg('<p>Contato realizado com sucesso. <br>
                    Enviamos um email, em sua caixa postal, com as informações do seu contato.</p>', 'success');
                echo "<script>alert('Email enviado com sucesso!');</script>";
            } else {
                setMsg('<p>Erro! Infelismente, houve um erro. Você pode tentar novamente mais tarde, ou nos enviar uma mensagem pelo nosso Whatsapp (38)9.9805-9502 </p>', 'error');
            }
        }

        $data = array(
            'head' => array(
                'title' => 'Napp - UniAtenas ',
            ),
            'titulo' => 'Napp - UniAtenas',
            'conteudo' => 'uniatenas/contatonapp',
            'dados' => array(
                'campus' => $dataCampus
            ),
            'js' => null,
            'footer' => ''
        );
        $this->load->view('templates/master', $data);
    }


    public function erro_404()
    {
    }

    public function graduacaoEad($codEad = null)
    {


        $campus = '1'; //campus Paracatu
        $localidade = $this->bancosite->get_all('campus', $campus)->row();
        if (isset($codEad) and $codEad != 'uniasselvi') {
            $curso = $this->bancosite->getWhere('courses', array('modalidade' => "ead", 'types' => "ead", 'id' => $codEad))->row();

            $data = array(
                'titulo' => 'Graduação EAD - UniAtenas',
                'conteudo' => 'uniatenas/graduacaoEad/eadUniatenas',
                'dados' => array(
                    'campus' => $localidade,
                    'curso' => $curso
                )
            );
            $this->load->view('templates/layoutParacatu', $data);
        } elseif (isset($codEad) and $codEad == 'uniasselvi') {
            $cursos = $this->bancosite->getQuery('SELECT * FROM courses WHERE modalidade="ead" and types="eadUniasselvi"')->result();

            $data = array(
                'titulo' => 'Graduação EAD - Uniasselvi - UniAtenas',
                'conteudo' => 'uniatenas/graduacaoEad/uniasselvi',
                'dados' => array(
                    'campus' => $localidade,
                    'cursos' => $cursos
                )
            );
            $this->load->view('templates/layoutParacatu', $data);
        } else {
            $cursos = $this->bancosite->getQuery('SELECT * FROM courses WHERE modalidade="ead" and types="ead"')->result();

            $data = array(
                'titulo' => 'Graduação EAD - UniAtenas',
                'conteudo' => 'uniatenas/graduacaoEad/cursos',
                'dados' => array(
                    'campus' => $localidade,
                    'cursos' => $cursos
                )
            );
            $this->load->view('templates/layoutParacatu', $data);
        }
    }

    public function infraestrutura($uricampus = NULL)
    {
        // usar quando aprovado
        /*
         * https://codepen.io/dbgomez/pen/PowdgPB
         * */

        if ($uricampus == null) {
            redirect("");
        }


        $dataCampus = $this->bancosite->where(array('campus.id', 'campus.instagram', 'campus.city', 'campus.facebook'), 'campus', NULL, array('shurtName' => $uricampus))->row();

        //$dataCampus = $this->bancosite->getWhere('campus', array('city' => $dataCampus->city))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'infraestrutura', 'campusid' => $dataCampus->id))->row();

        $pages_content = $this->bancosite->where('*', 'page_contents', NULL, array('pages_id' => $page->id, 'status' => 1), array('campo' => 'order', 'ordem' => 'asc'))->result();
        $photosConted = array();

        // $datajoin = array(
        //     'page_contents' => 'page_contents.id = photos_gallery.id_page_contents',
        //     'photos_gallery' => 'photos_gallery.photoscategoryid = photos_category.id'
        // );
        foreach ($pages_content as $contend) {
            $where =  array("page_contents_photos.id_page_contents" => $contend->id);
            $campos = array("page_contents_photos.file", "page_contents_photos.id");
            $photos = array("photo" => $this->bancosite->where('*', "page_contents_photos", null, $where)->result());
            $contend->array_fotos = $photos;
            // $contend->Fk_photosCat = $photos;
        }
        // $datajoin = array(
        //     'photos_category' => 'photos_category.id = page_contents.Fk_photosCat',
        //     'photos_gallery' => 'photos_gallery.photoscategoryid = photos_category.id'
        // );
        // foreach ($pages_content as $contend) {
        //     $where =  array("photos_category.id" => $contend->Fk_photosCat);
        //     $campos = array("photos_gallery.file", "photos_gallery.id");
        //     $photos = array("photo" => $this->bancosite->where($campos, "page_contents", $datajoin, $where)->result());
        //     $contend->Fk_photosCat = $photos;
        // }

        /*unset($where);
        unset($photos);
        unset($datajoin);*/



        $data = array(
            'head' => array(
                'title' => 'Infraestrutura - UniAtenas ',
            ),
            'conteudo' => 'uniatenas/infraestrutura',
            'dados' => array(
                //'dados' => $dados,
                'campus' => $dataCampus,
                'pages_content' => isset($pages_content) ? $pages_content : '',
            ),
            'js' => null,
            'footer' => ''
        );
        //unset($photosConted);
        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }


    public function nossaHistoria($uricampus = NULL)
    {

        if ($uricampus == null) {
            redirect("");
        }
        $dataCampus = $this->bancosite->where('*', 'campus', NULL, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'nossaHistoria', 'campusid' => $dataCampus->id))->row();
        $pages_content = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'status' => 1))->result();

        $data = array(
            'head' => array(
                'title' => 'História ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/nossaHistoria',
            'dados' => array(
                'campus' => $dataCampus,
                'pages_content' => $pages_content
            ),
            'js' => null,
            'footer' => ''

            //'news' => $news
        );
        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }

    public function secretaria_academica($uricampus = NULL)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', NULL, array('shurtName' => $uricampus))->row();
        $page = $this->bancosite->getWhere('pages', array('title' => 'secretariaacademica', 'campusid' => $dataCampus->id))->row();

        $queryItensSecretaria = "
        SELECT 
          page_contents.id,
          page_contents.title,
          page_contents.title_short,
          page_contents.status,
          page_contents.tipo,
          page_contents.order,
          page_contents.description
        FROM
          page_contents
          JOIN pages ON pages.id = page_contents.pages_id
          JOIN campus ON campus.id = pages.campusid
        WHERE
          page_contents.pages_id = $page->id AND 
          page_contents.status = 1 AND 
          page_contents.tipo = 'informacoesPagina' 
        ORDER BY page_contents.order
        ";
        // $pages_content = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'status' => 1))->result();
        $pages_content = $this->bancosite->getQuery($queryItensSecretaria)->result();

        $calendars = $this->bancosite->getWhere('campus_calendars', array('campusid' => $dataCampus->id, 'status' => 1, 'type' => 'demais_cursos'), array('campo' => 'semester', 'ordem' => 'desc'))->result();
        $calendarsMedicine = $this->bancosite->getWhere('campus_calendars', array('campusid' => $dataCampus->id, 'status' => 1, 'type' => 'medicina'), array('campo' => 'semester', 'ordem' => 'desc'))->result();

        $camposCartilha = array('files.name', 'files.files');
        $joinCartilha = array(
            'files_has_pages' => 'files_has_pages.filesid = files.id',
            'campus' => 'files.campusid = campus.id'
        );
        $whereCartilha = array('files.campusid' => $dataCampus->id, 'files.typesfile' => 'cartilha', 'files.status' => 1);
        // $horasComplementares = $this->bancosite->where($camposCartilha, 'files', array('campusid' => $dataCampus->id, 'typesfile' => 'cartilha'))->row();
        $horasComplementares = $this->bancosite->where($camposCartilha, 'files', $joinCartilha, $whereCartilha)->row();

        //$pages_content_contato = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id, 'order' => 'contatos'))->row();

        $colunasResultadoLinksUteis = array('page_contents.id', 'page_contents.title', 'page_contents.link_redir', 'page_contents.status', 'page_contents.pages_id');
        $whereLinksUteis = array('page_contents.pages_id' => $page->id, 'page_contents.status' => 1, 'page_contents.order' => 'linksUteis', 'page_contents.tipo' => 'linksUteis');
        $conteudoLinksUteis = $this->bancosite->where($colunasResultadoLinksUteis, 'page_contents', null, $whereLinksUteis)->result();

        $colunasResultadoAcessoRapido = array('page_contents.id', 'page_contents.title', 'page_contents.link_redir', 'page_contents.status', 'page_contents.pages_id');
        $whereAcessoRapido = array('page_contents.pages_id' => $page->id, 'page_contents.status' => 1, 'page_contents.order' => 'linksUteis', 'page_contents.tipo' => 'acessoRapido');
        $conteudoAcessoRapido = $this->bancosite->where($colunasResultadoAcessoRapido, 'page_contents', null, $whereAcessoRapido)->result();


        $filedPhones = array("contatos_setores.phone", "contatos_setores.ramal", "contatos_setores.visiblepage", "contatos_setores.email", "contatos_setores.phonesetor");
        $tablePhones = "campus_has_setores";
        $dataJoinPhones = array("contatos_setores" => "contatos_setores.setoresidcamp = campus_has_setores.id");
        $wherePhones = array("campus_has_setores.id" => $page->setorcampid, "contatos_setores.visiblepage" => 1);
        $phones = $this->Painelsite->where($filedPhones, $tablePhones, $dataJoinPhones, $wherePhones)->result();

        $data = array(
            'head' => array(
                'title' => 'Secretaría Acadêmica - ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/secretariaacademica/homesecretaria',
            'dados' => array(
                'campus' => $dataCampus,
                'conteudoAcessoRapido' => $conteudoAcessoRapido = isset($conteudoAcessoRapido) ? $conteudoAcessoRapido : '',
                'conteudoLinksUteis' => $conteudoLinksUteis = isset($conteudoLinksUteis) ? $conteudoLinksUteis : '',
                'conteudoPag' => $pages_content,
                'calendars' => $calendars,
                'calendarsMedicine' => $calendarsMedicine,
                //'conteudoContato' => $pages_content_contato,
                'horasComplementares' => $horasComplementares,
                //'contatos' => $phones,
            ),
            'js' => null,
            'footer' => ''
        );
        $this->load->view('templates/master', $data);
    }

    public function dirigentes($uricampus = NULL)
    {
        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', NULL, array('shurtName' => $uricampus))->row();

        $dirigentes = $this->bancosite->getQuery("SELECT * FROM dirigentes WHERE cargo NOT LIKE '%coordenador%' ")->result();

        $data = array(
            'head' => array(
                'title' => 'Dirigentes ' . $dataCampus->city,
            ),
            'conteudo' => 'uniatenas/dirigentes',
            'dados' => array(
                'campus' => $dataCampus,
                'dirigentes' => $dirigentes
            ),
            'js' => null,
            'footer' => ''
        );
        $this->output->cache(14.400);
        $this->load->view('templates/master', $data);
    }

    /* ------------------------------------------------------------
      --------------              Trabalhe Conosco
      ------------------------------------------------------------ */

    public function trabalheConosco($uricampus = NULL)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->where('*', 'campus', NULL, array('shurtName' => $uricampus))->row();

        $page = $this->bancosite->getWhere('pages', array('title' => 'trabalheconosco', 'campusid' => $dataCampus->id))->row();

        $localidades = $this->bancosite->getAll('campus')->result();

        $conteudoPrincipal = $this->bancosite->getWhere('page_contents', array('pages_id' => $page->id))->result();

        $areasAtuacao = $this->bancosite->getWhere('areas')->result();
        $vagasAbertas = $this->bancosite->getWhere('resume_job_vacancy', array('status' => '1'))->result();

        $filedPhones = array("contatos_setores.phone", "contatos_setores.ramal", "contatos_setores.visiblepage", "contatos_setores.email", "contatos_setores.phonesetor");
        $tablePhones = "campus_has_setores";
        $dataJoinPhones = array("contatos_setores" => "contatos_setores.setoresidcamp = campus_has_setores.id");
        $wherePhones = array("campus_has_setores.id" => 1, "contatos_setores.visiblepage" => 1);
        $phones = $this->Painelsite->where($filedPhones, $tablePhones, $dataJoinPhones, $wherePhones)->result();

        $data = array(
            'head' => array(
                'title' => 'Trabalhe Conosco - ' . $dataCampus->city,
            ),
            'conteudo' => 'uni_trabalheConosco/inicio',
            'menu' => '',
            'footer' => '',
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'idativo' => '$idativo',
                'localidades' => $localidades,
                'conteudoPag' => $conteudoPrincipal,
                'vagasAbertas' => $vagasAbertas,
                'contatos' => $phones
            )
        );
        $this->load->view('templates/master', $data);
    }

    public function envioCurriculo($uricampus = NULL, $vaga = NULL)
    {

        if ($uricampus == null) {
            redirect("");
        }
        $dataCampus = $this->bancosite->where('*', 'campus', NULL, array('shurtName' => $uricampus, 'visible' => 'SIM'))->row();
        $this->load->helper('file');

        $this->form_validation->set_rules('name', 'Nome', 'required|ucfirst');
        $this->form_validation->set_rules('email', 'E-mail', 'required');
        $this->form_validation->set_rules('gender', 'Gênero', 'required');
        $this->form_validation->set_rules('areacodecelphone', 'Código de Àrea', 'required');
        $this->form_validation->set_rules('celphone', 'Telefone', 'required');

        if ($this->input->post('schoolingid') == '0') {
            $this->form_validation->set_rules('schoolingid', 'Escolaridade', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar sua escolaridade.');
        } else {
            $this->form_validation->set_rules('schoolingid', 'Escolaridade');
        }

        $this->form_validation->set_rules('address', 'Endereço', 'required');
        $this->form_validation->set_rules('city', 'Cidade', 'required');

        if ($this->input->post('state') == '0') {
            $this->form_validation->set_rules('state', 'Estado', 'select_validate');
            $this->form_validation->set_message('select_validate', 'Você precisa selecionar um estado (UF).');
        } else {
            $this->form_validation->set_rules('state', 'Estado');
        }

        if ($vaga == 1) {

            if ($this->input->post('campusid') == '0') {
                $this->form_validation->set_rules('campusid', 'Campus', 'select_validate');
                $this->form_validation->set_message('select_validate', 'Você precisa selecionar um local/Campus para envio do seu currículo.');
            } else {
                $this->form_validation->set_rules('campusid', 'Campus');
            }
            $this->form_validation->set_rules('typeResume', 'Tipo de Currículo', 'required');
        }


        if (empty($_FILES['files']['name'])) {
            $this->form_validation->set_rules('files', 'Arquivo', 'callback_file_check');
            $this->form_validation->set_message('file_check', 'Você precisa informar um arquivo em formato PDF.');
        }


        if ($this->form_validation->run() == false) {
            if (validation_errors()) {
                setMsg(validation_errors(), 'error');
            }
        } else {

            $path = 'assets/files/trabalheConosco/panel/resume';
            $name_tmp = preg_replace(array(
                "/(á|à|ã|â|ä)/",
                "/(Á|À|Ã|Â|Ä)/",
                "/(é|è|ê|ë)/",
                "/(É|È|Ê|Ë)/",
                "/(í|ì|î|ï)/",
                "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"
            ), explode(" ", "a A e E i I o O u U n N"), $this->input->post('name'));
            $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', "’");

            // matriz de saída
            $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

            // devolver a string
            $name_tmp = str_replace($what, $by, $name_tmp);

            $upload = $this->bancosite->do_uploadFiles('files', $path, $types = 'pdf', $name_tmp);

            if ($upload) {

                $dadosForm = elements(array('name', 'email', 'gender', 'areacodecelphone', 'celphone', 'schoolingid', 'address', 'city', 'state'), $this->input->post());

                $dadosForm['campusid'] = ($vaga == 1) ? $this->input->post('campusid') : $this->bancosite->getWhere('resume_job_vacancy', array('id' => $vaga))->row()->campusid;
                $dadosForm['vacancyid'] = ($vaga <> 1) ? $vaga : 1;

                $dadosForm['files'] = $path . '/' . $upload['file_name'];

                $dadosForm['whatsapp'] = $this->input->post('whatsapp');

                if (!empty($dadosForm['whatsapp'])) {
                    $dadosForm['whatsapp'] = $this->input->post('whatsapp');
                } else {
                    $dadosForm['whatsapp'] = null;
                }

                //$dadosForm['whatsapp'] = !empty($this->input->post('whatsapp')) ? $this->input->post('whatsapp') : null;

                if (!empty($dadosForm['areacode'])) {
                    $dadosForm['areacode'] = $this->input->post('areacode');
                } else {
                    $dadosForm['areacode'] = null;
                }
                //$dadosForm['areacode'] = !empty($this->input->post('areacode')) ? $this->input->post('areacode') : null;


                if (!empty($dadosForm['phone'])) {
                    $dadosForm['phone'] = $this->input->post('phone');
                } else {
                    $dadosForm['phone'] = null;
                }

                // $dadosForm['phone'] = !empty($this->input->post('phone')) ? $this->input->post('phone') : null;

                setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
                date_default_timezone_set('America/Sao_Paulo');

                $this->load->library('email');

                //Inicia o processo de configuração para o envio do email
                $config['protocol'] = 'mail'; // define o protocolo utilizado
                $config['wordwrap'] = TRUE; // define se haverá quebra de palavra no texto
                $config['validate'] = TRUE; // define se haverá validação dos endereços de email
                $config['mailtype'] = 'html';
                $config['newline'] = '\r\n';
                $config['charset'] = 'utf-8';

                $this->email->initialize($config);

                $mensagem = '<style type="text/css">
    @media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:14px!important; line-height:150%!important } h1 { font-size:26px!important; text-align:center; line-height:120%!important } h2 { font-size:24px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:26px!important } h2 a { font-size:24px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:13px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:13px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:13px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:11px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:block!important } a.es-button { font-size:14px!important; display:block!important; border-left-width:0px!important; border-right-width:0px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
    #outlook a {
        padding:0;
    }
    .ExternalClass {
        width:100%;
    }
    .ExternalClass,
    .ExternalClass p,
    .ExternalClass span,
    .ExternalClass font,
    .ExternalClass td,
    .ExternalClass div {
        line-height:100%;
    }
    .es-button {
        mso-style-priority:100!important;
        text-decoration:none!important;
    }
    a[x-apple-data-detectors] {
        color:inherit!important;
        text-decoration:none!important;
        font-size:inherit!important;
        font-family:inherit!important;
        font-weight:inherit!important;
        line-height:inherit!important;
    }
    .es-desk-hidden {
        display:none;
        float:left;
        overflow:hidden;
        width:0;
        max-height:0;
        line-height:0;
        mso-hide:all;
    }
    .es-button-border:hover a.es-button {
        background:#3498db!important;
        border-color:#3498db!important;
    }
    .es-button-border:hover {
        border-color:#42d159 #42d159 #42d159 #42d159!important;
        background:#3498db!important;
    }
</style>
<div style="width:100%;font-family:roboto,    helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
    <div class="es-wrapper-color" style="background-color:#F6F6F6;">
        <!--[if gte mso 9]>
                             <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                                     <v:fill type="tile" color="#f6f6f6"></v:fill>
                             </v:background>
                     <![endif]-->
        <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;">
            <tr style="border-collapse:collapse;">
                <td valign="top" style="padding:0;Margin:0;">
                    <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                        <tr style="border-collapse:collapse;">
                            <td align="center" style="padding:0;Margin:0;">
                                <table bgcolor="transparent" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;">
                                    <tr style="border-collapse:collapse;">
                                        <td align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px;">
                                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                
                                            </table></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                    <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                        <tr style="border-collapse:collapse;">
                            <td align="center" style="padding:0;Margin:0;">
                                <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;" width="600" cellspacing="0" cellpadding="0" bgcolor="transparent" align="center">
                                    <tr style="border-collapse:collapse;">
                                        <td style="Margin:0;padding-top:15px;padding-bottom:15px;padding-left:20px;padding-right:20px;background-position:center bottom;" align="left">
                                            <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                <tr style="border-collapse:collapse;">
                                                    <td width="560" valign="top" align="center" style="padding:0;Margin:0;">
                                                        <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                            <tr style="border-collapse:collapse;">
                                                                <td align="center" style="padding:0;Margin:0;"><img src="http://www.atenas.edu.br/uniatenas/assets/images/logoUniatenas.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="189"></td>
                                                            </tr>
                                                        </table></td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                    <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                        <tr style="border-collapse:collapse;">
                            <td align="center" style="padding:0;Margin:0;">
                                <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;" width="600" cellspacing="0" cellpadding="0" bgcolor="transparent" align="center">
                                    <tr style="border-collapse:collapse;">
                                        <td style="padding:0;Margin:0;padding-bottom:20px;background-position:center top;" align="left">
                                            <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                <tr style="border-collapse:collapse;">
                                                    <td width="600" valign="top" align="center" style="padding:0;Margin:0;">
                                                        <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;background-position:center bottom;background-color:#FFFFFF;border-radius:5px;" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                                            <tr style="border-collapse:collapse;">
                                                                <td align="left"  class="es-m-txt-l" style="Margin:0;padding-bottom:5px;padding-top:20px;padding-left:20px;padding-right:20px;"><h2 style="Margin:0;line-height:26px;mso-line-height-rule:exactly;font-family:roboto,    helvetica, arial, sans-serif;font-size:22px;font-style:normal;font-weight:normal;color:#3F3D3D;">Olá ' . $dadosForm['name'] . ',</h2></td>
                                                            </tr>
                                                            <tr style="border-collapse:collapse;">
                                                                <td align="center" style="Margin:0;padding-bottom:5px;padding-top:10px;padding-left:20px;padding-right:20px;"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:roboto,    helvetica, arial, sans-serif;line-height:21px;color:#3F3D3D;">
                                                                
                                                                
                                                                <img style="width: 700px;" src="http://www.atenas.edu.br/uniatenas/assets/images/uploads/img-email.png" >
                                                                </td>
                                                            </tr>
                                                            <tr style="border-collapse:collapse;">
                                                            
                                                                <td align="center" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px;"><span class="es-button-border" style="border-style:solid;border-color:#2CB543;background:#31CB4B none repeat scroll 0% 0%;border-width:0px;display:inline-block;border-radius:7px;width:auto;">
                                                                
                                                                </span>

                                                                </td>
                                                                
                                                            </tr>
                                                        </table></td>
                                                        
                                                        <p>Esta é uma mensagem automática, favor não responder este e-mail.<br/></p>
                                                </tr>
                                            </table>
                                            </td>
                                             
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                    <table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top;">
                        <tr style="border-collapse:collapse;">
                            <td align="center" style="padding:0;Margin:0;">
                                <table class="es-footer-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;" width="600" cellspacing="0" cellpadding="0" bgcolor="rgba(0, 0, 0, 0)" align="center">
                                    <tr style="border-collapse:collapse;">
                                        <td style="Margin:0;padding-top:5px;padding-bottom:20px;padding-left:20px;padding-right:10px;background-position:center top;background-color:transparent;" bgcolor="transparent" align="left">
                                            <!--[if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="270" valign="top"><![endif]-->
                                            <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;">
                                                <tr style="border-collapse:collapse;">
                                                    <td width="520" valign="top" align="center" style="padding:0;Margin:0;">
                                                        
                          </td>
                                                </tr>
                                            </table>
                                            
                                            <!--[if mso]></td></tr></table><![endif]--></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table>
                    <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;">
                        <tr style="border-collapse:collapse;">
                            <td align="center" style="padding:0;Margin:0;">
                                <table bgcolor="transparent" class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;">
                                    <tr style="border-collapse:collapse;">
                                        <td align="left" style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;background-position:left top;">
                                            <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                                
                                            </table>
                                        </td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
        </table>
    </div>  
</div>';


                $assunto = 'Inscrição - Trabalhe Conosco Site Uniatenas';

                $this->email->from('resposta@uniatenas.edu.br', 'Trabalhe conosco - UniAtenas'); //quem mandou
                $this->email->to($dadosForm['email']);

                $this->email->subject($assunto);
                $this->email->message($mensagem);

                if ($this->email->send()) {
                    $this->bancosite->salvar('resume', $dadosForm);
                    $this->email->clear();

                    $this->email->from('resposta@uniatenas.edu.br', 'Trabalhe Conosco'); //quem mandou
                    $this->email->to('rh.estrategico@uniatenas.edu.br');


                    $this->email->subject($assunto);
                    $arquivoPDF = $dadosForm['files'];

                    if ($dadosForm['campusid'] == 1) {
                        $campusName = 'Paracatu';
                    } elseif ($dadosForm['campusid'] == 2) {
                        $campusName = 'Sete Lagoas';
                    } elseif ($dadosForm['campusid'] == 1) {
                        $campusName = 'Passos';
                    } elseif ($dadosForm['campusid'] == 99) {
                        $campusName = " Qualquer campus que tenha vaga";
                        $campusName = " Qualquer campus que tenha vaga";
                    }

                    date_default_timezone_set('America/Sao_Paulo');

                    $mensagemRH = "<p>O(A) Sr.(a) " .
                        "<b>" . $dadosForm['name'] . "</b> fez contato pelo site, interessado em trabalhar conosco." . "<br/>" .
                        "Email: " . $dadosForm['email'] . "<br/>" .
                        "Celular/ Telefone: (" . $dadosForm['areacodecelphone'] . ")" . $dadosForm['celphone'] . " -  (" . $dadosForm['areacode'] . ") " . $dadosForm['phone'] . " <br/>" .
                        "Endereço: " . $dadosForm['address'] . ", " . $dadosForm['city'] . " - " . $dadosForm['state'] . " <br/>" .
                        "Curriculo PDF: " . "<a href='http://www.atenas.edu.br/uniatenas/$arquivoPDF'>Ver arquivo.</a>" .
                        "Interessado no Campus : " . $campusName . "<br/>";

                    $this->email->message($mensagemRH);


                    $this->email->send();
                    $this->email->clear();

                    setMsg('<p>Cadastro realizado com sucesso! <br>
                        Enviamos um email, em sua caixa postal, com as informações a respeito do seu cadastro.</p>', 'success');
                    redirect(current_url());
                } else {
                    setMsg('<p>Erro! Infelismente, houve um erro. Você pode tentar novamente mais tarde, ou nos enviar uma mensagem para faleconosco@atenas.edu.br </p>', 'error');
                    redirect(current_url());
                }
            } else {
                //erro no upload
                $msg = $this->upload->display_errors();
                $msg .= '<p> São permitidos arquivos' . $types . '.</p>';
                setMsg($msg, 'erro');
            }
        }

        $localidades = $this->bancosite->getAll('campus')->result();
        $escolaridades = $this->bancosite->getWhere('resume_schooling')->result();
        $areasAtuacaoDocente = $this->bancosite->getWhere('resume_sector_area', array('type' => 'areas', 'situacao' => '1'))->result();
        $areasAtuacaoTecnico = $this->bancosite->getWhere('resume_sector_area', array('type' => 'setor', 'situacao' => '1'))->result();

        if (!empty($vaga)) {
            $queryVacancy = "
                        SELECT
                        resume_job_vacancy.id,
                        resume_job_vacancy.name,
                        resume_job_vacancy.files,
                        campus.id as campusid,
                        campus.name as campus_name,
                        resume_sector_area.id as id_area,
                        resume_sector_area.name as name_area
                    FROM
                        at_site.resume_job_vacancy
                    inner join campus on campus.id = resume_job_vacancy.campusid
                    inner join resume_sector_area on resume_sector_area.id = resume_job_vacancy.sectorareaid
                    where resume_job_vacancy.id = 9
                    ";

            $infoVaga = $this->bancosite->getQuery($queryVacancy)->row();
        } else {
            $infoVaga = '';
        }

        $data = array(
            'head' => array(
                'title' => 'Trabalhe Conosco',
            ),
            'conteudo' => 'uni_trabalheConosco/envioCurriculo',
            'menu' => '',
            'footer' => '',
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'idativo' => '$idativo',
                'localidades' => $localidades,
                'escolaridades' => $escolaridades,
                'infoVaga' => $infoVaga,
                'areasAtuacaoDocente' => $areasAtuacaoDocente,
                'areasAtuacaoTecnico' => $areasAtuacaoTecnico,
            )
        );
        $this->load->view('templates/master', $data);
    }

    public function informanapp($uricampus = NULL)
    {

        if ($uricampus == null) {
            redirect("");
        }
        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $dataCampus->city))->row();

        $data = array(
            'head' => array(
                'title' => 'Napp ',
            ),
            'conteudo' => 'templates/envionapp',
            'dados' => array(
                'campus' => $dataCampus,
            ),
            'js' => null,
            'footer' => ''
        );
        $this->load->view('templates/master', $data);
    }

    /* ------------------------------------------------------------
      --------------              Comunicados
      ------------------------------------------------------------ */


    public function comunicados($uricampus = NULL)
    {
        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $dataCampus->city))->row();

        $data = array(
            'head' => array(
                'title' => 'Processo Seletivo ',
            ),
            'conteudo' => 'uniatenas/comunicados/processoSeletivo',
            'dados' => array(
                'campus' => $dataCampus,
            ),
            'js' => null,
            'footer' => ''
        );
        $this->load->view('templates/master', $data);
    }


    public function processoSeletivo($uricampus = NULL)
    {

        if ($uricampus == null) {
            redirect("");
        }

        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $dataCampus->city))->row();

        $data = array(
            'head' => array(
                'title' => 'Processo Seletivo ',
            ),
            'conteudo' => 'uniatenas/comunicados/processoSeletivo',
            'dados' => array(
                'campus' => $dataCampus,
            ),
            'js' => null,
            'footer' => ''
        );
        $this->load->view('templates/master', $data);
    }

    /* ------------------------------------------------------------
         --------------              Telefones uteis
         ------------------------------------------------------------ */


    public function telefones($uricampus = 'paracatu')
    {

        $dataCampus = $this->bancosite->getWhere('campus', array('city' => $dataCampus->city))->row();

        $field = array('contatos_setores.id', 'contatos_setores.responsible', 'contatos_setores.ramal', 'contatos_setores.phone', 'setores.nome');
        $table = 'contatos_setores';
        $datajoin = array(
            'campus_has_setores' => 'contatos_setores.setoresidcamp = campus_has_setores.id ',
            'setores' => 'campus_has_setores.setores_id = setores.id'
        );
        $where = array('campus_id ' => $dataCampus->id, "contatos_setores.status" => 1);
        $order["campo"] = "setores.nome";
        $order["ordem"] = "ASC";

        $phones = $this->Painelsite->where($field, $table, $datajoin, $where, $order)->result();
        $i = 0;
        $result = array();
        foreach ($phones as $phone) {
            $result[$i] = array($phone->id, $phone->responsible, $phone->nome, $phone->phone, $phone->ramal);
            $i++;
        }

        $data = array(
            'head' => array(
                'title' => 'telefones uteis ',
            ),
            'conteudo' => 'uniatenas/telefones/phone',
            'menu' => '',
            'footer' => '',
            'js' => null,
            'dados' => array(
                'campus' => $dataCampus,
                'phones' => $result
            ),
            'js' => null,
            'footer' => ''
        );
        $this->load->view('templates/master', $data);
    }
}