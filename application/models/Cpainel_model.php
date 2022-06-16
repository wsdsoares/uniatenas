<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Cpainel_model extends CI_Model
{
    public function salvar($tabela = NULL, $dados = NULL)
    {
        if (isset($dados['id'])) {
            $this->db->where('id', $dados['id']);
            unset($dados['id']);
            $this->db->update("$tabela", $dados);
            return TRUE;
        } else {
            $this->db->insert("$tabela", $dados);
            return TRUE;
        }
    }

    public function getWhere($table = NULL, $where = NULL, $order = NULL)
    {
        if (isset($where)) {
            $this->db->where($where);
        }
        if ($order != NULL) {
            $this->db->order_by($order['campo'], $order['ordem']);
        }
        return $this->db->get($table);
    }

    public function where($fields = NULL, $table = NULL, $dataJoin = NULL, $where = NULL, $order = NULL, $limit = NULL)
    {
        if ($fields != NULL) {
            if ($fields == '*') {
                $this->db->select('*');
            } else {
                foreach ($fields as $key => $value) {
                    $this->db->select($value);
                }
            }
        }

        if (isset($where) && $where != null) {
            $this->db->where($where);
        }
        if ($order != NULL) {
            $this->db->order_by($order['campo'], $order['ordem']);
        }
        if ($limit != NULL) {
            return $this->db->get($table, $limit);
        }
        if ($dataJoin != NULL) {
            foreach ($dataJoin as $key => $value) {
                $this->db->join($key, $value);
            }
        }
        return $this->db->get($table);
    }


    public function uploadFiles($imagem, $path, $types, $name_tmp)
    {
        //leitura da biblioteca uploads e as configurações vindas do Funções HELPER
        $this->load->library('upload', configUploads($path, $types, $name_tmp));
        //$this->upload->initialize(config_upload($path,$types,$name_tmp));
        if (!$this->upload->do_upload($imagem)) {
            return $this->upload->display_errors();
        } else {
            return $this->upload->data();
        }
    }

    public function delete($table = NULL, $param = NULL)
    {
        if ($table != NULL && is_array($param)) {
            $this->db->delete($table, $param);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletar($table = null, $id = null)
    {
        if ($id != null && $table != null) {
            $this->db->where('id', $id);
            return $this->db->delete($table);
        } else {
            return false;
        }
    }

    public function alterar($table, $column, $columnIdentifier, $id, $value)

    {
        /*if ($table != null && $condition != null  && $values != null) {
            $this->bd->where($condition);
            $this->bd->update("$table", $values);
            if($this->bd->update($table, $values)){
                return true;
            }else{
                return false;
            }
        }*/
        $sql = "UPDATE $table SET $column = $value WHERE $columnIdentifier = $id";
        //$sql = "UPDATE :table: SET :column = :value: WHERE :identifiercolumn: = :id:";
        if($this->db->query($sql)){
            return true;
        }else{
            return false;
        };


    }


}