<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Acesso_model extends CI_Model {

    public function do_insert($dados = NULL, $redir = TRUE) {
        $nomeUser = $this->session->userdata('user_codusuario');
        if ($dados != NULL) :
            $this->db->insert('usuario', $dados);
            if ($this->db->affected_rows() > 0) :
                auditoria('Inclusão de usuários', 'Usuário "' . $dados['nome'] . '" cadastrado no sistema');
                set_msg('msgok', '<div class="alert alert-success"><strong>Cadastro efetuado com sucesso</strong>!</div>', 'sucesso');
            else :
                set_msg('msgerro', '<div class="alert alert-danger"><strong>Erro ao inserir dados</strong>.</div>', 'sucesso');
            endif;
            if ($redir)
                redirect(current_url());
        endif;
    }

    public function do_update($dados = NULL, $condicao = NULL) {//, $redir=TRUE
        $nomeUser = $this->session->userdata('user_codusuario');
        if ($dados != NULL && $condicao != NULL) ://is_array($condicao!=NULL)
            $this->db->update('usuario', $dados, $condicao);
            if ($this->db->affected_rows() > 0) :
                auditoria('Alteração de usuário', 'Alterado senha do usuário pelo email "' . $condicao['email'] . '" por aplicação externa.');
                set_msg('msgok', '<div class="alert alert-success"><strong>Alteração efetuada com sucesso!</strong> &nbsp Uma nova senha foi enviada para o seu e-mail, favor verificar para acessar o Portal Atenas novamente.</div>', 'sucesso');
            else :
                set_msg('msgerro', '<div class="alert alert-danger"><strong>Erro ao atualizar dados</strong>.</div>', 'sucesso');
            endif;
            redirect(current_url());

        endif;
    }

    public function do_delete($condicao = NULL) {
        $nomeUser = $this->session->userdata('user_codusuario');
        if ($condicao != NULL && is_array($condicao)) :
            $usuario = $this->usuarios->get_byid($condicao['codusuario'])->row()->login;
            $this->db->delete('usuario', $condicao);
            if ($this->db->affected_rows() > 0) :
                auditoria('Exclusão de usuários', 'Excluído cadastro do usuário "' . $condicao['codusuario'] . '" por "' . $nomeUser . '"');
                set_msg('msgok', '<div class="alert alert-success"><strong>Registro excluído com sucesso</strong>!</div>', 'sucesso');
            else :
                set_msg('msgerro', '<div class="alert alert-danger"><strong>Erro ao excluir registro</strong>.</div>', 'sucesso');
            endif;

            redirect(current_url());
        endif;
    }

    public function do_login($user = NULL, $passwd = NULL) {
        if ($user != NULL && $passwd != NULL) :
            $this->db->where('login', $user);
            $this->db->where('passwd', $passwd);

            $this->db->where('status', 1); // 1 ativo - 0 bobo
            $query = $this->db->get('users');

            if ($query->num_rows() == 1) :
                return TRUE;
            else:
                return FALSE;
            endif;
        else :
            return FALSE;
        endif;
    }

    public function get_byUser($user = NULL) {
        if ($user != NULL) :
            $this->db->where('user', $user);
            $this->db->where('status', 1);
            $this->db->limit(1);
            return $this->db->get('users');
        else :
            return FALSE;
        endif;
    }

    public function get_byid($id = NULL) {
        if ($id != NULL) :
            $this->db->where('codusuario', $id);
            $this->db->limit(1);
            return $this->db->get('usuario');
        else :
            return FALSE;
        endif;
    }

    public function get_all($usuario = NULL) {
        $perfilUserLogado = $this->session->userdata('user_perfil');
        $this->db->from('usuario');
        if ($usuario != NULL)
            $this->db->where('codusuario', $usuario);
        if ($perfilUserLogado == 7)
            $this->db->where('fk_codperfil', 2);
        $this->db->join('perfil', 'perfil.codperfil = usuario.fk_codperfil');
        return $query = $this->db->get();
    }

}

/* End of file usuario_model.php */
/* Location: ./application/models/usuario_model.php */

