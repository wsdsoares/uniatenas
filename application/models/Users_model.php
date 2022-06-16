<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Users_model extends CI_Model
{

    /*public function do_login($user = NULL, $passwd = NULL)
    {
        $DB2 = $this->load->database('dbUsers', TRUE);
        if ($user != NULL && $passwd != NULL) :
            $DB2->where('codusuario', $user);
            $DB2->where('password', $passwd);
            $query = $DB2->get('usuario');
            if ($query->num_rows() == 1) :
                return $query->row();
            else:
                return FALSE;
            endif;
        else:
            return FALSE;
        endif;
    }*/

    /** Criação de login - No próprio Site -  */
    
    public function login($dados=NULL)
    {
        if($dados['user']==null or $dados['password']==NULL){
            return false;
        }else{
            $this->db->where('cod_user', $dados['user']);
            $this->db->where('password', $dados['password']);
            $this->db->where('status',1);
            $this->db->limit(1);
            return $this->db->get('users');
        }
    }

    public function getWhere_($table = NULL, $where = NULL, $order = NULL)
    {
        $DB3 = $this->load->database('dbUsersIntegration', TRUE);

        if (isset($where)) {
            $DB3->where($where);
        }
        if ($order != NULL) {
            $DB3->order_by($order['campo'], $order['ordem']);
        }
        return $DB3->get($table);
    }




    public function getWhere($table = NULL, $where = NULL, $order = NULL)
    {
        $DB2 = $this->load->database('dbUsers', TRUE);
        if (isset($where)) {
            $DB2->where($where);
        }
        if ($order != NULL) {
            $DB2->order_by($order['campo'], $order['ordem']);
        }
        return $DB2->get($table);
    }


    public function get_byUser($user = NULL)
    {
        $DB2 = $this->load->database('dbUsers', TRUE);
        if ($user != NULL) :
            $DB2->where('codusuario', $user);
            $DB2->limit(1);
            return $DB2->get('usuario');
        else :
            return FALSE;
        endif;
    }

    public function getQuery($sql = NULL)
    {
        $DB2 = $this->load->database('dbUsers', TRUE);
        if ($sql != NULL):
            return $DB2->query($sql);
        endif;
    }

    public function query($database=NULL,$sql = NULL)
    {
        $DB2 = $this->load->database($database, TRUE);
        if ($sql != NULL):
            return $DB2->query($sql);
        endif;
    }

    public function where($database=NULL,$table = NULL, $where = NULL, $order = NULL)
    {

        $DB2 = $this->load->database($database, TRUE);
        if (isset($where)) {
            $DB2->where($where);
        }
        if ($order != NULL) {
            $DB2->order_by($order['campo'], $order['ordem']);
        }
        return $DB2->get($table);
    }

    public function getPermissoes($codusuario = NULL)
    {
        $DB3 = $this->load->database('dbPermissoes', TRUE);

        $sql = 'SELECT 
				
                    perfil.codperfil as codperfil, 
                    perfil.descricao as desc_perfil,
                    perfil.nome as nome_perfil,
                    permissao.codpermissao as codpermissao,
                    filialusuario.codfilial,
                    filial.nome as nomefilial
                FROM
                    permissaoperfil
                inner join perfil on perfil.codperfil = permissaoperfil.codperfil
                inner join perfilusuario on perfilusuario.codperfil = perfil.codperfil
                inner join usuario on usuario.codusuario = perfilusuario.codusuario
                inner join permissao on permissao.codpermissao = permissaoperfil.codpermissao
                inner join filialusuario on filialusuario.codusuario = usuario.codusuario
                inner join filial on filial.codfilial = filialusuario.codfilial
                where usuario.codusuario = "' . $codusuario . '"
                    and permissao.codmodulo="SITE"';

        if ($codusuario != NULL) {
            return $DB3->query($sql);
        } else {
            return FALSE;
        }


    }
}

/* End of file users_model.php */
/*Conexão com o portal 177.69.195.6*/
/* Location: ./application/models/users_model.php */