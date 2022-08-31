<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Acesso extends CI_Controller {

    public function __construct() {
        parent::__construct();
        init_painel_login();
        $this->load->model('users_model', 'users');
        $this->load->model('inicio_model', 'inicio');
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function index() {
       $this->login();
    }
    
    public function login() {
        echo '<script>alert("teste")</script>';
        $this->form_validation->set_rules('user', 'USUÁRIO', 'required');
        $this->form_validation->set_rules('passwd', 'SENHA', 'required');
        if ($this->form_validation->run() == FALSE):
            if (validation_errors()):
                 set_msg(validation_errors(), 'erro');
            endif;
        else:
            $dados_form = $this->input->post();
            $result = $this->users->get_byUser($dados_form['user'])->row();

            if ($result->user == $dados_form['user']):
                //usuário existe
                if ($this->users->do_login($dados_form['passwd'], $result->passwd)):
                    $this->session->set_userdata('logged', TRUE);
                    $this->session->set_userdata('id', $result->id);
                    $this->session->set_userdata('name', $result->name);
                    $this->session->set_userdata('email', $result->email);
                    redirect('painel');
                else:
                    //senha incorreta
                    set_msg('<strong>Usuário </strong>e a <strong>senha</strong> informada não coincidem!</strong>', 'erro');
                endif;
            else:
                //usuário não existe
                set_msg('Olá. Infelizmente não há cadastro para o <strong>Usuário</strong> informado <strong>' . $dados_form['cpf'] . '</strong>!', 'erro');
            endif;
          
        endif;

        //carrega a view
        $dados['tela'] = 'login';
        $dados['modulo'] = 'Login';
        $dados['diretorio_view'] = 'acesso';
        set_tema('titulo', 'Painel - Login');
        set_tema('conteudo', load_modulo_tela($dados));
        load_template();
    }


    public function logoff() {
        $this->session->unset_userdata(array(NULL));
        $this->session->sess_destroy();
        set_msg('Logoff efetuado com sucesso!', 'sucesso');
        redirect('acesso/login');
    }

    public function nova_senha() {

        $this->form_validation->set_rules('email', 'EMAIL', 'trim|required|valid_email|strtolower');
        if ($this->form_validation->run() == TRUE) :
            $email = $this->input->post('email');
            $query = $this->acesso->get_byemail($email);
            if ($query->num_rows() == 1) :
                $novasenha = substr(str_shuffle('qwertyuiopasdfghjklzxcvbnm0123456789'), 0, 6);
                $mensagem = "<p>Você solicitou uma nova senha para acesso ao painel de administração do site, a partir de agora use a seguinte senha para acesso: <strong>$novasenha</strong></p>
				<p>Troque esta senha para uma senha segura e de sua preferência o quanto antes. Acesse o Portal <a href='http://177.69.195.6:8080/portalatenas/acesso/login'> aqui.</a></p>
				<p><strong>ATT</strong>
				<br/><span>Suporte TI / Faculdade Atenas</span></p>";

                //* Funcão para envio de email */
                $config['smtp_host'] = 'smtp.atenas.edu.br';
                $config['smtp_port'] = 587;
                $config['protocol'] = 'smtp';
                $config['smtp_user'] = 'suporteti@atenas.edu.br';
                $config['smtp_pass'] = 'mxklnj101Sup';
                $config['charset'] = 'utf-8';
                $config['mailtype'] = 'html';
                $config['newline'] = '\r\n';
                $config['wordwrap'] = TRUE;
                $this->load->library('email', $config);
                $this->email->initialize($config); // Aqui carrega _todo config criado anteriormente
                $this->email->from('suporteti@atenas.edu.br', 'SUPORTE TI - Faculdade Atenas'); //quem mandou
                $this->email->to($email); //quem recebe
                $this->email->subject('Redefinição de senha, Portal Atenas.'); //assunto
                $this->email->message($mensagem);
                $this->email->send(); // Envia o email

                if ($this->sistema->enviar_email($email, 'Nova senha de acesso', $mensagem)) :
                    $dados['password'] = md5($novasenha);
                    $this->acesso->do_update($dados, array('email' => $email), FALSE);
                    auditoria('Redefinição de senha', 'O usuário solicitou uma nova senha por email');
                    set_msg('msgok', '<div class="alert alert-success"><strong>Uma nova senha foi enviada para seu email</strong>.</div>', 'erro');
                    redirect('acesso/nova_senha');
                else :
                    set_msg('msgerro', '<div class="alert alert-danger"><strong>Erro ao enviar nova senha, contate o administrador</strong>.</div>', 'erro');
                    redirect('acesso/nova_senha');
                endif;
            else:
                set_msg('msgerro', '<div class="alert alert-warning"><strong>Este e-mail não possui cadastro no sistema</strong>.</div>', 'erro');
                redirect('acesso/nova_senha');
            endif;

        endif;
        set_tema('titulo', 'Recuperar senha');
        set_tema('conteudo_login', load_modulo('acesso', 'nova_senha', 'painel'));
        set_tema('rodape', '');
        load_template();
    }

}

/* End of file acesso.php */
/* Location: ./application/controllers/acesso.php */
