<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Site_model extends CI_Model {

    public function salvar($tabela = NULL, $dados = NULL) {
        if (isset($dados['id']) and $dados['id'] > 0) {
            $this->db->where('id', $dados['id']);
            unset($dados['id']);
            $this->db->update("$tabela", $dados);
            return TRUE;
        } else {
            $this->db->insert("$tabela", $dados);
            return TRUE;
        }
    }

    public function getWhere($table = NULL, $where = NULL, $order = NULL, $limit = NULL) {
        
        if (isset($where)) {
            $this->db->where($where);
        }
        if ($order != NULL) {
            $this->db->order_by($order['campo'], $order['ordem']);
        }
        if ($limit != NULL) {
            return $this->db->get($table,$limit);
        } else {
            return $this->db->get($table);
        }
    }

    public function getMax($table = NULL, $condicao = NULL) {
        $this->db->select_max($condicao);
        return $this->db->get($table);
    }

     public function do_uploadFiles($imagem, $path, $types, $name_tmp) {
        //leitura da biblioteca uploads e as configurações vindas do Funções HELPER
        $this->load->library('upload', configUploads($path, $types, $name_tmp));

        if (!$this->upload->do_upload($imagem)) {
            return $this->upload->display_errors();
        } else {
            return $this->upload->data();
        }
    }
    
    public function get_campus($id = NULL, $status = NULL) {
        $this->db->select('city');
        if ($id != NULL):
            $this->db->where('id', $id);
        endif;
        if ($status != NULL):
            $this->db->where('status', $status);
        endif;
        return $this->db->get('campus');
    }

    public function get_news($id = NULL, $where = NULL, $limit = NULL) {
        if ($id != NULL):
            $this->db->where('id', $id);
        endif;
        if ($where != NULL):
            $this->db->where($where);
        endif;
        if ($limit != NULL):
            $this->db->limit($limit);
        endif;
        $this->db->order_by('id', 'DESC');
        return $this->db->get('news');
    }

    public function get_all($table = NULL, $id = NULL, $limit = NULL) {
        if ($table != NULL):
            if ($id != NULL)
                $this->db->where('id', $id);
            if ($limit != NULL)
                $this->db->limit($limit);
            return $this->db->get($table);
        else:
            return FALSE;
        endif;
    }

    public function get_where($table = NULL, $where = NULL, $order = NULL) {
        $this->db->where($where);
        if ($order != NULL) {
            $this->db->order_by($order['campo'], $order['ordem']);
        }
        return $this->db->get($table);
    }

    public function get_pages($id = NULL, $title = NULL, $table = NULL) {
        if ($table != NULL):
            if ($id != NULL)
                $this->db->where('id', $id);
            if ($title != NULL)
                $this->db->where('title', $title);
            return $this->db->get($table);
        else:
            return FALSE;
        endif;
    }

    public function get_contents($page = NULL, $active = NULL) {
        if ($page != NULL):
            $this->db->where('pages_id', $page);
            $this->db->where('active', $active);
            $this->db->order_by('order', 'asc');

        endif;
        return $this->db->get('page_contents');
    }

    public function get_cursos($table = NULL, $status = NULL, $ordem = NULL, $curso = NULL) {
        $presencial = 1;
        if ($table != NULL):
            //if($status!=NULL) $this->db->where('status', $status);
            if ($ordem != NULL)
                $this->db->order_by("nome", 'asc');
            if ($curso != NULL)
                $this->db->where("curso_id", $curso);
            if ($presencial != 0)
                $this->db->where("presencial", '1');

            return $this->db->get($table);
        else:
            return FALSE;
        endif;
    }

    public function get_min($table = NULL, $condicao = NULL) {
        $this->db->select_min($condicao);
        return $this->db->get($table);
    }

    public function get_byid($tabela = NULL, $id = NULL) {
        if ($id != NULL && $tabela != NULL):
            $this->db->where('id', $id);
            $this->db->limit(1);
            return $this->db->get("$tabela");
        else:
            return FALSE;
        endif;
    }

    public function getQuery($sql = NULL) {
        if ($sql != NULL):
            return $this->db->query($sql);
        endif;
    }

    public function getAll($table = NULL, $id = NULL, $limit = NULL) {
        if ($table != NULL):
            if ($id != NULL)
                $this->db->where('id', $id);
            if ($limit != NULL)
                $this->db->limit($limit);
            return $this->db->get($table);
        else:
            return FALSE;
        endif;
    }
    /**** COMO PASSAR PARÂMETROS WHERE
     * Fields - Campo da tabela  - Colunas - ONDE PODE-SE passar * que traz todas as colunas ou se colocar o nome da tabela.campo
     * Table - Tabela
     * Join - Array que recebe quais tabelas irão estar no JOIN
     * order - Ordem da exibição
     * limit - Filtro de resultados
    ****/
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

        if (isset($where)) {
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
    

}

/* End of file paginas_model.php */
/* Location: ./application/models/paginas_model.php */