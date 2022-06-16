<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_model extends CI_Model
{

    public function do_insert($tabela = NULL, $dados = NULL, $redir = TRUE)
    {
        if ($dados != NULL):
            $this->db->insert("$tabela", $dados);
            if ($this->db->affected_rows() > 0):
                set_msg('Cadastro efetuado com sucesso</strong>!', 'sucesso');
            else:
                set_msg('<div class="alert alert-danger"><strong>Erro ao inserir dados</strong>.</div>', 'erro');
            endif;
            if ($redir)
                redirect(current_url());
        endif;
    }

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

    public function deletar($table = null, $id = null)
    {
        if ($id != null && $table != null) {
            $this->db->where('id', $id);
            return $this->db->delete($table);
        } else {
            return false;
        }
    }
    

    public function salvarId($tabela = NULL, $dados = NULL)
    {
        if (isset($dados['id']) and $dados['id'] > 0) {
            $this->db->where('id', $dados['id']);
            unset($dados['id']);
            $this->db->update("$tabela", $dados);
            return TRUE;
        } else {
            $this->db->insert("$tabela", $dados);
            return $this->db->insert_id();
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

    public function get_all($table = NULL, $id = NULL)
    {
        if ($table != NULL):
            if ($id != NULL)
                $this->db->where('id', $id);
            return $this->db->get($table);
        else:
            return FALSE;
        endif;
    }

    public function get_pages($id = NULL, $title = NULL, $table = NULL)
    {
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

    public function get_query($sql = NULL)
    {
        if ($sql != NULL):
            return $this->db->query($sql);
        endif;
    }

    public function getQuery($sql = NULL)
    {
        if ($sql != NULL):
            return $this->db->query($sql);
        endif;
    }

    public function school_semester($id = NULL, $status = NULL)
    {
        if ($id != NULL):
            $this->db->where('id', $id);
        endif;
        if ($status != NULL):
            $this->db->where('status', $status);
        endif;
        $this->db->order_by('year_semester', 'DESC');
        return $this->db->get('school_semester');
    }

    public function campus($id = NULL, $status = NULL)
    {
        if ($id != NULL):
            $this->db->where('id', $id);
        endif;
        if ($status != NULL):
            $this->db->where('status', $status);
        endif;
        return $this->db->get('campus');
    }

    public function get_contents($page = NULL, $active = NULL)
    {
        if ($page != NULL):
            $this->db->where('pages_id', $page);
            $this->db->where('active', $active);
            $this->db->order_by('order', 'asc');

        endif;
        return $this->db->get('page_contents');
    }

    public function get_byid($tabela = NULL, $id = NULL)
    {
        if ($id != NULL && $tabela != NULL):
            $this->db->where('id', $id);
            $this->db->limit(1);
            return $this->db->get("$tabela");
        else:
            return FALSE;
        endif;
    }

    /* public function get_where($table = NULL, $where = NULL, $order = NULL) {
      $this->db->where($where);
      if ($order != NULL) {
      $this->db->order_by($order['campo'], $order['ordem']);
      }
      return $this->db->get($table);
      } */

    public function getCourses($id = NULL)
    {
        if ($id != NULL):
            $this->db->where('campus_has_courses.campus_id', $id);
        endif;

        $this->db->join('campus', 'campus.id = campus_has_courses.campus_id');
        $this->db->join('courses', 'courses.id = campus_has_courses.courses_id');
        return $this->db->get('campus_has_courses');
    }

    public function do_uploadFiles($imagem, $path, $types, $name_tmp)
    {
        //leitura da biblioteca uploads e as configurações vindas do Funções HELPER
        $this->load->library('upload', configUploads($path, $types, $name_tmp));

        if (!$this->upload->do_upload($imagem)) {
            return $this->upload->display_errors();
        } else {
            return $this->upload->data();
        }
    }

    public function uploadFiles($imagem, $path, $types, $name_tmp)
    {
        //leitura da biblioteca uploads e as configurações vindas do Funções HELPER
        $this->load->library('upload', configUploads($path, $types, $name_tmp));

        if (!$this->upload->do_upload($imagem)) {
            return $this->upload->display_errors();
        } else {
            return $this->upload->data();
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

    public function getAll($table = NULL, $id = NULL, $limit = NULL)
    {
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

    /** WHERE - completo */
    public function where($fields = NULL, $table = NULL, $dataJoin = NULL, $where = NULL, $order = NULL, $limit = NULL, $groupBy = NULL)
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
        if ($groupBy != NULL) {
            $this->db->group_by($groupBy);
        }
        return $this->db->get($table);
    }



}